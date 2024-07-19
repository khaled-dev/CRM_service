<?php

namespace Tests\Feature;

use App\Models\Opportunity;
use Tests\TestCase;

class OpportunityTest extends TestCase
{
    // list
    public function test_opportunities_returns_a_successful_response(): void
    {
        $opportunityOne = $this->createOpportunity([
            'deal_value' => '1000',
            'stage' => Opportunity::STAGES[0],
            'close_date' => '2020-02-02',
            'probability' => '1 probability',
        ]);

        $opportunityTwo = $this->createOpportunity([
            'deal_value' => '2000',
            'stage' => Opportunity::STAGES[1],
            'close_date' => '2020-02-02',
            'probability' => '2 probability',
        ]);

        $response = $this->get('/api/opportunities');

        $this->assertResponseStructure($response);

        $this->assertEquals($opportunityOne->deal_value, $response['data'][0]['deal_value']);
        $this->assertEquals($opportunityTwo->deal_value, $response['data'][1]['deal_value']);
        $this->assertEquals($opportunityOne->stage, $response['data'][0]['stage']);
        $this->assertEquals($opportunityTwo->stage, $response['data'][1]['stage']);
        $this->assertEquals($opportunityOne->close_date, $response['data'][0]['close_date']);
        $this->assertEquals($opportunityTwo->close_date, $response['data'][1]['close_date']);
        $this->assertEquals($opportunityOne->probability, $response['data'][0]['probability']);
        $this->assertEquals($opportunityTwo->probability, $response['data'][1]['probability']);
    }

    // show
    public function test_one_opportunity_returns_a_successful_response(): void
    {
        $opportunity = $this->createOpportunity();

        $response = $this->get('/api/opportunities/'.$opportunity->id);

        $this->assertResponseStructure($response);

        $this->assertEquals($opportunity->id, $response['data']['id']);
        $this->assertEquals($opportunity->deal_value, $response['data']['deal_value']);
        $this->assertEquals($opportunity->stage, $response['data']['stage']);
        $this->assertEquals($opportunity->close_date, $response['data']['close_date']);
        $this->assertEquals($opportunity->probability, $response['data']['probability']);

    }

    // store
    public function test_create_opportunity_returns_a_successful_response()
    {
        $response = $this->post('/api/opportunities/', [
            'deal_value' => '3000',
            'stage' => Opportunity::STAGES[2],
            'close_date' => '2020-07-07',
            'probability' => 'new probability',
        ]);

        $this->assertResponseStructure($response);

        $this->assertEquals('3000', $response['data']['deal_value']);
        $this->assertEquals(Opportunity::STAGES[2], $response['data']['stage']);
        $this->assertEquals('2020-07-07', $response['data']['close_date']);
        $this->assertEquals('new probability', $response['data']['probability']);
    }

    // put
    public function test_update_opportunity_returns_a_successful_response()
    {
        $opportunity = $this->createOpportunity();

        $response = $this->put('/api/opportunities/'.$opportunity->id, [
            'deal_value' => '7000',
            'stage' => Opportunity::STAGES[3],
            'close_date' => '2020-07-19',
            'probability' => 'updated probability',
        ]);

        $this->assertResponseStructure($response);

        $this->assertEquals('7000', $response['data']['deal_value']);
        $this->assertEquals(Opportunity::STAGES[3], $response['data']['stage']);
        $this->assertEquals('2020-07-19', $response['data']['close_date']);
        $this->assertEquals('updated probability', $response['data']['probability']);
    }

    // destroy
    public function test_delete_opportunity_returns_a_successful_response()
    {
        $opportunity = $this->createOpportunity();

        $response = $this->delete('/api/opportunities/'.$opportunity->id);

        $this->assertResponseStructure($response);
    }

    private function createOpportunity(array $attributes = []): Opportunity
    {
        if (count($attributes) === 0) {
            $attributes = [
                'deal_value' => '1000',
                'stage' => Opportunity::STAGES[0],
                'close_date' => '2020-06-19',
                'probability' => 'probability',
            ];
        }

        $opportunity = new Opportunity($attributes);
        $opportunity->save();

        return $opportunity;
    }
}
