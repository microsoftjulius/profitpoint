<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Investments;
use CoinbaseCommerce\ApiClient;
use CoinbaseCommerce\Resources\Checkout;
use CoinbaseCommerce\Resources\Charge;

class ApiTransactionsController extends Controller
{
    protected static $api_key       = '184D4850FAE4CCAAFC85E6C0B2A602E0';
    protected static $coin_base_key = '8feKjg8qn2sR6dSY';
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
    /*
    |Checkouts
    */
    /**
     * This function does the bitcoin transactions
     */
    public function makeRetrieveBitCoinTransaction(){
        //Make sure you don't store your API Key in your source code!
        ApiClient::init(Self::$coin_base_key);
        $apiClientObj->setTimeout(3);
        $apiClientObj->verifySsl(false);
        
        $checkoutObj = new Checkout([
            "description" => "Mastering the Transition to the Information Age",
            "local_price" => [
                "amount" => "1.00",
                "currency" => "USD"
            ],
            "name" => "test item 15 edited",
            "pricing_type" => "fixed_price",
            "requested_info" => ["email"]
        ]);
        
        try {
            $checkoutObj->save();
            echo sprintf("Successfully created new checkout with id: %s \n", $checkoutObj->id);
        } catch (\Exception $exception) {
            echo sprintf("Enable to create checkout. Error: %s \n", $exception->getMessage());
        }
        
        if ($checkoutObj->id) {
        
            $checkoutObj->name = "New name";
        
            // Update "name"
            try {
                $checkoutObj->save();
                echo sprintf("Successfully updated name of checkout via save method\n");
            } catch (\Exception $exception) {
                echo sprintf("Enable to update name of checkout. Error: %s \n", $exception->getMessage());
            }
        
            // Update "name" by "id"
            try {
                Checkout::updateById(
                    $checkoutObj->id,
                    [
                        "name" => "Another Name"
                    ]
                );
                echo sprintf("Successfully updated name of checkout by id\n");
            } catch (\Exception $exception) {
                echo sprintf("Enable to update name of checkout by id. Error: %s \n", $exception->getMessage());
            }
        
        
            $checkoutObj->description = "New description";
        
            // Refresh attributes to previous values
            try {
                $checkoutObj->refresh();
                echo sprintf("Successfully refreshed checkout\n");
            } catch (\Exception $exception) {
                echo sprintf("Enable to refresh checkout. Error: %s \n", $exception->getMessage());
            }
        
            // Retrieve checkout by "id"
            try {
                $retrievedCheckout = Checkout::retrieve($checkoutObj->id);
                echo sprintf("Successfully retrieved checkout\n");
                echo $retrievedCheckout;
            } catch (\Exception $exception) {
                echo sprintf("Enable to retrieve checkout. Error: %s \n", $exception->getMessage());
            }
        }
        
        try {
            $list = Checkout::getList(["limit" => 5]);
            echo sprintf("Successfully got list of checkouts\n");
        
            if (count($list)) {
                echo sprintf("Checkouts in list:\n");
        
                foreach ($list as $checkout) {
                    echo $checkout;
                }
            }
        
            echo sprintf("List's pagination:\n");
            print_r($list->getPagination());
        
            echo sprintf("Number of all checkouts - %s \n", $list->countAll());
        } catch (\Exception $exception) {
            echo sprintf("Enable to get list of checkouts. Error: %s \n", $exception->getMessage());
        }
        
        if (isset($list) && $list->hasNext()) {
            // Load next page with previous settings (limit=5)
            try {
                $list->loadNext();
                echo sprintf("Next page of checkouts: \n");
                foreach ($list as $checkout) {
                    echo $checkout;
                }
            } catch (\Exception $exception) {
                echo sprintf("Enable to get new page of checkouts. Error: %s \n", $exception->getMessage());
            }
        }
        
        try {
            $allCharge = Checkout::getAll();
            echo sprintf("Successfully got all checkouts:\n");
            foreach ($allCharge as $charge) {
                echo $charge;
            }
        } catch (\Exception $exception) {
            echo sprintf("Enable to get all checkouts. Error: %s \n", $exception->getMessage());
        }
    }

    /**
     * This function creates a BitCoin Transaction
     */
    public function createBTCTransactions(){
        $newCheckoutObj = new Checkout();
        
        $newCheckoutObj->name = 'The Sovereign Individual';
        $newCheckoutObj->description = 'Mastering the Transition to the Information Age';
        $newCheckoutObj->pricing_type = 'fixed_price';
        $newCheckoutObj->local_price = [
            'amount' => '100.00',
            'currency' => 'USD'
        ];
        $newCheckoutObj->requested_info = ['name', 'email'];
        
        $newCheckoutObj->save();
    }

    /**
     * This function updates the Bitcoint Transaction
     */
    public function updateBTCTransaction($checkout_id){
        $checkoutObj = new Checkout();
        $checkoutObj->id = $checkout_id;
        $checkoutObj->name = 'new name';
        $checkoutObj->save();
    }

    /**
     * This function deletesthe coinBaseTransaction
     */
    public function deleteCoinBaseTransaction($checkout_id){
        Checkout::deleteById($checkout_id);
    }

    /**
     * This function returns the Api Resource List
     */
    public function getApiResourceList(){
        $params = [
            'limit' => 2,
            'order' => 'desc'
        ];
        
        $list = Checkout::getList($params);
        
        foreach($list as $checkout) {
            var_dump($checkout);
        }
        
        // Get number of items in list
        $count = $list->count();
        
        // or
        $count = count($list);
        
        // Get number of all checkouts
        $countAll = $list->countAll();
        
        // Get pagination
        $pagination = $list->getPagination();
        
        // To load next page with previous setted params(in this case limit, order)
        if ($list->hasNext()) {
            $list->loadNext();
            
            foreach($list as $checkout) {
                var_dump($checkout);
            }
        }
    }

    /**
     * This function gets all the checkouts
     */
    public function getAllCheckouts(){
        $params = [
            'order' => 'desc'  
        ];
        $allCheckouts = Checkout::getAll($params);
    }

    /*
    | Charges
    | This section is for charges
    | this function is for retrieving a charge
    */
    public function retrieveCharge($charge_id){
        $chargeObj = Charge::retrieve($charge_id);
        return $chargeObj;
    }

    /**
     * this function creates a transaction charge
     */
    public function createCoinBaseCharge(){
        $chargeObj = new Charge();
        $chargeObj->name = 'The Sovereign Individual';
        $chargeObj->description = 'Mastering the Transition to the Information Age';
        $chargeObj->local_price = [
            'amount' => '100.00',
            'currency' => 'USD'
        ];
        $chargeObj->pricing_type = 'fixed_price';
        $chargeObj->save();
    }

    /**
     * This function gets all the charges
     */
    public function getAllCharges(){
        $allCharges = Charge::getAll();
        return $allCharges;
    }

    /**
     * This function resolves a charge that has been marked as not resolved
     */
    public function resolveCharge($charge_id){
        $chargeObj = Charge::retrieve($charge_id);
        if ($chargeObj) {
            $chargeObj->resolve();
        }
    }

    /**
     * This function cancels a charge that has been previosly created
     */
    public function cancelCharge($charge_id){
        $chargeObj = Charge::retrieve($charge_id);

        if ($chargeObj) {
            $chargeObj->confirm();
        }
    }
}
