<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceResource;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Return all services as a resource collection
     */
    public function index(Request $request)
    {
        $services = Service::all();
        return ServiceResource::collection($services); // wrap collection in resource
    }

    /**
     * Return a single service with ServiceResource
     */
    public function show(Request $request, $id)
    {
        $service = Service::findOrFail($id);
        return new ServiceResource($service); // single resource
    }
}
