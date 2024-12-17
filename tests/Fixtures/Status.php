<?php

namespace Hemp\Machinery\Tests\Fixtures;

use Hemp\Machinery\MachineryState;
use Hemp\Machinery\MachineryEnumeration;

enum Status: string implements MachineryState
{
    use MachineryEnumeration;

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
