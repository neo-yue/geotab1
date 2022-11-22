<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Geotab\Api;
use Illuminate\Console\Command;
use Geotab;

class sendToGeotap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sendToGeotab';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
         $db_username = "eric@fleetnova.com";
         $db_password = "4xk9wxqt2";
         $db_database = "pp_training";
         $db_federation = "mypreview1.geotab.com";
         $my_id = "b20C856C2";

        $api = new Geotab\API( $db_username, $db_password, $db_database, $db_federation);
        $api->authenticate();
        // show  all devices
        $devices = $api->call("Get", [
            "typeName" => "Device",
            "resultsLimit" => 10,
        ]);


//        print_r($devices);

        $header = ['Id','Name','Type'];
        $data = [];

        foreach ($devices as $device) {
        $data[] = [$device["id"], $device["name"], $device["deviceType"]];
        }

            $this->table( $header, $data );


        return Command::SUCCESS;
    }
}
