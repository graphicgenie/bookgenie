<?php

namespace App\Http\Controllers;

use App\Http\Requests\JournalRequest;
use App\Http\Resources\JournalResource;
use App\Http\Resources\LedgerAccountResource;
use App\Models\Journal;
use App\Models\JournalEntry;
use App\Models\LedgerAccount;
use Inertia\Inertia;

class JournalController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Journal::class);

        return JournalResource::collection(Journal::all());
    }

    public function create()
    {
        return Inertia::render('Journal/Create', [
            'accounts' => LedgerAccountResource::collection(LedgerAccount::all()),
        ]);
    }

    public function store(JournalRequest $request)
    {
        $journal = Journal::create([
            'reference' => $request->reference,
            'journal_date' => $request->journal_date,
        ]);

        foreach ($request->journal_entries as $entry) {
            JournalEntry::create([
                'ledger_account_id' => $entry['ledger_account_id'],
                'journal_id' => $journal->id,
                'description' => $entry['description'],
                'debit' => $entry['debit'],
                'credit' => $entry['credit'],
            ]);
        }

        return Inertia::render('Dashboard');
    }

    public function show(Journal $journal)
    {
        $this->authorize('view', $journal);

        return new JournalResource($journal);
    }

    public function update(JournalRequest $request, Journal $journal)
    {
        $this->authorize('update', $journal);

        $journal->update($request->validated());

        return new JournalResource($journal);
    }

    public function destroy(Journal $journal)
    {
        $this->authorize('delete', $journal);

        $journal->delete();

        return response()->json();
    }
}
