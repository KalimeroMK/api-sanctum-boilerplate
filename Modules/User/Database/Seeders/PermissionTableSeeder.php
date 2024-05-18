<?php

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Permission\Models\Permission;
use Modules\Role\Models\Role;
use Modules\User\Models\User;
use Spatie\Permission\PermissionRegistrar;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        $permissions = [
            'news-list',
            'news-create',
            'news-edit',
            'news-delete',
            'newsletter-list',
            'newsletter-create',
            'newsletter-edit',
            'newsletter-delete',
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'settings-list',
            'settings-create',
            'settings-edit',
            'settings-delete',
            'categories-list',
            'categories-create',
            'categories-edit',
            'categories-delete',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // create roles and assign existing permissions
        $role1 = Role::create(['name' => 'manager']);
        $role1->givePermissionTo([
            'news-list',
            'news-create',
            'news-edit',
            'news-delete',
            'user-list',
            'user-edit',
        ]);

        $role2 = Role::create(['name' => 'client']);
        $role2->givePermissionTo([
            'news-list',
            'user-list',
            'user-edit',
        ]);

        $role3 = Role::create(['name' => 'super-admin']);
        $role3->givePermissionTo(Permission::all());

        // create demo users
        /** @var User $user */
        $user = User::factory()->create([
            'name' => 'Example User',
            'email' => 'manager@mail.com',
        ]);
        $user->assignRole($role1);

        /** @var User $user */
        $user = User::factory()->create([
            'name' => 'Example client User',
            'email' => 'client@mail.com',
        ]);
        $user->assignRole($role2);

        /** @var User $user */
        $user = User::factory()->create([
            'name' => 'Example Super-Admin User',
            'email' => 'superadmin@mail.com',
        ]);
        $user->assignRole($role3);
    }
}
