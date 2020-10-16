<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class TransactionRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * @param Request $request
     * @return array
     */
    public function rules(Request $request)
    {
        $fromAccount = $request->route('account');

        return [
            'to' => [
                'required',
                'exists:accounts,id',
                'not_in:'.$fromAccount->id,
            ],
            'details' => [
                'required',
            ],
            'amount' => [
                'required',
                'regex:/^\d+(\.\d{1,2})?$/',
                'lte:'.$fromAccount->balance,
            ],
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'to.required' => 'Please enter the account.',
            'to.exists' => 'The account you are trying to send do not exist.',
            'to.not_in' => 'Sorry. You can not send money to yourself.',

            'details.required' => 'Please enter the details.',

            'amount.required' => 'Please enter the amount.',
            'amount.regex' => 'Please enter a correctly formatted money amount.',
            'amount.lte' => 'You do not have enough money to send.',
        ];
    }
}
