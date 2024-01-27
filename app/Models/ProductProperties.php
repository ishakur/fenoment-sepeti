<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductProperties extends Model
{
    use HasFactory;

    protected $table    = 'product_properties';
    protected $primaryKey = 'id';
    public   $timestamps = false;
    protected $fillable = [
        'property_name',
        'platform_id',
        'created_at',
        'updated_at'
    ];

    public function platform()
    {
        return $this->hasOne(Platform::class, 'id', 'platform_id');
    }
}
