<?php
/**
  
*/
class FundModel extends Model
{
	
	

function Index()
	{
		return;
	}


function depositIRR($amount,$currency){

	$qq="INSERT INTO balance_change (user_id, action_type, currency, amount, ticket_status) VALUES(:userId, :actionType, :currency, :amount, 'done')";
	//echo $qq;
		$this->query($qq);
		$this-> dataBind(':userId',$_SESSION['id']);
		$this-> dataBind(':actionType',"deposit");
		$this-> dataBind(':currency',$currency);
		$this-> dataBind(':amount',$amount);
		$result = $this->executeQuery();
		$output=$this-> dbh -> lastInsertId();

	 return $output;

}

function setCryptoAddress($address,$currency,$operationType){
	$qqq="INSERT INTO crypto_address (user_id, currency, address, action_type) VALUES(:userId, :currency, :address, :type)";
	//echo $qqq;
		$this->query($qqq);
		$this-> dataBind(':userId',$_SESSION['id']);		
		$this-> dataBind(':currency',$currency);
		$this-> dataBind(':type',$operationType);
		$this-> dataBind(':address',$address);
		$result = $this->executeQuery();
		$output=$this-> dbh -> lastInsertId();

	return $output;

}

public function getCryptoAddress(){
	$output="";
	$query="SELECT * FROM crypto_address WHERE  user_id= :userId AND used=0 AND action_type='deposit' ORDER BY generate_date DESC";

	$this->query($query);
	$this->dataBind(':userId',$_SESSION['id']);
	$result = $this -> resultSet();
				
	$num_rows=sizeof($result)>9?sizeof($result):9;
				 for ($i=0; $i <$num_rows ; $i++) { 
				 	  if (isset($result[$i])) {
				   $row=$result[$i];

				  	$output.='
					<tr>
				  
				      <td> 
				      	<div class="tableCell">
				      	'.($i+1).'
				     	 </div>
				      </td>
				       <td>
				      	<div class="tableCell">
				      	'.$row["currency"].'
						</div>
				      </td>
				      <td>
				      	<div class="tableCell">
				      	'.$row["address"].'
						</div>
				      </td>
				      <td>
				      <div class="tableCell">
				      '.$row["generate_date"].'
				      </div>
				      </td>

				    </tr>
				  	';
				  	 }else{
			$output.='<tr>
				  
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
				      <td>
				      <div class="tableCell">
				     
				      </div>
				      </td>

				    </tr>';
				}
			 }
		
	return $output;

}


public function getActiveTickets(){
	$output="";
	$query="SELECT * FROM balance_change WHERE  user_id= :userId AND action_type='withdraw' AND ticket_status= 'started' ORDER BY request_date DESC";

	$this->query($query);
	$this->dataBind(':userId',$_SESSION['id']);
	$result = $this -> resultSet();
				
	$num_rows=sizeof($result)>4?sizeof($result):4;
				 for ($i=0; $i <$num_rows ; $i++) { 
				 	  if (isset($result[$i])) {
				   $row=$result[$i];

				  	$output.='
					<tr id="ticId_'.$row["id"].'">
				  
				      <td> 
				      	<div class="tableCell" >
				      	'.($i+1).'
				     	 </div>
				      </td>
				       <td>
				      	<div class="tableCell">
				      	'.$row["currency"].'
						</div>
				      </td>
				      <td>
				      	<div class="tableCell">
				      	'.$row["amount"].'
						</div>
				      </td>
				      <td>
				      <div class="tableCell">
				      '.$row["request_date"].'
				      </div>
				      </td>
				      <td >
				      	<button class="btn main-red ticketCancelBtn" data-toggle="modal" data-target="#cancelTicketConf" >
				      	Cancel
						</button>
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
				      <td>
				      <div class="tableCell">
				  
				      </div>
				      </td>
				      <td>
				      <div class="tableCell">
				  
				      </div>
				      </td>

				    </tr>';
				}
				  }
		
	return $output;

}


function cancelTicket($ticketId){

				$query= "UPDATE balance_change SET ticket_status='canceled', action_date=CURRENT_TIMESTAMP WHERE id =:ticketId";
				$this->query($query);
				$this->dataBind(':ticketId',$ticketId);
				
				$this->executeQuery();
				$query2= "SELECT * FROM balance_change WHERE id =:ticketId";
				$this->query($query2);
				$this->dataBind(':ticketId',$ticketId);
				
				$result = $this->singleResult();
				return $result;

	}


public function wdr_Ticket_Crypto($amnt, $currency, $userWalletAdrs){
	//check for enugh balance
	$this->query("INSERT INTO crypto_address (user_id, action_type, currency, address) VALUES (:userId, 'withdraw', :currency ,  :address)");
						
						$this->dataBind(':userId',$_SESSION['id']);
						$this->dataBind(':currency', $currency);
						$this->dataBind(':address', $userWalletAdrs);
						$result = $this->executeQuery();
						$insertId= $this-> dbh -> lastInsertId();


	$this->query("INSERT INTO balance_change (user_id, crypto_adrs_id, action_type, currency, amount) VALUES (:userId, :addrsId,'withdraw', :currency , :amount)");
						
						$this->dataBind(':userId',$_SESSION['id']);
						$this->dataBind(':addrsId', $insertId);
						$this->dataBind(':currency', $currency);
						$this->dataBind(':amount', $amnt);
						$this->executeQuery();
						$insertId= $this-> dbh -> lastInsertId();				
						return $insertId;
}


function this_user_Balance($currency){
	$this->query("SELECT amount FROM balance WHERE user_id=:userId AND currency=:currency ");
						
						$this->dataBind(':userId',$_SESSION['id']);
						$this->dataBind(':currency',$currency);

						return $this->singleResult();
}

function wdr_Ticket_IRR($amnt){

	
				$this->query("INSERT INTO balance_change (user_id, action_type, currency, amount) 
							              		  VALUES (:userId,'withdraw', 'IRR' , :amount)");
							
				$this->dataBind(':userId',$_SESSION['id']);
				$this->dataBind(':amount', $amnt);
				$this->executeQuery();	
				$insertId= $this-> dbh -> lastInsertId();
				return $insertId;

}


//End of file****
}