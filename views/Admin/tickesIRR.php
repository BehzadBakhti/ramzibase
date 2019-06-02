
<h1 class="pt-2"> تیکیت های ریالی</h1>




<div >
<div class=" col-md-8 input-group" > 

				<div>
				  <label class="input-group-text" for="ticketType">نوع درخواست</label>
				  </div>
			  <select class="custom-select flex-3" id="ticketType">
			    <option selected>برداشت </option>
			    <option >افزایش موجودی</option>	   
			  </select>

				<div>
				  <label class="input-group-text" for="ticketCondition">وضعیت</label>
				  </div>
			  <select class="custom-select flex-3" id="ticketCondition">
			    <option selected>جدید</option>
			    <option >در دست اقدام</option>
			    <option >نهایی شده</option>
			   
			  </select>
			<div>
			  <label class="input-group-text" for="numberToShow">نمایش در صفحه</label>
			  </div>
			  <select class="custom-select flex-3" id="numberToShow">
			    <option selected>20</option>
			    <option >50</option>
			    <option >100</option>
			  
			  </select>

			  <input type="button" name="search" id="loadTicketsBtn" value="آیکون رفرش"> 
	
</div>

<div >
	
		<table class="table table-sm  table-striped table-bordered" >

							  <thead class="thead-dark">
							    <tr>
							     
							      
							      
							      <th scope="col">ایمیل</th>
							      <th scope="col">نام صاحب حساب</th>
							      <th scope="col">نام بانک</th>
							      <th scope="col">شماره حساب</th>
							      <th scope="col">شماره شبا</th>
							      <th scope="col">مبلغ</th>
							      <th scope="col">زمان ارسال تیکت</th>
							      <th scope="col">وضعیت</th>
							      <th scope="col">عملیات</th>
							     
							    </tr>
							  </thead>
							  <tbody id="mangeTicketsIRR">

							  <!---PHP FILLS HERE-->

							</tbody>
				</table>
				
</div>
<nav >
	<ul class="pagination justify-content-center" id="tableFooter">
		

	</ul>		
</nav>
	<div>
      
        <button type="button" class="btn btn-success" disabled="true" id="sendToOperate">ارسال جهت پرداخت</button>
        <button type="button" class="btn btn-success" disabled="true" id="ticketDoneIRR">پرداخت شده</button>

	</div>

</div>






<script type="text/javascript">



$('#ticketType').change(function(){

	if($('#ticketType option:selected').index()=="0"){
		if($('#ticketCondition option:selected').index()=="0"){
		
			$('#sendToOperate').attr('disabled', false);
			$('#ticketDoneIRR').attr('disabled', true);

		}else if($('#ticketCondition option:selected').index()=="1"){
		
			$('#sendToOperate').attr('disabled', true);
			$('#ticketDoneIRR').attr('disabled', false);

		}
		else{
	
			$('#sendToOperate').attr('disabled', true);
			$('#ticketDoneIRR').attr('disabled', true);
		}

	}else{
		if($('#ticketCondition option:selected').index()=="0"){
	
			$('#sendToOperate').attr('disabled', true);
			$('#ticketDoneIRR').attr('disabled', true);

		}else{
		
			$('#sendToOperate').attr('disabled', true);
			$('#ticketDoneIRR').attr('disabled', true);

		}


	}
})

$('#ticketCondition').change(function(){

	if($('#ticketCondition option:selected').index()=="0"){
		if($('#ticketType option:selected').index()=="0"){

			$('#sendToOperate').attr('disabled', false);
			$('#ticketDoneIRR').attr('disabled', true);
		}
		else{

			$('#sendToOperate').attr('disabled', true);
			$('#ticketDoneIRR').attr('disabled', true);
		}

	}else if($('#ticketCondition option:selected').index()=="1"){
			if($('#ticketType option:selected').index()=="0"){

			
				$('#sendToOperate').attr('disabled', true);
				$('#ticketDoneIRR').attr('disabled', false);

			}else{
				
				$('#sendToOperate').attr('disabled', true);
				$('#ticketDoneIRR').attr('disabled', true);

			}


	}else {
			
		
				$('#sendToOperate').attr('disabled', true);
				$('#ticketDoneIRR').attr('disabled', true);

	}
})


