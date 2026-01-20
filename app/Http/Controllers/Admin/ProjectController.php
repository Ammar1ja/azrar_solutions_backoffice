<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ProjectDataTable;
use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Project;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ProjectDataTable $dataTable)
    {
        $services = Service::all();
        $clients = Client::all();
        return $dataTable->render('admin.project.index', compact('services', 'clients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $services = Service::all();
        $clients = Client::all();
        return view('admin.project.create', compact('services', 'clients'));
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
                'en_description' => 'required|string',
                'ar_description' => 'required|string',
                'thumbnail' => 'required|file',
                'project_images.*' => 'nullable|file',
                'project_video' => 'nullable|file|mimes:mp4,avi,mov,wmv|max:10240',
                'date' => 'required|date',
                'project_url' => 'nullable|url',


            ]);
        } catch (ValidationException $e) {
            return validationErrorResponse($e);
        }

        DB::transaction(function () use ($request) {


            $data = [
                'en_title' => $request->en_title,
                'ar_title' => $request->ar_title,
                'en_description' => $request->en_description,
                'ar_description' => $request->ar_description,
                'thumbnail' => uploadFile($request->file('thumbnail'), 'projects/thumbnails'),
                'date' => $request->date,
                'project_url' => $request->project_url,
                'project_video' => $request->hasFile('project_video') ? uploadFile($request->file('project_video'), 'projects/videos') : null,
                'featured' => $request->featured ?? false,
                'client_id' => $request->client_id ?? '1',

            ];

            $project = Project::create($data);

            $project->Services()->sync($request->service_id ?? []);


            if ($request->hasFile('project_images')) {
                $projectImages = [];

                foreach ($request->file('project_images') as $image) {
                    $projectImages[] = uploadFile($image, 'projects/images');
                }

                $project->update([
                    'project_images' => $projectImages
                ]);
            }
        });


        return successResponse('Project created successfully.');
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
        $services = Service::all();
        $clients = Client::all();
        $project = Project::with(['Services', 'Client'])->findOrFail($id);

        $existingProjectImages = collect($project->project_images ?? [])->map(function ($img) {
            return [
                'id'   => $img,
                'name' => basename($img),
                'url'  => asset('storage/' . $img),
            ];
        });

        return view('admin.project.create', compact('services', 'clients', 'project', 'existingProjectImages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        // return $request;
        try {

            $request->validate([
                'en_title' => 'required|string|max:255',
                'ar_title' => 'required|string|max:255',
                'en_description' => 'required|string',
                'ar_description' => 'required|string',
                'project_images.*' => 'nullable|file',
                'date' => 'required|date',
                'project_url' => 'nullable|url',


            ]);
        } catch (ValidationException $e) {
            return validationErrorResponse($e);
        }

        DB::transaction(function () use ($request, $id) {

            $project = Project::findOrFail($id);

            $data = [
                'en_title' => $request->en_title,
                'ar_title' => $request->ar_title,
                'en_description' => $request->en_description,
                'ar_description' => $request->ar_description,
                'date' => $request->date,
                'project_url' => $request->project_url,
                'featured' => $request->featured ?? false,
                'client_id' => $request->client_id ?? '1',


            ];

            if ($request->hasFile(key: 'thumbnail')) {
                $data['thumbnail'] = uploadFile($request->file('icon'), 'projects/thumbnails');
            } elseif ($request->filled('remove_thumbnail')) {
                $data['thumbnail'] = null;
            } elseif ($request->filled('old_thumbnail')) {
                $data['thumbnail'] = $project->thumbnail;
            } else {
                $data['thumbnail'] = null;
            }



            if ($request->hasFile('project_video')) {
                $data['project_video'] = uploadFile($request->file('project_video'), 'projects/videos');
            } elseif ($request->filled('remove_project_video')) {
                $data['project_video'] = null;
            } elseif ($request->filled('old_project_video')) {
                $data['project_video'] = $project->project_video;
            } else {
                $data['project_video'] = null;
            }


            $project->update($data);

            $project->Services()->sync($request->service_id ?? []);


            $oldImages = json_decode($request->old_project_images, true) ?? [];

            $newImages = [];
            if ($request->hasFile('project_images')) {
                foreach ($request->file('project_images') as $image) {
                    $newImages[] = uploadFile($image, 'projects/images');
                }
            }
            $project->update([
                'project_images' => array_merge($oldImages, $newImages)
            ]);
        });


        return successResponse([], 'Project Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $project = Project::findOrFail($id);
        $project->delete();
        $project->Services()->detach();
        return successResponse('Project deleted successfully.');
    }
}
