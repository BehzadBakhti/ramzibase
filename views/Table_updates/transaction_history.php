
				<div class="col-sm-12 rtl">
					<span  ><strong>معاملات اخیر</strong></span>
				</div>
				<div class="col-sm-12">
					<table class="table table-sm  table-striped table-bordered" >

							  <thead class="thead-dark">
							    <tr>
							     
							      
							      <th scope="col">تاریخ</th>
							      <th scope="col">مقدار</th>
							      <th scope="col">جفت ارز</th>
							      <th scope="col">قیمت</th>
							      <th scope="col">مجموع</th>
							    </tr>
							  </thead>
							  <tbody id="transactionHistory">

							  </tbody>
							</table>
				</div>


<script type="text/javascript">
						
	function transactionHistory(){

	$.ajax({
				type:'get',
				url: 'TableUpdates/tradeBook',
				

				success: function(result){
								$("#transactionHistory").html(result);

							}
	});

}
</script>