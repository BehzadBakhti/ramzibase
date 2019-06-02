<?php 



class Funds extends Controller
{

protected function Index(){

		$viewmodel=new FundModel();
		$this -> returnView($viewmodel->Index(), true);

	}

protected function oprationSelector(){

	if(!isset($_SESSION['id'])){
		echo "ابتدا وارد حساب کاربری خود شوید";
		//echo $_SESSION['id'];
		return;
	}
	$myFundModel=new FundModel();
	$operation=$_POST['op_type'];
	$_SESSION['currency']=$_POST['currency'];
	$_SESSION['amountToHandle']=$_POST['amountToHandle'];

	$factorId=1;

		switch ($_SESSION['currency']){

		    case "IRR":

				if($operation=='deposit'){
					

					$myToken=$this-> NewToken();
					$sendURL= "https://bahamta.com/".FUND_BOX."?note=".$myToken."&amount=".$_SESSION['amountToHandle'];
					$myFundModel-> setCryptoAddress($myToken,$_SESSION['currency'],'deposit');
					$comment="<h5>توکن زیر را در صفحه پرداخت در قسمت 'توضیح' کپی کنید</h5> <br> <p class='lead'>$myToken</p> <br>  <p>پس از پرداخت، ظرف حداکثر 5 دقیقه موجودی کیف پول شما به روز میگردد</p>";
					$result=json_encode(['comment' => $comment , 'url'=> $sendURL]);
					echo $result;

						 return;

				}else{

						echo $this-> wdr_Ticket_IRR($_SESSION['amountToHandle']);
				}
		        break;
		/*----------------------------------------*/
		    case "BTC":
				if($operation=='deposit'){
						$res=$this->makeNewAddress($_SESSION['currency']);
					}else{
						$addrCrypto=$_POST['userWalletAddress'];
						echo $this-> wdr_Ticket_Crypto($_SESSION['amountToHandle'], $_SESSION['currency'], $addrCrypto);
					}
		        break;


		   /*----------------------------------------*/
		    case "ETH":
					if($operation=='deposit'){

					}else{

					}
		        break;
		/*----------------------------------------*/
		    case "BCH":
					if($operation=='deposit'){

					}else{

					}
		        break;
         /*----------------------------------------*/
   			 case "LTC":
					if($operation=='deposit'){

					}else{

					}
       			break;
		    default:
		        return;
			}
		return;
}

////////*********************** Deposit *******************///////////
private function sendIRR ($amount,  $email){  //send
       $gate = new Behbank();

			$params = array(
				'merchantCode' => IRR_API_KEY,//مرچنت کد درگاه
				'amount' => $amount,//مبلغ به ریال
				'callBackUrl' => 'https://www.ramzibase.com/funds',//آدرس بازگشت از درگاه
				'invoiceNumber' => time(),//شماره فاکتور
				'payerEmail' => $email
			);
			$request = $gate->paymentRequest($params);

			if($request['status']==1){
				return $gate->paymentGateway($request['paymentNumber']);
			}else{
				return var_dump($request);
			}
    } 


public function checkIRR(){ //get

			$gate = new Behbank();
			
			$params = array(
				'merchantCode' => IRR_API_KEY,
				'paymentNumber' => $_POST['paymentNumber'],
			);
			$request = $gate->paymentVerify($params);
	

	        if($request['status']==1){
				$depositModel= new FundModel();
				$natijeh= $depositModel->depositIRR($_SESSION['amountToHandle'], $_SESSION['currency']);

				 if($natijeh!=0){
					$dealModel=new DealModel();
					$dealModel-> manageUserBalance($_SESSION['id'], $_SESSION['currency'], $_SESSION['amountToHandle']);
					}
					echo 1;//successful payment

	        }else{
					echo 'پرداخت با شکست مواجه شد <pre>';
					var_dump($request);	
					echo '</pre>';

	        }

	
		$_SESSION['currency']="";
		$_SESSION['amountToHandle']=0; 
		
        return $natijeh;
    }

//protected function 

protected function makeNewAddress($currency)
	{
		$curr=MODE.strtolower($currency);
		
		$nodeJsPath =   'node classes/BitGoProject/createAddress.js '.CRYPTO_TOKEN.' '.WALLET_ID[$currency].' '.$curr.' 2>&1';
		$output= exec( $nodeJsPath, $out, $err);
		$address=$out[1];
		$address=str_replace("'","", $address);

		echo '<div class="justify-content-center my-2">برای افزایش موجودی خود رمز ارز مورد نظر را به آدرس زیر ارسال کنید: <br>  ' . $address. ' </div> ';

		$fundModel=new FundModel();
		$fundModel-> setCryptoAddress($address,$_SESSION['currency'],'deposit');

	}


protected function getCryptoAddress(){

		$viewmodel=new FundModel();
		echo  $viewmodel->getCryptoAddress();

	}
protected function getActiveTickets(){

		$viewmodel=new FundModel();
		echo  $viewmodel->getActiveTickets();

	}

