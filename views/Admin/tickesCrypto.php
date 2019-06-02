<h1 class="pt-2"> تیکت های ارز رمزنگاری</h1>




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
				  <label class="input-group-text" for="currency">ارز</label>
				</div>
			<select class="custom-select flex-3" id="currency">
			    <option selected>بیتکوین</option>
			    <option >اتریوم</option>   
			</select>

				<div>
				  <label class="input-group-text" for="ticketCondition">وضعیت</label>
				</div>
			<select class="custom-select flex-3" id="ticketCondition">
			    <option selected>جدید</option>
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
							      <th scope="col">نوع ارز</th>
							      <th scope="col">آدرس</th>
							      <th scope="col">مقدار</th>
							      <th scope="col">زمان ثبت</th>
							      <th scope="col">وضعیت</th>
							      <th scope="col">انتخاب</th>
							     
							    </tr>
							  </thead>
							  <tbody id="mangeTicketsCrypto">

							  <!---Ajax Loaded-->

							</tbody>
				</table>
				
</div>

		 <div id="TransPreloader" class="baseLoader"  >
         	 <div class="spinner"></div> 
   		 </div>

	<nav >
	<ul class="pagination justify-content-center" id="tableFooter">
		

	</ul>		
	</nav>

	<div>
		<input type="password" class="border alert-danger" id="passPhrase" placeholder="passPhrase را وارد کنید">
        <button type="button" class="btn btn-success" disabled="true" id="performSendCoin">عملیات پرداخت</button>

	</div>
</div>







<script type="text/javascript">
$(document).ready(function(){
	$("#TransPreloader").hide();
		var page=1;
		loadTicketsTableCrypto(page);
			$("#loadTicketsBtn").click(function(){

				loadTicketsTableCrypto(page);
				});

			$("#tableFooter").on('click','.paginationlink', function(){
			 	
		           page = $(this).attr("id"); 
		          
		          loadTicketsTableCrypto(page);  
		    });

});

$(document).on('click','#performSendCoin', function(){
$("#TransPreloader").show();
	 switch ($("#currency option:selected").index()){
  			    
  			    case 0:
  			        currency="BTC";
  			        break;
  			    case 1:
  			         currency="ETH";
  			        break;
  			    case 2:
  			         currency="BCH";
  			        break;
  			    case 3:
  			         currency="LTC";
  			        break;
  			}


	$.ajax({

				type:"POST",
				url:"admin/sendCoinsToUser",
				data: "ticketsArray=" + checkedArray + "&currency="+ currency +"&passPhrase="+$("#passPhrase").val() ,
				success: function(result){
					console.log(result)
	        		alert(result)
	        		var page=1;
					loadTicketsTableCrypto(page);

				}
			});
		$(document).ajaxComplete(function(){
		    $("#TransPreloader").hide();
		    checkedArray=new Array();
		});


})

$('#ticketType').change(function(){

	if($('#ticketType option:selected').index()=="0"){
		if($('#ticketCondition option:selected').index()=="0"){
			$('#passPhrase').attr('disabled', false);
			$('#performSendCoin').attr('disabled', false);
		}else{
			$('#passPhrase').attr('disabled', true);
			$('#performSendCoin').attr('disabled', true);
		}

	}else{
			$('#passPhrase').attr('disabled', true);
			$('#performSendCoin').attr('disabled', true);
	}
})


var checkedArray=new Array();
		 
$("#mangeTicketsCrypto").on('change','.selectCheck', function(){
	var thisRowId=$(this).closest("tr").attr("id");
	
			 		 if($(this).is(":checked")) {
    					 	checkedArray.push(thisRowId);

    					}else{
							checkedArray.splice(checkedArray.indexOf(thisRowId),1);

    					}


    					if(checkedArray.length<1){
    						$('#performSendCoin').attr('disabled', true);
    					}else{
    						$('#performSendCoin').attr('disabled', false);
    					}
    				//	console.log(checkedArray)
});

function loadTicketsTableCrypto(page){ 

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
				url:"admin/AdminTicketsCrypto",
				data: "ticketCondition=" + group + "&tType="+ tType +"&numToShow=" +numToShow +"&page="+ page,
				success: function(result){
				//console.log()
				output=result.split("|||");
		
        		  $("#mangeTicketsCrypto").html(output[0]);
        	
        		  $("#tableFooter").html(output[1]);
				}
			});


	}



</script>