<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Earnings;
use App\Investments;
use Carbon\Carbon;

class DailyEarnings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bonus:daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command runs daily to generate 2% to every person of what they invested';

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
        //get all the investments that have been made by all users
        $all_investements = Investments::join('users','users.id','investments.created_by')
        ->where('users.status','active')
        ->where('investments.created_at', '>', Carbon::now()->subDays(100))
        ->select('investments.created_by','investments.amount')
        ->get();
        $this->info($all_investements);
        //foreach investment as user investments, make a bonus of 2% from it
        foreach($all_investements as $user_investement){
            $earning = (0.02) * $user_investement->amount;
            $new_earnings = new Earnings;
            $new_earnings->amount = $earning;
            $new_earnings->referral_id = null;
            $new_earnings->sponsor_id = $user_investement->created_by;
            $new_earnings->save();
        }
        $this->info('You Sucessfully generated an Earning of 2% to every one');
    }
}
