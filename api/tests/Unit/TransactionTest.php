<?php

namespace Tests\Unit;

use App\Account;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class AccountTest.
 */
class TransactionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var
     */
    protected $url;

    /**
     * @var
     */
    protected $fromAccount;

    /**
     * @var
     */
    protected $toAccount;

    public function setUp(): void
    {
        parent::setUp();

        $this->toAccount = factory(Account::class)->create();
        $this->fromAccount = factory(Account::class)->create();

        $this->url = '/api/accounts/'.$this->fromAccount->id.'/transactions';
    }

    public function testSuccessfulTransaction()
    {
        $amount = 100;
        $details = 'Sample Transaction';

        $response = $this->postJson($this->url, [
            'to' => $this->toAccount->id,
            'details' => $details,
            'amount' => $amount,
            'currency_id' => $this->fromAccount->currency->id,
        ]);

        $response
            ->assertStatus(201)
            ->assertJson([
                'amount' => $amount,
                'details' => $details,
                'to' => $this->toAccount->id,
                'from' => $this->fromAccount->id,
                'currency_id' => $this->fromAccount->currency_id,
            ]);
    }

    public function testTransactionStoringFailsWhenNextInputtingToField()
    {
        $response = $this->postJson($this->url, [
            'to' => '',
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonStructure([
                'message', 'errors',
            ])
            ->assertJson([
                'message' => 'The given data was invalid.',
            ])
            ->assertJsonFragment([
                'to' => [
                    'Please enter the to account.',
                ],
            ]);
    }

    public function testTransactionStoringFailsWhenNextInputtingToFieldForUnknownAccount()
    {
        $response = $this->postJson($this->url, [
            'to' => 1000,
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonStructure([
                'message', 'errors',
            ])
            ->assertJson([
                'message' => 'The given data was invalid.',
            ])
            ->assertJsonFragment([
                'to' => [
                    'The account does not exist.',
                ],
            ]);
    }

    public function testTransactionStoringFailsWhenNextInputtingToFieldSameAsFromAccount()
    {
        $response = $this->postJson($this->url, [
            'to' => $this->fromAccount->id,
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonStructure([
                'message', 'errors',
            ])
            ->assertJson([
                'message' => 'The given data was invalid.',
            ])
            ->assertJsonFragment([
                'to' => [
                    'You can not send money to yourself.',
                ],
            ]);
    }

    public function testTransactionStoringFailsWhenNextInputtingDetailsField()
    {
        $response = $this->postJson($this->url, [
            'details' => '',
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonStructure([
                'message', 'errors',
            ])
            ->assertJson([
                'message' => 'The given data was invalid.',
            ])
            ->assertJsonFragment([
                'details' => [
                    'Please enter details.',
                ],
            ]);
    }

    public function testTransactionStoringFailsWhenNextInputtingAmountField()
    {
        $response = $this->postJson($this->url, [
            'amount' => '',
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonStructure([
                'message', 'errors',
            ])
            ->assertJson([
                'message' => 'The given data was invalid.',
            ])
            ->assertJsonFragment([
                'amount' => [
                    'Please enter the amount.',
                ],
            ]);
    }

    public function testTransactionStoringFailsWhenNextInputtingAmountFieldNotFormattedCorrectly()
    {
        $response = $this->postJson($this->url, [
            'amount' => '10.10.10',
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonStructure([
                'message', 'errors',
            ])
            ->assertJson([
                'message' => 'The given data was invalid.',
            ])
            ->assertJsonFragment([
                'amount' => [
                    'Please enter a correct money amount.',
                    'You do not have enough balance to send.',
                ],
            ]);
    }

    public function testTransactionStoringFailsWhenNextInputtingAmountFieldIsGreaterThanFromAccountBalance()
    {
        $response = $this->postJson($this->url, [
            'amount' => ($this->fromAccount->balance + 1000),
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonStructure([
                'message', 'errors',
            ])
            ->assertJson([
                'message' => 'The given data was invalid.',
            ])
            ->assertJsonFragment([
                'amount' => [
                    'You do not have enough balance to send.',
                ],
            ]);
    }
}
