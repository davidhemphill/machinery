<?php

namespace Hemp\Machinery;

/**
 * @method static transitions()
 */
trait MachineStateTrait
{
    /**
     * @throws InvalidStateTransition
     */
    public function transitionTo(MachineState $state, ?callable $sideEffect = null): MachineState
    {
        $callback = $sideEffect ?? fn () => null;

        if (! $this->isValidTransition($state)) {
            throw new InvalidStateTransition("Cannot transition from state [{$this->value}] to state [{$state->value}].");
        }

        $callback();

        return $state;
    }

    public function isValidTransition(MachineState $state): bool
    {
        return in_array($state, self::transitions()[$this->value]);
    }
}
