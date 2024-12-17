<?php

namespace Hemp\Tests\Fixtures;

use Hemp\Machinery\Machinery;
use Illuminate\Database\Eloquent\Model;

class User extends Model implements Machineable
{
    use Machinery;

    protected $casts = [
        'status' => Status::class,
    ];
}