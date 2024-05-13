<?php

require_once "./account.php";
require_once "./checking.php";


class SavingsAccount extends Account 
{

	public function withdrawal($amount) 
	{
		if(parent::getBalance() >= $amount)
            {
                parent::setBalance((parent::getBalance() - $amount));
            }
	} //end withdrawal

	public function getAccountDetails() 
	{
		$accountDetails = "<h2>Savings Account</h2>";
        $accountDetails .= parent::getAccountDetails();
        return $accountDetails;
	} //end getAccountDetails
	
} // end Savings

// The code below runs everytime this class loads and 
// should be commented out after testing.

    // $savings = new SavingsAccount('S123', 5000, '03-20-2020');
    
    // echo $savings->getAccountDetails();
    
?>
