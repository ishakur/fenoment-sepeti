<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Platform extends Model
{
    use HasFactory;

    protected $table      = 'platforms';
    protected $primaryKey = 'id';
    protected $fillable   = [
        'platform_name',
        'slug',
        'platform_rank',
        'platform_icon',
    ];
    protected $guarded    = [];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(ProductProperties::class, 'product_properties', 'platform_id', 'id');
    }
}
