<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        $users = json_decode(file_get_contents(storage_path() . "/json/users.json"), true);
        foreach($users['users'] as $user){
            User::create([
                "balance"       => $user['balance'],
                "currency"      => $user['currency'],
                "email"         => $user['email'],
                "created_at"    => Carbon::createFromFormat('d/m/Y', $user['created_at'])->format('Y-m-d'),
                "id"            => $user['id']
            ]);
        }
    }
}
