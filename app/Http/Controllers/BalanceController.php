<?php

namespace App\Http\Controllers;

use App\Http\Resources\LedgerAccountResource;
use App\Models\LedgerAccount;
use Inertia\Inertia;

class BalanceController extends Controller
{
    public function __invoke()
    {
        $nonCurrentAssets = LedgerAccountResource::collection(
            LedgerAccount::where('type', 'non_current_assets')->get()
        );
        $currentAssets = LedgerAccountResource::collection(
            LedgerAccount::where('type', 'current_assets')->get()
        );
        $expenses = LedgerAccountResource::collection(
            LedgerAccount::where('type', 'expenses')->get()
        );
        $revenue = LedgerAccountResource::collection(
            LedgerAccount::where('type', 'revenue')->get()
        );
        

        $totalAssets = $this->total($nonCurrentAssets) + $this->total($currentAssets);

        $equity = LedgerAccountResource::collection(
            LedgerAccount::where('type', 'equity')->get()
        );
        $currentLiabilities = LedgerAccountResource::collection(
            LedgerAccount::where('type', 'current_liabilities')->get()
        );

        $totalLiabilities =
            $this->total($currentLiabilities) + $this->total($equity) +
            ($this->total($revenue) - $this->total($expenses));

        return Inertia::render('Balance/Index', [
            'nonCurrentAssets' => $nonCurrentAssets,
            'currentAssets' => $currentAssets,
            'expenses' => $expenses,
            'equity' => $equity,
            'currentLiabilities' => $currentLiabilities,
            'revenue' => $this->total($revenue) - $this->total($expenses),
            'total_assets' => $totalAssets,
            'total_liabilities' => $totalLiabilities,
        ]);
    }

    protected function total($collection): float
    {
        $total = 0;

        foreach ($collection as $asset) {
            $total += $asset->total;
        }

        return $total;
    }
}
