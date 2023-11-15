<?php

namespace App\Policies;

use App\Models\JournalEntry;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class JournalEntryPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {

    }

    public function view(User $user, JournalEntry $journalEntry): bool
    {
    }

    public function create(User $user): bool
    {
    }

    public function update(User $user, JournalEntry $journalEntry): bool
    {
    }

    public function delete(User $user, JournalEntry $journalEntry): bool
    {
    }

    public function restore(User $user, JournalEntry $journalEntry): bool
    {
    }

    public function forceDelete(User $user, JournalEntry $journalEntry): bool
    {
    }
}
