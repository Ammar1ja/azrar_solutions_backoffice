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
        $homeData = Home::all(); // fetch all home records
        return HomeResource::collection($homeData); // wrap collection in resource
    }
}
