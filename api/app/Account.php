<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Account
 * @package App
 */
class Account extends Model
{

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'balance'
    ];

}