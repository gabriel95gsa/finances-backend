<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class ExpenseControllerTest extends TestCase
{
    public function test_get_all_resources_return_200_status(): void
    {
        $response = $this->getJson($this->apiUri, [
            'Authorization' => $this->authorizationToken
        ])->assertStatus(Response::HTTP_OK)->json('data');
    }

    public function test_create_resource_return_201_status(): void
    {
        // TODO: Implement test_create_resource_return_201_status() method.
    }

    public function test_create_resource_return_422_status_on_incorrect_request_field(): void
    {
        // TODO: Implement test_create_resource_return_422_status_on_incorrect_request_field() method.
    }

    public function test_get_resource_by_id_return_200_status(): void
    {
        // TODO: Implement test_get_resource_by_id_return_200_status() method.
    }

    public function test_get_resource_by_id_return_404_status_on_nonexistent_resource_id(): void
    {
        // TODO: Implement test_get_resource_by_id_return_404_status_on_nonexistent_resource_id() method.
    }

    public function test_get_resource_by_id_return_403_status_on_access_forbidden(): void
    {
        // TODO: Implement test_get_resource_by_id_return_403_status_on_access_forbidden() method.
    }

    public function test_update_resource_return_200_status(): void
    {
        // TODO: Implement test_update_resource_return_200_status() method.
    }

    public function test_update_resource_return_422_status_on_incorrect_request_field(): void
    {
        // TODO: Implement test_update_resource_return_422_status_on_incorrect_request_field() method.
    }

    public function test_update_resource_return_404_status_on_nonexistent_resource_id(): void
    {
        // TODO: Implement test_update_resource_return_404_status_on_nonexistent_resource_id() method.
    }

    public function test_update_resource_return_403_status_on_access_forbidden(): void
    {
        // TODO: Implement test_update_resource_return_403_status_on_access_forbidden() method.
    }

    public function test_delete_resource_return_200_status(): void
    {
        // TODO: Implement test_delete_resource_return_200_status() method.
    }

    public function test_delete_resource_return_422_status_on_incorrect_request_field(): void
    {
        // TODO: Implement test_delete_resource_return_422_status_on_incorrect_request_field() method.
    }

    public function test_delete_resource_return_404_status_on_nonexistent_resource_id(): void
    {
        // TODO: Implement test_delete_resource_return_404_status_on_nonexistent_resource_id() method.
    }

    public function test_delete_resource_return_403_status_on_access_forbidden(): void
    {
        // TODO: Implement test_delete_resource_return_403_status_on_access_forbidden() method.
    }
}
