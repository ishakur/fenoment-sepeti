<?php
namespace App\Http\Middleware\Api\Order;

use App\Enum\OrderStatus;
use App\Exceptions\NotFound;
use App\Http\Controllers\Api\ApiController;

class CalculateOrderDetails

//    public function handle($request, $next)
//    {
//        $order = $request->order;
//        $order->total_price = $order->orderItem->sum('total_price');
//        $order->save();
//        return $next($request);
//    }
//}
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {
        $order = $request->user()->orderDetail()->where('status', OrderStatus::OnChart)->first();
        if ($order) {
            $request->merge(['order' => $order]);
            return $next($request);
        }
        throw new NotFound(ApiController::getTextFromKeywordsLanguageFile('order'));
    }
}
