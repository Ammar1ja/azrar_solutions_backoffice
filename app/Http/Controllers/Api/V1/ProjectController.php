<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $projects = Project::with(['Client'])
            ->when($request->has('service_id'), function ($query) use ($request) {
                $query->whereHas('Services', function ($q) use ($request) {
                    $q->where('services.id', $request->input('service_id'));
                });
            })
            ->when($request->has('client_id'), function ($query) use ($request) {
                $query->where('client_id', $request->input('client_id'));
            })
            ->when($request->filled('country_id'), function ($query) use ($request) {
                $query->whereHas('Client', function ($q) use ($request) {
                    $q->where('country_id', $request->input('country_id'));
                });
            })
            ->get();
        return successResponse(ProjectResource::collection($projects), 'Projects retrieved successfully');
    }

    public function show(Request $request, $id)
    {
        $project = Project::with(['Services', 'Client.Country'])->findOrFail($id);
        return successResponse(new ProjectResource($project), 'Project retrieved successfully');
    }


    public function relatedProjects($id)
    {

        $project = Project::with(['Client.Country'])->findOrFail($id);
        $relatedProjects = Project::where(function ($query) use ($project) {
                $query
                    ->where('client_id', $project->client_id)
                    ->orWhereHas('CLient', function ($q) use ($project) {
                        $q->where('country_id', $project->Client->country_id);
                    })
                ;
            })
            ->where('id', '!=', $project->id)
            ->with(['Client'])
            ->inRandomOrder()
            ->take(3)
            ->get();
        return successResponse(ProjectResource::collection($relatedProjects), 'Related Projects retrieved successfully');
    }
}
