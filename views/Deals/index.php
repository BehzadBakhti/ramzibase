


<div class="container-fluid mt-5 pt-2">

	<div class="row ">
		<div class="col-lg-7 col-md-12  py-1 ">
			<?php require('price_chart.php'); ?>
			<?php require("views/Table_updates/transaction_history.php");?>
		</div>

		<div class="col-lg-5 col-md-12  py-1">
			<div><?php echo date("Y M d H:i",time());?></div>
				<div class="col-sm-12 " >
					<?php require("add_order.php");?>
				</div>
				<div class="col-sm-12">
					<?php require("views/Table_updates/orderBook.php");?>
					
				</div>

					<div class="col-sm-12">
						<?php require("views/Table_updates/active_orders.php");?>
						
					</div>

			
		</div>
	</div>

</div>

<script type="text/javascript">
var page_nav=2;
$(document).ready(function()
 {
 	loadPriceChart();
	transactionHistory();
 	updateBalance();
 	towTables();
 	setInterval("towTables()",20000);
 	userActiveOrdersView();
 
		
})
</script>


