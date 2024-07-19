<?php

namespace Tests\Feature;

use App\Models\Customer;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    // list
    public function test_customers_returns_a_successful_response(): void
    {
        $customerOne = $this->createCustomer([
            'name' => 'one name',
            'company_name' => 'one company_name',
            'address' => 'one address',
            'phone' => 'one phone',
            'email' => 'one@email.com',
            'country' => 'one country',
            'status' => Customer::POTENTIAL,
            'type' => 'one LSP',
        ]);

        $customerTwo = $this->createCustomer([
            'name' => 'two name',
            'company_name' => 'two company_name',
            'address' => 'two address',
            'phone' => 'two phone',
            'email' => 'two@email.com',
            'country' => 'two country',
            'status' => Customer::POTENTIAL,
            'type' => 'two LSP',
        ]);

        $response = $this->get('/api/customers');

        $this->assertResponseStructure($response);

        $this->assertEquals($customerOne->name, $response['data'][0]['name']);
        $this->assertEquals($customerTwo->name, $response['data'][1]['name']);
        $this->assertEquals($customerOne->company_name, $response['data'][0]['company_name']);
        $this->assertEquals($customerTwo->company_name, $response['data'][1]['company_name']);
        $this->assertEquals($customerOne->address, $response['data'][0]['address']);
        $this->assertEquals($customerTwo->address, $response['data'][1]['address']);
        $this->assertEquals($customerOne->phone, $response['data'][0]['phone']);
        $this->assertEquals($customerTwo->phone, $response['data'][1]['phone']);
        $this->assertEquals($customerOne->email, $response['data'][0]['email']);
        $this->assertEquals($customerTwo->email, $response['data'][1]['email']);
        $this->assertEquals($customerOne->country, $response['data'][0]['country']);
        $this->assertEquals($customerTwo->country, $response['data'][1]['country']);
        $this->assertEquals($customerOne->status, $response['data'][0]['status']);
        $this->assertEquals($customerTwo->status, $response['data'][1]['status']);
        $this->assertEquals($customerOne->type, $response['data'][0]['type']);
        $this->assertEquals($customerTwo->type, $response['data'][1]['type']);
    }

    // show
    public function test_one_customer_returns_a_successful_response(): void
    {
        $customer = $this->createCustomer();

        $response = $this->get('/api/customers/'.$customer->id);

        $this->assertResponseStructure($response);

        $this->assertEquals($customer->id, $response['data']['id']);
        $this->assertEquals($customer->name, $response['data']['name']);
        $this->assertEquals($customer->company_name, $response['data']['company_name']);
        $this->assertEquals($customer->address, $response['data']['address']);
        $this->assertEquals($customer->status, $response['data']['status']);
        $this->assertEquals($customer->phone, $response['data']['phone']);
        $this->assertEquals($customer->email, $response['data']['email']);
        $this->assertEquals($customer->country, $response['data']['country']);
        $this->assertEquals($customer->status, $response['data']['status']);
        $this->assertEquals($customer->type, $response['data']['type']);
    }

    // store
    public function test_create_customer_returns_a_successful_response()
    {
        $response = $this->post('/api/customers/', [
            'name' => 'stored name',
            'company_name' => 'stored company_name',
            'address' => 'stored address',
            'phone' => 'stored phone',
            'email' => 'stored@email.com',
            'country' => 'stored country',
            'status' => Customer::CURRENT,
            'type' => 'stored LSP',
        ]);

        $this->assertResponseStructure($response);

        $this->assertEquals('stored name', $response['data']['name']);
        $this->assertEquals('stored company_name', $response['data']['company_name']);
        $this->assertEquals('stored address', $response['data']['address']);
        $this->assertEquals('stored phone', $response['data']['phone']);
        $this->assertEquals('stored@email.com', $response['data']['email']);
        $this->assertEquals('stored country', $response['data']['country']);
        $this->assertEquals(Customer::CURRENT, $response['data']['status']);
        $this->assertEquals('stored LSP', $response['data']['type']);
    }

    // put
    public function test_update_customer_returns_a_successful_response()
    {
        $customer = $this->createCustomer();

        $response = $this->put('/api/customers/'.$customer->id, [
            'name' => 'updated name',
            'company_name' => 'updated company_name',
            'address' => 'updated address',
            'phone' => 'updated phone',
            'email' => 'updated@email.com',
            'country' => 'updated country',
            'status' => Customer::CURRENT,
            'type' => 'updated LSP',
        ]);

        $this->assertResponseStructure($response);

        $this->assertEquals('updated name', $response['data']['name']);
        $this->assertEquals('updated company_name', $response['data']['company_name']);
        $this->assertEquals('updated address', $response['data']['address']);
        $this->assertEquals('updated phone', $response['data']['phone']);
        $this->assertEquals('updated@email.com', $response['data']['email']);
        $this->assertEquals('updated country', $response['data']['country']);
        $this->assertEquals(Customer::CURRENT, $response['data']['status']);
        $this->assertEquals('updated LSP', $response['data']['type']);
    }

    // destroy
    public function test_delete_customer_returns_a_successful_response()
    {
        $customer = $this->createCustomer();

        $response = $this->delete('/api/customers/'.$customer->id);

        $this->assertResponseStructure($response);
    }

    // comment
    public function test_add_comment_to_customer_returns_a_successful_response()
    {
        $customer = $this->createCustomer();

        $response = $this->post('/api/customers/'.$customer->id.'/comments', [
            'comment' => 'test comment',
        ]);

        $this->assertResponseStructure($response);

        $this->assertEquals($customer->comments[0]->comment, $response['data']['comment']);
    }

    // request
    public function test_add_request_to_customer_returns_a_successful_response()
    {
        $customer = $this->createCustomer();

        $response = $this->post('/api/customers/'.$customer->id.'/requests', [
            'request' => 'test request',
        ]);

        $this->assertResponseStructure($response);

        $this->assertEquals($customer->requests[0]->request, $response['data']['request']);
    }

    private function createCustomer(array $attributes = []): Customer
    {
        if (count($attributes) === 0) {
            $attributes = [
                'name' => 'name',
                'company_name' => 'company_name',
                'address' => 'address',
                'phone' => 'phone',
                'email' => 'email@email.com',
                'country' => 'country',
                'status' => Customer::POTENTIAL,
                'type' => 'LSP',
            ];
        }

        $customer = new Customer($attributes);
        $customer->save();

        return $customer;
    }
}
