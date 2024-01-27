<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class OrderItems extends Model
{
    use HasFactory;

    protected $table    = 'order_items';
    protected $fillable = [
        'order_id',//sepet id
        'seller_id',//influencer id
        'product_id',//inf product id
        'status',// Urun siparis durumu
        'seller_confirmation',//influencer onayı
        'ad_duration',//reklam süresi
        'ad_total_price',//reklam fiyatı
    ];
    protected $casts    = [];
    protected $dates    = ['created_at', 'updated_at', 'deleted_at'];
    protected $hidden   = ['created_at', 'updated_at', 'deleted_at'];
    protected $guarded  = ['id'];

    public function orderDetail(): HasOne {
        return $this->hasOne(OrderDetails::class, 'id', 'order_id');
    }

    public function influencer(): HasOne
    {
        return $this->hasOne(Influencer::class, 'infID', 'seller_id');
    }

    public function product(): HasOne
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }


}
