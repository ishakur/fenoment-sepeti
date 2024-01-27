<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class InfluencerCategories extends Model
    {
        use HasFactory;

        protected $table      = 'influencer_categories';
        public    $timestamps = false;
        protected $fillable   = [
            'influencer_id',
            'category_id',


        ];

        protected $hidden = [
            'influencer_id',
            'category_id',
        ];

        public function influencer()
        {
            return $this->belongsTo(Influencer::class, 'influencer_id');
        }

        public function category()
        {
            return $this->belongsTo(Category::class, 'category_id');
        }


    }
