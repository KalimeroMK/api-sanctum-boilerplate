<?php

namespace Modules\Role\Service;

use Modules\Role\Repository\RoleRepository;

class RoleService
{


    public RoleRepository $roleRepository;

    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    /**
     * @return mixed|string
     */
    public function getAll(): mixed
    {
        return $this->roleRepository->findAll();
    }

    /**
     * @param $data
     *
     * @return mixed
     */
    public function store($data): mixed
    {
        return $this->roleRepository->create($data);
    }

    /**
     * @param $id
     *
     * @return mixed|string
     */
    public function show($id): mixed
    {
        return $this->roleRepository->findById($id);
    }

    /**
     * @param $id
     *
     * @return mixed|string
     */
    public function edit($id): mixed
    {
        return $this->roleRepository->findById($id);
    }

    /**
     * @param $id
     * @param $data
     *
     * @return mixed
     */
    public function update($id, $data): mixed
    {
        return $this->roleRepository->update($id, $data);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id): mixed
    {
        return $this->roleRepository->delete($id);
    }
}