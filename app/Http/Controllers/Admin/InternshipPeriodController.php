<?php

// app/Http/Controllers/Admin/InternshipPeriodController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreInternshipPeriodRequest;
use App\Http\Requests\Admin\UpdateInternshipPeriodRequest;
use App\Models\InternshipPeriod;

class InternshipPeriodController extends Controller
{
    /**
     * Display a listing of internship periods.
     */
    public function index()
    {
        $query = InternshipPeriod::withCount('internships');

        if (request()->filled('search')) {
            $q = request('search');
            $query->where('name', 'like', "%{$q}%");
        }

        if (request()->filled('status')) {
            $query->where('is_active', request('status') === 'active' ? 1 : 0);
        }

        $periods = $query->orderByDesc('start_date')->paginate(10)->withQueryString();

        return view('admin.periods.index', compact('periods'));
    }

    /**
     * Show the form for creating a new internship period.
     */
    public function create()
    {
        return view('admin.periods.create');
    }

    /**
     * Store a newly created internship period in storage.
     */
    public function store(StoreInternshipPeriodRequest $request)
    {
        $data              = $request->validated();
        $data['is_active'] = $request->boolean('is_active');

        InternshipPeriod::create($data);

        return redirect()->route('admin.periods.index')
            ->with('success', 'Periode magang berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified internship period.
     */
    public function edit(InternshipPeriod $period)
    {
        return view('admin.periods.edit', compact('period'));
    }

    /**
     * Update the specified internship period in storage.
     */
    public function update(UpdateInternshipPeriodRequest $request, InternshipPeriod $period)
    {
        $data              = $request->validated();
        $data['is_active'] = $request->boolean('is_active');

        $period->update($data);

        return redirect()->route('admin.periods.index')
            ->with('success', 'Data periode magang berhasil diperbarui.');
    }

    /**
     * Remove the specified internship period from storage (soft delete).
     */
    public function destroy(InternshipPeriod $period)
    {
        $period->delete();

        return redirect()->route('admin.periods.index')
            ->with('success', 'Periode magang berhasil dihapus.');
    }
}
