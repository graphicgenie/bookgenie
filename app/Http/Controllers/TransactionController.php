<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionRequest;
use App\Http\Resources\BankResource;
use App\Http\Resources\TransactionResource;
use App\Models\Bank;
use App\Models\Invoice;
use App\Models\LedgerAccount;
use App\Models\Transaction;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Kingsquare\Parser\Banking\Mt940;
use Illuminate\Database\Eloquent\Builder;

class TransactionController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Transaction::class);
    }

    public function index()
    {
        return Inertia::render('Transactions/Index', [
            'transactions' => TransactionResource::collection(Transaction::where('user_id', auth()->user()->id)
                ->orderBy('timestamp')->get())
        ]);
    }

    public function create()
    {
        return Inertia::render('Transactions/Create', [
            'banks' => BankResource::collection(Bank::where('user_id', auth()->user()->id)->get())
        ]);
    }

    public function store(TransactionRequest $request)
    {
        $parser = new Mt940();
        foreach ($parser->parse($request->file('transactions')->get(), new Mt940\Engine\Bunq()) as $key => $statement) {
            $transactions = $statement->getTransactions();
            foreach ($transactions as $transaction) {
                Transaction::firstOrCreate([
                    'user_id' => auth()->user()->id,
                    'amount' => $transaction->getPrice(),
                    'type' => $transaction->getDebitCredit(),
                    'description' => $transaction->getDescription(),
                ], [
                    'bank_id' => $request->bank_id,
                    'timestamp' => $transaction->getValueTimestamp(),
                    'code' => $transaction->getTransactionCode()
                ]);
            }
        }

        return redirect(route('transactions.index'));
    }

    public function show(Transaction $transaction)
    {
        $this->authorize('view', $transaction);

        return new TransactionResource($transaction);
    }

    public function update(TransactionRequest $request, Transaction $transaction)
    {
        $transaction->update([
            'link_id' => $request->link_id,
            'link_type' => $request->link_type
        ]);

        return $transaction;
    }

    public function destroy(Transaction $transaction)
    {
        $this->authorize('delete', $transaction);

        $transaction->delete();

        return response()->json();
    }

    public function search(Request $request)
    {
        $response['invoices'] = Invoice
            ::where('user_id', auth()->user()->id)
            ->with('contact')
            ->with('transactions')
            ->where(function (Builder $query) use ($request) {
                $query
                    ->where('invoice_number', 'like', '%'.$request->get('query').'%')
                    ->orWhereHas('contact', function (Builder $query) use ($request) {
                        $query
                            ->where('company_name', 'like', '%'.$request->get('query').'%')
                            ->orWhere('firstname', 'like', '%'.$request->get('query').'%')
                            ->orWhere('lastname', 'like', '%'.$request->get('query').'%');
                    });
            })
            ->get()
            ->toArray();

        $response['ledgers'] = LedgerAccount
            ::where('user_id', 0)
            ->orWhere('user_id', auth()->user()->id)
            ->get()
            ->toArray();

        return response()->json($response);
    }
}
