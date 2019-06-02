<?php 

/**
* 
*/
class Users extends Controller
{
	protected function Index(){

		$viewmodel=new UserModel();
		$this -> returnView($viewmodel->Index(), true);
	}
protected function loginSignup(){

			// if(!($this->Check_reCAPTCHA() ) ){
			// 	echo "<h5>شما روبات هستید!</h5>";
			// 	return;
				
			// }


		$viewmodel=new UserModel();
			//	$this -> returnView($viewmodel->login(), false);
				$output="";
				if($_POST['email']==""){
					$output= "لطفاً ایمیل خود را وارد نمایید!";
				}else if ($_POST['password']=="") {
					$output="لظفاً رمز عبور را وارد کنید!";
				}else if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) {
			  		$output="آدرس ایمیل نا معتبر است!";
				}else if($_POST['loginActive']==0){
				//check for the Existing Email Adresses
					//then sign up user
					if($_POST['rules']==0){
						return;
					}
					$result=$viewmodel-> checkIfUserExist($_POST['email']);	
						if (($result['id'])>0) {
						    $output= "این ایمیل قبلاً ثبت شده است!";
						}else{
							//register the user and retrive its id
							$userId=$viewmodel-> registerNewUser($_POST['email'],$_POST['password']);
							if(is_numeric($userId)){

								$hash=$this->NewToken();
								$viewmodel-> SetHash($_POST['email'], $hash, 'signup');
								$msg="<h4> This email has been sent in order to confirm your account at www.ramzibase.com.</h4>";
								$msg.="<p> If you have not registered there, just <strong> ignore </strong> this email.</p>";
								$msg.="<p> in order to confirm your account, click on the link below: </p>";
								$msg.="<a href='http://www.ramzibase.com/users/verify/".$_POST['email']."/".$hash."' > <h4>Verify My Email Account</h4></a>";
							 $this->SendTokenToUser($_POST['email'],$msg,'signup');

								$output = 'حساب کاربری شما با موفقیت ثبت شد، لینک فعالسازی به ایمیل شما ارسال گردید!';

							}else{

								$output = $userId;
							}
							
							
						}



				}else if($_POST['loginActive']==1){
						//login user

					$result=$viewmodel-> checkIfUserExist($_POST['email']);	
								if (($result['id'])>0) {
									$output=$viewmodel-> checkIfPassIsCorrect($_POST['email'], $_POST['password']);
									
									if(is_array($output)){
										$_SESSION['id']=$output['id'];
										$_SESSION['email']=$output['email'];
										$_SESSION['confirmed']=$output['confirmed'];								
										$_SESSION['user_level']=$output['user_level'];
									
										$output="";
									
									}else{

										$output= "رمز عبور اشتباه است!";
									
									}
									
				   			 		
								}else{

									$output = 'کاربر پیدا نشد، لطفاً ابتدا ثبت نام کنید!';
											
							}
								

					}

					echo $output;

	}


protected function verify(){
	$viewmodel=new UserModel();
		if(isset($_GET['token']) AND $_GET['token']!=""){

			$result= $viewmodel-> CheckHash($_GET['email'],$_GET['token'], 'signup');
				if(!empty($result)){
				$viewmodel-> ActivateUser($_GET['email']);
				header("location: http://ramzibase.com");

				}else{

				header("location: http://ramzibase.com/wrong");
				}

		}else{

		header("location: http://ramzibase.com/wrong");
		}
}


protected function forgotPassword(){

		$viewmodel=new UserModel();
			//	$this -> returnView($viewmodel->login(), false);
				$output="";
				if($_POST['email']==""){
					$output= "لطفاً ایمیل خود را وارد نمایید!";
				}else if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) {
			  		$output="آدرس ایمیل نا معتبر است!";
				}else {
				//check for the Existing Email Adresses
				
				$result=$viewmodel-> checkIfUserExist($_POST['email']);	
						if (($result['id'])>0) {

					//register the user and retrive its id
							
								$hash=$this->NewToken();
								$viewmodel-> SetHash($_POST['email'], $hash, 'rest');
								$msg="<h4> This email has been sent in order to <Strong>RESET</strong> your password at www.ramzibase.com.</h4>";
								$msg.="<p> If you have not requested password reset, just ignore this email.</p>";
								$msg.="<p> in order to reset your password, click on the link below: </p>";
								$msg.="<a href='http://www.ramzibase.com/users/resetPassword/".$_POST['email']."/".$hash."' > <h4>Reser My Account Password</h4></a>";
							$this->SendTokenToUser($_POST['email'],$msg,'reset');

							$output = 'ایمیل تغییر رمز عبور برای شما ارسال گردید، پوشه Spam را نیز بررسی نمایید.';

						}else{
								
						}

				}

					echo $output;

	}