	protected function cancelTicket(){
echo $_POST['ticketName'];
		$ticketId=explode("_",$_POST['ticketName'])[1];
		$fundModel=new FundModel();
		$out1=$fundModel->cancelTicket($ticketId);
		$dealModel=new DealModel();
		$out2=	$dealModel->manageUserBalance($out1['user_id'], $out1['currency'], $out1['amount']);
print_r($out2);

	}

/*
protected function manualTicketIRR($amnt,$rcpt){
				$viewmodel=new fundModel();
				$fileName=$rcpt['name'];
				$fileTmpName=$rcpt['tmp_name'];
				$fileSize=$rcpt['size'];
				$fileError=$rcpt['error'];
				$fileType=$rcpt['type'];
				$fileExt=explode('.', $fileName);
				$fileExtActual=strtolower(end($fileExt));
				$allowed = array('jpg' ,'jpeg' );
						if (in_array($fileExtActual, $allowed)) {
							if ($fileError===0) {
								if ($fileSize < 512000) {
									$newFileName=uniqid('', true).".".$fileExtActual;

									$fileDest="views/Funds/recipit/".$newFileName;
									move_uploaded_file($fileTmpName, $fileDest);
									 $viewmodel-> manualTicketIRR($amnt,$newFileName);
									
									return $newFileName ." Successfull uploade";
								}else{

									return "file is too big, maximum file size is 500 kb";
								}
							}else{
							return "there was an error";
							}
						}else{

						return "file type not allowed, only .jpg and .jpeg file formats are allowed";
						}
}*/

////////************************ Withdraw *********************////////////


protected function wdr_Ticket_Crypto($amnt, $currency, $userWalletAdrs){

	 $isValidAddr=$this-> addressVallidity($currency,$userWalletAdrs);
	/* if($isValidAddr==false){
	 	return "آدرس وارد شده برای ".$currency." قابل قبول نمی باشد.";
	 }*/

		$dealModel=new DealModel();
		$fundModel=new FundModel();
		$balance= $fundModel-> this_user_Balance($currency);
		if(isset($balance['amount']) AND $balance['amount']>=$amnt)
		 	{

		 		$addAmount=$amnt*(-1);
	 			$dealModel-> manageUserBalance($_SESSION['id'], $currency, $addAmount);
				$output=  $fundModel->wdr_Ticket_Crypto($amnt, $currency,  $userWalletAdrs);
				return "درخواست با موفقیت ثبت گردید؛ ظرف یک روز کاری وجه به حساب شما واریز می‌گردد";
				
			}else{

				return "مقدار وجه درخواستی بیشتر از موجودی کاربر است";
				
			}	

}

protected function wdr_Ticket_IRR($amnt){

		$dealModel=new DealModel();
		$fundModel=new FundModel();
		$balance= $fundModel-> this_user_Balance('IRR');

		if(isset($balance['amount']) AND $balance['amount']>=$amnt)
		 	{
		 			if($amnt<10000000){
	 						$wdr_fee=0;//$amnt*(WDR_IRR_FEE);
					   	}else{
					   		$wdr_fee=0;//50000;
					   	}
		 		$addAmount=$amnt*(-1);
	 			$dealModel-> manageUserBalance($_SESSION['id'], 'IRR', $addAmount);
				$output=  $fundModel->wdr_Ticket_IRR($amnt);
				return "درخواست با موفقیت ثبت گردید؛ ظرف یک روز کاری مبلغ ".($amnt-$wdr_fee)." ریال به حساب شما واریز می‌گردد";
			}else{

				return "مقدار وجه درخواستی بیشتر از موجودی کاربر است";
				
			}	



}

function addressVallidity($currency,$address){


$validator = Validation::make($currency);
return $validator->validate($address);
	
}
//*********** PRIVATE FUNCTIONS

private function NewToken(){

	return hash('fnv1a64', uniqid('', true));

}
//End of File****
}

