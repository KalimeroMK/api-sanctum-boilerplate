<?php

namespace Modules\Role\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\News\Models\News;
use Modules\Role\Database\factories\RoleFactory;
use Spatie\Permission\Models\Role as BaseRole;

class Role extends BaseRole
{
    use HasFactory;

    public $guard_name = 'api';

    /**
     * @return HasMany
     */
    public function news(): HasMany
    {
        return $this->hasMany(News::class);
    }

    /**
     * @return RoleFactory
     */
    public static function Factory(): RoleFactory
    {
        return RoleFactory::new();
    }
    
}