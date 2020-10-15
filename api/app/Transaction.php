<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Transaction
 * @package App
 */
class Transaction extends Model
{

    /**
     * @var array
     */
    protected $fillable = [
        'to',
        'from',
        'amount',
        'details'
    ];

}