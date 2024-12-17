<?php

namespace Hemp\Machinery\Tests;

use Hemp\Machinery\InvalidStateTransition;
use Hemp\Machinery\Tests\Fixtures\Status;
use Hemp\Machinery\Tests\Fixtures\User;

class MachineryTest extends IntegrationTestCase
{
    public function testModelStateCanBeTransitionedUsingTransitionTo()
    {
        /** @var User $user */
        $user = User::create([
            'name' => 'Hemp',
            'status' => Status::Active
        ]);

        $user->transitionTo('status', Status::Inactive);

        $this->assertEquals(Status::Inactive, $user->status);
    }

    public function testCannotTransitionToAnInvalidState()
    {
        /** @var User $user */
        $user = User::create([
            'name' => 'Hemp',
            'status' => Status::Banned
        ]);

        $this->expectException(InvalidStateTransition::class);

        $user->transitionTo('status', Status::Active);
    }

    public function testSideEffectsAreExecuted()
    {
        /** @var User $user */
        $user = User::create([
            'name' => 'Hemp',
            'status' => Status::Active
        ]);

        $user->transitionTo('status', Status::Inactive, fn () => $user->update(['name' => 'Hempington']));

        $this->assertEquals('Hempington', $user->name);
    }
}