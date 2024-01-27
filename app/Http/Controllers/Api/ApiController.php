<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Enum\HttpStatus;

class ApiController extends Controller
{
    public static function apiResponse($data, $message, $status, $eMailVerify = null, $success = false)
    {
        $response            = [];
        $response['success'] = false;
        if ($data != null)
            $response['data'] = $data;


        if ($status / 100 < 3)
            $response['success'] = true;

        if ($message != null)
            $response['message'] = $message;

        if ($eMailVerify != null)
            $response['eMailVerify'] = !($eMailVerify == 0);

        return response()->json($response, $status);
    }


    public static function getTextFromControllerLanguageFile($arrayKeyOfControllerLanguageFile, $attributeKey = null)
    {
        //burada attributeları keywords dosyasından çekip controller dosyasına gönderiyoruz. dil hangisiyse o klasor altındaki controller dosyasından çekiyoruz.
        return __('controller.' . $arrayKeyOfControllerLanguageFile, ['attribute' => __('keywords.' . $attributeKey)]);
    }

    public static function getTextFromAuthLanguageFile($arrayKeyOfAuthLanguageFile, $attributeKey = null)
    {
        //burada attributeları keywords dosyasından çekip auth dosyasına gönderiyoruz.
        return __('auth.' . $arrayKeyOfAuthLanguageFile, ['attribute' => __('keywords.' . $attributeKey)]);
    }

    public static function getTextFromKeywordsLanguageFile($arrayKeyOfKeywordsLanguageFile)
    {
        //burada attributeları keywords dosyasından çekip auth dosyasına gönderiyoruz.
        return __('keywords.' . $arrayKeyOfKeywordsLanguageFile);
    }

}
