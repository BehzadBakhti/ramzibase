<?php


class TableUpdateModel extends Model
{
	
	function Index()
	{
		$this->query('SELECT * FROM orders');
		$rows=$this->resultSet();
	return $rows;
		
	}


	function orderBook($pair,$buy_sell){
		$output="";
		if($buy_sell=="buy"){
			$sortDir="DESC";
		}else{

			$sortDir="ASC";
		}
			$this ->query("SELECT  price, SUM(amount) As total_amount FROM orders WHERE (buy_sell= :orderType AND pair=:pair AND status <> 'complete' AND authorization='confirmed') GROUP BY price  ORDER BY price ".$sortDir.", sub_time");
		$this->dataBind(':orderType',$buy_sell);
		$this->dataBind(':pair',$pair);

		if(strpos($pair, 'IRR')>(-1)){
			$dig=2;
		}else{
			$dig=6;
		}

		$result=$this->resultSet();
    
				 for($i=0;$i<15;$i++){
				  if (isset($result[$i])) {
						$row=$result[$i];
				  	$output.='
					<tr calss=" tableRow primary-dark">
				  
				      <td> 
				      	<div class="tableCell">
				      	'.$row["total_amount"].'
				     	 </div>
				      </td>
				      <td>
				      	<div class="tableCell">
				      	'.number_format($row["price"],$dig).'
						</div>
				      </td>
				      <td>
				      <div class="tableCell">
				      '.number_format($row["total_amount"]*$row["price"],$dig).'
				      </div>
				      </td>
				    </tr>
				  	';
				  }else{
		$output.='
					<tr>
				  
				      <td> 
				      	<div class="tableCell">
				      	
				     	 </div>
				      </td>
				      <td>
				      	<div class="tableCell">
				      	
						</div>
				      </td>
				      <td>
				      <div class="tableCell">
				      
				      </div>
				      </td>
				    </tr>
				  	';

				  }

				}

		 return $output;

}

function userActiveOrders($pair,$userId){
	$output="";
	$query="SELECT * FROM orders WHERE (user_id= :userId AND pair= :pair AND status <> 'complete' ) ORDER BY sub_time DESC";

	$this->query($query);
	$this->dataBind(':userId',$userId);
	$this->dataBind(':pair',$pair);
					
	$result = $this -> resultSet();
				
	$num_rows=sizeof($result);
				 for ($i=0; $i <$num_rows ; $i++) { 
				  	# code...
				   $row=$result[$i];

				  	$output.='
					<tr class="tableRow" id="acrId_'.$row["order_id"].'">
		
				      <td> 
				      	<div class="tableCell">
				      	'.$row["buy_sell"].'
				     	 </div>
				      </td>
				       <td>
				      	<div class="tableCell">
				      	'.$pair.'
						</div>
				      </td>
				      <td>
				      	<div class="tableCell">
				      	'.$row["amount"].'
						</div>
				      </td>
				      <td>
				      <div class="tableCell">
				      '.$row["price"].'
				      </div>
				      </td>
				       <td>
				      	<div class="tableCell">
				      	'.$row["sub_time"].'
						</div>
				      </td>
				       <td >
				      	<button class="btn main-red orderCancelBtn" data-toggle="modal" data-target="#cancelOrderConf" >
				      	Cancel
						</button>
				      </td>

				    </tr>
				  	';
				  }
		
	return $output;

}


function tradeBook(){
	$query="SELECT * FROM trade_book ORDER BY trade_time DESC LIMIT 15";
	$output='';
	$this->query($query);
	$result = $this -> resultSet();
				
	$num_rows=sizeof($result);
		for ($i=0; $i <$num_rows ; $i++) { 
				  
				   $row=$result[$i];
				   $output.='
					<tr>
				  
				      <td> 
				      	<div class="tableCell">
				      	'.$row['trade_time'].'
				     	 </div>
				      </td>
				       <td>
				      	<div class="tableCell">
				      	'.$row['amount'].'
						</div>
				      </td>
				      <td>
				      	<div class="tableCell">
				      	'.$row['pair'].'
						</div>
				      </td>
				      <td>
				      <div class="tableCell">
				      '.$row['price'].'
				      </div>
				      </td>
				       <td>
				      	<div class="tableCell">
				      	'.$row["amount"]*$row['price'].'
						</div>
				      </td>
				       

				    </tr>
				  	';
				  }
		
	return $output;

	}





 function myBalanceTable(){
	$query="SELECT * FROM balance WHERE user_id=:userId";
	$output='';
	$this->query($query);
	$this->dataBind(":userId",$_SESSION['id']);
	$result = $this -> resultSet();
				
	$num_rows=sizeof($result);
		for ($i=0; $i <$num_rows ; $i++) { 
				  
				   $row=$result[$i];
				   if($row['currency']=='IRR'){
					   	if($row['amount']<10000000){
	 						$wdr_fee=0;//$row['amount']*(WDR_IRR_FEE);
					   	}else{
					   		$wdr_fee=0;
					   	}

				   }else{
						$wdr_fee=$row['amount']*(WDR_CRPT_FEE);
				   }
				   
				  
				   $output.='
					<tr>
				  
				      <td> 
				      	<div class="tableCell">
				      	'.(1+$i).'
				     	 </div>
				      </td>
				      <td> 
				      	<div class="tableCell">
				      	'.$row['currency'].'
				     	 </div>
				      </td>
				       <td>
				      	<div class="tableCell">
				      	'.$row['amount'].'
						</div>
				      </td>
				      <td>
				      	<div class="tableCell">
				      	'.($row['amount']-$wdr_fee).'
						</div>
				      </td>
				      <td>
				      	<div class="tableCell">
				      	'.$row['last_update'].'
						</div>
				      </td>
				      
				    </tr>
				  	';
				  }
		
	return $output;

	}

		
	}







 