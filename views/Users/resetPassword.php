<?php 

?>
<div class="container my-5 py-5 rtl justify-content-center">
<h1></h1>

<div class="col-sm-5 mx-auto">


<form  class="form-group " style=" text-align: right">
				<div class="alert " style="display:none" id="passChangeAlert"></div>
				

				  <div class="form-group">
				    <label for="editPassword">رمز عبور جدید</label>
				    <input type="password" class="form-control" id="newPass" data-container="body" data-toggle="popover" data-placement="top" data-content="رمز عبور بایستی شامل 6 کاراکتر یا بیشتر باشد" placeholder="رمز عبور جدید">
				  </div>

				  <div class="form-group">
				    <label for="editPassword">تکرار رمز عبور جدید</label>
				    <input type="password" class="form-control" id="reNewPass" placeholder="تکرار رمز عبور جدید">
				  </div>
			  
			</form>
			<button type="button" class="my-3 btn btn-lg btn-primary" id="resetPasswordBtn">تغییر رمز عبور</button>
</div>
</div>



<script type="text/javascript">
	
$("#reNewPass").focusout(function(){

	if ($("#reNewPass").val()!==$("#newPass").val()) {
		 $("#reNewPass").addClass("is-invalid");
	}else{
		 $("#reNewPass").removeClass("is-invalid");
	}
})

$("#resetPasswordBtn").click(function(){
	if(!passValidity("#newPass")){
			$("#newPass").focus()
 			$("#newPass").addClass("is-invalid");
			$("#newPass").popover('show')
			return;
		}else{
			$("#newPass").removeClass("is-invalid");
			$("#newPass").popover('hide')
		}

   if( $("#newPass").val()!==$("#reNewPass").val()){
    $("#passChangeAlert").html("تکرار رمز عبور صحیح نیست").show();
      return;
  }
email='<?php echo $_GET['email']; ?>';
    $.ajax({
			type:"POST",
			url:"../../../users/resetPass",
			data: "email=" + email +"&newPass=" +$("#newPass").val() +"&reNewPass=" +$("#reNewPass").val(),
				success: function(result){

						if(result=='done'){
						pm="رمز عبور جدید با موفقیت پبت گردید";
							alert(pm);
							window.location.assign("<?php echo ROOT_URL;?>home");
						}else{
							$("#passChangeAlert").removeClass('alert-success')
							$("#passChangeAlert").addClass('alert-danger')
							$("#passChangeAlert").html(result).show();
						}
					}
		});
})




</script>