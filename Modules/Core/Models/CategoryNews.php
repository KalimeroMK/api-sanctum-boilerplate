<?php

/**
 * Created by Zoran Shefot Bogoevski.
 */

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Category\Models\Category;
use Modules\Core\Database\factories\CategoryNewsFactory;
use Modules\News\Models\News;

/**
 * Class CategoryNews
 *
 * @property int $category_id
 * @property int $news_id
 *
 * @property Category $category
 * @property News $news
 *
 * @package App\Models
 */
class CategoryNews extends Core
{
    use HasFactory;

    public $incrementing = false;
    public $timestamps = false;
    protected $table = 'category_news';
    protected $casts = [
        'category_id' => 'int',
        'news_id' => 'int',
    ];

    /**
     * @return CategoryNewsFactory
     */
    public static function Factory(): CategoryNewsFactory
    {
        return CategoryNewsFactory::new();
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function news(): BelongsTo
    {
        return $this->belongsTo(News::class);
    }
}
