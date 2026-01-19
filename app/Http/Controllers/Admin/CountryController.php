<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\DataTables\CountryDataTable;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function index(CountryDataTable $dataTable)
    {
        return $dataTable->render('admin.country.index');
    }

    public function create()
    {
        return view('admin.country.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'iso2'    => 'required|string|max:2|unique:countries',
            'flag'    => 'nullable|string|max:10',
        ]);

        Country::create($validated);

        return redirect()->route('admin.country.index')
            ->with('success', 'Country added successfully!');
    }

    public function edit(Country $country)
    {
        return view('admin.country.edit', compact('country'));
    }

    public function update(Request $request, Country $country)
    {
        $validated = $request->validate([
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'iso2'    => 'required|string|max:2|unique:countries,iso2,' . $country->id,
            'flag'    => 'nullable|string|max:10',
        ]);

        $country->update($validated);

        return redirect()->route('admin.country.index')
            ->with('success', 'Country updated successfully!');
    }

    public function destroy(Country $country)
    {
        $country->delete();
        return redirect()->route('admin.country.index')
            ->with('success', 'Country deleted successfully!');
    }
}
