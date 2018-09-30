<?php

use Illuminate\Database\Seeder;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $jsonString = file_get_contents(base_path('resources/province.json'));

        $data = json_decode($jsonString, true);
        foreach ($data as $province) {
            DB::table('cities')->insert(['name' => $province['Place_Name']]);
             
        }
    }
}
