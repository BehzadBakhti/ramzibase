<div class="row rtl">

						<div class="col-sm-12 ">
							<span ><strong>سفارش های فعال من</strong></span>
						</div>

						<div class="col-sm-12">

						<table class="table table-sm  table-striped table-bordered" >

							  <thead class="thead-dark">
							    <tr>
							     
							      <th scope="col">نوع سفارش</th>
							      <th scope="col">جفت ارز</th>
							      <th scope="col">مقدار</th>
							      <th scope="col">قیمت</th>
							      <th scope="col">تاریخ</th>
							      <th scope="col">عملیات</th>
							    </tr>
							  </thead>
							  <tbody id="activeOrders">

							  <!---PHP FILLS HERE-->


							  </tbody>
							</table>
						</div>
					</div>


<div class="modal rtl" tabindex="-1" role="dialog" id="cancelOrderConf">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle">تایید حذف سفارش</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p id="modalText">سفارش حذف شود؟</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">خروج</button>
        <button type="button" class="btn btn-warning " id="cancelOrder"  data-dismiss="modal">حذف سفارش</button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
						
	function userActiveOrdersView(){
	<?php if(isset($_SESSION['id'])){?>
	var userId=<?php  echo $_SESSION['id']; }?>;
	$.ajax({
				type:'post',
				url: 'TableUpdates/userActiveOrders',
				data: "pair="+$('#pair').val() + "&userId="+ userId,

				success: function(result){
								$("#activeOrders").html(result);

							}
	});

}

var thisOrder

$("#activeOrders").on('click','.orderCancelBtn', function(){
	 thisOrder=$(this).closest("tr").attr("id");
		 	
});

$("#cancelOrder").click(function(){
		
    		$.ajax({
				type:'POST',
				url: 'deals/cancelOrder',
				data: "orderName="+ thisOrder,

				success: function(out)
							{

							updateBalance();
							towTables();	
								userActiveOrdersView()
							}
				});
});

</script>

