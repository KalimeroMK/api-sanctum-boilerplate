<?php

namespace Modules\User\Service;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Hash;
use Modules\Core\Traits\ImageUpload;
use Modules\User\Models\User;
use Modules\User\Repository\UserRepository;

class UserService
{
    use ImageUpload;

    public UserRepository $user_repository;

    public function __construct(UserRepository $user_repository)
    {
        return $this->user_repository = $user_repository;
    }

    /**
     * @param $data
     *
     * @return mixed
     */
    public function store($data): mixed
    {
        return $this->user_repository->create($data);
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function edit($id): mixed
    {
        return $this->user_repository->findById($id);
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function show($id): mixed
    {
        return $this->user_repository->findById($id);
    }

    /**
     * @param $id
     * @param $data
     *
     * @return mixed|string
     */
    public function update($id, $data): mixed
    {
        $newData = array_filter($data, function ($value, $key) {
            return in_array($key, ['name', 'phone', 'date_of_birth', 'email', 'image', 'password']);
        }, ARRAY_FILTER_USE_BOTH);

        if (!empty($data['image'])) {
            $newData['image'] = $this->verifyAndStoreImage($data['image']);
        }

        if (!empty($data['password'])) {
            $newData['password'] = Hash::make($data['password']);
        }
        if (!empty($newData['date_of_birth'])) {
            return $this->user_repository->update($id, collect($newData)->except(['date_of_birth'])->toArray() + [
                    'date_of_birth' => Carbon::parse($newData['date_of_birth']),
                ]
            );
        } else {
            return $this->user_repository->update($id, $newData);
        }
    }

    /**
     * @param $id
     *
     * @return string|void
     */

    public function destroy($id)
    {
        return $this->user_repository->delete($id);
    }

    public function getAll()
    {
        return $this->user_repository->findAll();
    }

    /**
     * @param  array  $data
     *
     * @return User|Authenticatable|string|null
     */
    public function addUsersNewsCategory(array $data): User|Authenticatable|string|null
    {
        return $this->user_repository->addUsersNewsCategory($data);
    }

    public function restoreUser($id)
    {
        return $this->user_repository->restore($id);

    }
}