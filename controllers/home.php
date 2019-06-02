<?php 

/**
* 
*/
class Home extends Controller
{
	protected function Index(){

		$viewmodel=new HomeModel();
		$this -> returnView($viewmodel->Index(), true);
	}


	protected function tradeHistory(){
		$myHomeModel= new HomeModel();

		$data24hr=$myHomeModel->tradeHistory(time()-86400);
		$data1week=$myHomeModel->tradeHistory(time()-7*86400);
		$data1month=$myHomeModel->tradeHistory(time()-30*86400);
		
		//print_r($data1week);
		
			$sum24hr=0;
			$sum1week=0;
			$sum1month=0;
	
			foreach ($data24hr as  $pairHistory) {
				$secCurr=explode('/',$pairHistory['pair'])[1];
				if($secCurr=='IRR'){
					$sum24hr+=$pairHistory['total_volume'];
				}else{
					$avprice=$myHomeModel-> averagePrice($secCurr."/IRR",time()-86400);
					if(isset($avprice['average'])){
						$sum24hr+=$pairHistory['total_volume']*$avprice['average'];
					}else{
						$sum24hr+=$pairHistory['total_volume']*($this-> globalPriceToIRR($secCurr));
					}

				}
			}
			foreach ($data1week as  $pairHistory) {
				$secCurr=explode('/',$pairHistory['pair'])[1];
				if($secCurr=='IRR'){
					$sum1week+=$pairHistory['total_volume'];
				}else{
					$avprice=$myHomeModel-> averagePrice($secCurr."/IRR",time()-7*86400);
					if(isset($avprice['average'])){
						$sum1week+=$pairHistory['total_volume']*$avprice['average'];
					}else{
						$sum1week+=$pairHistory['total_volume']*($this-> globalPriceToIRR($secCurr));
					//	echo $this-> globalPrice($secCurr."/IRR");
					}

				}
			}

			foreach ($data1month as  $pairHistory) {
				$secCurr=explode('/',$pairHistory['pair'])[1];
				if($secCurr=='IRR'){
					$sum1month+=$pairHistory['total_volume'];
				}else{
					$avprice=$myHomeModel-> averagePrice($secCurr."/IRR",time()-30*86400);
					if(isset($avprice['average'])){
						$sum1month+=$pairHistory['total_volume']*$avprice['average'];
					}else{
						$sum1month+=$pairHistory['total_volume']*($this-> globalPriceToIRR($secCurr));
					}
				}
			}

		
		$array= array($sum24hr, $sum1week, $sum1month);
		echo json_encode($array);
	}



protected function globalPriceToIRR($curr) {
	// Only Works for Pairs that second currency is IRR #################
			

			$url= 'https://min-api.cryptocompare.com/data/pricemulti?fsyms='.$curr.'&tsyms=USD';
		
			$ch = curl_init();
	        curl_setopt($ch,CURLOPT_URL,$url);
	        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
	        $res = curl_exec($ch);
	        curl_close($ch);
			$priceArray= json_decode($res,true);
		
				$price= $priceArray[$curr]['USD'];
			
				$price=$price* $this->usdPrice();
				

			return $price;
		}



protected function usdPrice(){

		$url='http://www.tgju.org/?act=sanarateservice&client=tgju&noview&type=json';

		$ch = curl_init();
	        curl_setopt($ch,CURLOPT_URL,$url);
	        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
	        $res = curl_exec($ch);
	        curl_close($ch);
			$priceArray= json_decode($res,true);
			 $out= $priceArray['sana_buy_usd']['price'] ;
			return  str_replace(",","",$out);// 44,140 ==> 44140 
    	}



protected function contactUs(){
//	print_r($_POST);
if(isset($_POST['senderName']) AND isset($_POST['senderEmail']) AND isset($_POST['messageBody'])){
	if (filter_var($_POST['senderEmail'], FILTER_VALIDATE_EMAIL) === false) {
			  		echo "آدرس ایمیل نا معتبر است!";
					return;
			  	}
			  	$myUserModel= new UserModel();
			  	$user=$myUserModel-> checkIfUserExist($_POST['senderEmail']);
			  	$userId=isset($user['id'])?$user['id']:0;

$myHomeModel=new HomeModel();
$myHomeModel->cuntactUs($_POST['senderName'], $_POST['senderEmail'], $_POST['messageBody'],$userId);
echo "success";

}else{
	echo "لطفاً همه قسمت های فرم را تکمیل نمایید";
}


}






//END OF FILE **********	
}

 ?>