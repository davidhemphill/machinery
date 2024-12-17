<?php

namespace Hemp\Machinery\Tests;

use Hemp\Machinery\InvalidStateTransition;
use Hemp\Machinery\Tests\Fixtures\Status;
use PHPUnit\Framework\TestCase;

class MachineryUnitTest extends TestCase
{
    public function testModelStateCanBeTransitionedUsingTransitionTo()
    {
        $this->assertEquals(Status::Inactive, Status::Active->transitionTo(Status::Inactive));
    }

    public function testCannotTransitionToAnInvalidState()
    {
        $this->assertFalse(Status::Banned->canTransitionTo(Status::Active));

        $this->expectException(InvalidStateTransition::class);

        Status::Banned->transitionTo(Status::Active);
    }

    public function testSideEffectsAreExecuted()
    {
        $affected = false;

        Status::Active->transitionTo(Status::Inactive, function () use (&$affected) {
            $affected = true;
        });

        $this->assertTrue($affected);
    }
}