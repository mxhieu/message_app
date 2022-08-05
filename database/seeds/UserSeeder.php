<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run($limit = 3)
    {
        $faker = \Faker\Factory::create();

        for ($i = 0; $i < $limit; $i++) {
            $startDate = 1451606400; //01/01/2016
            $endDate = 1609459200; //01/01/2021
            $randomDate = \Carbon\Carbon::createFromTimestamp(rand($startDate, $endDate));
            
            \DB::table('users')->insert([
                'name' => $faker->name,
                'created_at' => $randomDate,
                'updated_at' => $randomDate
            ]);
        }
    }
}
