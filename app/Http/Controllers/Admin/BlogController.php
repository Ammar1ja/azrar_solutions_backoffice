<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\BlogsDataTable;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category; // Import Category to show in the dropdown
use Illuminate\Http\Request;

class BlogController extends Controller
{

    public function index(BlogsDataTable $dataTable)
    {
        return $dataTable->render('admin.blog.index');
    }


    // To display the form
    public function create()
    {
        $categories = Category::all();
        return view('admin.blog.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // 1. Validate all requested fields
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string|max:500',
            'body'        => 'required',
            'image'       => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // 2. Handle the image upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('blogs', 'public');
            $validated['image'] = $path;
        }

        // 3. Create the record
        Blog::create($validated);

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog created successfully!');
    }
}
