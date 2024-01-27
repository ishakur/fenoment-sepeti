<?php

    namespace App\Models;

    use App\Exceptions\StoreFailed;
    use App\Http\Requests\Category\StoreCategoryRequest;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsToMany;
    use Illuminate\Support\Facades\DB;

    class Category extends Model
    {
        use HasFactory;

        protected $table    = 'categories';
        public    $timestamps = false;
        protected $fillable = [
            'category_name',
            'slug',
            'category_up',
            'category_rank',
            'category_icon',
            'category_status',
        ];
        protected $guarded    = [];

        public function influencers(): BelongsToMany
        {
            return $this->belongsToMany(Influencer::class, 'influencer_categories', 'category_id', 'influencer_id');
        }

        public function products(): BelongsToMany
        {
            return $this->belongsToMany(Influencer::class, 'influencer_categories', 'category_id', 'influencer_id')->with('products');
        }

        public static function createCategory(StoreCategoryRequest $request)
        {
            $createCategory = DB::table('categories')->insert([
                                                                  'category_name'   => $request->category_name,
                                                                  'slug'            => $request->slug,
                                                                  'category_up'     => $request->category_up,
                                                                  'category_rank'   => $request->category_rank,
                                                                  'category_icon'   => $request->category_icon,
                                                                  'category_status' => $request->category_status,
                                                              ]);
            if ($createCategory) {
                return true;
            } else {
                throw new StoreFailed(__('keywords.category'));
            }
        }

        public static function getById($id)
        {
            return DB::select('SELECT * FROM categories WHERE id = ?', [$id]);
        }

        public function getByIds($ids)
        {

            for ($i = 0; $i < count($ids); $i++) {
                if ($this->where('category_id', $ids[$i])->first() == null) {
                    return false;
                }
            }
            return true;

        }

        public static function getCategories()
        {
            return DB::select('SELECT * FROM categories');
        }


    }
