<table class="table table-sm  table-striped table-bordered">
				<thead class="fund-thead">
					<tr>
						<th>
							#
						</th>
						<th>
							نام ارز
						</th>
						<th>
							موجودی
						</th>
						<th>
							موجودی قابل برداشت
						</th>
						<th>
							تاریخ آخرین تغییر
						</th>
					</tr>
				</thead>
				<tbody id="myBalance">
					<!-- php code here! -->


				</tbody>
			</table>

<script type="text/javascript">
	
function updateBalance(){

$.ajax({
					type:'post',
					url: "TableUpdates/myBalanceTable",
					

					success: function(result){
						
									$("#myBalance").html(result);


								}
					});

}



</script>
