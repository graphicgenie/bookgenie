<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyRequest;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use Inertia\Inertia;

class CompanyController extends Controller
{
    public function index()
    {
        $company = Company::first();

        if ($company) {
            return Inertia::render('Company/Edit', ['company' => $company]);
        }

        return Inertia::render('Company/Create');
    }

    public function store(CompanyRequest $request)
    {
        $request->merge(['user_id' => auth()->user()->id]);

        Company::create($request->all());

        return redirect(route('company.index'));
    }

    public function show(Company $company)
    {
        $this->authorize('view', $company);

        return new CompanyResource($company);
    }

    public function update(CompanyRequest $request, Company $company)
    {
        $company->update($request->validated());

        return redirect(route('company.index'));
    }

    public function destroy(Company $company)
    {
        $this->authorize('delete', $company);

        $company->delete();

        return response()->json();
    }
}
