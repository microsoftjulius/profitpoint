<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Withdraws;
use Log;

class convertMoneyToDollars extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:todollar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'A test cron for updating money from shillings to usd';

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
     * @return int
     */
    public function handle()
    {
        /**
         * This function converts the user earnings to dollars
         */
        //get all the earnings
        // $all_user_withdraws = Withdraws::get();
        // //loop through the earnings
        // foreach($all_user_withdraws as $user_withdraws){
        //     Withdraws::where('id',$user_withdraws->id)->update(array(
        //         'amount' => ($user_withdraws->amount / 3700)
        //     ));
        // }

        // Log::info("The update was successful");
        return 0;
    }
}
