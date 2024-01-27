<?php

    namespace App\Models;

    use App\Http\Requests\Product\StoreProductRequest;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\HasOne;
    use Illuminate\Support\Facades\DB;

    class Product extends Model
    {
        use HasFactory;

        protected $table      = 'products';
        public    $timestamps = false;
        protected $fillable   = [
            'influencer_id',
            'product_property_id',
            'price_for_per_minute',
        ];
        protected $guarded    = [];

        public function influencer(): HasOne
        {
            return $this->hasOne(Influencer::class, 'infID', 'influencer_id')
                        ->with('user')
                        ->with('categories');
        }

        public function property(): HasOne
        {
            return $this->hasOne(ProductProperties::class, 'id', 'product_property_id')->with('platform');
        }


        public static function createProduct(StoreProductRequest $request, $infID)
        {
            $product = DB::table('products')->insertGetId([
                                                              'influencer_id'        => $infID,
                                                              'product_property_id'  => $request->product_property_id,
                                                              'price_for_per_minute' => $request->price_for_per_minute,
                                                          ]);
            if (!$product) {
                return false;
            }
            return $product;
        }

        public static function getById($id)
        {
            $product = DB::select('SELECT i.userID,i.infID,i.platformUserName,i.fenocitySaleCount,pp.property_name ,p.price_for_per_minute
                FROM (SELECT influencer_id, product_property_id, price_for_per_minute FROM products WHERE id= ?) as p
                JOIN influencers i ON i.infID = p.influencer_id JOIN products_properties pp ON pp.id = p.product_property_id', [$id]);
//            $product = DB::select('SELECT * FROM products WHERE id = ?', [$id]);
//            dd(json_encode($product));
//            dd($product);
            if (!$product) {
                return false;
            }
            return $product;
        }

    }
