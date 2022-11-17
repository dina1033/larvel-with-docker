<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
// use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserTest extends TestCase
{
    // use DatabaseMigrations;
    // use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_all_users_route()
    {
        $response = $this->get('/api/users',['x-api-key' => 'pricHJpdmF0ZWFwaQ==vate']);

        $response->assertStatus(200);
    }

    public function test_add_users_from_file_json_route()
    {
        $response = $this->withHeaders(['x-api-key' => 'pricHJpdmF0ZWFwaQ==vate'])
        ->post('/api/users',[
            'file' => storage_path("/json/users.json")
        ]);

        $response->assertStatus(422);
    }
}