protected function resetPassword(){
	$viewmodel=new UserModel();
	
		if(isset($_GET['token']) AND $_GET['token']!=""){
			
			$result= $viewmodel-> CheckHash($_GET['email'],$_GET['token'], 'reset');
				if(!empty($result)){

				$this-> returnView($viewmodel->resetPassword(), true);
				
				}else{

				header("location: http://ramzibase.com/wrong");
				}

		}else{

		header("location: http://ramzibase.com/wrong");
		}
}


protected function resetPass(){
	 $myUserModel= new UserModel();
	 $email=$_POST['email'];
	
	 	if($_POST['newPass']==$_POST['reNewPass']){
			$myUserModel-> setNewPassword($email, $_POST['newPass']);
			$myUserModel->  SetHash($email, "", "reset");
			echo "done";
		}else{

		echo 'خطا در داده های ورودی!';

		}

}


protected function logOut(){

	session_unset();
	header('Location:'.ROOT_URL);
}


protected function profile(){

		$viewmodel=new UserModel();
		$this -> returnView($viewmodel->profile(), true);

}

protected function setProfileData(){

	$myUserModel=new UserModel();
	$fileuploade= $this->uploadeUserImage($_FILES);
		if($fileuploade!='success'){
				echo $fileuploade;
			}
		$output=$myUserModel->setProfileData($_POST);
	return;
}


protected function getProfileData(){

	$myUserModel=new UserModel();
	$output=$myUserModel->getProfileData();

		if($output['id_card_image']==""){
			$output['id_card_image']="false";
		}else{
			$output['id_card_image']="true";
		}

	echo json_encode($output);
}

protected function uploadeUserImage($imgFileObj){
	
		$viewmodel=new UserModel();
			if(isset($imgFileObj['imgFile'])){
				
				$imgFile=$imgFileObj['imgFile'];
				$fileName=$imgFileObj['imgFile']['name'];
				$fileTmpName=$imgFileObj['imgFile']['tmp_name'];
				$fileSize=$imgFileObj['imgFile']['size'];
				$fileError=$imgFileObj['imgFile']['error'];
				$fileType=$imgFileObj['imgFile']['type'];
				$fileExt=explode('.', $fileName);
				$fileExtActual=strtolower(end($fileExt));
				$allowed = array('jpg' ,'jpeg' );
						if (in_array($fileExtActual, $allowed)) {
							if ($fileError===0) {
								if ($fileSize < 500000) {
									$newFileName=uniqid('', true).".".$fileExtActual;

									$fileDest="views/Users/user_idcards/".$newFileName;
									move_uploaded_file($fileTmpName, $fileDest);
									$viewmodel-> uploadeUserImage($newFileName);
									
									return "success";
								}else{
									return "حجم فایل بیشتر از حد مجاز است، حدااکثر حجم مجاز 500 KB می‌باشد";
								}
							}else{
								return "خطایی رخ داده است.";
							}
						}else{
							return "فرمت تصویر باید jpeg باشد";
						}

			}else{
				$output=$viewmodel->getProfileData();
				if($output['id_card_image']==""){
				return "فایل تصویر کلرت ملی و کارت بانکی را آپلود نمایید.";
				}
			}

		} 

protected function changePass(){
	 $myUserModel= new UserModel();
	 $email=$_SESSION['email'];

	 $res=$myUserModel-> checkIfPassIsCorrect($email, $_POST['oldPass']);
	// print_r($res);
	 if(isset($res['id'])){
	 	if($_POST['newPass']==$_POST['reNewPass']){
			$myUserModel-> setNewPassword($email, $_POST['newPass']);
			echo "done";
		}

	 }else{

	 	echo 'رمز عبور پیشین صحیح نیست!';

	 }

}
## internl use function############################################################

private function NewToken(){

	return hash('sha256',uniqid('', true));

}

private function SendTokenToUser($email,$txt,$purpose){
	// $purpose: 'signup' or 'reset'
		$to = $email;
	if($purpose=='signup'){
		$subject = 'Confirm Email Address';
	}else{
		$subject = 'Reste Your Password';
	}


	$from = 'admin@ramzibase.com';
	 
	// To send HTML mail, the Content-type header must be set
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	 
	// Create email headers
	$headers .= 'From: '.$from."\r\n";
	 
	// Compose a simple HTML email message
	$message = '<html><body>';
	$message .= $txt;
	$message .= '</body></html>';
	 
	// Sending email
		
	return mail($to, $subject, $message, $headers);
		   
}

private function Check_reCAPTCHA(){

	$secretKey="6Lf8W1IUAAAAAFWYmsVySiP22zdTYATOy30za-Ji";
	$responseKey=$_POST['g-recaptcha-response'];
	$userIP=$_SERVER['REMOTE_ADDR'];
	$url="https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$responseKey&remoteip=$userIP";
	$response=file_get_contents($url);
	$response=json_decode($response);
	if($response->success){
		return true;
		//verified
	}else{
		//not 
		return false;
	}
}

//End of Class Definition/****
}

 ?>