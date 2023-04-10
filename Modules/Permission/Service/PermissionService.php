<?php

namespace Modules\Permission\Service;

use Modules\Permission\Repository\PermissionRepository;

class PermissionService
{

    public PermissionRepository $permissionRepository;

    public function __construct(PermissionRepository $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
    }

    /**
     * @return mixed|string
     */
    public function getAll(): mixed
    {
        return $this->permissionRepository->findAll();
    }

    /**
     * @param $data
     *
     * @return mixed
     */
    public function store($data): mixed
    {
        return $this->permissionRepository->create($data);
    }

    /**
     * @param $id
     *
     * @return mixed|string
     */
    public function show($id): mixed
    {
        return $this->permissionRepository->findById($id);
    }

    /**
     * @param $id
     *
     * @return mixed|string
     */
    public function edit($id): mixed
    {
        return $this->permissionRepository->findById($id);
    }

    /**
     * @param $id
     * @param $data
     *
     * @return mixed
     */
    public function update($id, $data): mixed
    {
        return $this->permissionRepository->update($id, $data);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id): mixed
    {
        return $this->permissionRepository->delete($id);
    }
}