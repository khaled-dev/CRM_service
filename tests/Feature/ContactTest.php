<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\Contact;
use Tests\TestCase;

class ContactTest extends TestCase
{
    // list
    public function test_contacts_returns_a_successful_response(): void
    {
        $mockAccount = new Account();
        $mockAccount->save();

        $contactOne = $this->createContact($mockAccount, [
            'name' => 'one name',
            'email' => 'one email',
            'phone' => 'one phone',
            'position' => 'one position',
        ]);

        $contactTwo = $this->createContact($mockAccount, [
            'name' => 'two name',
            'email' => 'two email',
            'phone' => 'two phone',
            'position' => 'two position',
        ]);

        $response = $this->get('/api/accounts/' . $mockAccount->id . '/contacts');

        $this->assertResponseStructure($response);

        $this->assertEquals($contactOne->name, $response['data'][0]['name']);
        $this->assertEquals($contactTwo->name, $response['data'][1]['name']);
        $this->assertEquals($contactOne->email, $response['data'][0]['email']);
        $this->assertEquals($contactTwo->email, $response['data'][1]['email']);
        $this->assertEquals($contactOne->phone, $response['data'][0]['phone']);
        $this->assertEquals($contactTwo->phone, $response['data'][1]['phone']);
        $this->assertEquals($contactOne->position, $response['data'][0]['position']);
        $this->assertEquals($contactTwo->position, $response['data'][1]['position']);
    }

    // show
    public function test_one_contact_returns_a_successful_response(): void
    {
        $mockAccount = new Account();
        $mockAccount->save();

        $contact = $this->createContact($mockAccount);

        $response = $this->get('/api/accounts/' . $mockAccount->id . '/contacts/' . $contact->id);

        $this->assertResponseStructure($response);

        $this->assertEquals($contact->id, $response['data']['id']);
        $this->assertEquals($contact->name, $response['data']['name']);
        $this->assertEquals($contact->email, $response['data']['email']);
        $this->assertEquals($contact->phone, $response['data']['phone']);
        $this->assertEquals($contact->position, $response['data']['position']);

    }

    // store
    public function test_create_contact_returns_a_successful_response()
    {
        $mockAccount = new Account();
        $mockAccount->save();

        $response = $this->post('/api/accounts/' . $mockAccount->id . '/contacts/', [
            'name' => 'a test name',
            'email' => 'a test email',
            'phone' => 'a test phone',
            'position' => 'a test position',
        ]);

        $this->assertResponseStructure($response);

        $this->assertEquals('a test name', $response['data']['name']);
        $this->assertEquals('a test email', $response['data']['email']);
        $this->assertEquals('a test phone', $response['data']['phone']);
        $this->assertEquals('a test position', $response['data']['position']);
    }

    // put
    public function test_update_contact_returns_a_successful_response()
    {
        $mockAccount = new Account();
        $mockAccount->save();

        $contact = $this->createContact($mockAccount);

        $response = $this->put('/api/accounts/' . $mockAccount->id . '/contacts/' . $contact->id, [
            'name' => 'updated name',
            'email' => 'updated email',
            'phone' => 'updated phone',
            'position' => 'updated position',
        ]);

        $this->assertResponseStructure($response);

        $this->assertEquals('updated name', $response['data']['name']);
        $this->assertEquals('updated email', $response['data']['email']);
        $this->assertEquals('updated phone', $response['data']['phone']);
        $this->assertEquals('updated position', $response['data']['position']);
    }

    // destroy
    public function test_delete_contact_returns_a_successful_response()
    {
        $mockAccount = new Account();
        $mockAccount->save();

        $contact = $this->createContact($mockAccount);

        $response = $this->delete('/api/accounts/' . $mockAccount->id . '/contacts/' . $contact->id);

        $this->assertResponseStructure($response);
    }

    private function createContact(Account $account, array $attributes = []): Contact
    {
        if (count($attributes) === 0) {
            $attributes = [
                'name' => 'a test name',
                'email' => 'a test email',
                'phone' => 'a test phone',
                'position' => 'a test position',
            ];
        }

        /** @var Contact $contact */
        $contact = $account->contacts()->create($attributes);

        return $contact;
    }
}
