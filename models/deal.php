<?php

/**
* 
*/
class DealModel extends Model
{
	
	function Index()
	{
		return;
	}



function userBalance($currency,$userId){
		
				$this->query("SELECT amount FROM balance WHERE currency=:currency AND user_id=:userId LIMIT 1");
				$this-> dataBind(':currency',$currency);
				$this-> dataBind(':userId',$userId);
				return $this->singleResult();
				
}

	
function putAnOrder($orderType,$pair,$amount,$price,$userId,$status){
	$currency=explode("/",$pair);
	$freezedCoins=$this->getFreezed();
		if($freezedCoins[$currency[0]]==0){
			return "در حال حاضر معامله با ".$currency[0]." امکان پذیر نمی باشد";
		}	elseif ($freezedCoins[$currency[1]]==0) {
			return "در حال حاضر معامله با ".$currency[1]." امکان پذیر نمی باشد";
		}

	for($i=0;$i<2;$i++){

		
		$result=$this->userBalance($currency[$i],$userId);
		
		$myBalance[$i]=$result['amount'];
		}
			$first_curr=$currency[0];
			$second_curr=$currency[1];
			$first_balance=$myBalance[0]*(1);
			$second_balance=$myBalance[1]*(1);
			$first_usable=$myBalance[0]/(1+FEE);
			$second_usable=$myBalance[1]/(1+FEE);



				if($orderType=="sell" && $first_usable<$amount){
					$output="موجودی ".$first_curr." شما کافی نیست";
					}else if($orderType=="buy" && $second_usable<$amount*$price){
					$output="موجودی ".$second_curr." شما کافی نیست";
					}else{
							if($orderType=="sell"){
							$orderFee=$amount*FEE;
							$addAmount=-($amount+$orderFee);
							$currency=$first_curr;

						}else{
							$orderFee=$amount*$price*FEE;
							$addAmount=-($amount*$price+$orderFee);
							$currency=$second_curr;

						}

		$query="INSERT INTO orders (user_id,buy_sell, pair, amount, fee,price, status) VALUES(:userId,:orderType,:pair,:amount,:fee,:price,:status)";
			$this->query($query);

			$this->dataBind(':userId',$userId);
			$this->dataBind(':orderType',$orderType);
			$this->dataBind(':pair',$pair);
			$this->dataBind(':amount',$amount);
			$this->dataBind(':fee',$orderFee);
			$this->dataBind(':price',$price);
			$this->dataBind(':status',$status);
			
			$result = $this->executeQuery();
			$output=$this ->dbh-> lastInsertId();

			$this->manageUserBalance($userId, $currency, $addAmount);

				}

return $output;

}


public function manageUserBalance($userId, $currency, $addAmount){


		$query= "SELECT * FROM balance WHERE (currency=:currency AND user_id=:userId);";
		$this->query($query);
		$this-> dataBind(':currency',$currency);
		$this-> dataBind(':userId',$userId);
		
		$result= $this-> singleResult();


			if(isset($result['id'])){
			
				$row=$result;
				$newAmount=$addAmount+$row['amount'];
				$new_query="UPDATE balance SET amount=:newAmount, last_update=:lastUpdate WHERE currency=:currency AND user_id=:userId";
				$lastUpdate=date('Y-m-d H:i:s');
				$this->query($new_query);
				$this->dataBind(':newAmount',$newAmount);
				$this-> dataBind(':currency',$currency);
				$this-> dataBind(':userId',$userId);
				$this-> dataBind(':lastUpdate',$lastUpdate);

				}else{
			
				$new_query="INSERT INTO balance (`user_id`, `amount`, `currency`, `last_update`) VALUES (:userId,:addAmount,:currency, :lastUpdate)";
				$lastUpdate=date('Y-m-d H:i:s');
				$this->query($new_query);
				$this->dataBind(':addAmount',$addAmount);
				$this-> dataBind(':currency',$currency);
				$this-> dataBind(':userId',$userId);
				$this-> dataBind(':lastUpdate',$lastUpdate);
				
				}

			
		$this->executeQuery();
		return;

}


function checkForTransaction($orderId,$orderType,$pair,$amount,$price,$userId){
	$currency=explode("/",$pair);
	if($orderType=="sell"){

		$initAmount=$amount;
		$initFee=$amount*FEE;

		$query="SELECT * FROM orders WHERE (pair =:pair AND price >=:price AND user_id <> :userId AND buy_sell = 'buy' AND status <> 'complete' AND authorization='confirmed') ORDER BY price DESC, sub_time;";

			$this->query($query);
			$this-> dataBind(':pair',$pair);
			$this-> dataBind(':price',$price);
			$this-> dataBind(':userId',$userId);
			$q_results= $this->resultSet();
			$num_rows=sizeof($q_results);
	    if($num_rows>0){

			for ($i=0;$i<$num_rows;$i++) {
			
					$answers_row=$q_results[$i];
					if($answers_row['amount']<$amount){
						$newFee=FEE* $answers_row['amount'] *$price;

						$answer_order_update="UPDATE orders
											  SET final_price=:price, fee=:fee, status= 'complete' 
											  WHERE order_id=:orderId";
						$this->query($answer_order_update);
						$this-> dataBind(':fee',$newFee);
						$this-> dataBind(':price',$price);
						$this-> dataBind(':orderId',$answers_row['order_id']);
						$this->executeQuery();
						
						 $buyerIncome=$answers_row['amount'];
						 
						$this-> manageUserBalance($answers_row['user_id'], $currency[0], $buyerIncome);
						$compensate=$answers_row['fee']-$newFee;
						$this-> manageUserBalance($answers_row['user_id'], $currency[1], $compensate);

						 $sellerIncome=$price * $answers_row['amount'];
						$this-> manageUserBalance($userId, $currency[1], $sellerIncome);

						$this-> tradeToDB($pair,$answers_row['amount'],$price,$userId, $answers_row['user_id']);
						 $amount-=$answers_row['amount'];

					}else if ($answers_row['amount']>$amount) {
						
						$request_order_update="UPDATE orders
											  SET final_price=:price, status= 'complete' 
											  WHERE order_id=:orderId";
					
						$this->query($request_order_update);
						$this-> dataBind(':price',$price);
						$this-> dataBind(':orderId',$orderId);
						$this->executeQuery();

						 $buyerIncome=$amount;
						$this-> manageUserBalance($answers_row['user_id'], $currency[0], $buyerIncome);
						 $sellerIncome=$price * $amount;
						$this-> manageUserBalance($userId, $currency[1], $sellerIncome);
						$newFee=FEE* $amount*$price;
						$answer_order_update="UPDATE orders
											  SET amount=:amount, final_price=:price, fee= :fee, status= 'complete' 
											  WHERE order_id=:orderId;";
						
						$this->query($answer_order_update);
						$this-> dataBind(':amount',$amount);
						$this-> dataBind(':price',$price);
						$this-> dataBind(':fee',$newFee);
						$this-> dataBind(':orderId',$answers_row['order_id']);
						$this->executeQuery();


						$this->tradeToDB($pair,$amount,$price,$userId, $answers_row['user_id']);

						$compensate=$answers_row['amount']*$answers_row['price']- $amount* $price +$answers_row['fee']-$newFee;
	 					$this-> manageUserBalance($answers_row['user_id'], $currency[1], $compensate);
						
						$order_remainder=$answers_row['amount']-$amount;

					 	$this-> putAnOrder('buy',$pair,$order_remainder,$answers_row['price'],$answers_row['user_id'],'partial');
						$amount=0;
						break;
						
					}else /*request amount= answer amount*/{
						$orders_update="UPDATE orders
											  SET final_price=:price, status= 'complete' 
											  WHERE order_id=:orderId OR order_id=:orderId2";

						$this->query($orders_update);
						$this-> dataBind(':price',$price);
						$this-> dataBind(':orderId',$orderId);
						$this-> dataBind(':orderId2',$answers_row['order_id']);
						$this->executeQuery();


						 $buyerIncome=$amount;
						$this->  manageUserBalance($answers_row['user_id'], $currency[0], $buyerIncome);
						 $sellerIncome=$price * $amount;
						$this-> manageUserBalance($userId, $currency[1], $sellerIncome);
						$this-> tradeToDB($pair,$amount,$price,$userId, $answers_row['user_id']);
						$amount=0;
						break;
						
					}

			}


			if($amount> 0.00000001){
				$newFee=FEE* ($initAmount-$amount);
				$order_update="UPDATE orders
							  SET amount=:amount, fee=:fee, final_price=:price, status= 'complete' 
							  WHERE order_id=:orderId";

						$this->query($order_update);
						$this-> dataBind(':amount',$initAmount-$amount);
						$this-> dataBind(':price',$price);
						$this-> dataBind(':orderId',$orderId);
						$this-> dataBind(':fee',$newFee);
						$this->executeQuery();
				$compensate=$amount+$initFee-$newFee;
		 		$this-> manageUserBalance($userId, $currency[0], $compensate);
				$this-> putAnOrder("sell",$pair,$amount,$price,$userId,"partial");
			}
		}


	}else{
		$initAmount=$amount;
		$initFee=$amount*FEE*$price;

		$query="SELECT * FROM orders WHERE (pair =:pair AND price <=:price AND user_id <> :userId AND buy_sell = 'sell' AND status <> 'complete' AND authorization='confirmed') ORDER BY price ASC, sub_time;";
		

	    	$this->query($query);
			$this-> dataBind(':pair',$pair);
			$this-> dataBind(':price',$price);
			$this-> dataBind(':userId',$userId);

			$q_results= $this->resultSet();
			//print_r($q_results);
			$num_rows=sizeof($q_results);
	    if($num_rows>0){

			for ($i=0;$i<$num_rows;$i++) {
					$answers_row=$q_results[$i];
						if($answers_row['amount']<$amount){
							//$newFee=$GLOBALS['fee']* $answers_row['amount'];
							$answer_order_update="UPDATE orders
												  SET final_price=:price, status= 'complete' 
												  WHERE order_id=:orderId";
					
							$this->query($answer_order_update);
							$this-> dataBind(':price',$price);
							$this-> dataBind(':orderId',$answers_row['order_id']);
							$this->executeQuery();

							$buyerIncome=$answers_row['amount'];
							 
							$this-> manageUserBalance($userId, $currency[0], $buyerIncome);
						
							$sellerIncome=$price * $answers_row['amount'];
							$this-> manageUserBalance($answers_row['user_id'], $currency[1], $sellerIncome);

							$this-> tradeToDB($pair,$answers_row['amount'],$price, $answers_row['user_id'], $userId);
							 $amount-=$answers_row['amount'];

						}else if ($answers_row['amount']>$amount) {
							
							$request_order_update="UPDATE orders
												  SET final_price=:price, status= 'complete' 
												  WHERE order_id=:orderId";
						
							$this->query($request_order_update);
							$this-> dataBind(':price',$price);
							$this-> dataBind(':orderId',$orderId);
							$this->executeQuery();


							 $buyerIncome=$amount;
							$this-> manageUserBalance($userId, $currency[0], $buyerIncome);
							 $sellerIncome=$price * $amount;
							$this-> manageUserBalance($answers_row['user_id'], $currency[1], $sellerIncome);
							 $newFee=FEE* $amount;
							 $answer_order_update="UPDATE orders
									  SET amount=:amount, final_price=:price, fee= :fee, status= 'complete' 
									  WHERE order_id=:orderId";
							 

							$this->query($answer_order_update);
							$this-> dataBind(':amount',$amount);
							$this-> dataBind(':price',$price);
							$this-> dataBind(':fee',$newFee);
							$this-> dataBind(':orderId',$answers_row['order_id']);
							$this->executeQuery();
							$this-> tradeToDB($pair,$amount,$price,$answers_row['user_id'], $userId);

							$compensate=$answers_row['amount']- $amount +$answers_row['fee']-$newFee;
		 					$this->	manageUserBalance($answers_row['user_id'], $currency[0], $compensate);
							
							$order_remainder=$answers_row['amount']-$amount;

							$this->putAnOrder("sell",$pair,$order_remainder,$answers_row['price'],$answers_row['user_id'],"partial");
							 $amount=0;
							break;
							
						}else /*request amount= answer amount*/{
							$orders_update="UPDATE orders
												  SET final_price=:price, status= 'complete' 
												  WHERE order_id=:orderId OR order_id=:orderId2";
				

							
						$this->query($orders_update);
						$this-> dataBind(':price',$price);
						$this-> dataBind(':orderId',$orderId);
						$this-> dataBind(':orderId2',$answers_row['order_id']);
						$this->executeQuery();

							 $buyerIncome=$amount;
							$this-> manageUserBalance($userId, $currency[0], $buyerIncome);
							 $sellerIncome=$price * $amount;
							$this-> manageUserBalance($answers_row['user_id'], $currency[1], $sellerIncome);
							$this->tradeToDB($pair,$amount,$price,$answers_row['user_id'], $userId);
							$amount=0;
							break;
							
						}

				}


				if($amount> 0.00000001){
					$newFee=FEE* ($initAmount-$amount)*$price;
					$order_update="UPDATE orders
								  SET amount= :amount,fee=:fee, final_price=:price, status= 'complete' WHERE order_id=:orderId";
					$this->query($order_update);
					$this-> dataBind(':amount',$initAmount-$amount);
					$this-> dataBind(':price',$price);
					$this-> dataBind(':orderId',$orderId);
					$this-> dataBind(':fee',$newFee);
					$this->executeQuery();
					$compensate=$amount*$price+$initFee-$newFee;
			 		$this->manageUserBalance($userId, $currency[1], $compensate);
					$this->putAnOrder("buy",$pair,$amount,$price,$userId,"partial");
				}
		}
	}

}

protected function tradeToDB($pair,$amount,$price,$sellerId, $buyerId) {
	$tradeTime=time();
	$query= "INSERT INTO trade_book (pair,amount,price,seller_id,buyer_id) 
			 VALUES (:pair,:amount,:price,:sellerId,:buyerId)";
					$this->query($query);
					$this-> dataBind(':amount',$amount);
					$this-> dataBind(':price',$price);
					$this-> dataBind(':pair',$pair);
					$this-> dataBind(':sellerId',$sellerId);
					$this-> dataBind(':buyerId',$buyerId);
 					$this->executeQuery();
			$currency=explode('/', $pair);
			$sellerFee=$amount*FEE;
			$buyerFee=$price*$amount*FEE;
 	$myResModel= new ReserveModel();
	$myResModel-> changeReserve($sellerFee, $currency[0], 'trade');
	$myResModel-> changeReserve($buyerFee, $currency[1], 'trade');
}



public function openPrice($startTime,$endTime, $pair){

	$query="SELECT price, trade_time FROM trade_book WHERE pair = :pair AND UNIX_TIMESTAMP(trade_time) >:startTime AND UNIX_TIMESTAMP(trade_time) <=:endTime ORDER BY UNIX_TIMESTAMP(trade_time) ASC LIMIT 1";
	return $this->fetch_OHLC($query,$startTime,$endTime, $pair);
}

public function closePrice($startTime,$endTime, $pair){

	$query="SELECT price, trade_time FROM trade_book WHERE pair = :pair AND UNIX_TIMESTAMP(trade_time) >:startTime AND UNIX_TIMESTAMP(trade_time) <=:endTime ORDER BY UNIX_TIMESTAMP(trade_time) DESC LIMIT 1";
	return $this->fetch_OHLC($query,$startTime,$endTime, $pair);
}

public function lowPrice($startTime,$endTime, $pair){

	$query="SELECT price, trade_time FROM trade_book WHERE pair = :pair AND UNIX_TIMESTAMP(trade_time) >:startTime AND UNIX_TIMESTAMP(trade_time) <=:endTime ORDER BY price ASC LIMIT 1";
	return $this->fetch_OHLC($query,$startTime,$endTime, $pair);
}

public function highPrice($startTime,$endTime, $pair){

	$query="SELECT price, trade_time FROM trade_book WHERE pair = :pair AND UNIX_TIMESTAMP(trade_time) >:startTime AND UNIX_TIMESTAMP(trade_time) <=:endTime ORDER BY price DESC LIMIT 1";
	return $this->fetch_OHLC($query,$startTime,$endTime, $pair);
}


protected function fetch_OHLC($query,$startTime,$endTime, $pair){

	$this->query($query);
	$this-> dataBind(':startTime',$startTime);
	$this-> dataBind(':endTime',$endTime);
	$this-> dataBind(':pair',$pair);
	$q_results= $this->singleResult();
	//	print_r($q_results);

	return (float)$q_results['price'];

}

public function cancelOrder($orderId){

	$query="SELECT * FROM orders WHERE order_id=:orderId";
	$this->query($query);
	$this-> dataBind(':orderId',$orderId);
	$orderData=$this->singleResult();

	$delQuery="DELETE FROM orders WHERE order_id=:orderId";
	$this->query($delQuery);
	$this-> dataBind(':orderId',$orderId);
	$this-> executeQuery();
	return $orderData;


}


function getFreezed(){
$query="SELECT IRR, BTC , ETH , BCH,  LTC FROM config_data ";
$this->query($query);

return $this->singleResult();
}


//End of file***
}