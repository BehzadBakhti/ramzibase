
<?php
include('/var/www/clients/client1/web1/web/config.php');
include('/var/www/clients/client1/web1/web/classes/Model.php');
include('/var/www/clients/client1/web1/web/models/deal.php');
include('/var/www/clients/client1/web1/web/classes/Bahamta.php');

        $myModel= new DealModel();
        $myGate = new Bahamta();
$cryptoCoins=['BTC'/*,'ETH','BCH','LTC'*/];
 //*******  CRYPTO UPDATE *********
$out=[];
foreach($cryptoCoins as $currency){
	$curr=MODE.strtolower($currency);

        $nodeJsPath = 'node /var/www/clients/client1/web1/web/classes/BitGoProject/checkTransactions.js '.CRYPTO_TOKEN.' '.WALLET_ID[$currency].' '.$curr.' 2>&1';
	$output= exec( $nodeJsPath, $out_i, $err);
$out= array_merge($out , $out_i);
}
        $myModel->query("SELECT id , user_id, address, currency FROM crypto_address WHERE used=0 AND action_type='deposit' ");
        $newAdrs=$myModel->resultSet();
	$myModel->query("SELECT * FROM config_data ");
	$configData= $myModel->singleResult();
	$lastCheck=$configData['last_fund_check'];
//$lastCheck='2015-05-27T03:53:01.123Z';
       
        $irrOut= json_decode($myGate->checkPayments($lastCheck),true);
//print_r($configData);
            foreach($newAdrs as $row){

               for($j=1; $j<sizeof($out); $j++){

                    if($row['address']==$out[$j]){
                     $amount=$out[$j+1]/100000000;// change from satushi to Bitcoin or ...
                    updateCryptoDeposits($myModel, $row['id'], $row['user_id'], $row['currency'], $amount );

                    }
                }
	if(!empty($irrOut)){
                for($k=0;$k<sizeof($irrOut['bills']); $k++){

                    if( $row['address']== $irrOut['bills'][$k]['note'] AND $irrOut['bills'][$k]['payed']!="" ){
                    updateCryptoDeposits($myModel, $row['id'], $row['user_id'], $row['currency'], $irrOut['bills'][$k]['amount']);

                    }
                }
	     }
	  }

if($irrOut['until']!=""){
	$myModel->query("UPDATE config_data SET `last_fund_check`= '".$irrOut['until']."' WHERE id=1");
        $configData2= $myModel->executeQuery();
}
//print_r($out);
function updateCryptoDeposits($myModel, $adrsId, $userId, $currency, $amount){
    $myModel->query("UPDATE crypto_address SET  used=1 WHERE id=$adrsId");
    $myModel-> executeQuery();
    //******
   
    $myModel->manageUserBalance($userId, $currency, $amount);
    $myModel->query("INSERT INTO balance_change  (`user_id`, `amount`, `currency`,`ticket_status`,`action_type` ,`crypto_adrs_id`, `action_date`) VALUES ($userId, $amount, '$currency', 'done','deposit', $adrsId, CURRENT_TIMESTAMP ) ");

    return  $myModel-> executeQuery();

}

