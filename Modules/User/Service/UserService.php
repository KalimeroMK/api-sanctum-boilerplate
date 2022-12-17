<?php

namespace Modules\User\Service;

use App\Service\BaseService;
use Exception;
use Modules\User\Repository\UserRepository;

class UserService extends BaseService
{
    
    public UserRepository $user_repository;
    
    public function __construct(UserRepository $user_repository)
    {
        $this->user_repository = $user_repository;
    }
    
    /**
     * @param $data
     *
     * @return mixed
     */
    public function store($data): mixed
    {
        try {
            return $this->user_repository->create($data);
        } catch (Exception $exception) {
            return $exception->getMessage();
        }
    }
    
    /**
     * @param $id
     *
     * @return mixed
     */
    public function edit($id): mixed
    {
        try {
            return $this->user_repository->findById($id);
        } catch (Exception $exception) {
            return $exception->getMessage();
        }
    }
    
    /**
     * @param $id
     *
     * @return mixed
     */
    public function show($id): mixed
    {
        try {
            return $this->user_repository->findById($id);
        } catch (Exception $exception) {
            return $exception->getMessage();
        }
    }
    
    /**
     * @param $id
     * @param $data
     *
     * @return mixed|string
     */
    public function update($id, $data): mixed
    {
        try {
            return $this->user_repository->update($id, $data);
        } catch (Exception $exception) {
            return $exception->getMessage();
        }
    }
    
    /**
     * @param $id
     *
     * @return string|void
     */
    
    public function destroy($id)
    {
        try {
            $this->user_repository->delete($id);
        } catch (Exception $exception) {
            return $exception->getMessage();
        }
    }
    
    public function getAll()
    {
        try {
            $this->user_repository->findAll();
        } catch (Exception $exception) {
            return $exception->getMessage();
        }
    }
}