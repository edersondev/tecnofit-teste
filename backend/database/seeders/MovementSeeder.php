<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MovementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arrName = ['Deadlift','Back Squat','Bench Press'];
        foreach($arrName as $name) {
            DB::table('movement')->updateOrInsert([
                'name' => $name
            ]);
        }
    }
}
