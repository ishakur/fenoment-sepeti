<?php

namespace App\Http\Middleware\Api\Order;

use App\Enum\OrderStatus;
use App\Http\Controllers\Api\ApiController;
use App\Models\OrderDetails;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class IsOrderDetailActiveForOrderItem extends ApiController
{
    /**
     * Handle an incoming request.
     *
     * @param Request                                       $request
     * @param Closure(Request): (Response|RedirectResponse) $next
     *
     * @return Request
     */
    public function handle(Request $request, Closure $next)
    {
        // eger aktif sepeti yoksa yeni sepet olusturulur ve sepetin idsi return edilir
        //aktif sepet varsa aktif sepet id return edilir


        $user   = auth()->user();
        $userId = $user->userID;
        $order  = OrderDetails::where("purchaser_id", $userId)
                              ->where("status", OrderStatus::OnChart)->first();

        if (!isset($order)) {
            $order = OrderDetails::create([
                                              "purchaser_id" => $userId,
                                              "status"       => OrderStatus::OnChart,
                                          ]);
        }


        //request uzerinde order id gomuluyor
        $request->merge(['currentBasketFromMiddleWare' => $order, 'user' => $user]);
        return $next($request);
    }
}
