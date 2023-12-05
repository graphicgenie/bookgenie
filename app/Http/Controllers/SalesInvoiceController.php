<?php

namespace App\Http\Controllers;

use App\Enums\Invoice;
use App\Http\Requests\InvoiceRequest;
use App\Http\Resources\LedgerAccountResource;
use App\Http\Resources\SalesInvoiceResource;
use App\Models\InvoiceDetail;
use App\Models\LedgerAccount;
use App\Models\SalesInvoice;
use App\Models\Tax;
use Carbon\Carbon;
use Inertia\Inertia;

class SalesInvoiceController extends Controller
{
    public function index()
    {
        return Inertia::render('SalesInvoice/Index',
            [
                'invoices' => SalesInvoiceResource::collection(
                    SalesInvoice
                        ::where('user_id', auth()->user()->id)
                        ->where('type', Invoice::SALES_INVOICE)
                        ->with('invoiceDetails')
                        ->get()
                )
            ]
        );
    }

    public function create()
    {
        $ledger_accounts = LedgerAccountResource::collection(
            LedgerAccount::where('type', 'revenue')->get()
        );
        $taxes = Tax::all();

        return Inertia::render('SalesInvoice/Create', [
            'ledger_accounts' => $ledger_accounts,
            'taxes' => $taxes,
        ]);
    }

    public function store(InvoiceRequest $request)
    {
        $invoice = SalesInvoice::create([
            'user_id' => auth()->user()->id,
            'contact_id' => $request->contact_id,
            'invoice_date' => Carbon::parse($request->invoice_date),
            'due_date' => Carbon::parse($request->due_date),
            'type' => Invoice::SALES_INVOICE,
            'invoice_number' => SalesInvoice::nextInvoiceNumber()
        ]);

        foreach ($request->invoices_details as $detail) {
            InvoiceDetail::create([
                'description' => $detail['description'],
                'tax_id' => $detail['tax_id'],
                'amount' => $detail['amount'],
                'price' => $detail['price'],
                'invoice_id' => $invoice['id'],
                'ledger_account_id' => $detail['ledger_account_id'],
            ]);
        }

        return redirect(route('sales_invoices.index'));
    }

    public function show(SalesInvoice $salesInvoice)
    {

    }

    public function edit(InvoiceRequest $request)
    {

    }

    public function update(InvoiceRequest $request)
    {

    }

    public function destroy(InvoiceRequest $request)
    {

    }
}
