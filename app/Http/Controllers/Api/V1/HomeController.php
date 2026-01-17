<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\HomeResource;
use App\Models\Home;
use Illuminate\Http\Request;
use Nette\Utils\Json;

class HomeController extends Controller
{
    public function index()
    {
        $homeData = Home::first(); // fetch all home records


        return successResponse(HomeResource::make($homeData),'Home data retrieved successfully');
    }
}
