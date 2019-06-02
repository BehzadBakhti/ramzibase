<?php 



class MarketMakerModel extends Model
{

	function Index()
	{

		return;
	}

	function getTradeInterval($pair){
		$curr=explode('/', $pair);
		$param=strtolower($curr[0]."_".$curr[1]."_tri");
		$query= "SELECT $param FROM config_data WHERE id=1";
		$this->query($query);
		$result=$this->singleResult();
		return  $result[$param];

	}


function latestGoodOrders($pair,$avr){
$maxBuyPrice=$avr*(1-FEE);
$minSellPrice=$avr*(1+FEE);

	$buyOrdersQry="SELECT `user_id`, `buy_sell`, `amount`, `price` FROM orders WHERE (pair ='$pair' AND price >=$maxBuyPrice AND buy_sell = 'buy' AND status <> 'complete' AND authorization='confirmed') ORDER BY `price` DESC, sub_time;";
	$this-> query($buyOrdersQry);
	$buyOrdersRslt=$this->singleResult();

	$sellOrdersQry="SELECT `user_id`, `buy_sell`, `amount`, `price` FROM orders WHERE (pair ='$pair' AND price <=$minSellPrice AND buy_sell = 'sell' AND status <> 'complete' AND authorization='confirmed') ORDER BY `price` ASC, sub_time;";
	$this-> query($sellOrdersQry);
	$sellOrdersRslt=$this->singleResult();
	$goodOrders=array('buySet'=> $buyOrdersRslt,'sellSet' => $sellOrdersRslt);
	return $goodOrders;
}




	


	function lastTrade($pair){

		$query= "SELECT amount, price, trade_time FROM trade_book WHERE pair='$pair'  ORDER BY trade_time DESC LIMIT 1";
		$this->query($query);
		$result=$this->singleResult();
		return $result;
	}
//End of file****
}