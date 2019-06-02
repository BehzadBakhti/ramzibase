<div class="container mt-5 pt-3  ">

<?php if(isset($_SESSION['id'])){?>
<div class="row rtl">
	<div class="col-md-2 pt-3 rounded " style="background-color: white;  line-height: 32px"> 
<button class="btn-secondary btn w-100 text-right"  data-toggle="modal" data-target="#changePassword" >تغییر رمز کاربری </button>
<br>
<!-- <a   style=" font-size: 16px; text-decoration: none;" href="#" > فعالسازی اعتبار سنجی دو مرحله ای </a> -->
	</div>
	<div class="col-md-10 ">
		<div class="row rtl py-5  justify-content-center" >
			<div class="col-md-6 ">
				<h4 class="col-md-6 d-inline">
					وضعیت کاربر:
				</h4>
				<div class="col-md-6 d-inline px-5 py-1 rounded" id="userStatus" style=" font-size: 18px">
				 
				</div>
			</div>
		</div>
	<hr>
	<div class="">

		<form class="form-group px-5  row rtl" id="userDataForm">
			<div class="col-md-6">
			
						<h3 class="text-center" >
							اطلاعات کاربری
						</h3> 
			
				
						
					  <div class="input-group  mb-2 mr-sm-2">
					    <div class="input-group-prepend w-25">
					      <div class="input-group-text w-100">ایمیل:  </div>
					    </div>
					    <input type="text" class="form-control" id="emailProfile">
					  </div>

					  <div class="input-group mb-2 mr-sm-2">
					    <div class="input-group-prepend w-25">
					      <div class="input-group-text w-100">نام کاربری:</div>
					    </div>
					    <input type="text" class="form-control " id="nameProfile" required placeholder="نام کاربری">
					  </div>

					  <div class="input-group mb-2 mr-sm-2">
					    <div class="input-group-prepend w-25">
					      <div class="input-group-text w-100">تلفن همراه:</div>
					    </div>
					    <input type="text" class="form-control" id="cellPhone" required placeholder="مثال: 09122222222">
					  </div>

					  <div class="input-group mb-2 mr-sm-2">
					    <div class="input-group-prepend w-25">
					      <div class="input-group-text w-100">تلفن ثابت:</div>
					    </div>
					    <input type="text" class="form-control" id="phone" required placeholder="مثال: 02188888888">
					  </div>
			
			</div>
		

		<div class="col-md-6">
		
		
				<h3 class="text-center" >
					اطلاعات حساب بانکی
				</h3> 
		
				
						
					  <div class="input-group  mb-2 mr-sm-2">
					    <div class="input-group-prepend w-25 ">
					      <div class="input-group-text w-100">صاحب حساب:</div>
					    </div>
					    <input type="text" class="form-control" id="accountName" required placeholder="نام صاحب حساب">
					  </div>

					  <div class="input-group mb-2 mr-sm-2">
					    <div class="input-group-prepend w-25">
					      <div class="input-group-text w-100">نام بانک:</div>
					    </div>
					    <input type="text" class="form-control" id="bankName" required placeholder="نام بانک مربوطه">
					  </div>

					  <div class="input-group mb-2 mr-sm-2">
					    <div class="input-group-prepend w-25">
					      <div class="input-group-text w-100">شماره حساب:</div>
					    </div>
					    <input type="text" class="form-control" id="accountNum" required placeholder="شماره حساب">
					  </div>

					  <div class="input-group mb-2 mr-sm-2">
					    <div class="input-group-prepend w-25">
					      <div class="input-group-text w-100">شماره شبا:</div>
					    </div>
					    <input type="text" class="form-control" id="shebaNum" required placeholder="مثال: IR 6301 8000 0000 0048 2535 1538">
					  </div>

					  <div class="input-group mb-2 mr-sm-2">
					    <div class="input-group-prepend w-35">
					      <div class="input-group-text w-100">تصویر کارت ملی و کارت بانکی:</div>
					    </div>
					    <input class=" input-group-text py-0 mr-1 w-60" value="فایل را انتخاب کنید" type="file" name="imgFile" id="imgFile">
					  </div>

		</div>

			<hr> 
					<input type="button" id="setProfileDataBtn" class="secondaryBtn btn text-center"  value="ذخیره تغییرات"> 
		</form>
				<div id="chartPreloader" class="baseLoader" type="hidden" >
					<div class="spinner"></div> 
				</div>
		</div>
	</div>
</div>					
<?php } else { ?>
	
		<div class="col-md-12">
		<div class="display-4 text-center my-5 py-5"> ابتدا وارد حساب کابری خود شوید</div>
		</div>
	
<?php }?>

	
</div>
<hr>




