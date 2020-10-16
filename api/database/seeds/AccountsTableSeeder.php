<?php

use Illuminate\Database\Seeder;

class AccountsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $euCurrency = factory(\App\Currency::class)->create();
        $usCurrency = factory(\App\Currency::class)->create([
            'name' => 'usd',
            'symbol' => '$',
        ]);

        DB::table('accounts')->insert([
            'name' => 'John',
            'balance' => 15000,
            'currency_id' => $euCurrency->id,
        ]);

        DB::table('accounts')->insert([
            'name' => 'Peter',
            'balance' => 100000,
            'currency_id' => $usCurrency->id,
        ]);
    }
}
