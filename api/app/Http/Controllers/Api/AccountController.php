<?php

namespace App\Http\Controllers\Api;

use App\Account;
use App\Http\Controllers\Controller;

/**
 * Class AccountController.
 */
class AccountController extends Controller
{
    /**
     * @param Account $account
     * @return array
     */
    public function show(Account $account)
    {
        return [
            'id' => $account->id,
            'name' => $account->name,
            'balance' => $account->balance,
            'currency' => [
                'name' => $account->currency->name,
                'symbol' => $account->currency->symbol,
            ],
        ];
    }
}
