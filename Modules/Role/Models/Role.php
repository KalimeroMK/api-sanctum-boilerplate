<?php

namespace Modules\Role\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Role\Database\factories\RoleFactory;
use Spatie\Permission\Models\Role as BaseRole;

class Role extends BaseRole
{
    use HasFactory;

    /**
     * @var string
     */
    public $guard_name = 'api';

    /**
     * @return HasMany
     */

    /**
     * @return RoleFactory
     */
    public static function Factory(): RoleFactory
    {
        return RoleFactory::new();
    }
    
}