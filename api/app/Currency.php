<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Currency.
 */
class Currency extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'name', 'symbol',
    ];

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function accounts()
    {
        return $this->hasMany(Account::class);
    }
}
