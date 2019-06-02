<h2 class="pt-2">جزئیات پیام کاربر</h2>

<div class=" col-md-10 rtl input-group border"> 
	<div class="col-md-5 m-3 ">
		<div class="row my-2">
			<div class="mx-3" > نام فرستنده: </div>
			<div id="senderName"></div>
		</div>
		<div class="row my-2 ">
			<div class="mx-3" > ایمیل: </div>
			<div id="senderEmail" ></div>
		</div>
		<div class="row  my-2">
			<div class="mx-3" >تاریخ دریافت </div>
			<div id="recieveDate" ></div>
		</div>
	

	</div>
	<div class="col-md-12 mx-auto">
		<h4>متن پیام</h4>
		<div class="col-md-12 text-right  p-3 border rounded" id='MsgBody' style="background-color: #F9F9F9; min-height: 150px"></div>
		
	</div>
	<div class="col-md-12 mx-auto my-3">
		<h4>متن پاسخ</h4>
		<textarea class="col-md-12 text-right  p-3 border rounded" id='ResponseBody' style="background-color: #FFF; min-height: 150px"></textarea>
		
	</div>
	<div class="col-md-10 my-3">
		<button class="btn btn-primary" id="goBackBtn">بازگشت</button>
		<button class="btn btn-danger" id="sendResponse">ارسال پاسخ</button>
	</div>
</div>


<script type="text/javascript">
	var MsgDataArray;
$(document).ready(function(){

	$.ajax({
				type:'GET',
				url:"admin/loadMsgData",
				success: function(data){
		
		MsgDataArray=JSON.parse(data);
	
		$('#senderName').html(MsgDataArray['name']);
		$('#senderEmail').html(MsgDataArray['email']);
		$('#MsgBody').html(MsgDataArray['message']);

		$('#recieveDate').html(MsgDataArray['submit_date']);
		$("#ResponseBody").html(MsgDataArray['response']);
		
		}

	})


});


$('#goBackBtn').on('click', function(){

			$.ajax({
				type:'GET',
				url:"admin/userMessages",
				success: function(data){
	 	
		$("#mainBodyAdmin").html(data);

		}
	})
});


$('#sendResponse').on('click', function(){
console.log(MsgDataArray);
			$.ajax({
				type:'POST',
				url:"admin/responseUserMsg",
				data:"senderEmail="+MsgDataArray['email']+"&ResponseBody="+ $("#ResponseBody").val() +"&MsgId="+ MsgDataArray['id'],
				success: function(output){
	 	console.log(output)

		}
	})
});
</script>