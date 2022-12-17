<?php

namespace Modules\User\Repository;

use App\Repository\BaseRepository;
use Modules\User\Models\User;

class UserRepository extends BaseRepository
{
    public $model = User::class;
}