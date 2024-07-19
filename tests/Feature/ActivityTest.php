<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\Activity;
use App\Models\Contact;
use App\Models\User;
use Tests\TestCase;

class ActivityTest extends TestCase
{
    // list
    public function test_activities_returns_a_successful_response(): void
    {
        $activityOne = $this->createActivity([
            'type' => Activity::TYPE_DEMONSTRATION,
            'outcome' => 'outcome 1',
            'date' => '2024-07-19',
            'note' => 'note 1',
        ]);

        $activityTwo = $this->createActivity([
            'type' => Activity::TYPE_CALL,
            'outcome' => 'outcome 2',
            'date' => '2024-07-20',
            'note' => 'note 2',
        ]);

        $response = $this->get('/api/activities');

        $this->assertAccountResponseStructure($response);

        $this->assertEquals($activityOne->outcome, $response['data'][0]['outcome']);
        $this->assertEquals($activityTwo->outcome, $response['data'][1]['outcome']);
        $this->assertEquals($activityOne->type, $response['data'][0]['type']);
        $this->assertEquals($activityTwo->type, $response['data'][1]['type']);
        $this->assertEquals($activityOne->date, $response['data'][0]['date']);
        $this->assertEquals($activityTwo->date, $response['data'][1]['date']);

        $response->assertStatus(200);
    }

    // show
    public function test_one_activity_returns_a_successful_response(): void
    {
        $activity = $this->createActivity();

        $response = $this->get('/api/activities/' . $activity->id);

        $this->assertAccountResponseStructure($response);

        $this->assertEquals($activity->id, $response['data']['id']);
        $this->assertEquals($activity->outcome, $response['data']['outcome']);
        $this->assertEquals($activity->type, $response['data']['type']);
        $this->assertEquals($activity->date, $response['data']['date']);
        $this->assertEquals($activity->note, $response['data']['note']);

    }

    // store
    public function test_create_activity_returns_a_successful_response()
    {
        $mockContact = new Contact();
        $mockContact->save();

        $response = $this->post('/api/activities/', [
            'contact_id' => $mockContact->id,
            'outcome' => 'a test outcome',
            'type' => Activity::TYPE_EMAIL,
            'date' => '2024-07-19',
            'note' => 'a test note',
        ]);

        $this->assertAccountResponseStructure($response);

        $this->assertEquals('a test outcome', $response['data']['outcome']);
        $this->assertEquals(Activity::TYPE_EMAIL, $response['data']['type']);
        $this->assertEquals('2024-07-19', $response['data']['date']);
        $this->assertEquals('a test note', $response['data']['note']);
    }

    // put
    public function test_update_activity_returns_a_successful_response()
    {
        $activity = $this->createActivity();

        $response = $this->put('/api/activities/' . $activity->id, [
            'outcome' => 'updated outcome',
            'type' => Activity::TYPE_EMAIL,
            'date' => '2020-07-19',
            'note' => 'updated note',
        ]);

        $this->assertAccountResponseStructure($response);

        $this->assertEquals('updated outcome', $response['data']['outcome']);
        $this->assertEquals(Activity::TYPE_EMAIL, $response['data']['type']);
        $this->assertEquals('2020-07-19', $response['data']['date']);
        $this->assertEquals('updated note', $response['data']['note']);
    }

    // destroy
    public function test_delete_activity_returns_a_successful_response()
    {
        $activity = $this->createActivity([
            'outcome' => 'deleted outcome',
            'note' => 'deleted note',
            'date' => '2020-06-19',
            'type' => Activity::TYPE_EMAIL,
        ]);

        $response = $this->delete('/api/activities/'.$activity->id);

        $this->assertAccountResponseStructure($response);
    }

    private function createActivity(array $attributes = []): Activity
    {
        if (count($attributes) === 0) {
            $attributes = [
                'type' => Activity::TYPE_CALL,
                'outcome' => 'outcome',
                'date' => '2024-07-19',
                'note' => 'note',
            ];
        }

        $activity = new Activity($attributes);
        $activity->save();

        return $activity;
    }
}
