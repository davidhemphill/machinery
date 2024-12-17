<?php

namespace Hemp\Tests\Fixtures;

use Hemp\Machinery\MachineState;
use Hemp\Machinery\MachineStateTrait;
use Override;

enum Status: string implements MachineState
{
    use MachineStateTrait;

    case Active = 'active';

    case Inactive = 'inactive';

    case Banned = 'banned';

    public static function transitions(): array
    {
        return [
            self::Active->value => [
                self::Inactive,
                self::Banned,
            ],
            self::Inactive->value => [
                self::Active,
                self::Banned,
            ],
            self::Banned->value => [
                //
            ],
        ];
    }
}
