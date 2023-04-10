<?php

namespace Modules\Core\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Category\Models\Category;
use Modules\Core\Models\CategoryNews;
use Modules\News\Models\News;

class CategoryNewsFactory extends Factory
{
    protected $model = CategoryNews::class;

    public function definition(): array
    {
        return [
            'news_id' => News::factory(),
            'category_id' => Category::factory(),
        ];
    }
}
