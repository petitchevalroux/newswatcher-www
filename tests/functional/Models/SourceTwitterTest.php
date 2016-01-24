<?php

use NwWebsite\Models\Sources\Twitter as TwitterSource;

class SourceTwitterTest extends PHPUnit_Framework_TestCase
{

    public function testCreate()
    {
        $source = TwitterSource::get();
        $source->method = 'user';
        $source->accessTokenKey = 'aTk';
        $source->accessTokenSecret = 'aTks';
        $source->save();
        $this->assertGreaterThan(0, $source->id);
    }

    public function testGet()
    {
        $source = TwitterSource::get();
        $source->method = 'user';
        $source->accessTokenKey = 'aTk';
        $source->accessTokenSecret = 'aTks';
        $source->save();
        $fetchedSource = TwitterSource::get($source->id);
        $this->assertEquals('user', $fetchedSource->method);
        $this->assertEquals('aTk', $fetchedSource->accessTokenKey);
        $this->assertEquals('aTks', $fetchedSource->accessTokenSecret);
    }

    public function testUpdate()
    {
        $source = TwitterSource::get();
        $source->method = 'user';
        $source->accessTokenKey = 'aTk';
        $source->accessTokenSecret = 'aTks';
        $source->save();
        $fetchedSource = TwitterSource::get($source->id);
        $this->assertEquals('user', $fetchedSource->method);
        $this->assertEquals('aTk', $fetchedSource->accessTokenKey);
        $this->assertEquals('aTks', $fetchedSource->accessTokenSecret);
        $fetchedSource->accessTokenKey = 'lalilol';
        $fetchedSource->save();
        $updatedSource = TwitterSource::get($fetchedSource->id);
        $this->assertEquals('lalilol', $updatedSource->accessTokenKey);
    }

}
