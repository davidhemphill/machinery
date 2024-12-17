<?php

namespace Hemp\Machinery;

interface MachineryState
{
    public function transitionTo(MachineryState $state, callable $sideEffect): MachineryState;

    public static function transitions(): array;

    public function canTransitionTo(MachineryState $state): bool;
}