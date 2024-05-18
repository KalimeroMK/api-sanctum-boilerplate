<?php

namespace Modules\Role\Service;

use Modules\Core\Service\CoreService;
use Modules\Role\Models\Role;
use Modules\Role\Repository\RoleRepository;

class RoleService extends CoreService
{
    public RoleRepository $roleRepository;

    public function __construct(RoleRepository $roleRepository)
    {
        parent::__construct($roleRepository);
        $this->roleRepository = $roleRepository;
    }

    /**
     * Create a new role.
     *
     * @param array<string, mixed> $data
     * @return Role
     */
    public function create(array $data): Role
    {
        /** @var Role $role */
        $role = $this->roleRepository->create(['name' => $data['name']]);
        $role->syncPermissions($data['permission']);
        return $role;
    }

    /**
     * Update an existing role.
     *
     * @param int $id
     * @param array<string, mixed> $data
     * @return Role
     */
    public function update(int $id, array $data): Role
    {
        /** @var Role $role */
        $role = $this->findById($id);
        $role->update(['name' => $data['name']]);
        $role->syncPermissions($data['permission']);
        return $role->fresh();
    }
}
