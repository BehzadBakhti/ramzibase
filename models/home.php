<?php

/**
* 
*/
class HomeModel extends Model
{
	
	function Index()
	{
		return;
	}

	function tradeHistory($startTime){
		$query="SELECT pair, SUM((amount * price)) AS total_volume From trade_book WHERE UNIX_TIMESTAMP(trade_time)>= $startTime GROUP BY pair";
		$this-> query($query);
		return $this-> resultSet();
	}



function averagePrice($pair, $startTime){

	$query="SELECT pair, (SUM(amount*price)/SUM(amount)) AS average FROM trade_book WHERE pair='$pair' AND UNIX_TIMESTAMP(trade_time)>= $startTime";
		$this-> query($query);
		return $this-> singleResult();
}

function cuntactUs($senderName, $senderEmail, $messageBody, $userId){
	$query= "INSERT INTO contact_us (name , email , message, user_id) VALUES (:name, :email, :message, :userId)";
	$this->query($query);
	$this-> dataBind(':name',$senderName);
	$this-> dataBind(':email',$senderEmail);
	$this-> dataBind(':message',$messageBody);
	$this-> dataBind(':userId',$userId);

	$this-> executeQuery();

}
//***END OF Class ***///
}


  ?>