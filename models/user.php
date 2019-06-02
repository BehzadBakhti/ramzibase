<?php

/**
* 
*/
class UserModel extends Model
{
	
	function Index()
	{
		return;
	}

	function profile()
	{
		
		return;
	}

	function checkIfUserExist($email_input)
	{
		$this->query("SELECT * FROM users WHERE email=:email_input LIMIT 1");
		$this->dataBind(":email_input",$email_input);


		return $this->singleResult();
	}
 

	function registerNewUser($email_input,$pass_input){
						$this->query("INSERT INTO users (`email`, `password`) values (:email,:password)");
						$this->dataBind(':email', $email_input);
						$this->dataBind(':password',$pass_input);
						$result = $this->executeQuery();

						$insertedUserId=$this ->dbh-> lastInsertId();

						$hashPass=hash('sha256',$pass_input.md5($insertedUserId));
						
						$this->query("UPDATE users SET password= :hashed WHERE id=:insertId");
						$this->dataBind(':hashed', $hashPass);
						$this->dataBind(':insertId',$insertedUserId);
						$this->executeQuery();
						
	
						$this->query("INSERT INTO fiat_accounts (user_id) VALUES ($insertedUserId)");
						$this->executeQuery();
						return $insertedUserId;

	}


function SetHash($email, $hash, $type){
	if($type=='signup'){
		$query="UPDATE users SET signup_hash= :hashed WHERE email=:email";
		$this->query($query);
	}else{
		$query="UPDATE users SET token= :hashed, token_expire=:xpr WHERE email=:email";
		$xpr=time()+3600;
		$this->query($query);
		$this->dataBind(':xpr', $xpr);
	}
						
		$this->dataBind(':hashed', $hash);
		$this->dataBind(':email', $email);
		$this->executeQuery();

}

function CheckHash($email,$hash, $type){
		if($type=='signup'){
				$query="SELECT * FROM users WHERE (email=:email AND signup_hash=:hash)";
				$this->query($query);
			}else{

				$now=time();
				$query="SELECT * FROM users WHERE (email=:email AND token=:hash AND token_expire >= :now)";
				
				$this->query($query);
				$this->dataBind(':now', $now);
			}
	
		$this->dataBind(":email",$email);
		$this->dataBind(":hash",$hash);

		return $this-> singleResult();

}

function resetPassword(){

	return;
}


function ActivateUser($email){

		$query="UPDATE users SET activation= 'active' WHERE email=:email";
	
		$this->query($query);
		$this->dataBind(':email', $email);
		$this->executeQuery();
}


function setNewPassword($email, $pass){
	$thisUser=$this-> checkIfUserExist($email);
				$hashPass=hash('sha256',$pass.md5($thisUser['id']));
						
						$this->query("UPDATE users SET password= :hashed WHERE email=:email");
						$this->dataBind(':hashed', $hashPass);
						$this->dataBind(':email',$email);
						$this->executeQuery();

}


	function checkIfPassIsCorrect($email_input,$pass_input){

						$row=$this-> checkIfUserExist($email_input);
						if(!$row){
							$error= "Email not Found, Sign Up Please!";
							return $error;

						}else{
						//print_r($row);
						$hashPass=hash('sha256',$pass_input.md5($row['id']));
							if ($row['password']==$hashPass ) {
							
								return $row;

							}else{

								
								$error= "Username and password doesn't match!";
								return $error;
							}

						}

	}


	function uploadeUserImage($newImgName){
					$this->query("UPDATE users  SET id_card_image=:imageName WHERE id=:userId");
						$this->dataBind(':imageName', $newImgName);
						$this->dataBind(':userId',$_SESSION['id']);
						$result = $this->executeQuery();

	}

function setProfileData($userData){
	$query="UPDATE users
			INNER JOIN fiat_accounts ON fiat_accounts.user_id=users.id
				 SET users.username=:username, users.phone_cell=:cellPhone, users.phone=:phone, fiat_accounts.name=:name , fiat_accounts.bank_name=:bankName, fiat_accounts.account_num=:accNum , fiat_accounts.sheba_num=:shebaNum
				 WHERE users.id=:userId";

					$this->query($query);
						$this->dataBind(':username', $userData['nameProfile']);
						$this->dataBind(':cellPhone', $userData['cellPhone']);
						$this->dataBind(':phone', $userData['phone']);
						$this->dataBind(':name', $userData['accountName']);
						$this->dataBind(':bankName', $userData['bankName']);
						$this->dataBind(':accNum', $userData['accountNum']);
						$this->dataBind(':shebaNum', $userData['shebaNum']);
						$this->dataBind(':userId',$_SESSION['id']);
						echo $this->executeQuery();
						

}


function getProfileData(){
	$query="SELECT users.email, users.username, users.confirmed, users.id_card_image, users.phone_cell, users.phone, fiat_accounts.name, fiat_accounts.bank_name, fiat_accounts.account_num, fiat_accounts.sheba_num
	FROM users
	INNER JOIN fiat_accounts 
	ON fiat_accounts.user_id=users.id
    WHERE users.id=:userId";



	$this->query($query);
						
						$this->dataBind(':userId',$_SESSION['id']);
						$result = $this->singleResult();
						return $result;

}

//End of Class Definition/****
}

