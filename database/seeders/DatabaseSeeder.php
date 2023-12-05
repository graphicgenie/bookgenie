<?php

namespace Database\Seeders;

use App\Models\LedgerAccount;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        LedgerAccount::factory()->create(
            ['name' => 'Debiteuren', 'type' => 'current_assets', 'account_type' => 'debit']
        );

        LedgerAccount::factory()->create(
            [
                'name' => 'Te rubriceren transacties',
                'type' => 'current_assets',
                'account_type' => 'debit'
            ]
        );

        $btw = LedgerAccount::factory()->create(
            ['name' => 'BTW', 'type' => 'current_assets', 'account_type' => 'debit']
        );

        LedgerAccount::factory()->create(
            [
                'name' => 'Te ontvangen BTW',
                'type' => 'current_assets',
                'account_type' => 'debit',
                'parent_id' => $btw->id
            ]
        );

        LedgerAccount::factory()->create(
            [
                'name' => 'Te betalen BTW',
                'type' => 'current_assets',
                'account_type' => 'debit',
                'parent_id' => $btw->id
            ]
        );

        LedgerAccount::factory()->create(
            ['name' => 'Crediteuren', 'type' => 'current_liabilities', 'account_type' => 'credit']
        );

        LedgerAccount::factory()->create(
            ['name' => 'Kosten', 'type' => 'expenses', 'account_type' => 'result']
        );

        LedgerAccount::factory()->create(
            ['name' => 'Omzet', 'type' => 'revenue', 'account_type' => 'result']
        );
    }
}
