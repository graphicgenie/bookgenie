<?php

namespace App\Http\Controllers;

use App\Http\Resources\LedgerAccountResource;
use App\Models\LedgerAccount;
use Inertia\Inertia;

class ProfitLossController extends Controller
{
    public function __invoke()
    {
        return Inertia::render('ProfitLoss/Index', [
            'revenue' =>
                LedgerAccountResource::collection(
                    LedgerAccount::where('type', LedgerAccount::REVENUE)->get()
                ),
            'expenses' =>
                LedgerAccountResource::collection(
                    LedgerAccount::where('type', LedgerAccount::EXPENSES)->get()
                ),
        ]);
    }
}
