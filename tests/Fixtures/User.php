<?php

namespace Hemp\Machinery\Tests\Fixtures;

use Hemp\Machinery\Machinable;
use Hemp\Machinery\Machinery;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use Machinery;

    protected $guarded = [];

    protected $casts = [
        'status' => Status::class,
    ];
}