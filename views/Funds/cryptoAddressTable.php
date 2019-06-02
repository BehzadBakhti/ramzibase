<div   style="height: 215px; overflow: auto; border: 1px solid silver">
<table class="table table-sm  table-striped table-bordered" >
				<thead class="fund-thead">
					<tr>
						<th>#</th>
						<th>نام ارز</th>
						<th>آدرس جهت ارسال</th>
						<th>تاریخ ایجاد</th>
					</tr>
				</thead>
				<tbody id="myAddresses">
					<!-- php code here! -->


				</tbody>
			</table>
		</div>

<script type="text/javascript">
	
function getCryptoAddresses(){
<?php if(isset($_SESSION['id'])) { ?>
$.ajax({
					type:'post',
					url: "Funds/getCryptoAddress",

					success: function(result){
									$("#myAddresses").html(result);


								}
					});

$(document).ajaxComplete(function(){
    $("#chartPreloader").hide();
});
<?php }?>

}



</script>