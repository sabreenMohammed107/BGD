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
               'dt_status'=>'Completed',

            ],
            [
               'en_status'=>'Cancelled by Doc ',
               'dt_status'=>'Cancelled by Doc ',

            ],
            [
                'en_status'=>'Cancelled by Patient',
                'dt_status'=>'Cancelled by Patient',
 
             ],
             [
                'en_status'=>'Confirmed by Doc ',
                'dt_status'=>'Confirmed by Doc ',
 
             ]

        ];

        foreach ($statuses as $key => $status) {
            Reservation_status::create($status);
        }
    }
}
