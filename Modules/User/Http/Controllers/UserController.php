<?php

namespace Modules\User\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Modules\User\Http\Helper\Helper;
use Modules\User\Http\Resources\UserResource;
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
    public function index(): AnonymousResourceCollection
    {
        return UserResource::collection($this->user_service->getAll());
    }
    
    /**
     * @param $id
     *
     * @return JsonResponse|string
     */
    public function show($id)
    {
        try {
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
        } catch (Exception $exception) {
            return $exception->getMessage();
        }
    }
    
    /**
     * @param $id
     *
     * @return JsonResponse|string
     */
    public function destroy($id)
    {
        try {
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
        } catch (Exception $exception) {
            return $exception->getMessage();
        }
    }
}
