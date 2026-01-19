<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\HomeResource;
use App\Http\Resources\ServiceResource;
use App\Models\Home;
use App\Models\Service;
use Illuminate\Http\Request;
use Nette\Utils\Json;

class HomeController extends Controller
{
    public function index()
    {
        $homeData = Home::first(); // fetch all home records
        $services = Service::with('Features')->get();


        return successResponse([
            'home' => new HomeResource($homeData),
            'services' => ServiceResource::collection($services),
        ],'Home data retrieved successfully');
    }
}
