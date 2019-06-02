<table class="table table-sm  table-striped table-bordered mb-1">
				<thead class="fund-thead">
					<tr>
						<th>#</th>
						<th>نام ارز</th>
						<th>مقدار</th>
						<th>تاریخ ثبت تیکت</th>
						<th> عملیات </th>
					</tr>
				</thead>
				<tbody id="myTickets">
					<!-- php code here! -->


				</tbody>
			</table>



<div class="modal rtl" tabindex="-1" role="dialog" id="cancelTicketConf">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalTitle">تایید حذف تیکت</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p id="deleteModalText"> تیکت حذف شود؟</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">خروج</button>
        <button type="button" class="btn btn-warning " id="cancelTicket"  data-dismiss="modal">حذف تیکت</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
	
function getActiveTickets(){
<?php if(isset($_SESSION['id'])) { ?>
$.ajax({
					type:'post',
					url: "Funds/getActiveTickets",

					success: function(result){
									$("#myTickets").html(result);


								}
					});
<?php }?>

}


var thisTiket=''

$("#myTickets").on('click','.ticketCancelBtn', function(){
	 thisTiket=$(this).closest("tr").attr("id");
		 
});

$("#cancelTicket").click(function(){
		
    		$.ajax({
				type:'POST',
				url: 'funds/cancelTicket',
				data: "ticketName="+ thisTiket,

				success: function(out)
							{
				getActiveTickets()
							
							}
				});
});
</script>