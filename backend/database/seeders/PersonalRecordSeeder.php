<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PersonalRecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arrData = [
            ['user_id' => 1,'movement_id' => 1,'value' => 100.0,'date' => '2021-01-01 00:00:00.0'],
            ['user_id' => 1,'movement_id' => 1,'value' => 180.0,'date' => '2021-01-02 00:00:00.0'],
            ['user_id' => 1,'movement_id' => 1,'value' => 150.0,'date' => '2021-01-03 00:00:00.0'],
            ['user_id' => 1,'movement_id' => 1,'value' => 110.0,'date' => '2021-01-04 00:00:00.0'],
            ['user_id' => 2,'movement_id' => 1,'value' => 110.0,'date' => '2021-01-04 00:00:00.0'],
            ['user_id' => 2,'movement_id' => 1,'value' => 140.0,'date' => '2021-01-05 00:00:00.0'],
            ['user_id' => 2,'movement_id' => 1,'value' => 190.0,'date' => '2021-01-06 00:00:00.0'],
            ['user_id' => 3,'movement_id' => 1,'value' => 170.0,'date' => '2021-01-01 00:00:00.0'],
            ['user_id' => 3,'movement_id' => 1,'value' => 120.0,'date' => '2021-01-02 00:00:00.0'],
            ['user_id' => 3,'movement_id' => 1,'value' => 130.0,'date' => '2021-01-03 00:00:00.0'],
            ['user_id' => 1,'movement_id' => 2,'value' => 130.0,'date' => '2021-01-03 00:00:00.0'],
            ['user_id' => 2,'movement_id' => 2,'value' => 130.0,'date' => '2021-01-03 00:00:00.0'],
            ['user_id' => 3,'movement_id' => 2,'value' => 125.0,'date' => '2021-01-03 00:00:00.0'],
            ['user_id' => 1,'movement_id' => 2,'value' => 110.0,'date' => '2021-01-05 00:00:00.0'],
            ['user_id' => 1,'movement_id' => 2,'value' => 100.0,'date' => '2021-01-01 00:00:00.0'],
            ['user_id' => 2,'movement_id' => 2,'value' => 120.0,'date' => '2021-01-01 00:00:00.0'],
            ['user_id' => 3,'movement_id' => 2,'value' => 120.0,'date' => '2021-01-01 00:00:00.0']
        ];

        foreach($arrData as $data) {
            DB::table('personal_record')->updateOrInsert(
                ['user_id' => $data['user_id'],'movement_id' => $data['movement_id'],'value' => $data['value']]
            , ['date' => $data['date']]);
        }

    }
}
