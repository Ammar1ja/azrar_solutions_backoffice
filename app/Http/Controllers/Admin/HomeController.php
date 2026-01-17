<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Home;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function edit()
    {
        // Logic to show edit form for home settings
        $settings = Home::first();
        return view('admin.home.edit', compact('settings'));
    }


    public function update(Request $request)
    {


        $settings = Home::first();
        $data = [
            'hero_en_title' => $request->hero_en_title,
            'hero_ar_title' => $request->hero_ar_title,
            'hero_en_subtitle' => $request->hero_en_subtitle,
            'hero_ar_subtitle' => $request->hero_ar_subtitle,
            'hero_en_button_text' => $request->hero_en_button_text,
            'hero_ar_button_text' => $request->hero_ar_button_text,

        ];

        if ($request->file('hero_background')) {
            $data['hero_background'] = uploadFile($request->file('hero_background'), 'home');
        } else {
            if ($request->remove_hero_background) {
                $data['hero_background'] = null;
            }
            elseif (isset($request->old_hero_background)) {
            } 
        }



        $settings->update($data);

        return successResponse([],message: 'Home settings updated successfully.');
    }
}
