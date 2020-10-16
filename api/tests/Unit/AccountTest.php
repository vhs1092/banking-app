<?php

namespace Tests\Unit;

use App\Account;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class AccountTest.
 */
class AccountTest extends TestCase
{
    use RefreshDatabase;

    public function testErrorIsReturnedWhenRequestingUnknownAccount()
    {
        $response = $this->get('/api/accounts/10');

        $response
            ->assertStatus(200)
            ->assertJson([
                'errors' => [
                    'message' => 'No query results for model Account.',
                ],
            ]);
    }

    public function testAccountIsReturnedWhenRequestingKnownAccount()
    {
        $account = factory(Account::class)->create();

        $response = $this->get('/api/accounts/'.$account->id);

        $response
            ->assertStatus(200)
            ->assertJson([
                'id' => $account->id,
                'name' => $account->name,
                'balance' => $account->balance,
                'currency' => [
                    'name' => $account->currency->name,
                    'symbol' => $account->currency->symbol,
                ],
            ]);
    }
}
