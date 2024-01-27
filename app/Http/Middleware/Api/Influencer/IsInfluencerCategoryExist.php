<?php

    namespace App\Http\Middleware\Api\Influencer;

    use App\Exceptions\AlreadyExist;
    use App\Exceptions\NotFound;
    use App\Http\Middleware\Api\ResponseClass;
    use App\Http\Resources\InfluencerCategoryResource;
    use App\Models\Category;
    use App\Models\InfluencerCategories;
    use Closure;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Http\Request;
    use Illuminate\Http\Response;

    class IsInfluencerCategoryExist extends ResponseClass
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
            if (Category::find($request->category_id)->exists()) {
                $influencerCategory = InfluencerCategories::where('influencer_id', $request->influencer_id)
                                                          ->where('category_id', $request->category_id);
                if ($influencerCategory->exists())
                    throw new AlreadyExist(__('influencerCategory'));
                return $next($request);
            }

            throw new NotFound(__('influencerCategory'));
        }
    }
