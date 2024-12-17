<?php

namespace Hemp\Machinery;

trait Machinery
{
    public function transitionTo($machineKey, MachineryState $state, ?callable $sideEffect = null): MachineryState
    {
        $sideEffect = $sideEffect ?? fn () => null;

        $callable = function () use ($state, $machineKey, $sideEffect) {
            $this->update([$machineKey => $state]);
            $sideEffect();
        };

        return $this->{$machineKey}->transitionTo($state, $callable);
    }

    public function canTransitionTo($machineKey, MachineryState $state): bool
    {
        return $this->{$machineKey}->canTransitionTo($state);
    }
}