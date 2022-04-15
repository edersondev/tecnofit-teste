<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arrName = ['Joao','Jose','Paulo'];
        foreach($arrName as $name) {
            DB::table('user')->updateOrInsert([
                'name' => $name
            ]);
        }
    }
}
