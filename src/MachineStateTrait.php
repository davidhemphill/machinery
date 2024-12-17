<?php

namespace Hemp\Machinery;

use Exception;

/**
 * @method static transitions()
 */
trait MachineStateTrait
{
    /**
     * @throws Exception
     */
    public function transitionTo(MachineState $state, ?callable $sideEffect = null): MachineState
    {
        $callback = $sideEffect ?? fn () => null;

        if (! $this->isValidTransition($state)) {
            throw new Exception("Cannot transition from state [{$this->value}] to state [{$state->value}].");
        }

        //        $this->callTransitionCallback($state);

        $callback();

        return $state;
    }

    public function canTransitionTo(MachineState $state): bool
    {
        return $this->isValidTransition($state);
    }

    public function isValidTransition(MachineState $state): bool
    {
        return in_array($state, self::transitions()[$this->value]);
    }

    //    public function callTransitionCallback(MachineState $state)
    //    {
    //        $method = 'after'.ucfirst($state->value);
    //
    //        if (method_exists($this, $method)) {
    //            $this->$method();
    //        }
    //    }
}