<!-- Modal -->
<div class="modal fade rtl" id="changePassword" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center">تغییر رمز عبور</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
         
        </button>
      </div>
      <div class="modal-body">
       
		<div class="alert " style="display:none" id="passChangeAlert"></div>
			<form  class="form-group " style=" text-align: right">

				 <div class="form-group">
				    <label for="editEmail">رمز عبور پیشین</label>
				    <input type="password" class="form-control" id="oldPass" placeholder="رمز عبور پیشین">
		   		  </div>

				  <div class="form-group">
				    <label for="editPassword">رمز عبور جدید</label>
				    <input type="password" class="form-control" id="newPass" placeholder="رمز عبور جدید">
				  </div>

				  <div class="form-group">
				    <label for="editPassword">تکرار رمز عبور جدید</label>
				    <input type="password" class="form-control" id="reNewPass" placeholder="تکرار رمز عبور جدید">
				  </div>
			  
			</form>


      </div>
      <div class="modal-footer">
  
        <button type="button" class="btn btn-secondary" data-dismiss="modal">خروج</button>
        <button type="button" class="btn btn-primary" id="changePasswordBtn">تغییر رمز عبور</button>
      </div>
    </div>

  </div>
</div>

<script type="text/javascript">
	var page_nav=7;
$(document).ready( function(){

	loadProfileData();
})



$("#setProfileDataBtn").click(function(){
	$("#chartPreloader").show();
	  var fileProperty=document.getElementById("imgFile").files[0];

	  var myFormData= new FormData();
	  myFormData.append("imgFile",fileProperty);
	  myFormData.append("nameProfile",$("#nameProfile").val());
	  myFormData.append("cellPhone",$("#cellPhone").val());
	  myFormData.append("phone",$("#phone").val())
	  myFormData.append("accountName",$("#accountName").val());
	  myFormData.append("bankName",$("#bankName").val());
	  myFormData.append("accountNum",$("#accountNum").val());
	  myFormData.append("shebaNum",$("#shebaNum").val());
	 
		//console.log(myFormData.getAll("shebaNum"))
		$.ajax({
				type:"POST",
				url: "setProfileData",
				
		       data: myFormData,   
		       cache: false,
		       contentType: false,
		       enctype: 'multipart/form-data',
		       processData: false,
				success: function(output){
					if(output=='success')
					{
					 alert('ذخیره تغییرات انجام شد')
					}else{
					alert(output)
					}


				}
		});
		
		$(document).ajaxComplete(function(){
		    $("#chartPreloader").hide();
		});
		  loadProfileData();
		

});

function loadProfileData(){

	var dataArray;

		$.ajax({
					type:"GET",
					url: "getProfileData",
						
					success: function(output){
									dataArray=JSON.parse(output);
					$("#emailProfile").val(dataArray['email']);
					$("#emailProfile").attr('disabled','true');
					$("#nameProfile").val(dataArray['username']);
					$("#cellPhone").val(dataArray['phone_cell']);
					$("#phone").val(dataArray['phone'])
					$("#accountName").val(dataArray['name']);
					$("#bankName").val(dataArray['bank_name']);
					$("#accountNum").val(dataArray['account_num']);
					$("#shebaNum").val(dataArray['sheba_num']);
					if(dataArray['confirmed']=='confirmed'){
					$("#userStatus").addClass('successful')
					$("#userStatus").html('تایید شده')
					}else if(dataArray['confirmed']=='unconfirmed'){
						$("#userStatus").addClass('pending')
					$("#userStatus").html('در انتظار تایید')

					}else{
						$("#userStatus").addClass('main-red')
						$("#userStatus").html('مسدود شده')


					}

				}


		});


$(document).ajaxComplete(function(){
		    $("#chartPreloader").hide();
		});
}
//************
$("#reNewPass").focusout(function(){

	if ($("#reNewPass").val()!==$("#newPass").val()) {
		 $("#reNewPass").addClass("is-invalid");
	}else{
		 $("#reNewPass").removeClass("is-invalid");
	}
})

$("#changePasswordBtn").click(function(){
  if( $("#newPass").val()!==$("#reNewPass").val()){
    $("#passChangeAlert").html("تکرار رمز عبور صحیح نیست").show();
      return;
  }

    $.ajax({
			type:"POST",
			url:"changePass",
			data: "oldPass=" + $("#oldPass").val() +"&newPass=" +$("#newPass").val() +"&reNewPass=" +$("#reNewPass").val(),
				success: function(result){
console.log(result)
						if(result=='done'){
						pm="رمز عبور جدید با موفقیت ثبت گردید";
						$("#passChangeAlert").removeClass('alert-danger')
						$("#passChangeAlert").addClass('alert-success')
						$("#passChangeAlert").html(pm).show();
						$("#oldPass").val("")
						$("#newPass").val("")
						$("#reNewPass").val("")

						}else{
						$("#passChangeAlert").removeClass('alert-success')
						$("#passChangeAlert").addClass('alert-danger')
						$("#passChangeAlert").html(result).show();

						}
					}
		});

})

</script>