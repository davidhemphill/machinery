<?php

namespace Hemp\Machinery;

interface MachineState
{
    public function transitionTo(MachineState $state, callable $sideEffect): MachineState;

    public static function transitions(): array;

    public function canTransitionTo(MachineState $state): bool;

    public function isValidTransition(MachineState $state): bool;
}