<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\BlogDataTable;
use App\DataTables\BlogsDataTable;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category; // Import Category to show in the dropdown
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class BlogController extends Controller
{

    public function index(BlogDataTable $dataTable)
    {

        $categories = Category::all();

        return $dataTable->render('admin.blog.index',compact('categories'));
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
        try {
            $request->validate([
                'title'       => 'required|string|max:255',
                'category_id' => 'required|exists:categories,id',
                'description' => 'required|string',
                'body'        => 'required',
                'image'       => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            ]);
        } catch (ValidationException $e) {
            return validationErrorResponse($e);
        }



        DB::transaction(function () use ($request) {
            $data = [
                'title'       => $request->input('title'),
                'description' => $request->input('description'),
                'body'        => $request->input('body'),
            ];
            // 2. Handle the image upload
            if ($request->hasFile('image')) {
                $path = uploadFile($request->file('image'), 'blogs');
                $data['image'] = $path;
            }

            // 3. Create the record
            $blog = Blog::create($data);

            $blog->Categories()->sync($request->category_id ?? []);

            if ($request->filled('tags')) {
                foreach ($request->tags as $tagName) {
                    $blog->Tags()->create(['name' => trim($tagName)]);
                }
            }
        });
        return successResponse([], 'Blog created successfully.');
    }



    public function edit(Blog $blog)
    {
        $categories = Category::all();
        return view('admin.blog.create', compact('blog', 'categories'));
    }


    public function update(Request $request, Blog $blog)
    {
        // 1. Validate all requested fields
        try {
            $request->validate([
                'title'       => 'required|string|max:255',
                'category_id' => 'required|exists:categories,id',
                'description' => 'required|string',
                'body'        => 'required',
                'image'       => 'sometimes|image|mimes:jpeg,png,jpg,webp|max:2048',
            ]);
        } catch (ValidationException $e) {
            return validationErrorResponse($e);
        }
        DB::transaction(function () use ($request, $blog) {
            $data = [
                'title'       => $request->input('title'),
                'description' => $request->input('description'),
                'body'        => $request->input('body'),
            ];
            // 2. Handle the image upload
            if ($request->hasFile('image')) {
                $data['image'] = uploadFile($request->file('image'), 'blogs');
            } elseif ($request->filled('remove_image')) {
                $data['image'] = null;
            } elseif ($request->filled('old_image')) {
                $data['image'] = $blog->image;
            } else {
                $data['image'] = null;
            }

            // 3. Update the record
            $blog->update($data);

            $blog->Categories()->sync($request->category_id ?? []);
        });



        $blog->Tags()->delete();
        if ($request->filled('tags')) {
        
            foreach ($request->tags as $tagName) {
                $blog->Tags()->create(['name' => trim($tagName)]);
            }
        }
        return successResponse([], 'Blog updated successfully.');
    }
    public function destroy(Blog $blog)
    {
        $blog->delete();
        return successResponse([], 'Blog deleted successfully.');
    }
}
