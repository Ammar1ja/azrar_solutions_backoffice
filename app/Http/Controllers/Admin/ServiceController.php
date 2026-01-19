<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ServiceDataTable;
use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ServiceDataTable $dataTable)
    {
        return $dataTable->render('admin.service.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.service.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            $request->validate([
                'en_title' => 'required|string|max:255',
                'ar_title' => 'required|string|max:255',
                'icon' => 'required|file|mimes:jpg,jpeg,png,svg,gif|max:2048',
                'en_description' => 'required|string',
                'ar_description' => 'required|string',
                'en_button_text' => 'nullable|string',
                'ar_button_text' => 'nullable|string',
                'image' => 'required|file|mimes:jpg,jpeg,png,svg,gif|max:2048',

            ]);
        } catch (ValidationException $e) {
            return validationErrorResponse($e);
        }




        DB::transaction(function () use ($request) {
            $service = Service::create([
                'en_title' => $request->en_title,
                'ar_title' => $request->ar_title,
                'icon' => uploadFile($request->file('icon'), 'services/icons'),
                'en_description' => $request->en_description,
                'ar_description' => $request->ar_description,
                'en_button_text' => $request->en_button_text,
                'ar_button_text' => $request->ar_button_text,
                'image' => uploadFile($request->file('image'), 'services/images'),
            ]);



            if ($request->filled('features')) {

                foreach ($request->features as $feature) {
                    $data['en_name'] = $feature['en_feature'] ?? '';
                    $data['ar_name'] = $feature['ar_feature'] ?? '';
                    $service->Features()->create($data);
                }
            }


            return successResponse('Service created successfully');
        });
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $service = Service::with('Features')->findOrFail($id);
        return view('admin.service.create', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {

            $request->validate([
                'en_title' => 'required|string|max:255',
                'ar_title' => 'required|string|max:255',
                'en_description' => 'required|string',
                'ar_description' => 'required|string',
                'en_button_text' => 'nullable|string',
                'ar_button_text' => 'nullable|string',

            ]);
        } catch (ValidationException $e) {
            return validationErrorResponse($e);
        }




        DB::transaction(function () use ($request, $id) {
            $service = Service::findOrFail($id);
            $data = [
                'en_title' => $request->en_title,
                'ar_title' => $request->ar_title,
                'en_description' => $request->en_description,
                'ar_description' => $request->ar_description,
                'en_button_text' => $request->en_button_text,
                'ar_button_text' => $request->ar_button_text,
            ];

            if ($request->hasFile('icon')) {
                $data['icon'] = uploadFile($request->file('icon'), 'services/icons');
            } elseif ($request->filled('remove_icon')) {
                $data['icon'] = null;
            } elseif ($request->filled('old_icon')) {
                $data['icon'] = $service->icon;
            } else {
                $data['icon'] = null;
            }


            if ($request->hasFile('image')) {
                $data['image'] = uploadFile($request->file('image'), 'services/images');
            } elseif ($request->filled('remove_image')) {
                $data['image'] = null;
            } elseif ($request->filled('old_image')) {
                $data['image'] = $service->image;
            } else {
                $data['image'] = null;
            }
            $service->update($data);


            $service->Features()->delete();
            if ($request->filled('features')) {

                foreach ($request->features as $feature) {
                    $data['en_name'] = $feature['en_feature'] ?? '';
                    $data['ar_name'] = $feature['ar_feature'] ?? '';
                    $service->Features()->create($data);
                }
            }


            return successResponse('Service created successfully');
        });
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $service = Service::findOrFail($id);
        $service->delete();
        $service->Features()->delete();
        return successResponse('Service deleted successfully');
    }
}
