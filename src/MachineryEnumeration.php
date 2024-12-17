<?php

namespace Hemp\Machinery;

/**
 * @method static transitions()
 */
trait MachineryEnumeration
{
    /**
     * @throws InvalidStateTransition
     */
    public function transitionTo(MachineryState $state, ?callable $sideEffect = null): MachineryState
    {

        if (!$this->canTransitionTo($state)) {
            throw new InvalidStateTransition("Cannot transition from state [{$this->value}] to state [{$state->value}].");
        }

        call_user_func($sideEffect ?? fn() => null);

        return $state;
    }

    public function canTransitionTo(MachineryState $state): bool
    {
        return in_array($state, self::transitions()[$this->value]);
    }

    public function is(MachineryState $state): bool
    {
        return $this->value === $state->value;
    }
}
