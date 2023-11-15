<?php

namespace App\Http\Controllers;

use App\Http\Requests\LedgerAccountRequest;
use App\Http\Resources\LedgerAccountResource;
use App\Models\LedgerAccount;
use Inertia\Inertia;

class LedgerAccountController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(LedgerAccount::class);
    }

    public function index()
    {
        return Inertia::render('LedgerAccount/Index');
    }

    public function create()
    {
        $types = [
            ['id' => LedgerAccount::CURRENT_ASSETS, 'name' => 'Vlottende activa'],
            ['id' => LedgerAccount::NON_CURRENT_ASSETS, 'name' => 'Vaste activa'],
            ['id' => LedgerAccount::EQUITY, 'name' => 'Eigen vermogen'],
            ['id' => LedgerAccount::CURRENT_LIABILITIES, 'name' => 'Kort vreemd vermogen'],
            ['id' => LedgerAccount::NON_CURRENT_LIABILITIES, 'name' => 'Lang vreemd vermogen'],
            ['id' => LedgerAccount::PROVISION, 'name' => 'Voorzieningen'],
            ['id' => LedgerAccount::EXPENSES, 'name' => 'Kosten'],
            ['id' => LedgerAccount::REVENUE, 'name' => 'Omzet'],
        ];

        return Inertia::render('LedgerAccount/Create', [
            'accounts' => LedgerAccountResource::collection(LedgerAccount::all()),
            'types' => $types,
            'parents' => LedgerAccount
                ::where('user_id', auth()->user()->id)
                ->orWhere('parent_id', 0)->get(),
        ]);
    }

    public function store(LedgerAccountRequest $request)
    {
        LedgerAccount::create([
            'user_id' => auth()->user()->id,
            'parent_id' => $request->parent_id ?? 0,
            'name' => $request->name,
            'type' => $request->type,
            'account_type' => $request->account_type
        ]);

        return redirect(route('ledger_accounts.index'));
    }

    public function show(LedgerAccount $legderAccount)
    {
        $this->authorize('view', $legderAccount);

        return new LedgerAccountResource($legderAccount);
    }

    public function update(LedgerAccountRequest $request, LedgerAccount $legderAccount)
    {
        $this->authorize('update', $legderAccount);

        $legderAccount->update($request->validated());

        return new LedgerAccountResource($legderAccount);
    }

    public function destroy(LedgerAccount $legderAccount)
    {
        $this->authorize('delete', $legderAccount);

        $legderAccount->delete();

        return response()->json();
    }
}
