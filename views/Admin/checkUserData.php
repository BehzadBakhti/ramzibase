<h2 class="pt-2"> اطلاعات کاربر </h2>	

<div class="container">

<div class="row rtl">

	<div class="col-md-6 border">
		<div class="row rtl " >
			<div class="col-md-12 rtl" ><span>نام کاربری:</span><span id="userName"></span></div>
			<div class="col-md-12 rtl" > <span>ایمیل:</span> <span id ="userEmail"></span></div>
			<div class="col-md-12 rtl"><span>تاریخ ثبت نام:<span id="userRegTime"></span></span></div>
			<div class="col-md-12 rtl"><span>وضعیت:</span><span id="confStatus"></span></div>
			<div class="col-md-12 rtl"><span>تاریخ تایید:</span><span id="userConfTime"></span></div>
			<div class="col-md-12 rtl"><span>شماره تلفن همراه:<span id="cellPhone"></span></span></div>
			<div class="col-md-12 rtl"><span>شماره تلفن ثابت:</span><span id="phone"></span></div>


		</div>
	<hr>
	<div class="row rtl ">
		<div class="row rtl " >
			<div class="col-md-12 rtl"><span>نام صاحب حساب:<span id="accUserName"></span></span></div>
			<div class="col-md-12 rtl"><span>نام بانک:</span><span id="bankName"></span></div>
			<div class="col-md-12 rtl"><span>شماره حساب:<span id="accNo"></span></span></div>
			<div class="col-md-12 rtl"><span>شماره شبا:</span><span id="shebaNo"></span></div>

		</div>
	</div>
</div>
<div class="col-md-4 border ">
		<a href="" id='IdCardPhotoContainer' target="_blank" class="row rtl border" style="height: 300px;" >
		<img id="IdCardPhoto" src="">
		</a>
	</div>
	
	
</div>
</div>
<div  class="col-md-5 mx-auto">
	<h4>توضیح</h4>
	<textarea class="col-md-12" id="reason">
		
	</textarea>
</div>
<div>
	<input  class="btn btn-primary" type="button" name="goBack" id="goBack" value="بازگشت">
	<button class="btn btn-warning" type="button" id="notConfirm">عدم تایید کاربر</button>
	<button class="btn btn-danger" type="button" id="blockUser">مسدود کردن کاربر</button>

	<button class="btn btn-success" type="button" id="confirmUser">تایید کاربر</button>
</div>

<script type="text/javascript">

//retrive User Photo
var dataArray;
$(document).ready(function(){

	$.ajax({
				type:'GET',
				url:"admin/loadUserDataForAdmin",
				success: function(data){
		console.log(data);
		dataArray=JSON.parse(data);
			switch( dataArray['confirmed']){
				case 'confirmed':
				confSataus='تایید شده'

				break;
				case 'unconfirmed':
				confSataus='بررسی نشده'
				break;
				case 'blocked':
				confSataus='مسدود شده'
				break;
				case 'notconfirm':
				confSataus='تایید نشده'
				break;
			}




		$('#userName').html(dataArray['username']);
		$('#userEmail').html(dataArray['email']);
		$('#userRegTime').html(dataArray['register_time']);

		$('#confStatus').html(confSataus);

		$('#userConfTime').html(dataArray['confirm_time']);
		$('#cellPhone').html(dataArray['phone_cell']);
		$('#phone').html(dataArray['phone']);

		$('#accUserName').html(dataArray['name']);
		$('#bankName').html(dataArray['bank_name']);
		$('#accNo').html(dataArray['account_num']);
		$('#shebaNo').html(dataArray['sheba_num']);

			imagePath="views/Users/user_idcards/"+dataArray['id_card_image'];
		$('#IdCardPhoto').attr("src", imagePath);
		$("#IdCardPhotoContainer").attr('href', imagePath);

		}

	})


});


$('#goBack').on('click', function(){

			$.ajax({
				type:'GET',
				url:"admin/manageUsers",
				success: function(data){
	 	
		$("#mainBodyAdmin").html(data);

		}
	})
});

$('#confirmUser').on('click', function(){
response=judgeUser('confirmed');
/*
if(response==null)
alert("حساب کاربری تایید شد");
*/
});


$('#blockUser').on('click', function(){
response=judgeUser('blocked');
/*
if(response==null)
alert("حساب کاربری مسدود شد");
*/
});

$('#notConfirm').on('click', function(){
response=judgeUser('notConfirm');
/*
if(response==null)
alert("حساب کاربری مسدود شد");
*/
});

function judgeUser(decision){
			$.ajax({
				type:'POST',
				url:"admin/judgeUser",
				data: "userEmail="+dataArray['email'] +"&decision="+decision +"&reason="+$("#reason").val(),
				success: function(data){
					alert(data)
				// return data;

		}
	})

}


</script>
