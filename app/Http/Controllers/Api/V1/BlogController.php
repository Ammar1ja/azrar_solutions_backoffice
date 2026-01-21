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
        $blogs = Blog::with(['Categories', 'Tags'])
            ->when($request->search, function ($query, $search) {
                $cleanSearch = str_replace(['"', "'"], '', $search);

                return $query->where('title', 'LIKE', "%{$cleanSearch}%");
            })
            ->when($request->filled('iso2') && in_array($request->iso2, ['jo', 'sa', 'ae']), function ($query) use ($request) {
                $query->whereHas('Countries', function ($q) use ($request) {
                    $q->where('countries.iso2', $request->input('iso2'));
                });
            })
            ->latest() // Optional: puts newest blogs first
            ->paginate(10);

        return successResponse(BlogResource::collection($blogs), 'Blogs retrieved successfully');
    }



    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $blog = Blog::with(['Categories', 'Tags'])->findOrFail($id);
        $blog->Views()->create([
            'ip_address' => request()->ip(),
        ]);
        return successResponse(new BlogResource($blog), 'Blog retrieved successfully');
    }

    public function TopBlogs(Request $request)
    {
        $blogs = Blog::withCount('Views')
            ->when($request->filled('iso2') && in_array($request->iso2, ['jo', 'sa', 'ae']), function ($query) use ($request) {
                $query->whereHas('Countries', function ($q) use ($request) {
                    $q->where('countries.iso2', $request->input('iso2'));
                });
            })
            ->orderBy('views_count', 'desc')
            ->take(5)
            ->get();

        return successResponse(BlogResource::collection($blogs), 'Top Blogs retrieved successfully');
    }
}
