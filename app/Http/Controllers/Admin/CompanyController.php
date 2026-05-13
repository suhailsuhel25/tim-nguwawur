<?php

// app/Http/Controllers/Admin/CompanyController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCompanyRequest;
use App\Http\Requests\Admin\UpdateCompanyRequest;
use App\Models\Company;

class CompanyController extends Controller
{
    /**
     * Display a listing of companies.
     */
    public function index()
    {
        $query = Company::query();

        if (request()->filled('search')) {
            $q = request('search');
            $query->where(function ($q2) use ($q) {
                $q2->where('name', 'like', "%{$q}%")
                    ->orWhere('industry', 'like', "%{$q}%")
                    ->orWhere('contact_person', 'like', "%{$q}%");
            });
        }

        if (request()->filled('industry')) {
            $query->where('industry', request('industry'));
        }

        $companies  = $query->latest()->paginate(10)->withQueryString();
        $industries = Company::select('industry')->distinct()->orderBy('industry')->pluck('industry');

        return view('admin.companies.index', compact('companies', 'industries'));
    }

    /**
     * Show the form for creating a new company.
     */
    public function create()
    {
        return view('admin.companies.create');
    }

    /**
     * Store a newly created company in storage.
     */
    public function store(StoreCompanyRequest $request)
    {
        Company::create($request->validated());

        return redirect()->route('admin.companies.index')
            ->with('success', 'Perusahaan mitra berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified company.
     */
    public function edit(Company $company)
    {
        return view('admin.companies.edit', compact('company'));
    }

    /**
     * Update the specified company in storage.
     */
    public function update(UpdateCompanyRequest $request, Company $company)
    {
        $company->update($request->validated());

        return redirect()->route('admin.companies.index')
            ->with('success', 'Data perusahaan berhasil diperbarui.');
    }

    /**
     * Remove the specified company from storage (soft delete).
     */
    public function destroy(Company $company)
    {
        $company->delete();

        return redirect()->route('admin.companies.index')
            ->with('success', 'Perusahaan berhasil dihapus.');
    }
}
