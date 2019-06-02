<?php

class Admin extends Controller
{
	protected function Index(){

					$viewmodel=new AdminModel();
					$this -> returnView($viewmodel->Index(), true);
				
	} 

protected function Access_denied(){
					$viewmodel=new AdminModel();	
					$this -> returnView($viewmodel->Index(), true);
	}

protected function announcement(){

	$viewmodel=new AdminModel();	
	$this -> returnView($viewmodel->Index(), false);
}

protected function manageUsers(){

	$viewmodel=new AdminModel();	
	$this -> returnView($viewmodel->Index(), false);
}

protected function userMessages(){

	$viewmodel=new AdminModel();	
	$this -> returnView($viewmodel->Index(), false);
}
protected function tickesCrypto(){

	$viewmodel=new AdminModel();	
	$this -> returnView($viewmodel->Index(), false);
}

protected function tickesIRR(){

	$viewmodel=new AdminModel();	
	$this -> returnView($viewmodel->Index(), false);
}

protected function posts(){

	$viewmodel=new AdminModel();	
	$this -> returnView($viewmodel->Index(), false);
}

protected function highLevelOps(){

	$viewmodel=new AdminModel();	
	$this -> returnView($viewmodel->Index(), false);
}

protected function judgeUser(){
	$viewmodel=new AdminModel();	
	$userEmail=$_POST['userEmail'];
	$decision=$_POST['decision'];
	$reason=$_POST['reason'];
if($decision=='confirmed'){
$subject='تایید حساب کاربری';
$txt='حساب کاربری شما با موفقیت تایید گردید، حالا میتوانید کار را شروع کنید. موفق باشید';

}else if($decision=='notConfirm'){
$subject='عدم تایید حساب کاربری';
$txt= "متاسفانه حساب کاربری شما تایید نشده است، علیت این موضوع در زیر آمده است: <br>".$reason;
}else{
	//blocked
	$subject="مسدود شدن حساب کاربری";
	$txt= "متاسفانه حساب کاربری شما مسدود گردید است، علیت این موضوع در زیر آمده است: <br>".$reason;

}
$this-> SendEmailUser($userEmail, $txt, $subject);
	$output=$viewmodel->judgeUser($userEmail, $decision);
	echo $subject." انجام شد";
}




protected function checkUserData(){
	$viewmodel=new AdminModel();	
	$this -> returnView($viewmodel->Index(), false);
	$_SESSION['userEmailToCheck']=$_POST['userEmailToCheck'];
}

protected function checkSingleMsg(){
	$viewmodel=new AdminModel();	
	$this -> returnView($viewmodel->Index(), false);
	$_SESSION['MsgNumber']=$_POST['MsgNumber'];
}

protected function loadMsgData(){

	$viewmodel=new AdminModel();	
	
	$MsgNumber=$_SESSION['MsgNumber'];
	$result=$viewmodel-> loadMsgData($MsgNumber);
	//print_r($result);
	echo json_encode($result);
}
protected function responseUserMsg()
{
	$MsgId=$_POST['MsgId'];
	$senderEmail=$_POST['senderEmail'];
	$responseMsg=$_POST['ResponseBody'];
	$subject="پاسخ رمزی بیس به پیام شما";
	$this-> SendEmailUser($senderEmail,$responseMsg,$subject);
	$viewmodel=new AdminModel();	
	
	$result=$viewmodel-> responseUserMsg($MsgId, $responseMsg);
	echo $result;

}

protected function loadUserDataForAdmin(){

	$viewmodel=new AdminModel();	
	
	$userEmailToCheck=$_SESSION['userEmailToCheck'];
	$result=$viewmodel-> loadUserDataForAdmin($userEmailToCheck);
	//print_r($result);
	echo json_encode($result);
}

protected function UserMsgTable(){
			$viewmodel=new AdminModel();	
			if($_SESSION['user_level']!='ordinary'){
				
				$group=$_POST['msgCondition'];
				$record_per_page=$_POST['numToShow'];
				 echo $viewmodel-> UserMsgTable($group,$record_per_page);

			}

	}

protected function AdminUsersTable(){
			$viewmodel=new AdminModel();	
			if($_SESSION['user_level']!='ordinary'){
				
				$group=$_POST['userCondition'];
				$record_per_page=$_POST['numToShow'];
				 echo $viewmodel-> adminUsersTable($group,$record_per_page);

			}

	}

protected function AdminTicketsIRR(){

			$viewmodel=new AdminModel();	
			if($_SESSION['user_level']!='ordinary'){
				
				$group=$_POST['ticketCondition'];
				$tType=$_POST['tType'];
				$record_per_page=$_POST['numToShow'];
				 echo $viewmodel-> adminTicketsIRR($group,$tType,$record_per_page);

			}
}

/*protected function confirmManualDepositIRR(){
	$myAdminModel=new AdminModel();
	$myDealModel=new DealModel();
	$ticketsArray=explode(',',$_POST['ticketsArray']);
	foreach ($ticketsArray as $rowId) {
		$ticketId=explode("_", $rowId)[1];
		$ticketData=$myAdminModel->confirmManualDepositIRR($ticketId);
		print_r($ticketData);
		$myDealModel-> manageUserBalance($ticketData['user_id'], 'IRR' , $ticketData['amount']);
	}

}*/


protected function underOperationTicketIRR(){
	$myAdminModel=new AdminModel();
	$ticketsArray=explode(',',$_POST['ticketsArray']);
	foreach ($ticketsArray as $rowId) {
		$ticketId=explode("_", $rowId)[1];
		print_r($ticketData);
		$ticketData=$myAdminModel->underOperationTicketIRR($ticketId);
	
		
	}

}
protected function ticketDoneIRR(){
	$myAdminModel=new AdminModel();
	$ticketsArray=explode(',',$_POST['ticketsArray']);
	foreach ($ticketsArray as $rowId) {
		$ticketId=explode("_", $rowId)[1];
		print_r($ticketData);
		$ticketData=$myAdminModel->ticketDoneIRR($ticketId);
	
		
	}

}


protected function AdminTicketsCrypto(){
	$viewmodel=new AdminModel();	
			if($_SESSION['user_level']!='ordinary'){
				
				$group=$_POST['ticketCondition'];
				$tType=$_POST['tType'];
				$record_per_page=$_POST['numToShow'];
				 echo( $viewmodel-> adminTicketsCrypto($group,$tType,$record_per_page));

		}
}

protected function sendCoinsToUser(){

	$viewmodel=new AdminModel();
	$ticketsArray=explode(',',$_POST['ticketsArray']);

	$currency=$_POST['currency'];
	$passPhrase=$_POST['passPhrase'];
	$addressAmount=$viewmodel -> addressAmountToSendCoin($ticketsArray);

	$curr=MODE.strtolower($currency);
	$nodeJsPath =   'node classes/BitGoProject/sendCoin.js '.$addressAmount.' '.$passPhrase .' '.CRYPTO_TOKEN.' '.WALLET_ID[$currency].' '.$curr.' 2>&1';
	//echo 'cd '. dirname($nodeJsPath). ' \funds && node sendCoin.js 2>&1", $out, $err';
	$output= exec( $nodeJsPath, $out, $err);


	$needle='txid:';
	$ret = array_keys(array_filter($out, function($var) use ($needle){
    return strpos($var, $needle) !== false;
	}));
			if(sizeof($ret)>0){
				$viewmodel-> TransactionSuccessful($ticketsArray);

				echo "انتقال با موفقیت انجام شد";
				
			}else{
				echo "انتقال با مشکل مواجه گردید";
				
			}
	 
	 
}

//************High Level Operations	

protected function freezCoin(){
	$myAdminModel=new AdminModel();
	$arr=$_POST;
	
	echo $myAdminModel-> freezCoin($arr);

}

protected function getFreezed(){
	$myDealModel=new DealModel();
	echo json_encode($myDealModel-> getFreezed());

}

protected function mmFunding(){

	$currArr=['IRR','BTC','ETH','BCH','LTC'];

	$myDealModel= new DealModel();
	$myResModel= new ReserveModel();
	$userId='10'.$_POST['mm']; // '10'.'0' = 100
	$currency=$currArr[$_POST['currency']];
	$amount=$_POST['amount'];

	if($_POST['fundType']=='add'){

		$row= $myResModel->reserve();
		
		if($row[0][$currency] < $amount){
		
				echo "موجودی کافی نیست";
				return;
			}
			$addAmount=$amount;
	
	
	}else{
		
		$row=$myDealModel-> userBalance($currency,$userId);

		if($row['amount'] < $amount){
	
			echo "موجودی کافی نیستش";
			return;
		}

		$addAmount=-1*$amount;	
	}
$outt=	$myDealModel-> manageUserBalance($userId, $currency, $addAmount);
print_r($outt);
	echo $myResModel-> changeReserve((-1)*$addAmount, $currency, 'market_maker');
	}



protected function mmLoadeFund(){

	$myResModel= new ReserveModel();
	$mmfunds=$myResModel->mmLoadeFund();

	for ($i=100; $i <102 ; $i++) { 
	$output[$i]['IRR']=0;
	$output[$i]['BTC']=0;
	$output[$i]['BCH']=0;
	$output[$i]['ETH']=0;
	$output[$i]['LTC']=0;
	
	}

	foreach ($mmfunds as $row) {
		
				$output[$row['user_id']][$row['currency']]=$row['amount'];
		}
	
	echo json_encode($output);

}

protected function netReserve(){
	$myResModel= new ReserveModel();
	$myReserve=$myResModel->reserve();
	$mmBalance=$myResModel->mmLoadeFund();
	//print_r($mmBalance[0]['currency']);
	$currArr=['IRR','BTC','BCH' ,'ETH','LTC'];

	foreach ($currArr as $cur ) {
		$netRes[$cur]=$myReserve[0][$cur];
	}

	foreach ($mmBalance as $row ) {

		$netRes[$row['currency']]+=$row['amount'];
	}

	echo json_encode($netRes);
		/// owned = reserves + mm balances	
}


protected function totalReserve(){
	$myResModel= new ReserveModel();
	$myReserve=$myResModel->reserve();
	$userBalance=$myResModel->allUsersBalance();
	$userOrders=$myResModel-> allOrders();
	$currArr=['IRR','BTC','BCH' ,'ETH','LTC'];;

	foreach ($currArr as $cur ) {
		$totalRes[$cur]=$myReserve[0][$cur];
	}

	foreach ($userBalance as $row ) {
		$thiscurr=$row['currency'];
	//	print_r($totalRes);
	$totalRes[$thiscurr]+=$row['total_amount'];
	}

	foreach ($userOrders as $row ) {
		$currency=explode('/', $row['pair'] );
		if($row['buy_sell']=='sell'){
			$totalRes[$currency[0]]+=$row['total_amount']+$row['total_fee'];
		}else{
			$totalRes[$currency[1]]+=$row['total_amount']+$row['total_fee'];
		}
	}
	echo json_encode($totalRes);
	// total= reserves  + user balances +order amounts + order fees;

}

protected function incomeChartData(){
	$currArr=['IRR','BTC','BCH' ,'ETH','LTC'];;
	$curr=$currArr[$_POST['curr']];
		$interval=$_POST['timeItrvl'];
		

		switch ($interval) {
	    	case "0": // 1 hr
	        $startTime= time()-3600;
	        break;

	        case "1": // 12 Hrs
	        $startTime= time()-86400/2;
	        break;

	    	case "2": // 24 hrs
	        $startTime= time()-86400;
	        break;

	        case "3": // 1 week
	        $startTime= time()-7*86400;
	        break;

	   		case "4": // 1 Month
	         $startTime= time()-30*86400;
	        break;
        
	        case "5": // 1 Year
	        $startTime= time()-365*86400;
	        break;
		}

$myResModel= new ReserveModel();
$chartData=$myResModel-> incomeChartData($curr, $startTime);
$output[0][0]='time';
$output[0][1]='amount';
for ($i=1; $i <sizeof($chartData)+1 ; $i++) { 
 	$output[$i][0]=$chartData[$i-1]['change_time'];
 	$output[$i][1]=1*$chartData[$i-1]['amount'];
 } {
	
}
echo json_encode($output);

}
//********* Internal Use

private function SendEmailUser($email,$txt,$subject){
	// $purpose: 'signup' or 'reset'
		$to = $email;

	$from = 'admin@ramzibase.com';
	 
	// To send HTML mail, the Content-type header must be set
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	 
	// Create email headers
	$headers .= 'From: '.$from."\r\n";
	 
	// Compose a simple HTML email message
	$message = '<html><body>';
	$message .= $txt;
	$message .= '</body></html>';
	 
	// Sending email
		
	return mail($to, $subject, $message, $headers);
		   
}




//End of file*****
}