$(document).ready(function(){
		var page=1;
		 loadTicketsTableIRR(page)
			$("#loadTicketsBtn").click(function(){

				loadTicketsTableIRR(page);
				});

			$("#tableFooter").on('click','.paginationlink', function(){
			 	
		           page = $(this).attr("id"); 
		          
		          loadTicketsTableIRR(page);  
		    });

});





$(document).on('click','#sendToOperate', function(){

	if(checkedArray.length<1){
    						alert("هیچ تیکتی انتخاب نشده است");
    						return;
    					}


		$.ajax({

				type:"POST",
				url:"admin/underOperationTicketIRR",
				data: "ticketsArray=" + checkedArray ,
				success: function(result){
					
				}
			});


})



$(document).on('click','#ticketDoneIRR', function(){

	if(checkedArray.length<1){
    						alert("هیچ تیکتی انتخاب نشده است");
    						return;
    					}


		$.ajax({

				type:"POST",
				url:"admin/ticketDoneIRR",
				data: "ticketsArray=" + checkedArray ,
				success: function(result){
					
				}
			});


})

/*		 
$("#mangeTicketsIRR").on('click','.tableRow', function(){
			 		 var tableData = $(this).children("td").map(function() {
      				  return $(this).text();
   					}).get();
   					userEmail=tableData[0].replace( /\s/g, "");
		          
	$('#ticketDataIRR').modal('show');
		$('#accUserName').html(tableData[1]);
		$('#bankName').html(tableData[2]);
		$('#accNo').html(tableData[3]);
		$('#shebaNo').html(tableData[4]);
		$('#amount').html(tableData[5]);
	

});
*/
function loadTicketsTableIRR(page){ 

	var ticketCondition=$("#ticketCondition option:selected").index();
	var ticketType=$("#ticketType option:selected").index();
	var numToShow=$("#numberToShow option:selected").val();

	var group="";
	var tType="";
	  	switch (ticketCondition){
	  		case 0:
			group="started"
			break;

			case 1:
			group="operated"
			break;
			case 2:
			group="done"
			break;
	  	};
	switch (ticketType){
	  		case 0:
			tType="withdraw"
			break;

			case 1:
			tType="deposit"
			break;

	  	};
     


	$.ajax({

				type:"POST",
				url:"admin/AdminTicketsIRR",
				data: "ticketCondition=" + group + "&tType="+ tType +"&numToShow=" +numToShow +"&page="+ page,
				success: function(result){
				
				output=result.split("|||");
        		  $("#mangeTicketsIRR").html(output[0]);
        	
        		  $("#tableFooter").html(output[1]);
				}
			});


	}



var checkedArray=new Array();
		 
$("#mangeTicketsIRR").on('change','.selectCheck', function(){
	var thisRowId=$(this).closest("tr").attr("id");
	
			 		 if($(this).is(":checked")) {
    					 	checkedArray.push(thisRowId);

    					}else{
							checkedArray.splice(checkedArray.indexOf(thisRowId),1);

    					}


    					
});

</script>

















<!-- Modal -->
<div class="modal fade" id="ticketDataIRR" tabindex="-1" role="dialog" >
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" >جزئیات درخواست</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       
		<div class="row rtl " >
			<div class="col-md-12 rtl"><span>نام صاحب حساب:<span id="accUserName"></span></span></div>
			<div class="col-md-12 rtl"><span>نام بانک:</span><span id="bankName"></span></div>
			<div class="col-md-12 rtl"><span>شماره حساب:<span id="accNo"></span></span></div>
			<div class="col-md-12 rtl"><span>شماره شبا:</span><span id="shebaNo"></span></div>

		</div>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">خروج</button>
        <button type="button" class="btn btn-primary" id="loginSignupButton">پرداخت شده</button>
        <button type="button" class="btn btn-primary" id="loginSignupButton">ارسال جهت پرداخت</button>
      </div>
    </div>
  </div>
</div>