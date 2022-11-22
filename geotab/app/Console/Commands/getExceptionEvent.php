<?php

namespace App\Console\Commands;

use DateTime;
use Exception;
use Illuminate\Console\Command;
use Geotab;
use Carbon\Carbon;

class getExceptionEvent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ExceptionEvent';

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

        $api = new Geotab\API( $db_username, $db_password, $db_database, $db_federation);
        $api->authenticate();

        $toDate = new DateTime();
        $fromDate = new DateTime();
        $fromDate->modify("-1 month");

        try {
            $violations = $api->get("DutyStatusViolation", [
                "search" => [
                    "userSearch" => ["id" => "b1"],
                    "toDate" => $toDate->format("c"),   // ISO8601, or could use "2018-11-03 00:53:29.370134"
                    "fromDate" => $fromDate->format("c")
                ],
                "resultsLimit" => 10
            ]);
        } catch (Exception $e) {
            // Handle this or return
        }

        echo "The driver has " . count($violations) . " violations!";
        return Command::SUCCESS;
    }
}
