# Laravel sanctum auth boilerplate

laravel boilerplate with api auth using sanctum (signup, login, logout, reset password)

## Use starter project

Details of starter laravel project

- Laravel v9.4
- Sanctum v3.0

## Setup Instructions

1. Clone the repo and cd into it
2. composer install
3. Rename or copy .env.example file to .env
4. php artisan key:generate
5. Set your database credentials in your .env file
6. Run php artisan migrate:fresh --seed
7. run command[laravel file manager]:- php artisan storage:link
8. Edit .env file :- remove APP_URL
9. php artisan serve or use virtual host
10. Visit localhost:8000 in your browser
11. Visit /admin if you want to access the admin panel. Admin Email/Password: superadmin@mail.com/password. User
    Email/Password:
    client@mail.com/password
12. Test run: vendor/bin/phpunit

### Requirements installation and configuration for docker

* **Docker**
* **In project root run**: docker-compose up -d.
* **Install laravel packages**: composer install
* **ENV**: rename DB_HOST=127.0.0.1 to DB_HOST=mysql
* **Container ssh**: docker-compose exec app sh
* **Run migrations**: php artisan:migrate:fresh --seed.

### Endpoints for API Authentication

The auth routes are present in `routes/api.php` and prefixed with `auth` as follows:

```php
Route::prefix('/v1')->group(function () {
    Route::post('signup', [AuthController::class,'signup'])->name('auth.signup');
    Route::post('login', [AuthController::class,'login'])->name('auth.login');
    Route::post('logout', [AuthController::class,'logout'])->middleware('auth:sanctum')->name('auth.logout');
    Route::get('user', [AuthController::class,'getAuthenticatedUser'])->middleware('auth:sanctum')->name('auth.user');
    Route::post('/password/email', [AuthController::class,'sendPasswordResetLinkEmail'])->middleware('throttle:5,1')->name('password.email');
    Route::post('/password/reset', [AuthController::class,'resetPassword'])->name('password.reset');
});
```

Hence all the api auth routes are prefixed with `/api/v1` and the routes are:

### api endpoints

- Signup:

  `POST: /api/v1/register`
  ```json
  {
    "name": "John Doe",
    "email": "johndoe@example.org",
    "password": "password",
    "password_confirmation": "password"
  }
  ```
- Login:

  `POST: /api/v1/login`
  ```json
  {
    "email": "johndoe@example.org",
    "password": "password"
  }
  ```
- Logout:

  `POST: /api/v1/logout`

- Get authenticated user details:

  `GET: /api/v1/user`
- Send forgot password email:

  `POST: /api/v1/password/email`

  ```json
  {
    "email": "johndoe@example.org"
  }
  ```

- Reset password:

  `POST: /api/v1/password/reset`

  ```json
  {
    "email": "johndoe@example.org",
    "token": "valid-token-recieved-in-email",
    "password": "password",
    "password_confirmation": "password"
  }
  ```
