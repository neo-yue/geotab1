<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Geotab;

class getTrip extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'getTrip';

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

        $api = new Geotab\API($db_username, $db_password, $db_database, $db_federation);
        $api->authenticate();


        $parameters = [
            "typeName" => "Trip",
            "resultsLimit" => 5,
            //"fromVersion" => "0000000000000000",
            "fromVersion"=>"00000000003f6888",
            "search" => [
                "toDate" => Carbon::now()->toIso8601ZuluString(),
                "fromDate" => Carbon::now()->subWeek()->toIso8601ZuluString(), //Last week
            ],
        ];
        $data = [];
//        $trips = $api->call("GetFeed", $parameters);
//
//
//
//        foreach ($trips['data'] as $trip) {
//            if (is_array($trip["driver"])) {
//                if (array_key_exists("id", $trip["driver"])) {
//                    $driverId = $trip["driver"]["id"];
//
//                }
//            } else {
//                $driverId = "No Driver";
//            }
//
//
//            $data[] = [$trip["id"], $trip["device"]["id"], $driverId];
//        }
//            $this->table(['Id', 'Device Id', 'Driver Id'], $data);

        $api->call("GetFeed", $parameters, function ($trips) {

            $toVersion = $trips['toVersion'];
            foreach ($trips['data'] as $trip) {
            if (is_array($trip["driver"])) {

                if (array_key_exists("id", $trip["driver"])) {
                    $driverId = $trip["driver"]["id"];

                }
            } else {
                $driverId = "No Driver";
            }


            $data[] = [$trip["id"], $trip["device"]["id"], $driverId];


            }
            $this->table(['Id', 'Device Id', 'Driver Id'], $data);
            print_r($toVersion);

        }, function ($error) {
            var_dump($error);
        });




        return Command::SUCCESS;
        }



}
