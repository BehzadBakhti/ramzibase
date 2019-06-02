<?php 

class MarketMaker 
{
	protected function Index(){
		
	}


	protected function checkTradeHistory($pair){
		
		$makerModel= new MarketMakerModel();

		return $makerModel-> lastTrade($pair);

		}


	protected function latestGoodOrders( $pair, $avr){
		$makerModel= new MarketMakerModel();
		return $makerModel->latestGoodOrders($pair,$avr);
				/*[buySet] => Array ( 
									[buy_sell] => buy
									[user_id] => userId
									[amount] => 1 
									[price] => 50080000 ) 
				[sellSet] => Array ( 
									[buy_sell] => sell 
									[user_id] => userId
									[amount] => 0.5 
									[price] => 50004000 ) */

		}

	protected function globalPrice($pair) {
			$currArr=explode("/", $pair);

			if($currArr[1]=='IRR'){
			$url= 'https://min-api.cryptocompare.com/data/pricemulti?fsyms='.$currArr[0].'&tsyms=USD';
			}else{
			$url= 'https://min-api.cryptocompare.com/data/pricemulti?fsyms='.$currArr[0].'&tsyms='.$currArr[1];	
			}
			
			$ch = curl_init();
	        curl_setopt($ch,CURLOPT_URL,$url);
	        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
	        $res = curl_exec($ch);
	        curl_close($ch);
			$priceArray= json_decode($res,true);
		
			
			if($currArr[1]=='IRR'){
				$price= $priceArray[$currArr[0]]['USD'];
			
				$price=$price* $this->usdPrice();
				
			}else{
				$price= $priceArray[$currArr[0]][$currArr[1]];
			
				$price=$price* $this->usdPrice();
				
			}
			return $price;
		}


	protected function lastPrice($pair){
		$makerModel = new  MarketMakerModel();
		 $lastTrade= $makerModel->lastTrade($pair);
		return $lastTrade['price'];
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


	protected function putMakerOrder($orderType, $pair,$amount, $price ,$userId){
		$dealModel=new DealModel();

		$output= $dealModel->putAnOrder($orderType,$pair,$amount,$price,$userId,'original');

		if(is_numeric($output)){
				$print= "Order Successfuly Added";
				$orderId=$output;
			$dealModel-> checkForTransaction($orderId,$orderType,$pair,$amount,$price,$userId);
			}else{
				$print= $output;
			}
		return $output;	

	}


public function executeMM($pair){

	$makerModel= new MarketMakerModel();
		$tri= 60*($makerModel->getTradeInterval($pair));

		$lastTrade=$this->checkTradeHistory($pair);
		//		$goodOrders=$this->latestGoodOrders('BTC/IRR',50000000);
			//	print_r($lastTrade);
		
				$userId=MM_ID_1;
		if((time()-strtotime($lastTrade['trade_time']))<$tri)
			{
//echo date( 'H:i')."  " ;
				// its Ok for now, check next 'tri' min again.
				echo "its Ok";
				return;

			}
			$lPrice= $this->lastPrice($pair);
			$gPrice=$this->globalPrice($pair);
				if($lPrice<$gPrice/2){
					$avPrice=$gPrice;
				}else{
					$avPrice=($lPrice + $gPrice)/2;
				}
				
				
				$goodOrders=$this->latestGoodOrders($pair,$avPrice);
				$orderAmount= mt_rand(100,400)/100000;// generate radome amount
				//print_r($goodOrders);
					if(isset($goodOrders['buySet']['price']) AND isset($goodOrders['sellSet']['price'])){
						//both order types are Available
						$buyDiff=$avPrice-$goodOrders['buySet']['price'];
						$sellDiff=$goodOrders['sellSet']['price'] -$avPrice;
		
						if($buyDiff<=$sellDiff){
							
							if($goodOrders['buySet']['user_id'] ==MM_ID_1){$userId=MM_ID_2;}
						    $this-> putMakerOrder('sell', $pair,$orderAmount, 1*$goodOrders['buySet']['price'],$userId);
						}else{
							if($goodOrders['sellSet']['user_id'] ==MM_ID_1){$userId=MM_ID_2;}
					        $this-> putMakerOrder('buy', $pair,$orderAmount, 1*$goodOrders['sellSet']['price'],$userId);
						}

					}else if(isset($goodOrders['buySet']['price'])){
						//only buy order is availebel, so put a sell order
							if($goodOrders['buySet']['user_id'] ==MM_ID_1){	$userId=MM_ID_2;}
								
							$this-> putMakerOrder('sell', $pair,$orderAmount, 1*$goodOrders['buySet']['price'],$userId);
					}else if(isset($goodOrders['sellSet']['price'])){
						//only sell order is availebel, so put a buy order
								if($goodOrders['sellSet']['user_id'] ==MM_ID_1){$userId=MM_ID_2;}
									
							$this-> putMakerOrder('buy', $pair,$orderAmount, 1*$goodOrders['sellSet']['price'],$userId);

					}else{
						// no good order available, Initiate a randome Order
						//$this->cancelPrevOrders();
							if(mt_rand(1,2)==1){
								$orderType='buy';
								$orderPrice=$avPrice*(1-FEE);
							}else{
								$orderType='sell';
								$orderPrice=$avPrice*(1+FEE);
							}
//echo $orderType."--".$orderPrice."--".$orderAmount;
						$myOrder=$this-> putMakerOrder($orderType, $pair,$orderAmount, $orderPrice,$userId);
						// print_r($myOrder);
					}
	return;
	
}


//End of file ************
}

