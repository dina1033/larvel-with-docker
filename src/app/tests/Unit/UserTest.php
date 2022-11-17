<?php

namespace Tests\Unit;

// use PHPUnit\Framework\TestCase;
use App\Models\User;
// use Illuminate\Foundation\Testing\DatabaseMigrations;
// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    // use DatabaseMigrations;
    // use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_example()
    {
        $this->assertTrue(true);
    }

    // public function test_filter_users(){

    //     $request = [
    //         'statuscode'   =>  'authorized',
    //         'currency'      =>  'SAR',
    //         'amount'        =>  '150,280'
    //     ];
       
    //    $users = User::Filter((object) $request)->first();
    //    $this->assertEqual($request['statuscode'],$users->transections->statusCode);
    // }
}
