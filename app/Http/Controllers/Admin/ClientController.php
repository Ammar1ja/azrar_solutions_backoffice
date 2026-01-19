<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ClientDataTable;
use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ClientController extends Controller
{
    /**
     * Display a listing of client.
     */

    public function index(ClientDataTable $dataTable)
    {
        return $dataTable->render('admin.client.index');
    }

    /**
     * Show the form for creating a new client.
     */
    public function create()
    {
        $countries = Country::all();
        return view('admin.client.create', compact('countries'));
    }

    /**
     * Store a newly created client in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_ar_name' => 'required|string|max:255',
            'client_en_name' => 'required|string|max:255',
            'client_logo'    => 'required|image|mimes:jpeg,png,jpg,svg|max:2048',
            'website_url'    => 'nullable|url',
            'country_id'     => 'required|exists:countries,id',
        ]);

        if ($request->hasFile('client_logo')) {
            $path = $request->file('client_logo')->store('client', 'public');
            $validated['client_logo'] = $path;
        }

        Client::create($validated);

        return redirect()->route('admin.client.index')
            ->with('success', 'Client added successfully!');
    }

    /**
     * Show the form for editing the specified client.
     */
    public function edit(Client $client) // Using Route Model Binding
    {
        $countries = Country::all();
        return view('admin.client.edit', compact('client', 'countries'));
    }

    /**
     * Update the specified client in storage.
     */
    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'client_ar_name' => 'required|string|max:255',
            'client_en_name' => 'required|string|max:255',
            'client_logo'    => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'website_url'    => 'nullable|url',
            'country_id'     => 'required|exists:countries,id',
        ]);

        if ($request->hasFile('client_logo')) {
            // Delete old logo to keep storage clean
            if ($client->client_logo) {
                Storage::disk('public')->delete($client->client_logo);
            }
            $path = $request->file('client_logo')->store('client', 'public');
            $validated['client_logo'] = $path;
        }

        $client->update($validated);

        return redirect()->route('admin.client.index')
            ->with('success', 'Client updated successfully!');
    }

    /**
     * Remove the specified client from storage.
     */
    public function destroy(Client $client)
    {
        if ($client->client_logo) {
            Storage::disk('public')->delete($client->client_logo);
        }

        $client->delete();

        return redirect()->route('admin.client.index')
            ->with('success', 'Client deleted successfully!');
    }
}
