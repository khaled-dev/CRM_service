<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\User;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class AccountTest extends TestCase
{
    // list
    public function test_accounts_returns_a_successful_response(): void
    {
        $accountOne = $this->createAccount([
            'name' => 'name 1',
            'industry' => 'industry 1',
            'annual_revenue' => 'annual_revenue 1',
            'status' => Account::ACTIVE,
        ]);

        $accountTwo = $this->createAccount([
            'name' => 'name 2',
            'industry' => 'industry 2',
            'annual_revenue' => 'annual_revenue 3',
            'status' => Account::ACTIVE,
        ]);

        $response = $this->get('/api/accounts');

        $this->assertAccountResponseStructure($response);

        $this->assertEquals($accountOne->name, $response['data'][0]['name']);
        $this->assertEquals($accountTwo->name, $response['data'][1]['name']);

        $response->assertStatus(200);
    }

    // show
    public function test_one_account_returns_a_successful_response(): void
    {
        $account = $this->createAccount();

        $response = $this->get('/api/accounts/'.$account->id);

        $this->assertAccountResponseStructure($response);

        $this->assertEquals($account->id, $response['data']['id']);
        $this->assertEquals($account->name, $response['data']['name']);
        $this->assertEquals($account->industry, $response['data']['industry']);
        $this->assertEquals($account->annual_revenue, $response['data']['annual_revenue']);
        $this->assertEquals($account->status, $response['data']['status']);

    }

    // store
    public function test_create_account_returns_a_successful_response()
    {
        $response = $this->post('/api/accounts/', [
            'name' => 'test name',
            'industry' => 'test industry',
            'annual_revenue' => 'test annual_revenue',
            'status' => Account::INACTIVE,
        ]);

        $this->assertAccountResponseStructure($response);

        $this->assertEquals('test name', $response['data']['name']);
        $this->assertEquals('test industry', $response['data']['industry']);
        $this->assertEquals('test annual_revenue', $response['data']['annual_revenue']);
        $this->assertEquals(Account::INACTIVE, $response['data']['status']);
    }

    // put
    public function test_update_account_returns_a_successful_response()
    {
        $account = $this->createAccount();

        $response = $this->put('/api/accounts/'.$account->id, [
            'name' => 'updated name',
            'industry' => 'updated industry',
            'annual_revenue' => 'updated annual_revenue',
            'status' => Account::ACTIVE,
        ]);

        $this->assertAccountResponseStructure($response);

        $this->assertEquals('updated name', $response['data']['name']);
        $this->assertEquals('updated industry', $response['data']['industry']);
        $this->assertEquals('updated annual_revenue', $response['data']['annual_revenue']);
        $this->assertEquals(Account::ACTIVE, $response['data']['status']);
    }

    // destroy
    public function test_delete_account_returns_a_successful_response()
    {
        $account = $this->createAccount([
            'name' => 'deleted name',
            'industry' => 'deleted industry',
            'annual_revenue' => 'deleted annual_revenue',
            'status' => Account::INACTIVE,
        ]);

        $response = $this->delete('/api/accounts/'.$account->id);

        $this->assertAccountResponseStructure($response);
    }

    // store
    public function test_assign_user_to_account_returns_a_successful_response()
    {
        $user = new User([
            'name' => 'test name',
            'email' => 'test email',
            'type' => User::ACCOUNT_MANGER,
        ]);
        $user->save();

        $account = $this->createAccount();

        $response = $this->post('/api/accounts/'.$account->id.'/assign', [
            'user_id' => $user->id,
        ]);

        $this->assertAccountResponseStructure($response);

        $this->assertEquals($account->name, $response['data']['name']);
        $this->assertEquals($account->industry, $response['data']['industry']);
        $this->assertEquals($user->id, $response['data']['assigned_to']['id']);
        $this->assertEquals($user->name, $response['data']['assigned_to']['name']);
        $this->assertEquals($user->type, $response['data']['assigned_to']['type']);

    }

    private function assertAccountResponseStructure(TestResponse $response): void
    {
        $response->assertJsonStructure([
            'state',
            'message',
            'data',
            'metadata',
        ])
            ->assertJsonPath('state', true)
            ->assertJsonPath('message', 'Request Successful')
            ->assertStatus(200);
    }

    private function createAccount(array $attributes = []): Account
    {
        if (count($attributes) === 0) {
            $attributes = [
                'name' => 'name',
                'industry' => 'industry',
                'annual_revenue' => 'annual_revenue',
                'status' => Account::INACTIVE,
            ];
        }

        $account = new Account($attributes);
        $account->save();

        return $account;
    }
}
