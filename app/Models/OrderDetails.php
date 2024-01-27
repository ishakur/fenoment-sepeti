<?php

namespace App\Models;

use App\Enum\OrderStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class OrderDetails extends Model
{
    use HasFactory;

    protected $table    = 'order_details';
    protected $fillable = [
        'purchaser_id',//user id
        'status',
        'total_price',
        'payment_id',
    ];
    protected $casts    = [];
    protected $dates    = ['created_at', 'updated_at', 'deleted_at'];
    protected $hidden   = ['created_at', 'updated_at', 'deleted_at'];
    protected $guarded  = ['id'];

    public function getTotalPrice(): HasMany
    {
        $orderItems = $this->hasMany(OrderItems::class, 'order_id', 'id');
        $totalPrice = 0;
        foreach ($orderItems as $orderItem) {
            $totalPrice += $orderItem->ad_total_price;
        }
        return $totalPrice;
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'userID', 'purchaser_id');
    }

    public function orderItem(): HasMany
    {
        return $this->hasMany(OrderItems::class, 'order_id', 'id');
    }

    public function getOrderItemsId()
    {
        $orderItems   = $this->orderItem;
        $orderItemsId = [];
        foreach ($orderItems as $orderItem) {
            $orderItemsId[] = $orderItem->id;
        }
        return $orderItemsId;
    }

    public function payment()
    {
//        return $this->hasOne(Payment::class, 'id', 'payment_id');
    }

    public function destroyBasketItems()
    {
        $basketItems = $this->getOrderItemsId();
        $trueOrFalse = OrderItems::destroy($basketItems);
        return $trueOrFalse;
    }
}
