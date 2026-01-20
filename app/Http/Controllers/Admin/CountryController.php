<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\DataTables\CountryDataTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            'flag'    => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Changed to image
        ]);

        if ($request->hasFile('flag')) {
            $validated['flag'] = uploadFile($request->file('flag'), 'flags');
        }

        Country::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Country added successfully!'
        ]);
    }

    public function edit(Country $country)
    {
        // Re-using the create view for edit logic
        return view('admin.country.create', compact('country'));
    }

    public function update(Request $request, Country $country)
    {
        $validated = $request->validate([
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'iso2'    => 'required|string|max:2|unique:countries,iso2,' . $country->id,
            'flag'    => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Nullable on update
        ]);

        if ($request->hasFile('flag')) {
            // Delete old flag if it exists
            if ($country->flag) {
                Storage::disk('public')->delete($country->flag);
            }
            $validated['flag'] = $request->file('flag')->store('flags', 'public');
        } else {
            // Remove flag from validated array so it doesn't overwrite with null
            unset($validated['flag']);
        }

        $country->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Country updated successfully!'
        ]);
    }

    public function destroy(Country $country)
    {
        if ($country->flag) {
            Storage::disk('public')->delete($country->flag);
        }

        $country->delete();

        return successResponse('Country deleted successfully.');
    }
}
