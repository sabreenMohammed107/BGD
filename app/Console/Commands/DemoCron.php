<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Operation;
use App\User;
use Carbon\Carbon;
use Notification;
use App\Notifications\OperationNotification;
use DateTime;
use Illuminate\Support\Facades\Date;
class DemoCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // \Log::info("Cron is working fine!");
        // $operations = Operation::all();
        // $user = User::where('role_id', '=', 1)->first();
        // $datetime = new DateTime('tomorrow');

        // foreach ($operations as $operation) {

        //     $xx=new DateTime($operation->loadind_date);
        //      if (date_format(date_create($operation->loadind_date),'Y-m-d')==$datetime->format('Y-m-d')) {

        //         $user->notify(new OperationNotification($operation));

        //      }
        //      dd(date_format(date_create($operation->loadind_date),'Y-m-d'));

        // }
        // $this->info('Demo:Cron Cummand Run successfully!');
    }
}
