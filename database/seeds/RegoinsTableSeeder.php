<?php

use Illuminate\Database\Seeder;

class RegoinsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {       // 1063 regoins in this files 
            // cairo Regoins
            $jsonString = file_get_contents(base_path('resources/regoins/cairo.json'));
            $data = json_decode($jsonString, true);
            foreach ($data as $regoin) {
                DB::table('regoins')->insert([ 'name' => $regoin['Place_Name'], 'city_id' => 1]);
            }

            // Giza Regoins
            $jsonString = file_get_contents(base_path('resources/regoins/Giza.json'));
            $data = json_decode($jsonString, true);
            foreach ($data as $regoin) {
                DB::table('regoins')->insert([ 'name' => $regoin['Place_Name'], 'city_id' => 2]);
            }

            // Alexandria Regoins
            $jsonString = file_get_contents(base_path('resources/regoins/Alexandria.json'));
            $data = json_decode($jsonString, true);
            foreach ($data as $regoin) {
                DB::table('regoins')->insert([ 'name' => $regoin['Place_Name'], 'city_id' => 3]);
            }

            // Beheira Regoins
            $jsonString = file_get_contents(base_path('resources/regoins/Beheira.json'));
            $data = json_decode($jsonString, true);
            foreach ($data as $regoin) {
                DB::table('regoins')->insert([ 'name' => $regoin['Place_Name'], 'city_id' => 4]);
            }

            // BeniSuef Regoins
            $jsonString = file_get_contents(base_path('resources/regoins/BeniSuef.json'));
            $data = json_decode($jsonString, true);
            foreach ($data as $regoin) {
                DB::table('regoins')->insert([ 'name' => $regoin['Place_Name'], 'city_id' => 5]);
            }

            // Sohag Regoins
            $jsonString = file_get_contents(base_path('resources/regoins/Sohag.json'));
            $data = json_decode($jsonString, true);
            foreach ($data as $regoin) {
                DB::table('regoins')->insert([ 'name' => $regoin['Place_Name'], 'city_id' => 6]);
            }

            // KafrElSheikh Regoins
            $jsonString = file_get_contents(base_path('resources/regoins/KafrElSheikh.json'));
            $data = json_decode($jsonString, true);
            foreach ($data as $regoin) {
                DB::table('regoins')->insert([ 'name' => $regoin['Place_Name'], 'city_id' => 7]);
            }

            // Minya Regoins
            $jsonString = file_get_contents(base_path('resources/regoins/Minya.json'));
            $data = json_decode($jsonString, true);
            foreach ($data as $regoin) {
                DB::table('regoins')->insert([ 'name' => $regoin['Place_Name'], 'city_id' => 8]);
            }

            // Qena Regoins
            $jsonString = file_get_contents(base_path('resources/regoins/Qena.json'));
            $data = json_decode($jsonString, true);
            foreach ($data as $regoin) {
                DB::table('regoins')->insert([ 'name' => $regoin['Place_Name'], 'city_id' => 9]);
            }

            // Faiyum Regoins
            $jsonString = file_get_contents(base_path('resources/regoins/Faiyum.json'));
            $data = json_decode($jsonString, true);
            foreach ($data as $regoin) {
                DB::table('regoins')->insert([ 'name' => $regoin['Place_Name'], 'city_id' => 10]);
            }
            
            // Dakahlia Regoins
            $jsonString = file_get_contents(base_path('resources/regoins/Dakahlia.json'));
            $data = json_decode($jsonString, true);
            foreach ($data as $regoin) {
                DB::table('regoins')->insert([ 'name' => $regoin['Place_Name'], 'city_id' => 11]);
            }

            // Monufia Regoins
            $jsonString = file_get_contents(base_path('resources/regoins/Monufia.json'));
            $data = json_decode($jsonString, true);
            foreach ($data as $regoin) {
                DB::table('regoins')->insert([ 'name' => $regoin['Place_Name'], 'city_id' => 12]);
            }

            // Asyut Regoins
            $jsonString = file_get_contents(base_path('resources/regoins/Asyut.json'));
            $data = json_decode($jsonString, true);
            foreach ($data as $regoin) {
                DB::table('regoins')->insert([ 'name' => $regoin['Place_Name'], 'city_id' => 13]);
            }

            // Sharqia Regoins
            $jsonString = file_get_contents(base_path('resources/regoins/Sharqia.json'));
            $data = json_decode($jsonString, true);
            foreach ($data as $regoin) {
                DB::table('regoins')->insert([ 'name' => $regoin['Place_Name'], 'city_id' => 14]);
            }

