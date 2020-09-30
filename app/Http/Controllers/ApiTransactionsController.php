<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Investments;

class ApiTransactionsController extends Controller
{
    protected static $api_key = '184D4850FAE4CCAAFC85E6C0B2A602E0';
    /**
     * This function makes a deposit to the JPESA account
     */
    public function makeDepositToJpesa($phone_number, $amount, $investments_id){
        $DATA   =   '<?xml version="1.0" encoding="ISO-8859-1"?>
                        <g7bill>
                        <_key_>'.Self::$api_key.'</_key_>
                        <cmd>account</cmd>
                        <action>credit</action>
                        <pp>mm</pp>
                        <mobile>'.$phone_number.'</mobile>
                        <amount>'.$amount .'</amount>
                        <callback>http://url.com/order.php</callback>
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
                    curl_close($ch);
                    $transaction_id = json_decode($return,true)["tid"];
                    $transaction_message = json_decode($return,true)["msg"];
                    $transaction_memo    = json_decode($return,true)["memo"];
                    // print_r($transaction_message);
                    print_r(json_decode($return,true));
                    //call the method to update the transaction status
                    return $this->updateTransactionStatus($investments_id, $transaction_id, $transaction_message, $transaction_memo); 
    }

    /**
     * This function withdraws money to a user account
     */
    public function withdrawMoneyFromJpesa($phone_number, $amount){
        $DATA   =   '<?xml version="1.0" encoding="ISO-8859-1"?>
                        <g7bill>
                        <_key_>'.Self::$api_key.'</_key_>
                        <cmd>account</cmd>
                        <action>debit</action>
                        <pp>mm</pp>
                        <mobile>'.$phone_number.'</mobile>
                        <amount>'.$amount.'</amount>
                        <callback>http://url.com/order.php</callback>
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
                    curl_close($ch);
                    print_r(json_decode($return,true));
    }

    /**
     * This function updates the transaction status and id in the packages table once a transaction is successful
     */
    private function updateTransactionStatus($investments_id, $transaction_id, $transaction_message, $transaction_memo){
        Investments::where('id',$investments_id)->update(array(
            'transaction_id'     => $transaction_id,
            'status_explanation' => $transaction_message,
            'memo'               => $transaction_memo
        ));
    }

    /**
     * This function tracks the transaction status of a particular transaction
     */
    public function getTransactionStatus($transaction_id){
        $DATA   =   '<?xml version="1.0" encoding="ISO-8859-1"?>
                        <g7bill>
                        <_key_>'.Self::$api_key.'</_key_>
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
        curl_close($ch);
        print_r(json_decode($return,true));
    }
}
