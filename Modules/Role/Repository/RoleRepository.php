<?php

namespace Modules\Role\Repository;

use Modules\Core\Repositories\Repository;
use Modules\Role\Models\Role;

class RoleRepository extends Repository
{
    public $model = Role::class;

    /**
     * @param  $id
     *
     * @return mixed
     */
    public function findById($id): mixed
    {
        return $this->model::with('permissions')->find($id);
    }

    public function create(array $data): mixed
    {
        $role = $this->model::create(['name' => $data['name']]);
        $role->syncPermissions($data['permission']);
        return $role;
    }

    /**
     * @param  $id
     * @param array $data
     *
     * @return mixed
     */
    public function update($id, array $data): mixed
    {
        $role = $this->findById($id);
        $role->update($data['name']);
        $role->syncPermissions($data['permission']);
        return $role->fresh();
    }
}
