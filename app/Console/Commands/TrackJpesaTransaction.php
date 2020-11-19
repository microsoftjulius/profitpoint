<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Log;
use App\Investments;

class TrackJpesaTransaction extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'track:status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command is used to track the transaction status of a specific transaction made by a user';

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
        //get all the transaction ids where status is innitiated 
        $all_initiated_transaction = DB::table('investments')->where('status','initiated')->get();
        foreach($all_initiated_transaction as $transaction_id){
            $this->checkTransactionStatus($transaction_id->transaction_id);
        }
    }

    private function checkTransactionStatus($transaction_id){
        $DATA   =   '<?xml version="1.0" encoding="ISO-8859-1"?>
                        <g7bill>
                        <_key_>184D4850FAE4CCAAFC85E6C0B2A602E0</_key_>
                        <cmd>account</cmd>
                        <action>info</action>
                        <tid>'.$transaction_id.'</tid>
                    </g7bill>';
        $ch 	= 	curl_init();		
        curl_setopt($ch, CURLOPT_URL,"https://my.jpesa.com/api/");
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$DATA);
        curl_setopt($ch, CURLOPT_HTTPHEADER,array("Content-Type: text/xml")); 
        curl_setopt($ch, CURLOPT_HEADER,false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,0);
        curl_setopt($ch, CURLOPT_TIMEOUT,400);
        $return 	= 	curl_exec($ch);
        Log::info("Cron Job Works");		
        curl_close($ch);
        $api_status = json_decode($return,true)['api_status'];
        if($api_status == 'error'){
            $status = 'failed';
            return $this->updateTransactionStatus($status, $transaction_id);
        }elseif($api_status == "success"){
            $status = json_decode($return,true)['status'];
            if($status == 'closed'){
                $status = 'successful';
                return $this->updateTransactionStatus($status, $transaction_id);
            }
        }else{
            $status = 'failed';
            return $this->updateTransactionStatus($status, $transaction_id);
        }
    }

    /**
     * This function updates the transaction status
     */
    private function updateTransactionStatus($status, $transaction_id){
        Investments::where('transaction_id',$transaction_id)->update(array(
            'status' => $status
        ));
    }
}
