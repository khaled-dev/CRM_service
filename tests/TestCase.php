<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Testing\TestResponse;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabaseTrait;

    protected function setUp(): void
    {
        parent::setUp();
        $this->refreshDatabase();
    }

    protected function assertResponseStructure(TestResponse $response): void
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
}
