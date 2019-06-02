<?php 

/**
* 
*/
class Deals extends Controller
{
	protected function Index(){

		$viewmodel=new DealModel();
		$this -> returnView($viewmodel->Index(), true);
	}

protected function userBalance(){
		$viewmodel=new DealModel();
		$currency=explode("/",$_POST['pair']);
		$userId=$_POST['userId'];

		$JSON="";
		
		for($i=0;$i<2;$i++){

		
		$result=$viewmodel->userBalance($currency[$i],$userId);
		
		$amount[$i]=$result['amount'];
		}

			$amount[0]=$amount[0]*(1);
			$amount[1]=$amount[1]*(1);
			$amount[2]=$amount[0]/(1+FEE);
			$amount[3]=$amount[1]/(1+FEE);

			$Aarray = array($amount, $currency);
			$JSON = json_encode($Aarray);	
		
		echo  $JSON;
		
		
	}

	protected function putAnOrder(){
		$pair=$_POST['pair'];
		$orderType=$_POST['orderType'];
		$amount=$_POST['amount'];
		$price=$_POST['price'];
		$userId=$_POST['userId'];


		if (!preg_match("/^\d{0,12}(\.\d{1,9})?$/", $amount) OR !preg_match("/^\d{0,12}(\.\d{1,9})?$/", $price)){
			echo 'مقادیر وارد شده صحیح نمی باشد';
    		return;
		} 




		$status='original';
		$viewmodel=new DealModel();
		
			if($_SESSION['confirmed']=='confirmed'){

				$output= $viewmodel->putAnOrder($orderType,$pair,$amount,$price,$userId,$status);
			}else{
				$state=($_SESSION['confirmed']=='unconfirmed')?'تایید نشده':'مسدود';
				$output="حساب کاربری شما ".$state." است ";
			}

			if(is_numeric($output)){
				echo "سفارش با موفقیت ثبت گردید";
				$orderId=$output;
			$viewmodel-> checkForTransaction($orderId,$orderType,$pair,$amount,$price,$userId);
			}else{
				echo $output;
			}
	}


