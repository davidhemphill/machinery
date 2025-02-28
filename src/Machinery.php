<?php

namespace Hemp\Machinery;

trait Machinery
{
    public function transitionTo($machineKey, MachineryState $state, ?callable $sideEffect = null): MachineryState
    {
        $state = $this->{$machineKey}->transitionTo($state);

        ($sideEffect ?? fn() => null)($this);

        $this->$machineKey = $state;
        $this->save();

        return $state;
    }

    public function canTransitionTo($machineKey, MachineryState $state): bool
    {
        return $this->{$machineKey}->canTransitionTo($state);
    }
}