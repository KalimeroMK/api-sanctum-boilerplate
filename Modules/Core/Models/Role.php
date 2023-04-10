<?php

namespace Modules\Core\Models;

class Role extends \Spatie\Permission\Models\Role
{
    public $guard_name = 'api';

}