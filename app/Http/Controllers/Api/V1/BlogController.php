<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\BlogResource;
use App\Models\Blog;
use App\Models\Service;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $blogs = Blog::with(['category'])
            // The 'when' method only runs the callback if $request->search is not empty
            ->when($request->search, function ($query, $search) {
                // Clean the search term: remove quotes and extra spaces
                $cleanSearch = str_replace(['"', "'"], '', $search);

                return $query->where('title', 'LIKE', "%{$cleanSearch}%");
            })
            ->latest() // Optional: puts newest blogs first
            ->paginate(10);

        return BlogResource::collection($blogs);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $service = Blog::with('category')->findOrFail($id);
        return response()->json($service);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
