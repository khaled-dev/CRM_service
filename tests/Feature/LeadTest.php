<?php

namespace Tests\Feature;

use App\Models\Lead;
use App\Models\User;
use Tests\TestCase;

class LeadTest extends TestCase
{
    // list
    public function test_leads_returns_a_successful_response(): void
    {
        $leadOne = $this->createLead([
            'source' => Lead::SOURCE_REFERRAL,
            'status' => Lead::STATUS_NEW,
            'phone' => 'one phone number',
            'email' => 'one@email.com',
            'interest_level' => LEAD::INTEREST_HIGH,
        ]);

        $leadTwo = $this->createLead([
            'source' => Lead::SOURCE_EVENT,
            'status' => Lead::STATUS_QUALIFIED,
            'phone' => 'two phone number',
            'email' => 'one@email.com',
            'interest_level' => LEAD::INTEREST_LOW,
        ]);

        $response = $this->get('/api/leads');

        $this->assertResponseStructure($response);

        $this->assertEquals($leadOne->source, $response['data'][0]['source']);
        $this->assertEquals($leadTwo->source, $response['data'][1]['source']);
        $this->assertEquals($leadOne->status, $response['data'][0]['status']);
        $this->assertEquals($leadTwo->status, $response['data'][1]['status']);
        $this->assertEquals($leadOne->phone, $response['data'][0]['phone']);
        $this->assertEquals($leadTwo->phone, $response['data'][1]['phone']);
        $this->assertEquals($leadOne->email, $response['data'][0]['email']);
        $this->assertEquals($leadTwo->email, $response['data'][1]['email']);
        $this->assertEquals($leadOne->interest_level, $response['data'][0]['interest_level']);
        $this->assertEquals($leadTwo->interest_level, $response['data'][1]['interest_level']);
    }

    // show
    public function test_one_lead_returns_a_successful_response(): void
    {
        $lead = $this->createLead();

        $response = $this->get('/api/leads/'.$lead->id);

        $this->assertResponseStructure($response);

        $this->assertEquals($lead->id, $response['data']['id']);
        $this->assertEquals($lead->source, $response['data']['source']);
        $this->assertEquals($lead->status, $response['data']['status']);
        $this->assertEquals($lead->phone, $response['data']['phone']);
        $this->assertEquals($lead->email, $response['data']['email']);
        $this->assertEquals($lead->interest_level, $response['data']['interest_level']);

    }

    // store
    public function test_create_lead_returns_a_successful_response()
    {
        $response = $this->post('/api/leads/', [
            'source' => Lead::SOURCE_WEBSITE,
            'status' => Lead::STATUS_LOST,
            'phone' => 'stored phone number',
            'email' => 'stored@email.com',
            'interest_level' => LEAD::INTEREST_HIGH,
        ]);

        $this->assertResponseStructure($response);

        $this->assertEquals(Lead::SOURCE_WEBSITE, $response['data']['source']);
        $this->assertEquals(Lead::STATUS_LOST, $response['data']['status']);
        $this->assertEquals('stored phone number', $response['data']['phone']);
        $this->assertEquals('stored@email.com', $response['data']['email']);
        $this->assertEquals(LEAD::INTEREST_HIGH, $response['data']['interest_level']);
    }

    // put
    public function test_update_lead_returns_a_successful_response()
    {
        $lead = $this->createLead();

        $response = $this->put('/api/leads/'.$lead->id, [
            'source' => Lead::SOURCE_WEBSITE,
            'status' => Lead::STATUS_LOST,
            'phone' => 'updated phone number',
            'email' => 'updated@email.com',
            'interest_level' => LEAD::INTEREST_MEDIUM,
        ]);

        $this->assertResponseStructure($response);

        $this->assertEquals(Lead::SOURCE_WEBSITE, $response['data']['source']);
        $this->assertEquals(Lead::STATUS_LOST, $response['data']['status']);
        $this->assertEquals('updated phone number', $response['data']['phone']);
        $this->assertEquals('updated@email.com', $response['data']['email']);
        $this->assertEquals(LEAD::INTEREST_MEDIUM, $response['data']['interest_level']);
    }

    // destroy
    public function test_delete_lead_returns_a_successful_response()
    {
        $lead = $this->createLead();

        $response = $this->delete('/api/leads/'.$lead->id);

        $this->assertResponseStructure($response);
    }

    // assign
    public function test_assign_user_to_lead_returns_a_successful_response()
    {
        $user = new User([
            'name' => 'test name',
            'email' => 'test email',
            'type' => User::ACCOUNT_MANGER,
        ]);
        $user->save();

        $lead = $this->createLead();

        $response = $this->post('/api/leads/'.$lead->id.'/assign', [
            'user_id' => $user->id,
        ]);

        $this->assertResponseStructure($response);

        $this->assertEquals($lead->id, $response['data']['id']);

        $this->assertEquals($user->id, $response['data']['assigned_to']['id']);
        $this->assertEquals($user->name, $response['data']['assigned_to']['name']);
        $this->assertEquals($user->email, $response['data']['assigned_to']['email']);
        $this->assertEquals($user->type, $response['data']['assigned_to']['type']);

    }

    // comment
    public function test_add_comment_to_lead_returns_a_successful_response()
    {
        $lead = $this->createLead();

        $response = $this->post('/api/leads/'.$lead->id.'/comments', [
            'comment' => 'test comment',
        ]);

        $this->assertResponseStructure($response);

        $this->assertEquals($lead->comments[0]->comment, $response['data']['comment']);
    }

    private function createLead(array $attributes = []): Lead
    {
        if (count($attributes) === 0) {
            $attributes = [
                'source' => Lead::SOURCE_EVENT,
                'status' => Lead::STATUS_CONTRACTED,
                'phone' => 'a phone number',
                'email' => 'email@email.com',
                'interest_level' => LEAD::INTEREST_MEDIUM,
            ];
        }

        $lead = new Lead($attributes);
        $lead->save();

        return $lead;
    }
}
