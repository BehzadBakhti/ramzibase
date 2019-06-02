<?php 

?>

<div class="container-fluid mt-5 ">
	<div class="row rtl border">
		<div class="col-md-2 border admin-dashboard ">
			<div class="admin-dashboard " style="padding:10px 0px; color: white;"> <h4> داشبرد</h4></div>
			<input class="admin-dashboard-btn" type="button" id="announcement" value="اطلاعیه جدید">
			<input class="admin-dashboard-btn" type="button" id="posts" value="افزودن پست">
			<input class="admin-dashboard-btn" type="button" id="userMessages" value="پیام های کاربران">
			<input class="admin-dashboard-btn" type="button" id="tickesIRR" value="مدیریت درخواست های ریالی">
			<input class="admin-dashboard-btn" type="button" id="tickesCrypto" value="مدیریت درخواست های ارز رمزی">
			<input class="admin-dashboard-btn" type="button" id="manageUsers" value="مدیریت کاربران جدید">
			<?php if(isset($_SESSION['user_level']) AND $_SESSION['user_level']=='owner'){?>
				<input class="admin-dashboard-btn" type="button" id="highLevelOps" value="عملیات ویژه">
			<?php }?>
		</div>
		<div class="col-md-10 border" id="mainBodyAdmin" style="min-height:100vh;">
			
		</div>
	</div>
</div>

<script type="text/javascript">
	var page_nav=4;
$(".admin-dashboard .admin-dashboard-btn").click(function(){

		$.ajax({
				type:'GET',
				url:"admin/"+$(this).attr('id'),
				success: function(data){
	 	
		$("#mainBodyAdmin").html(data);

		}

	})



       
})


</script>

