<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Modules\Core\Helpers\Helper;
use Modules\Core\Http\Controllers\CoreController;
use Modules\User\Http\Requests\Update;
use Modules\User\Http\Resources\UserResource;
use Modules\User\Service\UserService;

class UserController extends CoreController
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return UserResource::collection($this->userService->getAll());
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $resourceName = Helper::getResourceName($this->userService->userRepository->model);
        $user = $this->userService->findById($id);

        return $this
            ->setMessage(__('apiResponse.ok', ['resource' => $resourceName]))
            ->respond(['data' => new UserResource($user)]);
    }

    /**
     * @param Update $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Update $request, int $id): JsonResponse
    {
        $resourceName = Helper::getResourceName($this->userService->userRepository->model);
        $user = $this->userService->update($id, $request->validated());

        return $this
            ->setMessage(__('apiResponse.updateSuccess', ['resource' => $resourceName]))
            ->respond(['data' => new UserResource($user)]);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $resourceName = Helper::getResourceName($this->userService->userRepository->model);
        $this->userService->delete($id);

        return $this
            ->setMessage(__('apiResponse.deleteSuccess', ['resource' => $resourceName]))
            ->respond(['message' => __('apiResponse.deleteSuccess', ['resource' => $resourceName])]);
    }

    /**
     * @return JsonResponse
     */
    public function authUser(): JsonResponse
    {
        $resourceName = Helper::getResourceName($this->userService->userRepository->model);

        return $this
            ->setMessage(__('apiResponse.ok', ['resource' => $resourceName]))
            ->respond(['data' => new UserResource(Auth::user())]);
    }


    /**
     * @param int $id
     * @return JsonResponse
     */
    public function restore(int $id): JsonResponse
    {
        $resourceName = Helper::getResourceName($this->userService->userRepository->model);
        $this->userService->restore($id);

        return $this
            ->setMessage(__('apiResponse.restoreSuccess', ['resource' => $resourceName]))
            ->respond(['message' => __('apiResponse.restoreSuccess', ['resource' => $resourceName])]);
    }

    public function findByIdWithTrashed(int $id): JsonResponse
    {
        $resourceName = Helper::getResourceName($this->userService->userRepository->model);
        $user = $this->userService->findByIdWithTrashed($id);

        return $this
            ->setMessage(__('apiResponse.ok', ['resource' => $resourceName]))
            ->respond(['data' => new UserResource($user)]);
    }
}
