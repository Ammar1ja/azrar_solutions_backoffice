<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\FaqDataTable;
use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(FaqDataTable $dataTable)
    {
        return $dataTable->render('admin.faq.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.faq.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        try {

            $request->validate([
                'en_question' => 'required|string',
                'ar_question' => 'required|string',
                'en_answer' => 'required|string',
                'ar_answer' => 'required|string',
            ]);
        } catch (ValidationException $e) {
            return validationErrorResponse($e);
        }


        DB::transaction(function () use ($request) {
            Faq::create([
                'en_question' => $request->en_question,
                'ar_question' => $request->ar_question,
                'en_answer' => $request->en_answer,
                'ar_answer' => $request->ar_answer,
            ]);
        });


        return successResponse([],'FAQ created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $faq = Faq::findOrFail($id);
        return view('admin.faq.create', compact('faq'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {

            $request->validate([
                'en_question' => 'required|string',
                'ar_question' => 'required|string',
                'en_answer' => 'required|string',
                'ar_answer' => 'required|string',
            ]);
        } catch (ValidationException $e) {
            return validationErrorResponse($e);
        }

        DB::transaction(function () use ($request, $id) {
            $faq = Faq::findOrFail($id);
            $faq->update([
                'en_question' => $request->en_question,
                'ar_question' => $request->ar_question,
                'en_answer' => $request->en_answer,
                'ar_answer' => $request->ar_answer,
            ]);
        });

        return successResponse([],'FAQ updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::transaction(function () use ($id) {
            $faq = Faq::findOrFail($id);
            $faq->delete();
        });

        return successResponse([],'FAQ deleted successfully.');
    }
}
