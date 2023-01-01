<?php

namespace Database\Seeders;

use App\Models\Reservation_status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReservationStatus extends Seeder
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
               'en_status'=>'Pending',
               'dt_status'=>'Pending',

            ],
            [
               'en_status'=>'Completed',
               'dt_status'=>'Pending',

            ],
            [
               'en_status'=>'Cancelled',
               'dt_status'=>'Pending',

            ],


        ];

        foreach ($statuses as $key => $status) {
            Reservation_status::create($status);
        }
    }
}