            // Gharbia Regoins
            $jsonString = file_get_contents(base_path('resources/regoins/Gharbia.json'));
            $data = json_decode($jsonString, true);
            foreach ($data as $regoin) {
                DB::table('regoins')->insert([ 'name' => $regoin['Place_Name'], 'city_id' => 15]);
            }

            // Aswan Regoins
            $jsonString = file_get_contents(base_path('resources/regoins/Aswan.json'));
            $data = json_decode($jsonString, true);
            foreach ($data as $regoin) {
                DB::table('regoins')->insert([ 'name' => $regoin['Place_Name'], 'city_id' => 16]);
            }

            // RedSea Regoins
            $jsonString = file_get_contents(base_path('resources/regoins/RedSea.json'));
            $data = json_decode($jsonString, true);
            foreach ($data as $regoin) {
                DB::table('regoins')->insert([ 'name' => $regoin['Place_Name'], 'city_id' => 17]);
            }

            // NewValley Regoins
            $jsonString = file_get_contents(base_path('resources/regoins/NewValley.json'));
            $data = json_decode($jsonString, true);
            foreach ($data as $regoin) {
                DB::table('regoins')->insert([ 'name' => $regoin['Place_Name'], 'city_id' => 18]);
            }

            // Matruh Regoins
            $jsonString = file_get_contents(base_path('resources/regoins/Matruh.json'));
            $data = json_decode($jsonString, true);
            foreach ($data as $regoin) {
                DB::table('regoins')->insert([ 'name' => $regoin['Place_Name'], 'city_id' => 19]);
            }

            // NorthSinai Regoins
            $jsonString = file_get_contents(base_path('resources/regoins/NorthSinai.json'));
            $data = json_decode($jsonString, true);
            foreach ($data as $regoin) {
                DB::table('regoins')->insert([ 'name' => $regoin['Place_Name'], 'city_id' => 20]);
            }

            // Luxor Regoins
            $jsonString = file_get_contents(base_path('resources/regoins/Luxor.json'));
            $data = json_decode($jsonString, true);
            foreach ($data as $regoin) {
                DB::table('regoins')->insert([ 'name' => $regoin['Place_Name'], 'city_id' => 21]);
            }

            // Ismailia Regoins
            $jsonString = file_get_contents(base_path('resources/regoins/Ismailia.json'));
            $data = json_decode($jsonString, true);
            foreach ($data as $regoin) {
                DB::table('regoins')->insert([ 'name' => $regoin['Place_Name'], 'city_id' => 22]);
            }

            // Suez Regoins
            $jsonString = file_get_contents(base_path('resources/regoins/Suez.json'));
            $data = json_decode($jsonString, true);
            foreach ($data as $regoin) {
                DB::table('regoins')->insert([ 'name' => $regoin['Place_Name'], 'city_id' => 23]);
            }

            // Qalyubia Regoins
            $jsonString = file_get_contents(base_path('resources/regoins/Qalyubia.json'));
            $data = json_decode($jsonString, true);
            foreach ($data as $regoin) {
                DB::table('regoins')->insert([ 'name' => $regoin['Place_Name'], 'city_id' => 24]);
            }

            // PortSaid Regoins
            $jsonString = file_get_contents(base_path('resources/regoins/PortSaid.json'));
            $data = json_decode($jsonString, true);
            foreach ($data as $regoin) {
                DB::table('regoins')->insert([ 'name' => $regoin['Place_Name'], 'city_id' => 25]);
            }
            // Damietta Regoins
            $jsonString = file_get_contents(base_path('resources/regoins/Damietta.json'));
            $data = json_decode($jsonString, true);
            foreach ($data as $regoin) {
                DB::table('regoins')->insert([ 'name' => $regoin['Place_Name'], 'city_id' => 26]);
            }

            // mansoura Regoins
            $jsonString = file_get_contents(base_path('resources/regoins/mansoura.json'));
            $data = json_decode($jsonString, true);
            foreach ($data as $regoin) {
                DB::table('regoins')->insert([ 'name' => $regoin['Place_Name'], 'city_id' => 27]);
            }

            // tanta Regoins
            $jsonString = file_get_contents(base_path('resources/regoins/tanta.json'));
            $data = json_decode($jsonString, true);
            foreach ($data as $regoin) {
                DB::table('regoins')->insert([ 'name' => $regoin['Place_Name'], 'city_id' => 28]);
            }

            

           
        
    }
}
