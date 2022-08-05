<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run($limit = 10)
    {
        $faker = \Faker\Factory::create();

        for ($i = 0; $i < $limit; $i++) {

            $senderId = \App\User::all()->random()->id;
            $receiverId = $receiverId = \App\User::where('id', '!=', $senderId)->get()->random()->id;

            $startDate = 1451606400; //01/01/2016
            $endDate = 1609459200; //01/01/2021
            $randomDate = \Carbon\Carbon::createFromTimestamp(rand($startDate, $endDate));
            
            \DB::table('messages')->insert([
                'sender_id' => $senderId,
                'message' => $faker->text,
                'receiver_id' => $receiverId,
                'updated_at' => $randomDate,
                'created_at' => $randomDate
            ]);
        }
    }
}
