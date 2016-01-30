<?php

use NwWebsite\Models\Users as User;

class UserTest extends PHPUnit_Framework_TestCase
{
    public function testUpdate()
    {
        $user = User::get();
        $user->name = 'John doe';
        $user->save();
        $user->name = 'Monk Doe';
        $user->save();
        $user2 = User::get($user->id);
        $this->assertEquals('Monk Doe', $user2->name);
    }

    public function testCollection()
    {
        $user = User::get();
        $user->name = 'John Dafoo';
        $user->save();
        $users = User::getCollection(['name' => 'John Dafoo'], 0, 1);
        $this->assertEquals('John Dafoo', $users[0]->name);
    }
}
