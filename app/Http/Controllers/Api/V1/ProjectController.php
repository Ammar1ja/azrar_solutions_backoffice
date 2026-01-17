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
        $projects = Project::with(['service', 'client'])->get();
        return ProjectResource::collection($projects);
    }

    public function show(Request $request, $id)
    {
        $project = Project::with(['service', 'client'])->findOrFail($id);
        return new ProjectResource($project);
    }
}
