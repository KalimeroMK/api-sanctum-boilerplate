<?php

namespace Modules\Permission\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Modules\Core\Helpers\Helper;
use Modules\Core\Http\Controllers\CoreController;
use Modules\Permission\Http\Requests\StoreRequest;
use Modules\Permission\Http\Requests\StoreRequest as UpdateRequest;
use Modules\Permission\Http\Resource\PerimssionResource;
use Modules\Permission\Service\PermissionService;

class PermissionController extends CoreController
{

    private PermissionService $permissionService;

    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    /**
     * @return ResourceCollection
     */
    public function index(): ResourceCollection
    {
        return PerimssionResource::collection($this->permissionService->getAll());
    }

    /**
     * @param StoreRequest $request
     *
     * @return JsonResponse|string
     */
    public function store(StoreRequest $request)
    {
        return $this
            ->setMessage(
                __(
                    'apiResponse.storeSuccess',
                    [
                        'resource' => Helper::getResourceName(
                            $this->permissionService->permissionRepository->model
                        ),
                    ]
                )
            )
            ->respond(new PerimssionResource($this->permissionService->store($request->validated())));

    }

    /**
     * @param $id
     *
     * @return JsonResponse|string
     */
    public function show($id)
    {
        return $this
            ->setMessage(
                __(
                    'apiResponse.ok',
                    [
                        'resource' => Helper::getResourceName(
                            $this->permissionService->permissionRepository->model
                        ),
                    ]
                )
            )
            ->respond(new PerimssionResource($this->permissionService->show($id)));

    }

    /**
     * @param UpdateRequest $request
     * @param $id
     *
     * @return JsonResponse|string
     */
    public function update(UpdateRequest $request, $id)
    {
        return $this
            ->setMessage(
                __(
                    'apiResponse.updateSuccess',
                    [
                        'resource' => Helper::getResourceName(
                            $this->permissionService->permissionRepository->model
                        ),
                    ]
                )
            )
            ->respond(new PerimssionResource($this->permissionService->update($id, $request->validated())));

    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        return $this
            ->setMessage(
                __(
                    'apiResponse.deleteSuccess',
                    [
                        'resource' => Helper::getResourceName(
                            $this->permissionService->permissionRepository->model
                        ),
                    ]
                )
            )
            ->respond($this->permissionService->destroy($id));

    }
}
