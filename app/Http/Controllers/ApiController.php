<?php

namespace App\Http\Controllers;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    public function sendResponse($data, $message = null, $code = 200): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ],200);
    }

    public function sendError($data=null,$message = null, $code = 200): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => $data
        ],200);
    }

    public function validation(array $rules = [])
    {
        $validator = Validator::make(request()->all(), $rules);

        if ($validator->fails()) {
            throw new HttpResponseException(response()->json([
                'success'   => false,
                'message'   => $validator->errors()->first(),
                'errors'    => $validator->errors()
            ], 422));
        }
    }


}
