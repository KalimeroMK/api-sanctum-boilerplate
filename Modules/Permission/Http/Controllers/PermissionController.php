<?php

namespace Modules\Permission\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Modules\Core\Helpers\Helper;
use Modules\Core\Http\Controllers\CoreController;
use Modules\Permission\Http\Requests\Store;
use Modules\Permission\Http\Requests\Update;
use Modules\Permission\Http\Resource\PermissionResource;
use Modules\Permission\Service\PermissionService;

class PermissionController extends CoreController
{
    protected PermissionService $permissionService;

    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    public function index(): AnonymousResourceCollection
    {
        return PermissionResource::collection($this->permissionService->getAll());
    }

    /**
     * @param Store $request
     * @return JsonResponse
     */
    public function store(Store $request): JsonResponse
    {
        $resourceName = Helper::getResourceName($this->permissionService->permissionRepository->model);
        $permission = $this->permissionService->create($request->validated());

        return $this
            ->setMessage(__('apiResponse.storeSuccess', ['resource' => $resourceName]))
            ->respond(['data' => new PermissionResource($permission)]);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $resourceName = Helper::getResourceName($this->permissionService->permissionRepository->model);
        $permission = $this->permissionService->findById($id);

        return $this
            ->setMessage(__('apiResponse.ok', ['resource' => $resourceName]))
            ->respond(['data' => new PermissionResource($permission)]);
    }

    /**
     * @param Update $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Update $request, int $id): JsonResponse
    {
        $resourceName = Helper::getResourceName($this->permissionService->permissionRepository->model);
        $permission = $this->permissionService->update($id, $request->validated());

        return $this
            ->setMessage(__('apiResponse.updateSuccess', ['resource' => $resourceName]))
            ->respond(['data' => new PermissionResource($permission)]);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $resourceName = Helper::getResourceName($this->permissionService->permissionRepository->model);
        $this->permissionService->delete($id);

        return $this
            ->setMessage(__('apiResponse.deleteSuccess', ['resource' => $resourceName]))
            ->respond(['message' => __('apiResponse.deleteSuccess', ['resource' => $resourceName])]);
    }
}
