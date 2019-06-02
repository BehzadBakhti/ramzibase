
<?php
include('/var/www/clients/client1/web1/web/config.php');
include('/var/www/clients/client1/web1/web/classes/Model.php');
include('/var/www/clients/client1/web1/web/models/deal.php');
include('/var/www/clients/client1/web1/web/classes/Bahamta.php');

        $myModel= new DealModel();
        $myGate = new Bahamta();

 //*******  CRYPTO UPDATE *********
        $nodeJsPath = 'node /var/www/clients/client1/web1/web/classes/BitGoProject/checkTransactions.js 2>&1';
        $myModel->query("SELECT id , user_id, address, currency FROM crypto_address WHERE used=0 AND action_type='deposit' ");
        $newAdrs=$myModel->resultSet();
        $output= exec( $nodeJsPath, $out, $err);
        $irrOut= json_decode($myGate->checkPayments());

            foreach($newAdrs as $row){

               for($j=1; $j<sizeof($out); $j++){

                    if($row['address']==$out[$j]){
                     $amount=$amount/100000000;// change from satushi to Bitcoin or ...
                    updateCryptoDeposits($myModel, $row['id'], $row['user_id'], $row['currency'], $out[$j+1] );

                    }
                }

                for($k=1;$k<sizeof($irrOut->bills); $k++){

                    if( $row['address']== $irrOut->bills[$k]->note){
                    updateCryptoDeposits($myModel, $row['id'], $row['user_id'], $row['currency'], $irrOut->bills[$k]->amount);

                    }
                }

            }

function updateCryptoDeposits($myModel, $adrsId, $userId, $currency, $amount){
    $myModel->query("UPDATE crypto_address SET  used=1 WHERE id=$adrsId");
    $myModel-> executeQuery();
    //******
   
    $myModel->manageUserBalance($userId, $currency, $amount);
    $myModel->query("INSERT INTO balance_change  (`user_id`, `amount`, `currency`,`ticket_status`,`action_type` ,`crypto_adrs_id`, `action_date`) VALUES ($userId, $amount, '$currency', 'done','deposit', $adrsId, CURRENT_TIMESTAMP ) ");

    return  $myModel-> executeQuery()";

}
