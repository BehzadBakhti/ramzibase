<?php


/**
* 
*/
class ReserveModel extends Model
{
	
	function index()
	{
		return;
	}

	function fundMarketMaker(){



	}

	function changeReserve($amnt, $curr, $src){
	$query="INSERT INTO reserve_change (`amount` , `currency` , `source`) VALUES (:amount , :currency, :source)";
		$this->query($query);
		$this-> dataBind(':currency',$curr);
		$this-> dataBind(':amount',$amnt);
		$this-> dataBind(':source',$src);
		$this->executeQuery();

		$query2= "UPDATE reserve SET ".$curr." = ".$curr." + (".$amnt.") WHERE id=1";
		$this->query($query2);
		$this->executeQuery();
	
	}

function mmLoadeFund(){
	$query="SELECT * FROM balance WHERE user_id=100 OR user_id=101";
				$this-> query($query);
		return	$this-> resultSet();

}


function reserve(){
		//$this ->query("SELECT currency, SUM(amount) As total_amount FROM reserve_change WHERE source= 'trade'  GROUP BY currency")  ;
		$this ->query("SELECT * FROM reserve");
		return	$this ->resultSet();

	}

function allUsersBalance(){

	$this ->query("SELECT currency, SUM(amount) AS total_amount FROM balance  GROUP BY currency");
	return	$this ->resultSet();

}


function allOrders(){

	$this ->query("SELECT pair, buy_sell, SUM(amount) AS total_amount, SUM(fee) AS total_fee FROM orders WHERE buy_sell = 'sell' AND status <> 'complete' GROUP BY pair");
	$sellOrders =$this ->resultSet();
	$this ->query("SELECT pair, buy_sell, SUM(amount) AS total_amount, SUM(fee) AS total_fee FROM orders WHERE buy_sell = 'buy' AND status <> 'complete' GROUP BY pair");
	$buyOrders =$this ->resultSet();
	return array_merge($sellOrders, $buyOrders);
}

function incomeChartData($curr, $startTime){
	$this ->query("SELECT amount, change_time FROM reserve_change WHERE currency = :curr AND UNIX_TIMESTAMP(change_time)>= :startTime");
	$this-> dataBind(':curr',$curr);
	$this-> dataBind(':startTime',$startTime);
	$chartData =$this ->resultSet();
	return $chartData;

}


//End of file************
}