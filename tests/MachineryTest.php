<?php

namespace Hemp\Tests;

use Hemp\Tests\Fixtures\Status;
use Hemp\Tests\Fixtures\User;

class MachineryTest extends IntegrationTestCase
{
    public function testModelStateCanBeTransitionedUsingTransitionTo()
    {
        $user = User::create([
            'name' => 'John Doe',
            'status' => Status::Active
        ]);

        $user->transitionTo('status', Status::Inactive);

        $this->assertEquals(Status::Inactive, $user->status);
    }

}