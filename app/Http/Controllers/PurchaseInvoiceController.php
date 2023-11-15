<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceRequest;
use App\Http\Requests\PurchaseInvoiceRequest;
use App\Http\Resources\LedgerAccountResource;
use App\Http\Resources\PurchaseInvoiceResource;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\LedgerAccount;
use App\Models\PurchaseInvoice;
use App\Models\SalesInvoice;
use App\Models\Tax;
use Carbon\Carbon;
use Inertia\Inertia;
use Inertia\Response;

class PurchaseInvoiceController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(PurchaseInvoice::class);
    }

    public function index()
    {
        return Inertia::render('PurchaseInvoice/Index', [
            'invoices' => PurchaseInvoiceResource::collection
            (PurchaseInvoice
                ::where('user_id', auth()->user()->id)
                ->where('type', Invoice::PURCHASE_INVOICE)
                ->with('invoiceDetails')
                ->get())
        ]);
    }

    public function create(): Response
    {
        $ledger_accounts = LedgerAccountResource::collection(
            LedgerAccount::where('type', 'expenses')->get()
        );
        $taxes = Tax::all();

        return Inertia::render('PurchaseInvoice/Create', [
            'ledger_accounts' => $ledger_accounts,
            'taxes' => $taxes,
        ]);
    }

    public function store(InvoiceRequest $request)
    {
        $invoice = PurchaseInvoice::create([
            'user_id' => auth()->user()->id,
            'contact_id' => $request->contact_id,
            'invoice_date' => Carbon::parse($request->invoice_date),
            'due_date' => Carbon::parse($request->due_date ?? Carbon::now()->addMonth()),
            'type' => Invoice::PURCHASE_INVOICE,
            'invoice_number' => $request->invoice_number
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

        return redirect(route('purchase_invoices.index'));
    }

    public function show(PurchaseInvoice $purchaseInvoice)
    {
        $this->authorize('view', $purchaseInvoice);

        return new PurchaseInvoiceResource($purchaseInvoice);
    }

    public function update(PurchaseInvoiceRequest $request, PurchaseInvoice $purchaseInvoice)
    {
        $this->authorize('update', $purchaseInvoice);

        $purchaseInvoice->update($request->validated());

        return new PurchaseInvoiceResource($purchaseInvoice);
    }

    public function destroy(PurchaseInvoice $purchaseInvoice)
    {
        $this->authorize('delete', $purchaseInvoice);

        $purchaseInvoice->delete();

        return response()->json();
    }
}
