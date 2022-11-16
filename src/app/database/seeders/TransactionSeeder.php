<?php

namespace Database\Seeders;

use App\Models\Transection;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Transection::truncate();
        $transections = json_decode(file_get_contents(storage_path() . "/json/transactions.json"), true);
        foreach($transections['transactions'] as $transection){
            Transection::create([
                "paidAmount"                => $transection['paidAmount'],
                "currency"                  => $transection['Currency'],
                "parentEmail"               => $transection['parentEmail'],
                "statusCode"                => $transection['statusCode'],
                "created_at"                => $transection['paymentDate'],
                "parentIdentification"      => $transection['parentIdentification']
            ]);
        }
    }
}
