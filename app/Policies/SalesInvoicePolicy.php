<?php

namespace App\Policies;

use App\Models\SalesInvoice;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SalesInvoicePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {

    }

    public function view(User $user, SalesInvoice $salesInvoice)
    {
    }

    public function create(User $user)
    {
    }

    public function update(User $user, SalesInvoice $salesInvoice)
    {
    }

    public function delete(User $user, SalesInvoice $salesInvoice)
    {
    }

    public function restore(User $user, SalesInvoice $salesInvoice)
    {
    }

    public function forceDelete(User $user, SalesInvoice $salesInvoice)
    {
    }
}
