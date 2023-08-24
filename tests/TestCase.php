<?php

namespace Tests;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Hash;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected string $apiUri;

    protected string $authorizationToken;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

//        $this->seed();

        $this->apiUri = 'api/app/';

//        $this->user = $this->createUser([
//            'name' => 'Test User 1',
//            'email' => 'testuser1@testing.com',
//            'password' => Hash::make('1234'),
//        ]);
//
//        $this->user->email_verified_at = Carbon::now();
//        $this->user->save();

        $authorizationToken = $this->postJson('api/auth/login', [
            'email' => $this->user->email,
            'password' => '1234',
        ])->json('access_token');
    }

    protected function createUser(array $attributes): User
    {
        return User::factory()->create($attributes);
    }

    /**
     * Abstract method which should be implemented in the feature test classes
     * For testing all their api methods
     */
    public abstract function test_get_all_resources_return_200_status(): void;

    public abstract function test_create_resource_return_201_status(): void;

    public abstract function test_create_resource_return_422_status_on_incorrect_request_field(): void;

    public abstract function test_get_resource_by_id_return_200_status(): void;

    public abstract function test_get_resource_by_id_return_404_status_on_nonexistent_resource_id(): void;

    public abstract function test_get_resource_by_id_return_403_status_on_access_forbidden(): void;

    public abstract function test_update_resource_return_200_status(): void;

    public abstract function test_update_resource_return_422_status_on_incorrect_request_field(): void;

    public abstract function test_update_resource_return_404_status_on_nonexistent_resource_id(): void;

    public abstract function test_update_resource_return_403_status_on_access_forbidden(): void;

    public abstract function test_delete_resource_return_200_status(): void;

    public abstract function test_delete_resource_return_422_status_on_incorrect_request_field(): void;

    public abstract function test_delete_resource_return_404_status_on_nonexistent_resource_id(): void;

    public abstract function test_delete_resource_return_403_status_on_access_forbidden(): void;
}
