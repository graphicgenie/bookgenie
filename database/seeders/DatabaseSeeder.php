<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Contact;
use App\Models\InvoiceDetail;
use App\Models\LedgerAccount;
use App\Models\PurchaseInvoice;
use App\Models\SalesInvoice;
use App\Models\Tax;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithFaker;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory()->create();

        Tax::factory()->create();
        Contact::factory()->create(['user_id' => $user]);

        LedgerAccount::factory()->create(
            ['name' => 'Debiteuren', 'type' => 'current_assets', 'account_type' => 'debit']
        );

        LedgerAccount::factory()->create(
            ['name' => 'Crediteuren', 'type' => 'current_liabilities', 'account_type' => 'credit']
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
            ['name' => 'Kosten', 'type' => 'expenses', 'account_type' => 'result']
        );
        LedgerAccount::factory()->create(
            ['name' => 'Omzet', 'type' => 'revenue', 'account_type' => 'result']
        );


//        for ($i = 0; $i < 50; $i++) {
//            InvoiceDetail::factory()->create([
//                'tax_id' => $tax,
//                'ledger_account_id' => $ledger_account_assets,
//                'invoice_id' => SalesInvoice::factory()->create([
//                    'user_id' => $user,
//                    'contact_id' => Contact::factory()->create(['user_id' => $user])
//                ])
//            ]);
//        }
//
//        for ($i = 0; $i < 50; $i++) {
//            InvoiceDetail::factory()->create([
//                'tax_id' => $tax,
//                'ledger_account_id' => $ledger_account_liabilities,
//                'invoice_id' => PurchaseInvoice::factory()->create([
//                    'user_id' => $user,
//                    'contact_id' => Contact::factory()->create(['user_id' => $user])
//                ])
//            ]);
//        }
    }
}
