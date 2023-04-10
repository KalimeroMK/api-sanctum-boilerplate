<?php

namespace Modules\Role\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Modules\Role\Models\Role;

class RoleFactory extends Factory
{
    protected $model = Role::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'guard_name' => 'api',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
