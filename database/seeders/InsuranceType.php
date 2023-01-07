<?php

namespace Database\Seeders;

use App\Models\Insurance_type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InsuranceType extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            [
               'en_type'=>'public',
               'dt_type'=>'öffentlich',

            ],
            [
               'en_type'=>'private',
               'dt_type'=>'privat',

            ],

        ];

        foreach ($statuses as $key => $status) {
            Insurance_type::create($status);
        }
    }
}
