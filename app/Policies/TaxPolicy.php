<?php

namespace App\Policies;

use App\Models\Tax;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaxPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {

    }

    public function view(User $user, Tax $tax): bool
    {
    }

    public function create(User $user): bool
    {
    }

    public function update(User $user, Tax $tax): bool
    {
    }

    public function delete(User $user, Tax $tax): bool
    {
    }

    public function restore(User $user, Tax $tax): bool
    {
    }

    public function forceDelete(User $user, Tax $tax): bool
    {
    }
}
