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
        $projects = Project::with(['Services', 'Client'])
        ->when($request->has('service_id'), function ($query) use ($request) {
            $query->whereHas('Services', function ($q) use ($request) {
                $q->where('services.id', $request->input('service_id'));
            });
        })
        ->when($request->has('client_id'), function ($query) use ($request) {
            $query->where('client_id', $request->input('client_id'));
        })
        
        ->get();
        return ProjectResource::collection($projects);
    }

    public function show(Request $request, $id)
    {
        $project = Project::with(['service', 'client'])->findOrFail($id);
        return new ProjectResource($project);
    }
}
