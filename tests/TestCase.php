<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, RefreshDatabase;

    /**
     * Indicates whether the default seeder should run before each test.
     *
     * @var bool
     */
    protected bool $seed = true;

    protected string $apiUri;

    protected string $authorizationToken;

    protected User $user, $user2;

    protected function setUp(): void
    {
        parent::setUp();

        $this->apiUri = 'api/app/';

        $this->user = User::where('email', 'testuser1@example.com')->first();

        $this->user2 = User::where('email', 'testuser2@example.com')->first();

        $this->authorizationToken = 'bearer ' . $this->postJson('api/auth/login', [
                'email' => $this->user->email,
                'password' => '1234',
            ])->json('access_token');

        $this->withHeader('Authorization', $this->authorizationToken);
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

    public abstract function test_delete_resource_return_404_status_on_nonexistent_resource_id(): void;

    public abstract function test_delete_resource_return_403_status_on_access_forbidden(): void;
}
