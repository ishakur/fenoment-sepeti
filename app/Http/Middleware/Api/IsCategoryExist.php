<?php

    namespace App\Http\Middleware\Api;

    use App\Exceptions\AlreadyExist;
    use App\Exceptions\NotFound;
    use App\Http\Controllers\Api\ApiController;
    use App\Http\Resources\CategoryResource;
    use App\Models\Category;
    use Closure;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Http\Request;
    use Illuminate\Http\Response;

    class IsCategoryExist extends ResponseClass
    {
        /**
         * Handle an incoming request.
         *
         * @param Request                                       $request
         * @param Closure(Request): (Response|RedirectResponse) $next
         *
         */
        public function handle(Request $request, Closure $next)
        {

            if ($request->method() == 'POST') {

                if (Category::where('category_name', $request->category_name)->exists()) {
//                    $category = Category::where('category_name', $request->category_name)->first();
                    throw new AlreadyExist(ApiController::getTextFromKeywordsLanguageFile('category'));
                }

            } else if ($request->method() == 'PUT') {

                if (Category::where('category_name', $request->category_name)
                    ->where('category_up', $request->category_up)
                    ->where('category_rank', $request->category_rank)
                    ->where('category_icon', $request->category_icon)
                    ->where('category_status', $request->category_status)
                    ->exists()) {

//                    $category = Category::where('category_name', $request->category_name)
//                                        ->where('category_up', $request->category_up)
//                                        ->where('category_rank', $request->category_rank)
//                                        ->where('category_icon', $request->category_icon)
//                                        ->where('category_status', $request->category_status)
//                                        ->first();

                    throw new AlreadyExist(ApiController::getTextFromKeywordsLanguageFile('category'));
                }

            } else if ($request->method() == 'DELETE') {

                if (!$request->route('category')) {

                    throw new NotFound(ApiController::getTextFromKeywordsLanguageFile('category'));

                }
            } else if ($request->method() == 'GET') {

                if (!$request->route('category')) {
                    throw new NotFound(ApiController::getTextFromKeywordsLanguageFile('category'));
                }
            }

            return $next($request);
        }
    }