	protected function priceChart(){
		
		$pair=$_POST['pair'];
		$interval=$_POST['timeInterval'];
		$chartType=$_POST['chartType'];


		switch ($interval) {
	    	case "0"://1 Hr
	       $startTime= time()-3600;
	       $bakedTimeStep=120;
	       $timFormat='H:i';
	        break;

	        case "1":// 12 Hr
	        $startTime= time()-86400/2;
	        $bakedTimeStep=900;
	        $timFormat='H:i';
	        break;

	    	case "2": // 24 Hr
	        $startTime= time()-86400;
	        $bakedTimeStep=1800;
	         $timFormat='H:i';
	        break; 

	        case "3":
	         $startTime= time()-7*86400;
	         $bakedTimeStep=4*3600;
	          $timFormat='D H:i';
	        break;

	   		case "4":
	         $startTime= time()-30*86400;
	         $bakedTimeStep=15*3600;
	          $timFormat='M-d';
	        break;

			case "5":
	         $startTime= time()-90*86400;
	       $bakedTimeStep=45*3600;
	       $timFormat='M-d';
	        break;
	        
	        case "6":
	        $startTime= time()-365*86400;
	        $bakedTimeStep=8*86400;
	        $timFormat='M-d';
	        break;

	        case "7":
	         $startTime= strtotime('2009-01-01 01:00:00');
	         $bakedTimeStep=30*86400;
	         $timFormat='Y-M';
	        break;	
		}


		if($chartType=="line"){
		$chartData=($bakedData=$this->bakeDataLINE( $startTime, $bakedTimeStep,$pair,$timFormat));
		}else{
		$chartData= $bakedData=$this->bakeDataOHLC( $startTime, $bakedTimeStep, $pair,$timFormat);

		}

	//print_r($rawData);
		echo json_encode($chartData);
	return;

}


private function bakeDataOHLC( $startTime, $timeStep,$pair,$timFormat){

		$viewmodel=new DealModel();
		$outpuData = array();
		
		$outpuData[0][0]='time';
		$outpuData[0][1]='low';
		$outpuData[0][2]='open';
		$outpuData[0][3]='close';
		$outpuData[0][4]='high';

		$outpuData[1][0]=date($timFormat,$startTime);
		$outpuData[1][1]=$viewmodel->closePrice(0,$startTime, $pair);
		$outpuData[1][2]=$viewmodel->closePrice(0,$startTime, $pair);
		$outpuData[1][3]=$viewmodel->closePrice(0,$startTime, $pair);
		$outpuData[1][4]=$viewmodel->closePrice(0,$startTime, $pair);
		$outputLength= floor((time()-$startTime)/$timeStep);
		for ($i=2; $i <$outputLength+2 ; $i++) { 
			$outpuData[$i][0]=date($timFormat,($startTime+($i-1)*$timeStep));
			$strt=$startTime+($i-1)*$timeStep;//strtotime($outpuData[$i-1][0]);
			$end=$strt+$timeStep;//strtotime($outpuData[$i][0]);
			$outpuData[$i][1]=$viewmodel->lowPrice($strt,$end, $pair);
			$outpuData[$i][2]=$viewmodel->openPrice($strt,$end, $pair);
			$outpuData[$i][3]=$viewmodel->closePrice($strt,$end, $pair);	
			$outpuData[$i][4]=$viewmodel->highPrice($strt,$end, $pair);


			If(($outpuData[$i][1]==0) && ($outpuData[$i][2]==0) && ($outpuData[$i][3]==0) && ($outpuData[$i][4]==0)){
				$outpuData[$i][1]=$outpuData[$i-1][3];
				$outpuData[$i][2]=$outpuData[$i-1][3];
				$outpuData[$i][3]=$outpuData[$i-1][3];
				$outpuData[$i][4]=$outpuData[$i-1][3];
			}
		}


		return $outpuData;

}


	private function bakeDataLINE($startTime, $timeStep,$pair,$timFormat){
		$timeStep=$timeStep/5;
		$viewmodel=new DealModel();
		$outpuData = array();
		
		$outpuData[0][0]='time';
		$outpuData[0][1]=explode("/", $pair)[1];
		

		$outpuData[1][0]=date($timFormat,$startTime);
		$outpuData[1][1]=$viewmodel->closePrice(0,$startTime, $pair);
		$outputLength= floor((time()-$startTime)/$timeStep);
		
		for ($i=2; $i <$outputLength+1 ; $i++) { 
			$outpuData[$i][0]=date($timFormat,($startTime+($i-1)*$timeStep));
			$strt=$startTime+($i-1)*$timeStep;//strtotime($outpuData[$i-1][0]);
			$end=$strt+$timeStep;//strtotime($outpuData[$i][0]);
			$outpuData[$i][1]=$viewmodel->closePrice($strt,$end, $pair);
			If($outpuData[$i][1]==0){
				$outpuData[$i][1]=$outpuData[$i-1][1];
			}
			
		}
	
	return $outpuData;
}



protected function cancelOrder(){
	$orderId=explode("_", $_POST['orderName'])[1];
	$viewmodel=new DealModel();	

	$orderData=$viewmodel-> cancelOrder($orderId);

	$userId=$orderData['user_id'];
	
	if($orderData['buy_sell']=='sell'){
			$addAmnt=$orderData['amount']+$orderData['fee'];
			$curr=explode('/',$orderData['pair'])[0];
		}else{

			$addAmnt=$orderData['price']*$orderData['amount']+$orderData['fee'];
			$curr=explode('/',$orderData['pair'])[1];
		}

	$output=$viewmodel-> manageUserBalance($userId, $curr, $addAmnt);
	print_r($output);
}
// End of file*****
}