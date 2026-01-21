<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\BookCall;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class BookCallController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        try {

            $request->validate([
                'full_name' => 'required|string',
                'email' => 'required|email',
                'date' => 'required|date',
                'time' => 'required|string',
            ]);
        } catch (ValidationException $e) {
            return validationErrorResponse($e);
        }


        BookCall::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'date' => $request->date,
            'time' => $request->time,
        ]);


        return successResponse([], 'Book call request submitted successfully.');
    }
}
