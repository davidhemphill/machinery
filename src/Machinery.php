<?php

namespace Hemp\Machinery;

trait Machinery
{
    public function transitionTo($machineKey, MachineryState $state, ?callable $sideEffect = null): MachineryState
    {
        if (!$this->canTransitionTo($machineKey, $state)) {
            throw new InvalidStateTransition("Cannot transition from state [{$this->{$machineKey}->value}] to state [{$state->value}].");
        }

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