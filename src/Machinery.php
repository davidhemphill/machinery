<?php

namespace Hemp\Machinery;

trait Machinery
{
    public function transition()
    {
        return new PendingTransition($this);
    }

    public function transitionTo($machineKey, MachineState $state, ?callable $sideEffect = null): MachineState
    {
        $sideEffect = $sideEffect ?? fn () => null;

        $callable = function () use ($state, $machineKey, $sideEffect) {
            $sideEffect();
            $this->update([$machineKey => $state]);
        };

        return $this->{$machineKey}->transitionTo($state, $callable);
    }
}