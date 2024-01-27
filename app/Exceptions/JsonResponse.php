<?php

    namespace App\Exceptions;

    use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

    class JsonResponse extends ExceptionHandler
    {
        public static function apiResponse($data, $message, $status, $eMailVerify = null, $success = true)
        {
            $response = [];

            if ($data != null) {
                $response['data']    = $data;
                $response['success'] = true;
            }

            if ($data == null)
                $response['success'] = false;

            if ($message != null)
                $response['message'] = $message;

            if ($eMailVerify != null)
                $response['eMailVerify'] = !($eMailVerify == 0);

            return response()->json($response, $status);
        }
    }
