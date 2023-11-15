<?php

namespace App\Http\Controllers;

use App\Http\Requests\BankRequest;
use App\Http\Resources\BankResource;
use App\Models\Bank;

class BankController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Bank::class);

        return BankResource::collection(Bank::all());
    }

    public function store(BankRequest $request)
    {
        $this->authorize('create', Bank::class);

        return new BankResource(Bank::create($request->validated()));
    }

    public function show(Bank $bank)
    {
        $this->authorize('view', $bank);

        return new BankResource($bank);
    }

    public function update(BankRequest $request, Bank $bank)
    {
        $this->authorize('update', $bank);

        $bank->update($request->validated());

        return new BankResource($bank);
    }

    public function destroy(Bank $bank)
    {
        $this->authorize('delete', $bank);

        $bank->delete();

        return response()->json();
    }
}
