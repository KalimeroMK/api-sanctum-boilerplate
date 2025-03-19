<?php

use App\Providers\AppServiceProvider;
use Modules\Auth\Providers\AuthServiceProvider;
use Modules\Core\Providers\CoreServiceProvider;
use Modules\Permission\Providers\PermissionServiceProvider;
use Modules\Role\Providers\RoleServiceProvider;
use Modules\User\Providers\UserServiceProvider;

return [
    AppServiceProvider::class,
    CoreServiceProvider::class,
    AuthServiceProvider::class,
    PermissionServiceProvider::class,
    RoleServiceProvider::class,
    UserServiceProvider::class,
];
