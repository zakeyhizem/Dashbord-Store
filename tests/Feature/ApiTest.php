<?php

namespace Tests\Feature;

use Tests\TestCase;

class ApiTest extends TestCase
{
    /**
     * Test basic API endpoint.
     */
    public function test_api_returns_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertJson([
            'name' => 'Dashboard Store API',
            'version' => '1.0.0',
        ]);
    }
}
