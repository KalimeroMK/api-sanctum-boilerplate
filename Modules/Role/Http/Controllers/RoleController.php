<?php

namespace Modules\Role\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Modules\Core\Helpers\Helper;
use Modules\Core\Http\Controllers\CoreController;
use Modules\Role\Http\Requests\StoreRequest;
use Modules\Role\Http\Requests\UpdateRequest;
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
     * @return ResourceCollection
     */
    public function index(): ResourceCollection
    {
        return RoleResource::collection($this->roleService->getAll());
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
                            $this->roleService->roleRepository->model
                        ),
                    ]
                )
            )
            ->respond(new RoleResource($this->roleService->store($request->validated())));

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
                            $this->roleService->roleRepository->model
                        ),
                    ]
                )
            )
            ->respond(new RoleResource($this->roleService->show($id)));

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
                            $this->roleService->roleRepository->model
                        ),
                    ]
                )
            )
            ->respond(new RoleResource($this->roleService->update($id, $request->validated())));

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
                            $this->roleService->roleRepository->model
                        ),
                    ]
                )
            )
            ->respond($this->roleService->destroy($id));

    }
}
