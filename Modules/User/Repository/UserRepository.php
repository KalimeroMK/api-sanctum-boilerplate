<?php

namespace Modules\User\Repository;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Modules\Core\Repositories\Repository;
use Modules\User\Models\User;

class UserRepository extends Repository
{
    public $model = User::class;

    /**
     * @return mixed
     */
    public function findAll(): mixed
    {
        return $this->model::with('organizations', 'crematoria')->get();
    }

    /**
     * @param  $id
     *
     * @return mixed
     */
    public function findById($id): mixed
    {
        return $this->model::with('organizations', 'crematoria')->find($id);
    }

    /**
     * @param  array  $data
     * @return Authenticatable|User|null
     */
    public function addUsersNewsCategory(array $data): Authenticatable|User|null
    {
        $user = Auth::user();
        $user->categories()->sync($data['category']);
        return $user;
    }

    public function restore($id): mixed
    {
        $object = $this->findByIdWithTrashed($id);
        DB::table('password_resets')->where([
            ['email', $object['email']],
        ])->delete();
        $token = Str::random(60);

        DB::table('password_resets')
            ->insert(
                [
                    'email' => $object['email'],
                    'token' => $token,
                    'created_at' => Carbon::now(),
                ]
            );

        Mail::send('email.forgetPassword', ['token' => $token], function ($message) use ($object) {
            $message->to($object->email);
            $message->subject('Reset Password');
        });
        $object->restore($id);
        return $object;
    }

}