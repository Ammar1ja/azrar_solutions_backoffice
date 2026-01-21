<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $faqs = Faq::all();
        return successResponse($faqs->map(function($faq){
            return [
                'id' => $faq->id,
                'question' => $faq[app()->getLocale().'_question'],
                'answer' => $faq[app()->getLocale().'_answer'],
            ];
        }),__('Faq fetched successfully'));
    }
}
