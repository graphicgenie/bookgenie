<?php

namespace App\Http\Controllers;

use App\Http\Requests\JournalEntryRequest;
use App\Http\Resources\JournalEntryResource;
use App\Http\Resources\LedgerAccountResource;
use App\Models\JournalEntry;
use App\Models\LedgerAccount;
use Inertia\Inertia;

class JournalEntryController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', JournalEntry::class);

        return JournalEntryResource::collection(JournalEntry::all());
    }

    public function create()
    {
        return Inertia::render('Journal/Create', [
            'accounts' => LedgerAccountResource::collection(LedgerAccount::all()),
        ]);
    }

    public function store(JournalEntryRequest $request)
    {
        $this->authorize('create', JournalEntry::class);

        return new JournalEntryResource(JournalEntry::create($request->validated()));
    }

    public function show(JournalEntry $journalEntry)
    {
        $this->authorize('view', $journalEntry);

        return new JournalEntryResource($journalEntry);
    }

    public function update(JournalEntryRequest $request, JournalEntry $journalEntry)
    {
        $this->authorize('update', $journalEntry);

        $journalEntry->update($request->validated());

        return new JournalEntryResource($journalEntry);
    }

    public function destroy(JournalEntry $journalEntry)
    {
        $this->authorize('delete', $journalEntry);

        $journalEntry->delete();

        return response()->json();
    }
}
