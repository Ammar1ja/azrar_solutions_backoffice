<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClientResource;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function __invoke(Request $request)
    {
        $clients = Client::when($request->filled('country_id'), function($query) use ($request){
            $query->where('country_id', $request->country_id);
        })->get();
        return successResponse(ClientResource::collection($clients), __('Clients fetched successfully'));
    }
}
