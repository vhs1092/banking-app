
<?php

namespace App\Http\Controllers\Api;

use App\Account;
use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionRequest;
use App\Transaction;
use Illuminate\Http\Request;

/**
 * Class TransactionController.
 */
class TransactionController extends Controller
{
    /**
     * @param Account $account
     * @return mixed
     */
    public function index(Account $account)
    {
        $transactions = Transaction::with('currency', 'to', 'from')
            ->where('from', $account->id)->orWhere('to', $account->id)
            ->get();

        return $transactions;
    }

    /**
     * @param Account $account
     * @param TransactionRequest $request
     * @return mixed
     */
    public function store(Account $account, TransactionRequest $request)
    {
        $toAccount = Account::find($request->input('to'));

        $amount = $request->input('amount');
        $details = $request->input('details');

        $account->update(['balance' => ($account->balance - $amount)]);

        $toAccount->update(['balance' => ($toAccount->balance + $amount)]);

        $transaction = Transaction::create([
            'amount' => $amount,
            'details' => $details,
            'from' => $account->id,
            'to' => $toAccount->id,
            'currency_id' => $account->currency->id,
        ]);

        return $transaction;
    }
}
