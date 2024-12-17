<?php

namespace Hemp\Machinery;

class PendingTransition
{
    protected string $machine;

    public function __construct(protected Machinable $context) {}

    public function to(MachineState $state, ?callable $sideEffect = null): MachineState
    {
        return $this->context->transitionTo($this->machine, $state, $sideEffect);
    }

    public function __get(string $name)
    {
        $this->machine = $name;

        return $this;
    }
}
