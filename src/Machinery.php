<?php

namespace Hemp\Machinery;

trait Machinery
{
    public function transitionTo($machineKey, MachineState $state, ?callable $sideEffect = null): MachineState
    {
        $sideEffect = $sideEffect ?? fn () => null;

        $callable = function () use ($state, $machineKey, $sideEffect) {
            $this->update([$machineKey => $state]);
            $sideEffect();
        };

        return $this->{$machineKey}->transitionTo($state, $callable);
    }

    public function canTransitionTo($machineKey, MachineState $state): bool
    {
        return $this->{$machineKey}->canTransitionTo($state);
    }
}