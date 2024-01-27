<?php

namespace App\Enum;


class OrderStatus
{
    public static function cases()
    {
        return [
            self::OrderCanceled,
            self::OnChart,
            self::ActiveOrder,
            self::OrderCompleted,
            self::OrderDelivery,
        ];
    }

    const OrderCanceled  = 'OrderCanceled';
    const OnChart        = 'OnChart';
    const ActiveOrder    = 'ActiveOrder';
    const OrderCompleted = 'OrderCompleted';
    const OrderDelivery  = 'OrderDelivery';
}
