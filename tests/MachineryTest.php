<?php

namespace Hemp\Machinery\Tests;

use Exception;
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
        $this->assertTrue($user->status->is(Status::Inactive));
    }

    public function testCannotTransitionToAnInvalidState()
    {
        /** @var User $user */
        $user = User::create([
            'name' => 'Hemp',
            'status' => Status::Banned
        ]);

        $this->assertFalse($user->canTransitionTo('status', Status::Active));

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

    public function testSideEffectsReceiveTheCurrentModel()
    {
        /** @var User $user */
        $user = User::create([
            'name' => 'Hemp',
            'status' => Status::Active
        ]);

        $user->transitionTo(
            'status',
            Status::Inactive,
            fn(User $user) => $user->update(['name' => 'Side Effects'])
        );

        $this->assertEquals('Side Effects', $user->name);
    }
}