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

  `POST: /api/v1/signup`
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

- Get v1enticated user details:

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

### Create tests for auth endpoints

Create AuthController test with `php artsan make:test`

```bash
php artisan make:test Api/Auth/AuthControllerTest
```

Add Following code in `tests/Feature/Api/Auth/AuthControllerTest.php`

```php
<?php

namespace Tests\Feature\Api\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;use Illuminate\Support\Facades\Hash;use Illuminate\Support\Facades\Password;use Laravel\Sanctum\Sanctum;use Modules\User\Models\User;use Notification;use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;


    public function setUp() :void
    {
        parent::setUp();

        // fake all notifications that are sent out during tests
        Notification::fake();

        // create a user
        User::factory()->create([
            'email' => 'johndoe@example.org',
            'password' => Hash::make('testpassword')
        ]);

    }

    public function test_show_validation_error_when_both_fields_empty()
    {

        $response = $this->json('POST', route('auth.login'), [
            'email' => '',
            'password' => ''
        ]);

        $response->assertStatus(422)
        ->assertJsonValidationErrors(['email', 'password']);
    }


    public function test_show_validation_error_on_email_when_credential_donot_match()
    {
        $response = $this->json('POST', route('auth.login'), [
            'email' => 'test@test.com',
            'password' => 'abcdabcd'
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }

    public function test_return_user_and_access_token_after_successful_login()
    {
        $response = $this->json('POST', route('auth.login'), [
            'email' =>'johndoe@example.org',
            'password' => 'testpassword',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['user', 'access_token']);
    }

    public function test_non_authenticated_user_cannot_get_user_details()
    {

        $response = $this->json('GET', route('auth.user'));

        $response->assertStatus(401)
            ->assertSee('Unauthenticated');
    }

    public function test_authenticated_user_can_get_user_details()
    {
        Sanctum::actingAs(
            User::first(),
        );

        $response = $this->json('GET', route('auth.user'));

        $response->assertStatus(200)
            ->assertJsonStructure(['name', 'email']);
    }

    public function test_non_authenticated_user_cannot_logout()
    {
        $response = $this->json('POST', route('auth.logout'), []);

        $response->assertStatus(401)
            ->assertSee('Unauthenticated');;
    }

    public function test_authenticated_user_can_logout()
    {
        Sanctum::actingAs(
            User::first(),
        );

        $response = $this->json('POST', route('auth.logout'), []);

        $response->assertStatus(200);
    }


    // Password reset
    public function test_return_validation_error_when_email_doenot_exist()
    {
        $response = $this->json('POST', route('password.email'), ['email' => 'invalid@email.com']);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }

    public function test_send_password_reset_link_if_email_exists()
    {
        $user = User::first();
        $response = $this->json('POST', route('password.email'), ['email' => $user->email]);

        $response->assertStatus(200)
            ->assertJsonStructure(['message']);

        // Notification::assertSentTo($user, ResetPassword::class); // running on issue with asserting notification
    }

    public function test_reset_password_success()
    {
        $user = User::first();
        $token = Password::broker()->createToken($user);
        $new_password = 'testpassword';

        $response = $this->json('POST', route('password.reset'), [
            'token' => $token,
            'email' => $user->email,
            'password' => $new_password,
            'password_confirmation' => $new_password
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['message']);
    }
}
```

> If theres any problem on this please open an issue !
