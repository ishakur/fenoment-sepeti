<?php

namespace App\Http\Middleware\Api\Influencer;

use App\Http\Middleware\Api\Request;
use App\Http\Middleware\Api\ResponseClass;
use Closure;
use Illuminate\Support\Facades\Validator;

class InfCategoryValidator extends ResponseClass
{

    private function validator(Request $request)
    {
        $validator = Validator::make($request->toArray(), [
            'influencer_id' => 'required|int|exists:influencers,id',
            'category_id'   => 'required|int|exists:categories,id',
        ]);
        if ($validator->fails())
            return $this->apiResponse(null, $validator->errors(), 400);

        return true;
    }

    public function handle($request, Closure $next)
    {
        $validator = $this->validator($request);
        if ($validator === true)
            return $next($request);
        return $validator;

    }

}
