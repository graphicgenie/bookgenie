<?php

namespace App\Policies;

use App\Models\LedgerAccount;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LedgerAccountPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, LedgerAccount $legderAccount): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, LedgerAccount $legderAccount): bool
    {
        return true;
    }

    public function delete(User $user, LedgerAccount $legderAccount): bool
    {
        return true;
    }

    public function restore(User $user, LedgerAccount $legderAccount): bool
    {
        return true;
    }

    public function forceDelete(User $user, LedgerAccount $legderAccount): bool
    {
        return true;
    }
}
