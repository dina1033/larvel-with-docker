<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_all_users_route()
    {
        $response = $this->get('/api/all-users',['Key' => 'pricHJpdmF0ZWFwaQ==vate']);

        $response->assertStatus(200);
    }

    public function test_add_users_from_file_json_route()
    {
        $response = $this->withHeaders(['Key' => 'pricHJpdmF0ZWFwaQ==vate'])
        ->post('/api/add-user',[
            'file' => storage_path("/json/users.json")
        ]);

        $response->assertStatus(422);
    }
}
