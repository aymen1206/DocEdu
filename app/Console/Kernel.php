<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Models\Tabbyconfig;
use Illuminate\Database\Schema\Blueprint;
use App\Http\Controllers\Api\HomeController;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();

        

     $schedule->call(function () {
        
        //get last payment with autrized status 
        $tabby_config= Tabbyconfig::query()->first();
        $Resp = Http::withHeaders([
            'Authorization' => "Bearer ".$tabby_config->secretKeyToken,
            'Content-Type' => 'application/json' 
        ])->get('https://api.tabby.ai/api/v2/payments');
                    
        $response=$Resp->json();
        $count=0;
        $count=count($Resp['payments']);


            for($x = 0; $x <= $count; $x++) {

                        $Payment_id=$response['payments'][$x]['id'];
                        $status=$response['payments'][$x]['status'];
                        $Order_id=$response['payments'][$x]['order']['reference_id'];            
                        $Payment_amount=$response['payments'][$x]['amount'];


                        if ($status=='AUTHORIZED'){

                        $tabby_config= Tabbyconfig::query()->first();

                        $dt = Http::withHeaders([
                        'Authorization' => "Bearer ".$tabby_config->secretKeyToken,
                        'Content-Type' => 'application/json' 
                        ])->post('https://api.tabby.ai/api/v1/payments/'.$Payment_id.'/captures',
                        [
                            "amount"=> $Payment_amount
                        ]
                        );

                        $Captured=$dt->json();

                       if($Captured['status']=='CLOSED'){
                        app(HomeController::class)->tabbyHandleCapturedPayments($Order_id,$Payment_id);
                        }
                        }      

            }                 
        })->everyFiveMinutes();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}