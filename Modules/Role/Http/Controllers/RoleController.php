<?php

namespace Modules\Role\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Modules\Core\Helpers\Helper;
use Modules\Core\Http\Controllers\CoreController;
use Modules\Role\Http\Requests\Store;
use Modules\Role\Http\Requests\Update;
use Modules\Role\Http\Resource\RoleResource;
use Modules\Role\Service\RoleService;

class RoleController extends CoreController
{
    private RoleService $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return RoleResource::collection($this->roleService->getAll());
    }

    /**
     * @param Store $request
     * @return JsonResponse
     */
    public function store(Store $request): JsonResponse
    {
        $resourceName = Helper::getResourceName($this->roleService->roleRepository->model);
        $role = $this->roleService->create($request->validated());

        return $this
            ->setMessage(__('apiResponse.storeSuccess', ['resource' => $resourceName]))
            ->respond(['data' => new RoleResource($role)]);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $resourceName = Helper::getResourceName($this->roleService->roleRepository->model);
        $role = $this->roleService->findById($id);

        return $this
            ->setMessage(__('apiResponse.ok', ['resource' => $resourceName]))
            ->respond(['data' => new RoleResource($role)]);
    }

    /**
     * @param Update $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Update $request, int $id): JsonResponse
    {
        $resourceName = Helper::getResourceName($this->roleService->roleRepository->model);
        $role = $this->roleService->update($id, $request->validated());

        return $this
            ->setMessage(__('apiResponse.updateSuccess', ['resource' => $resourceName]))
            ->respond(['data' => new RoleResource($role)]);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $resourceName = Helper::getResourceName($this->roleService->roleRepository->model);
        $this->roleService->delete($id);

        return $this
            ->setMessage(__('apiResponse.deleteSuccess', ['resource' => $resourceName]))
            ->respond(['message' => __('apiResponse.deleteSuccess', ['resource' => $resourceName])]);
    }
}
