<?php

namespace Modules\User\Service;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Modules\Core\Service\CoreService;
use Modules\Core\Traits\ImageUpload;
use Modules\User\Repository\UserRepository;

class UserService extends CoreService
{
    use ImageUpload;

    public UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        parent::__construct($userRepository);
        $this->userRepository = $userRepository;
    }

    /**
     * @param  int  $id
     * @param  array<string, mixed>  $data
     *
     * @return Model
     */
    public function update(int $id, array $data): Model
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
            return $this->userRepository->update($id, collect($newData)->except(['date_of_birth'])->toArray() + [
                    'date_of_birth' => Carbon::parse($newData['date_of_birth']),
                ]
            );
        } else {
            return $this->userRepository->update($id, $newData);
        }
    }
}
