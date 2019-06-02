<?php


/**
* 
*/
class AdminModel extends Model
{
	
	function index()
	{
		return;
	}


function adminUsersTable($group,$record_per_page){
	 
		 $page = '';  
		 $output = '';  
		 if(isset($_POST["page"]))  
		 {  
		      $page = $_POST["page"];  
		 }  
		 else  
		 {  
		      $page = 1;  
		 } 

			$start_from = ($page - 1)*$record_per_page;  

			if($group=='all'){
				$page_query = "SELECT * FROM users ";
				$this->query("SELECT * FROM users LIMIT $start_from , $record_per_page");
				  
				
			}else{
				$page_query = "SELECT * FROM users WHERE confirmed= '$group'"; 
				$this->query("SELECT * FROM users WHERE confirmed='$group' LIMIT $start_from , $record_per_page");
				 

			}

			$result= $this-> resultSet();
			//print_r($result);
			$totlaRows=sizeof($result);
			/// create table

			for($i=0;$i<$totlaRows;$i++){
				if (isset($result[$i])) {
						$row=$result[$i];
						switch( $row['confirmed']){
								case 'confirmed':
								$confSataus='تایید شده';
								break;
								case 'unconfirmed':
								$confSataus='بررسی نشده';
								break;
								case 'notconfirm':
								$confSataus='تایید نشده';
								break;
								case 'blocked':
								$confSataus='مسدود شده';
								break;
							}
					  	$output.='
						<tr class="tableRow" id="rowId_'.$i.'">
					      <td> 
					      	<div class="tableCell">
					      	'.$row["email"].'
					     	 </div>
					      </td>
					      <td>
					      	<div class="tableCell">
					      	'.$row["username"].'
							</div>
					      </td>
					      <td>
						      <div class="tableCell">
						      '.$confSataus.'
						      </div>
					      </td>

					     <td>
						      <div class="tableCell">
						      '.$row["register_time"].'
						      </div>
					      </td>

					   <td>
						      <div class="tableCell">
						      '.$row["confirm_time"].'
						      </div>
					      </td>
					    </tr>
					  	';
					  }

					}

			//*******************************
			$output.='|||';

			 $this-> query($page_query);

			 $total_records =sizeof( $this-> resultSet()); 

			 $total_pages = ceil($total_records/$record_per_page);  
			 for($i=1; $i<=$total_pages; $i++)  
			 {  
			      $output .= '<li  class="page-link paginationlink" id='.$i.'>'.$i.'</li>';  
			 }  
		//*************************
		return $output;
	}


function UserMsgTable($group,$record_per_page){
	 
		 $page = '';  
		 $output = '';  
		 if(isset($_POST["page"]))  
		 {  
		      $page = $_POST["page"];  
		 }  
		 else  
		 {  
		      $page = 1;  
		 } 

			$start_from = ($page - 1)*$record_per_page;  

			if($group=='all'){
				$page_query = "SELECT * FROM contact_us ";
				$this->query("SELECT * FROM contact_us LIMIT $start_from , $record_per_page");
				  
				
			}else{
				$page_query = "SELECT * FROM contact_us WHERE status= '$group'"; 
				$this->query("SELECT * FROM contact_us WHERE status='$group' LIMIT $start_from , $record_per_page");
				 

			}

			$result= $this-> resultSet();
			//print_r($result);
			$totlaRows=sizeof($result);
			/// create table

			for($i=0;$i<$totlaRows;$i++){
				if (isset($result[$i])) {
						$row=$result[$i];
						switch( $row['status']){
								case 'new':
								$msgSataus='جدید';
								break;
								case 'seen':
								$msgSataus='مشاهده شده';
								break;
								case 'answered':
								$msgSataus='پاسخ داده شده';
								break;
								
							}
					  	$output.='
						<tr class="tableRow" id="msgId_'.$row["id"].'">
					      <td> 
					      	<div class="tableCell">
					      	'.$row["email"].'
					     	 </div>
					      </td>
					      <td>
					      	<div class="tableCell">
					      	'.$row["name"].'
							</div>
					      </td>
					      <td>
						      <div class="tableCell">
						      '.$msgSataus.'
						      </div>
					      </td>

					     <td>
						      <div class="tableCell">
						      '.$row["submit_date"].'
						      </div>
					      </td>

					    </tr>
					  	';
					  }

					}

			//*******************************
			$output.='|||';

			 $this-> query($page_query);

			 $total_records =sizeof( $this-> resultSet()); 

			 $total_pages = ceil($total_records/$record_per_page);  
			 for($i=1; $i<=$total_pages; $i++)  
			 {  
			      $output .= '<li  class="page-link paginationlink" id='.$i.'>'.$i.'</li>';  
			 }  
		//*************************
		return $output;
	}


function loadMsgData($MsgNumber){

$MsgId=explode('_', $MsgNumber)[1];
	$query1="SELECT * FROM contact_us WHERE id = :MsgId";
			$this-> query($query1);
			$this-> dataBind(':MsgId',$MsgId);
			$msgResult= $this->singleResult();


			return $msgResult;
		


}
function responseUserMsg($MsgId, $responseMsg){
$MsgStatus=($responseMsg=='')?"seen":"answered";
	$query3="UPDATE contact_us SET status=:MsgStatus , response=:responseMsg WHERE id=$MsgId";
			$this-> query($query3);
			$this-> dataBind(':MsgStatus',$MsgStatus);
			$this-> dataBind(':responseMsg',$responseMsg);
			$this-> executeQuery();
}

function loadUserDataForAdmin($userEmailToCheck){


	$query1="SELECT id, email, username, id_card_image ,register_time ,confirm_time ,phone_cell ,phone ,confirmed FROM users WHERE email = :userEmail LIMIT 1";
			$this-> query($query1);
			$this-> dataBind(':userEmail',$userEmailToCheck);
			$userResult= $this->singleResult();

	$query2="SELECT name, bank_name, account_num, sheba_num FROM fiat_accounts WHERE user_id = :userId LIMIT 1";
			$this-> query($query2);
			$this-> dataBind(':userId',$userResult['id']);
			$fiatAccResult= $this->singleResult();
		if(isset($fiatAccResult['name'])){
			return array_merge($userResult,$fiatAccResult);
		}else{
			return $userResult;
		}


}


function adminTicketsIRR($group,$tType,$record_per_page){

		 $page = '';  
		 $output = '';  
			 if(isset($_POST["page"]))  
				 {  
				      $page = $_POST["page"];  
				 }  
			 else  
				 {  
				      $page = 1;  
				 } 

			$start_from = ($page - 1)*$record_per_page;  

		 $queryPage=
			"SELECT  
				 balance_change.id, balance_change.amount , balance_change.request_date,balance_change.ticket_status,
				 fiat_accounts.name, fiat_accounts.bank_name, fiat_accounts.account_num, fiat_accounts.sheba_num, 
				 users.email 
			FROM balance_change 
			LEFT JOIN fiat_accounts ON  balance_change.user_id = fiat_accounts.user_id 
			LEFT JOIN users ON balance_change.user_id=users.id 
			WHERE (action_type='$tType' AND currency='IRR' AND ticket_status= '$group')";

		 $queryTicket = $queryPage."LIMIT $start_from , $record_per_page";

			
			$this->query($queryTicket);

			$resultTiket= $this-> resultSet();

						

			$totlaRows=sizeof($resultTiket);
			/// create table

			for($i=0;$i<$totlaRows;$i++){

				if (isset($resultTiket[$i])) {
						$row=$resultTiket[$i];

								if($row['amount']<10000000){
			 						//$wdr_fee=$row['amount']*(WDR_IRR_FEE);
			 						$wdr_fee=0;
							   	}else{
							   		$wdr_fee=0;
							   	}
							   	
						switch( $row['ticket_status']){
								case 'started':
								$ticketSataus='جدید';
								break;
								case 'operated':
								$ticketSataus='در دست اقدام';
								break;
								case 'done':
								$ticketSataus='نهایی شده';
								break;
							}


					  	$output.='
						<tr class="tableRow" id="rowId_'.$row["id"].'">
					      <td> 
					      	<div class="tableCell">
					      	'.$row["email"].'
					     	 </div>
					      </td>
					      <td>
					      	<div class="tableCell">
					      	'.$row["name"].'
							</div>
					      </td>
					      <td>
						      <div class="tableCell">
						      '.$row["bank_name"].'
						      </div>
					      </td>

					     <td>
						      <div class="tableCell">
						      '.$row["account_num"].'
						      </div>
					      </td>

					    	<td>
						      <div class="tableCell">
						      '.$row["sheba_num"].'
						      </div>
					      	</td>
					      	<td>
						      <div class="tableCell">
						      '.($row['amount']-$wdr_fee).'
						      </div>
					      	</td>
					      	<td>
						      <div class="tableCell">
						      '.$row["request_date"].'
						      </div>
					      	</td>
					      	
					      	<td>
						      <div class="tableCell">
						      '.$ticketSataus.'
						      </div>
					      	</td>

					      	<td>
						      <div class="tableCell ">
						      <input class="selectCheck" type ="checkbox">
						      </div>
					      	</td>
					      	
					    </tr>
					  	';
					  }

					}

			//*******************************
			$output.='|||';

			 $this-> query($queryPage);

			 $total_records =sizeof( $this-> resultSet()); 

			 $total_pages = ceil($total_records/$record_per_page);  
			 for($i=1; $i<=$total_pages; $i++)  
			 {  
			       $output .= '<li  class="page-link paginationlink" id='.$i.'>'.$i.'</li>';  
			 }  

		//*************************
		return $output;
}

function adminTicketsCrypto($group,$tType,$record_per_page){

		 $page = '';  
		 $output = '';  
			 if(isset($_POST["page"]))  
				 {  
				      $page = $_POST["page"];  
				 }  
			 else  
				 {  
				      $page = 1;  
				 } 

			$start_from = ($page - 1)*$record_per_page;  

		 $queryPage=
			"SELECT  
				balance_change.id, balance_change.amount , balance_change.request_date, balance_change.ticket_status,balance_change.currency,
					crypto_address.address, 
					users.email 
			 FROM balance_change 
			 JOIN crypto_address ON  balance_change.crypto_adrs_id = crypto_address.id 
			 JOIN users ON balance_change.user_id=users.id 
           	 WHERE (balance_change.action_type='$tType'  
           	 		AND balance_change.currency<>'IRR' 
           	 		AND ticket_status= '$group')";

		 $queryTicket = $queryPage."LIMIT $start_from , $record_per_page";

			
			$this->query($queryTicket);

			$resultTiket= $this-> resultSet();



			$totlaRows=sizeof($resultTiket);
			/// create table

			for($i=0;$i<$totlaRows;$i++){

				if (isset($resultTiket[$i])) {
						$row=$resultTiket[$i];
						switch( $row['ticket_status']){
								case 'started':
								$ticketSataus='جدید';
								break;
								case 'done':
								$ticketSataus='نهایی شده';
								break;
							}


					  	$output.='
						<tr class="tableRow" id="rowId_'.$row["id"].'">
					      <td> 
					      	<div class="tableCell">
					      	'.$row["email"].'
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
						      '.$row["amount"].'
						      </div>
					      	</td>
					      	<td>
						      <div class="tableCell">
						      '.$row["request_date"].'
						      </div>
					      	</td>
					      	
					      	<td>
						      <div class="tableCell">
						      '.$ticketSataus.'
						      </div>
					      	</td>
							<td>
						      <div class="tableCell ">
						      <input class="selectCheck" type ="checkbox">
						      </div>
					      	</td>
					      	
					    </tr>
					  	';
					  }

					}

			//*******************************
			$output.='|||';

			 $this-> query($queryPage);

			 $total_records =sizeof( $this-> resultSet()); 

			 $total_pages = ceil($total_records/$record_per_page);  
			 for($i=1; $i<=$total_pages; $i++)  
			 {  
			       $output .= '<li  class="page-link paginationlink" id='.$i.'>'.$i.'</li>';  
			 }  

		//*************************
		return $output;
}


function addressAmountToSendCoin($ticketIdArray){
	$query="SELECT balance_change.amount, crypto_address.address FROM balance_change
			JOIN crypto_address ON balance_change.crypto_adrs_id=crypto_address.id
			WHERE balance_change.id=:ticketId AND balance_change.ticket_status<> 'done' ";
			$this-> query($query);
	$i=0;
	$addrAmntPair="";
	foreach ($ticketIdArray as $ticketId) {
		$thisId=explode('_', $ticketId)[1];
				$this-> dataBind(':ticketId',$thisId);
				$addrAmnt=$this->singleResult();
				$addrAmntPair.= $addrAmnt['address'].','. $addrAmnt['amount']."_";
				$i++;
			}
		return	$addrAmntPair;

}

function TransactionSuccessful($ticketIdArray){

	for ($i=0; $i < sizeof($ticketIdArray) ; $i++) { 
		# code...
	

	$thisId=explode('_', $ticketIdArray[$i])[1];
	$query="UPDATE balance_change SET ticket_status= 'done' , action_date=CURRENT_TIMESTAMP
		WHERE id=$thisId";
			$this-> query($query);
			$this-> executeQuery();

			$query2="SELECT crypto_adrs_id FROM balance_change WHERE id=$thisId";
			$this-> query($query2);
			$res=$this-> singleResult();

			$adrs_id= $res['crypto_adrs_id'];

			$query3="UPDATE crypto_address SET used= 1 WHERE id=$adrs_id";
			$this-> query($query3);
			$this-> executeQuery();

	}

}

function confirmManualDepositIRR($ticketId){
	$query="UPDATE balance_change SET ticket_status= 'done' , action_date=CURRENT_TIMESTAMP
		WHERE id=$ticketId";
			$this-> query($query);
			$this-> executeQuery();

			$query2="SELECT user_id, amount FROM balance_change WHERE id= $ticketId";
			$this-> query($query2);
			return $this-> singleResult();


}



function underOperationTicketIRR($ticketId){

	$query="UPDATE balance_change SET ticket_status= 'operated' , action_date=CURRENT_TIMESTAMP
		WHERE id=$ticketId";
			$this-> query($query);
			$this-> executeQuery();

}


function ticketDoneIRR($ticketId){

	$query="UPDATE balance_change SET ticket_status= 'done' , action_date=CURRENT_TIMESTAMP
		WHERE id=$ticketId";
			$this-> query($query);
			$this-> executeQuery();

	}


function judgeUser($userEmail, $decision){
			$query="UPDATE users SET confirmed= '$decision' , confirm_time=CURRENT_TIMESTAMP
					WHERE email='$userEmail'";
			
				//$this-> dataBind(':userEmail',$userEmail);
				$this-> query($query);
				$out1=$this-> executeQuery();

			$query2="UPDATE orders SET authorization= '$decision' 
					 WHERE user_id=(SELECT id FROM users WHERE email='$userEmail')";
			
				//$this-> dataBind(':userEmail',$userEmail);
				$this-> query($query2);
				$out2=$this-> executeQuery();	
return $query;
	}

	function freezCoin($arr){
	$query="UPDATE config_data SET IRR=:irrFrz, BTC=:btcFrz , ETH=:ethFrz , BCH=:bchFrz, LTC=:ltcFrz ";
	$this->query($query);
	$this->dataBind(':irrFrz',$arr['irrFreez']);
	$this->dataBind(':btcFrz',$arr['btcFreez']);
	$this->dataBind(':ethFrz',$arr['ethFreez']);
	$this->dataBind(':bchFrz',$arr['bchFreez']);
	$this->dataBind(':ltcFrz',$arr['ltcFreez']);
	return $this->executeQuery();

}


//End of file*****
}