<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CompanyController extends Controller
{
    // Display all companies
    public function index()
    {
        $companies = Company::withCount('users')
            ->latest()
            ->paginate(10);

        return view('companies.index', compact('companies'));
    }

    // Display create form
    public function create()
    {
        return view('companies.create');
    }

    // Store new company
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:companies,name'],
        ]);

       $data = Company::create($validated);


        return redirect()
            ->route('companies.index')
            ->with('success', 'Company created successfully.');
    }

    // Display edit form
    public function edit(Company $company)
    {
        return view('companies.edit', compact('company'));
    }

    // Update company
    public function update(Request $request, Company $company)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('companies', 'name')->ignore($company->id),
            ],
        ]);

        $company->update($validated);

        return redirect()
            ->route('companies.index')
            ->with('success', 'Company updated successfully.');
    }

    // Delete company
    public function destroy(Company $company)
    {
        $company->delete();

        return redirect()
            ->route('companies.index')
            ->with('success', 'Company deleted successfully. Its users will remain in the system without a company.');
    }
}
