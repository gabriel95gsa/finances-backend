<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function createUser(array $attributes): User
    {
        return User::factory()->create($attributes);
    }

    protected abstract function test_get_all_resources(): void;

    protected abstract function test_create_resource_return_201_status(): void;

    protected abstract function test_create_resource_return_422_status_on_incorrect_request_field(): void;

    protected abstract function test_get_resource_by_id_return_200_status(): void;

    protected abstract function test_get_resource_by_id_return_404_status_on_nonexistent_resource_id(): void;

    protected abstract function test_get_resource_by_id_return_403_status_on_access_forbidden(): void;

    protected abstract function test_update_resource_return_200_status(): void;

    protected abstract function test_update_resource_return_422_status_on_incorrect_request_field(): void;

    protected abstract function test_update_resource_return_404_status_on_nonexistent_resource_id(): void;

    protected abstract function test_update_resource_return_403_status_on_access_forbidden(): void;

    protected abstract function test_delete_resource_return_200_status(): void;

    protected abstract function test_delete_resource_return_422_status_on_incorrect_request_field(): void;

    protected abstract function test_delete_resource_return_404_status_on_nonexistent_resource_id(): void;

    protected abstract function test_delete_resource_return_403_status_on_access_forbidden(): void;
}
