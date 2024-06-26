<?php

namespace Modules\Permission\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Permission\Database\factories\PermissionFactory;
use Spatie\Permission\Models\Permission as BasePermission;

class Permission extends BasePermission
{
    use HasFactory;

    /**
     * The name of the guard used by the model.
     *
     * @var string
     */
    public string $guard_name = 'api';

    /**
     * @return PermissionFactory
     */
    public static function Factory(): PermissionFactory
    {
        return PermissionFactory::new();
    }
}
