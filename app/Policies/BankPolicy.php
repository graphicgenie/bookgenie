<?php

namespace App\Policies;

use App\Models\Bank;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BankPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {

    }

    public function view(User $user, Bank $bank): bool
    {
    }

    public function create(User $user): bool
    {
    }

    public function update(User $user, Bank $bank): bool
    {
    }

    public function delete(User $user, Bank $bank): bool
    {
    }

    public function restore(User $user, Bank $bank): bool
    {
    }

    public function forceDelete(User $user, Bank $bank): bool
    {
    }
}
