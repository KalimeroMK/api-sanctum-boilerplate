<?php

namespace Modules\User\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Modules\Core\Helpers\Helper;
use Modules\User\Http\Requests\UpdateRequest;
use Modules\User\Http\Resources\UserResource;
use Modules\User\Models\User;
use Modules\User\Service\UserService;


class UserController extends Controller
{

    private UserService $user_service;

    public function __construct(UserService $user_service)
    {
        $this->user_service = $user_service;
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return UserResource::collection(User::all());
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
                            $this->user_service->user_repository->model
                        ),
                    ]
                )
            )
            ->respond(new UserResource($this->user_service->show($id)));
    }

    /**
     * @param  UpdateRequest  $request
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
                            $this->user_service->user_repository->model
                        ),
                    ]
                )
            )
            ->respond(new UserResource($this->user_service->update($id, $request->validated())));
    }


    /**
     * @param $id
     *
     * @return JsonResponse|string
     */
    public function destroy($id)
    {
        return $this
            ->setMessage(
                __(
                    'apiResponse.deleteSuccess',
                    [
                        'resource' => Helper::getResourceName(
                            $this->user_service->user_repository->model
                        ),
                    ]
                )
            )
            ->respond($this->user_service->destroy($id));
    }

    /**
     * @return string
     */
    public function authUser()
    {
        return $this
            ->setMessage(
                __(
                    'apiResponse.deleteSuccess',
                    [
                        'resource' => Helper::getResourceName(
                            $this->user_service->user_repository->model
                        ),
                    ]
                )
            )
            ->respond(new UserResource(Auth::user()));
    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function addUsersNewsCategory(Request $request)
    {
        return $this
            ->setMessage(
                __(
                    'apiResponse.deleteSuccess',
                    [
                        'resource' => Helper::getResourceName(
                            $this->user_service->user_repository->model
                        ),
                    ]
                )
            )
            ->respond(new UserResource($this->user_service->addUsersNewsCategory($request->all())));
    }


    /**
     * @param $id
     *
     * @return JsonResponse|string
     */
    public function restore($id)
    {
        return $this
            ->setMessage(
                __(
                    'apiResponse.RestoreSuccess',
                    [
                        'resource' => Helper::getResourceName(
                            $this->user_service->user_repository->model
                        ),
                    ]
                )
            )
            ->respond($this->user_service->restoreUser($id));
    }



}
