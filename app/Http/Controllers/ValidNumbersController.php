<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Str;

class ValidNumbersController extends Controller
{
    static protected $valid_contacts = ['25677','25678','25670','25679','25671','25675','25675','25620','25639','25641',
                                        '25477','25478','25470','25479','25471','25475','25475','25420','25439','25441','25479'];
    static protected $to_append_valid_contacts = ['077','078','070','079','071','075','075','020','039','041'];
    /**
     * Check if the number has 13 figures. if so, 
     * check if it has +256 as the first figures
     * check if the other numbers are in the array of valid numbers
     * if so, save it
     * else, tell the user the required numbers must have 256 as the starting number
     * 
     * if the figures are not 13, check if they are 10
     * if so, check if the first figure is 0,
     * if so, remove it ans substitute it with +256
     * else, tell the user the number is invalid(save in an invalid array and return it to the user)
     * allowed numbers are in the format(MTN, Airtel, Africel, K2Telecom, Lyca Mobile)
     * valid numbers are ['25677','25678','25670','25679','25671','25675','25675','25620','25639','25641'];
     */

    private function checkIfNumberHasThirteenFigures(){
        $contact_number = request()->phone_number;
        if(strlen($contact_number) == 13){
            if($contact_number[0] == 0){
                return response()->json("Invalid contact, Please enter a valid contact to continue");
            }
            //checking if the number contains alphabetical letters
            if(!ctype_digit($contact_number)){
                return response()->json("The number you entered is wrong, Valid numbers don't contain Alphabetical Letters and special characters");
            }
            if(Str::substr($contact_number, 0, 4) == '+256' || Str::substr($contact_number, 0, 4) == '+254'){
                if(in_array(Str::substr($contact_number, 1, 5), self::$valid_contacts)){
                    return $contact_number;
                }else{
                    return response()->json("The supplied contact is not valid, valid contacts start with these digits 25677, 25678, 25670, 25679, 25671, 25675, 25675, 25620, 25639, 25641,
                    25477, 25478, 25470, 25479, 25471, 25475, 25475, 25420, 25439, 25441, 25479");
                }
            }else{
                return response()->json("The contact number you entered is not valid, the number must start with +256");
            }
        }elseif(strlen($contact_number) == 12){
            if($contact_number[0] == 0){
                return response()->json("Invalid contact, Please enter a valid contact to continue");
            }
            //checking if the number contains alphabetical letters
            if(!ctype_digit($contact_number)){
                return response()->json("The number you entered is wrong, Valid numbers don't contain Alphabetical Letters and special characters");
            }
            if(in_array(Str::substr($contact_number, 0, 5), self::$valid_contacts)){
                return "+".$contact_number;
            }else{
                return response()->json("The supplied contact is not valid");
            }
        }else{
            return $this->checkIfNumberHasTenFigures();
        }
    }

    /**
     * check if the number has 10 figures, 
     * check is the first three digits are in the valid contacts array with the first 3 digits being the 0 and the last two
     * per number in the array
     * if so, substitute 0 with +256
     * then return the number
     * else tell the client the number is invalid
     */
    private function checkIfNumberHasTenFigures(){
        $contact_number = request()->phone_number;
        //checking if the number contains alphabetical letters
        if(!ctype_digit($contact_number)){
            return response()->json("The number you entered is wrong, Valid numbers don't contain Alphabetical Letters and special characters");
        }
        if(strlen($contact_number) == 10){
            if(in_array(Str::substr($contact_number, 0, 3), self::$to_append_valid_contacts)){
                return "+256".Str::substr($contact_number, 1, 9);
            }else{
                return response()->json("The supplied contact is not valid, 
                    valid contacts start with these digits 077, 078, 070, 079, 071, 075, 075, 020, 039, 041 or 25677, 25678, 25670, 25679, 25671, 25675, 25675, 25620, 25639, 25641,
                    25477, 25478, 25470, 25479, 25471, 25475, 25475, 25420, 25439, 25441, 25479. if you aint in uganda, consider adding the country code to your number");
            }
        }else{
            return response()->json("The supplied number is not valid, Kindly check the length of the number to verify");
        }
    }
    /**
     * This function returns the validated number
     */
    public function getValidatedNumber(){
        return $this->checkIfNumberHasThirteenFigures();
    }
}
