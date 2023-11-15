<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaxRequest;
use App\Http\Resources\TaxResource;
use App\Models\Tax;

class TaxController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Tax::class);

        return TaxResource::collection(Tax::all());
    }

    public function store(TaxRequest $request)
    {
        $this->authorize('create', Tax::class);

        return new TaxResource(Tax::create($request->validated()));
    }

    public function show(Tax $tax)
    {
        $this->authorize('view', $tax);

        return new TaxResource($tax);
    }

    public function update(TaxRequest $request, Tax $tax)
    {
        $this->authorize('update', $tax);

        $tax->update($request->validated());

        return new TaxResource($tax);
    }

    public function destroy(Tax $tax)
    {
        $this->authorize('delete', $tax);

        $tax->delete();

        return response()->json();
    }
}
