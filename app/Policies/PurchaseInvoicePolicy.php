<?php

namespace App\Policies;

use App\Models\PurchaseInvoice;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PurchaseInvoicePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, PurchaseInvoice $purchaseInvoice): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, PurchaseInvoice $purchaseInvoice): bool
    {
        return true;
    }

    public function delete(User $user, PurchaseInvoice $purchaseInvoice): bool
    {
        return true;
    }

    public function restore(User $user, PurchaseInvoice $purchaseInvoice): bool
    {
        return true;
    }

    public function forceDelete(User $user, PurchaseInvoice $purchaseInvoice): bool
    {
        return true;
    }
}
