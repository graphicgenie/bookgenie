<?php

namespace App\Policies;

use App\Models\upload;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class uploadPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {

    }

    public function view(User $user, upload $upload): bool
    {
    }

    public function create(User $user): bool
    {
    }

    public function update(User $user, upload $upload): bool
    {
    }

    public function delete(User $user, upload $upload): bool
    {
    }

    public function restore(User $user, upload $upload): bool
    {
    }

    public function forceDelete(User $user, upload $upload): bool
    {
    }
}
