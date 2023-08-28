<?php

namespace Tests\Feature;

use App\Models\Expense;
use App\Models\ExpensesCategory;
use App\Models\RecurrentExpense;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class ExpenseControllerTest extends TestCase
{
    use RefreshDatabase;

    /*
     * Attributes used throughout the class
     */
    private ExpensesCategory $expensesCategory;

    private RecurrentExpense $recurrentExpense;

    protected function setUp(): void
    {
        parent::setUp();

        $this->expensesCategory = ExpensesCategory::create([
            'user_id' => $this->user->id,
            'name' => 'Test Expense Category 1',
        ]);

        $this->recurrentExpense = RecurrentExpense::create([
            'user_id' => $this->user->id,
            'expenses_category_id' => $this->expensesCategory->id,
            'description' => 'Test Recurrent Expense 1',
            'default_value' => 120,
            'limit_value' => 140,
            'due_day' => 15,
            'status' => 1,
        ]);

        // Overrides base apiUri to the test context uri
        $this->apiUri = $this->apiUri . 'expenses/';
    }

    public function test_get_all_resources_return_200_status(): void
    {
        $this->getJson($this->apiUri)->assertStatus(Response::HTTP_OK);
    }

    public function test_create_resource_return_201_status(): void
    {
        // Testing create expense with recurrence
        $response = $this->postJson($this->apiUri, [
            'user_id' => $this->user->id,
            'recurrent_expense_id' => $this->recurrentExpense->id,
            'period_date' => '2023-08',
        ])->assertStatus(Response::HTTP_CREATED);

        $this->assertEquals($this->recurrentExpense['description'], $response['description']);

        // Testing create expense without recurrence
        $description = fake()->text(50);

        $response = $this->postJson($this->apiUri, [
            'Authorization' => $this->authorizationToken,
            'user_id' => $this->user->id,
            'expenses_category_id' => $this->expensesCategory->id,
            'description' => $description,
            'value' => 85,
            'period_date' => '2023-09',
            'due_day' => 10,
        ])->assertStatus(Response::HTTP_CREATED);

        $this->assertEquals($description, $response['description']);
    }

    public function test_create_resource_return_422_status_on_incorrect_request_field(): void
    {
        // Testing create expense with recurrence
        $response = $this->postJson($this->apiUri, [
            'user_id' => $this->user->id,
            'description' => fake()->text(50),
            'recurrent_expense_id' => $this->recurrentExpense->id,
            'value' => 105,
            'period_date' => '2023-08',
        ])->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $this->assertEquals('Invalid data sent', $response['message']);
        $this->assertEquals(
            'The recurrent expense id field prohibits expenses category id / description / value / due day from being present.',
            $response['errors']['recurrent_expense_id'][0]
        );

        // Testing create expense without recurrence
        $response = $this->postJson($this->apiUri, [
            'Authorization' => $this->authorizationToken,
            'user_id' => $this->user->id,
            'expenses_category_id' => $this->expensesCategory->id,
            'value' => 85,
            'period_date' => '2023-09',
            'due_day' => 10,
        ])->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $this->assertEquals('Invalid data sent', $response['message']);
        $this->assertEquals(
            'The description field is required when recurrent expense id is not present.',
            $response['errors']['description'][0]
        );

        // Testing create expense with wrong data types
        $response = $this->postJson($this->apiUri, [
            'Authorization' => $this->authorizationToken,
            'user_id' => $this->user->id,
            'expenses_category_id' => $this->expensesCategory->id,
            'description' => 'Test Expense',
            'value' => '85abc',
            'period_date' => '2023-09-01',
            'due_day' => 10,
        ])->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $this->assertEquals('Invalid data sent', $response['message']);
        $this->assertEquals(
            'The value field must have 0-2 decimal places.',
            $response['errors']['value'][0]
        );
        $this->assertEquals(
            'The period date field must match the format Y-m.',
            $response['errors']['period_date'][0]
        );
    }

    public function test_get_resource_by_id_return_200_status(): void
    {
        $expense = Expense::first();

        $response = $this->getJson($this->apiUri . $expense->id)->assertStatus(Response::HTTP_OK)->json('data');

        $this->assertEquals($expense->id, $response['id']);
    }

    public function test_get_resource_by_id_return_404_status_on_nonexistent_resource_id(): void
    {
        $response = $this->getJson($this->apiUri . '99999')->assertStatus(Response::HTTP_NOT_FOUND)->json('message');

        $this->assertEquals('Resource not found.', $response);
    }

    public function test_get_resource_by_id_return_403_status_on_access_forbidden(): void
    {
        // Create
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
