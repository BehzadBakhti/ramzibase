

<div class="rtl row  ">
					

					<div class="col-sm-12 col-md-6 primary-dark">	
						
						
							<table class="table table-sm  table-striped table-bordered " >
						<hr style="border-color: white;  margin: 5px 0px ;">
						<h5 class="mt-0">پیشنهادات خرید</h5>
						
							  <thead class="thead-dark">
							    <tr>
							     
							      <th scope="col">مقدار</th>
							      <th scope="col">قیمت</th>
							      <th scope="col">مجموع</th>
							    </tr>
							  </thead>
							  <tbody id="buytable">

							  <!---PHP FILLS HERE-->


							  </tbody>
							</table>
						
				  		
				  	</div>

				  	<div class="col-sm-12 col-md-6 primary-dark">
						<hr style="border-color: white;  margin: 5px 0px ;">
						<h5 class="mt-0">پیشنهادات فروش</h5>
						
						
							<table class="table table-sm  table-striped table-bordered " >
								
							  <thead class="thead-dark">
							    <tr>
							     
							      <th scope="col">مقدار</th>
							      <th scope="col">قیمت</th>
							      <th scope="col">مجموع</th>
							    </tr>
							  </thead>
							  <tbody id="selltable">



							  </tbody>
							</table>
						
				  	</div>
	 </div>

<script type="text/javascript">
	
   	//Ajax data handle

function ajaxUpdateTable(table){

	var sell_buy="";
		if(table=="#selltable"){
				sell_buy="sell";
		}else{
				sell_buy="buy";
		}

					$.ajax({
					type:'post',
					url: "TableUpdates/orderBook",
					data: "pair="+$('#pair').val() + "&sell_buy="+sell_buy ,

					success: function(result){
									$(table).html(result);


								}
					});
 
			}


function towTables(){


	 	ajaxUpdateTable("#selltable");
	 	ajaxUpdateTable("#buytable");
}


$("#selltable").on('click','tr', function(){
	
			 		 var tableData = $(this).children("td").map(function() {
      				  return $(this).text();
   					}).get();
			 	
   					amount=tableData[0].replace( /\s/g, "");
   					price=tableData[1].replace( /\s/g, "");
					   $("#buyAmount").val(parseFloat(amount.replace(/,/g, '')));
					   $("#buyPrice").val(parseFloat(price.replace(/,/g, '')));


	});

$("#buytable").on('click','tr', function(){
	
			 		 var tableData = $(this).children("td").map(function() {
      				  return $(this).text();
   					}).get();
			 	
   					amount=tableData[0].replace( /\s/g, "");
   					price=tableData[1].replace( /\s/g, "");
					   $("#sellAmount").val(parseFloat(amount.replace(/,/g, '')));
					   $("#sellPrice").val(parseFloat(price.replace(/,/g, '')));


	});




</script>