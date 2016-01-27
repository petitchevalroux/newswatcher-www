<?php

namespace NwWebsite\Controllers\Auth;

use NwWebsite\Di;
use NwWebsite\Exceptions\User as UserException;
use NwWebsite\Models\Sources\Twitter as TwitterSourceModel;
use NwWebsite\Models\Users as UserModel;

/**
 * Twitter authentifier.
 */
class Twitter extends Authentifier
{
    const CALLBACK_URL = '/auth/twitter/callback';

    private function getCallbackUrl()
    {
        $di = Di::getInstance();

        return $di->http->getAbsoluteUrl(static::CALLBACK_URL);
    }

    /**
     * Redirect to twitter for authentication.
     *
     * @throws UserException
     */
    public function login()
    {
        $di = Di::getInstance();
        $token = $di->twitterOAuth->oauth(
                'oauth/request_token', ['oauth_callback' => $this->getCallbackUrl()]
        );
        if (empty($token['oauth_token'])) {
            throw new UserException('Unable to signin using twitter, try later');
        }
        if (empty($token['oauth_token_secret'])) {
            throw new UserException('Unable to signin using twitter, try later');
        }
        $oauthToken = $token['oauth_token'];
        $oauthTokenSecret = $token['oauth_token_secret'];
        $di->session->set('oauth_token', $oauthToken);
        $di->session->set('oauth_token_secret', $oauthTokenSecret);
        $redirectUrl = $di->twitterOAuth->url(
                'oauth/authorize', ['oauth_token' => $oauthToken]
        );
        $di->slim->redirect($redirectUrl, 302);
    }

    /**
     * Handle return of twitter authentication.
     *
     * @throws UserException
     */
    public function callback()
    {
        $di = Di::getInstance();
        $requestToken = $di->slim->request->get('oauth_token');
        $sessionOauthToken = $di->session->get('oauth_token');
        $requestSecret = $di->session->get('oauth_token_secret');
        if ($requestToken !== $sessionOauthToken) {
            throw new UserException('Unable to signin using twitter, try later');
        }
        $oauthVerifier = $di->slim->request->get('oauth_verifier');
        // Fetching access token using authorize request token
        $di->twitterOAuth->setOauthToken($requestToken, $requestSecret);
        $accessToken = $di->twitterOAuth->oauth(
                'oauth/access_token', ['oauth_verifier' => $oauthVerifier]
        );
        $di->session->delete('oauth_token');
        $di->session->delete('oauth_token_secret');
        if (empty($accessToken['user_id']) || empty($accessToken['screen_name']) || empty($accessToken['oauth_token']) || empty($accessToken['oauth_token_secret'])
        ) {
            throw new UserException('Unable to signin using twitter, try later');
        }
        $twitterUserId = $accessToken['user_id'];
        $twitterScreenName = $accessToken['screen_name'];
        $oauthToken = $accessToken['oauth_token'];
        $oauthTokenSecret = $accessToken['oauth_token_secret'];
        $di->twitterOAuth->setOauthToken($oauthToken, $oauthTokenSecret);
        // Check if access token works
        $credentials = $di->twitterOAuth->get('account/verify_credentials');
        $user = $di->api->getResources('/users?limit=1&filters[twitterId]='.rawurlencode($twitterUserId));
        if (empty($user)) {
            // Create user
            $user = UserModel::get();
            $user->name = $twitterScreenName;
            $user->twitterId = $twitterUserId;
            $user->twitterToken = $oauthToken;
            $user->twitterTokenSecret = $oauthTokenSecret;
            $user->save();
            // Create source
            $source = TwitterSourceModel::get();
            $source->method = 'user';
            $source->accessTokenKey = $oauthToken;
            $source->accessTokenSecret = $oauthTokenSecret;
            $source->save();
            // Associate user to source
            $source->associate($user);
            // Start source indexer
            $source->startIndexer();
        } else {
            $user = $user[0];
            if ($user['twitterToken'] !== $oauthToken || $user['twitterTokenSecret'] !== $oauthTokenSecret) {
                $user = $di->api->updateResource(
                        '/users/'.rawurlencode($user['id']), [
                    'twitterToken' => $oauthToken,
                    'twitterTokenSecret' => $oauthTokenSecret,
                ]);
            }
        }

        $this->authentify($user);
        $di->slim->redirect('/home', 302);
    }
}
