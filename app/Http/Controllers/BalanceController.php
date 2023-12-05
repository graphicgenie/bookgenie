<?php

namespace App\Http\Controllers;

use App\Http\Resources\LedgerAccountResource;
use App\Models\LedgerAccount;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BalanceController extends Controller
{
    public function __invoke(Request $request)
    {
        $start = Carbon::now()->startOfYear();
        $end = $request->end_date ? Carbon::parse($request->end_date)->endOfDay() : Carbon::now()->endOfYear();

        $nonCurrentAssets = LedgerAccountResource::collection(
            LedgerAccount::where('type', 'non_current_assets')
                ->dateBetween($start, $end)
                ->get()
        );
        $currentAssets = LedgerAccountResource::collection(
            LedgerAccount::where('type', 'current_assets')
                ->dateBetween($start, $end)
                ->get()
        );

        $expenses = LedgerAccountResource::collection(
            LedgerAccount::where('type', 'expenses')
                ->dateBetween($start, $end)
                ->get()
        );
        $revenue = LedgerAccountResource::collection(
            LedgerAccount::where('type', 'revenue')
                ->dateBetween($start, $end)
                ->get()
        );


        $totalAssets = $this->total($nonCurrentAssets) + $this->total($currentAssets);

        $equity = LedgerAccountResource::collection(
            LedgerAccount::where('type', 'equity')
                ->dateBetween($start, $end)
                ->get()
        );
        $currentLiabilities = LedgerAccountResource::collection(
            LedgerAccount::where('type', 'current_liabilities')
                ->dateBetween($start, $end)
                ->get()
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
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
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
