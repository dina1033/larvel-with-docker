<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

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
        Storage::fake('local');
        $file = UploadedFile::fake()->create('file.json');

        $response = $this->withHeaders(['Key' => 'pricHJpdmF0ZWFwaQ==vate'])
        ->post('/api/add-user',[
            'file' => $file
        ]);

        $response->assertStatus(200);
    }
}
