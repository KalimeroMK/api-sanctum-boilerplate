<?php

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens as ApiToken;
use Modules\Category\Models\Category;
use Modules\Crematorium\Models\Crematorium;
use Modules\News\Models\News;
use Modules\Organization\Models\Organization;
use Modules\User\Database\factories\UserFactory;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable;
    use HasFactory;
    use ApiToken;
    use HasRoles;
    use HasPermissions;
    use SoftDeletes;

    protected string $guard_name = 'api';


    protected $table = 'users';

    protected $dates = [
        'email_verified_at'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'password',
        'remember_token'
    ];

    /**
     * @return UserFactory
     */
    public static function Factory(): UserFactory
    {
        return UserFactory::new();
    }
}
