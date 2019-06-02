



<div class="row  rtl ">
		<div class="col-sm-12 " style="padding: 0px 2px 0px 15px;">
			
  					<div class="input-group  mb-1 mr-sm-2">

						  <div class="input-group-prepend w-20">
						    <label class="input-group-text w-100" for="pair">جفت ارز</label>
						  </div>
						  <select class="form-control" id="pair">
						    <option selected>BTC/IRR</option>
								    <option >ETH/IRR</option>
								    <option >BCH/IRR</option>						    
								    <option >LTC/IRR</option>
								    <option >BTC/ETH</option>
								    <option >BTC/BCH</option>
								    <option >BTC/LTC</option>
		   						    <option >ETH/BCH</option>
		   						    <option >ETH/LTC</option>
								    <option >BCH/LTC</option>
						    
						   
						  </select>
						</div>
				
		</div>
	


		<div class="col-md-6 col-sm-12 ">

					<div class="py-0  border ">
						<h5 class="mt-1"> ثبت پیشنهاد فروش</h5>
						<hr style="border-color: silver; ">
					  <div class="form-inline form-group">
					    <label for="sellAmount" style="width: 25%">مقدار</label>
					    <input type="text" style="width: 73%" class="form-control" id="sellAmount" placeholder="مقدار مورد نظر فروش">
					  </div>

					  <div class="form-group form-inline">
	                    <label for="sellPrice" style="width: 25%">قیمت</label>
	                    <input type="text" class="form-control" style="width: 73%" id="sellPrice" placeholder="قیمت پیشنهادی">
	                  </div>

					  <button type="button" class="btn secondaryBtn mb-1" id="sellButton">پیشنهاد فروش</button>
					</div>
					<div id="mySellBalance" class=" border  mt-1 col-md rtl primary-dark">
					</div>
		</div>
		<div class="col-md-6 col-sm-12 ">
				<div class="py-0  border ">
					<h5 class="mt-1"> ثبت پیشنهاد خرید</h5>
						<hr style="border-color: silver; ">
					  <div class="form-inline form-group ">
					    <label for="buyAmount" style="width: 25%">مقدار</label>
					    <input type="text" class="form-control" style="width: 73%" id="buyAmount" placeholder="مقدار مورد نظر برای خرید">
					  </div>
					  <div class="form-group form-inline">
					    <label for="buyPrice" style="width: 25%">قیمت</label>
					    <input type="text" class="form-control" style="width: 73%" id="buyPrice" placeholder="قیمت پیشنهادی">
					  </div>
				  <button type="button" class="btn ordinaryBtn mb-1" id="buyButton">پیشنهاد خرید</button>
				</div>
				<div id="myBuyBalance" class="border mt-1 col-md rtl primary-dark">

				</div>
		</div>
	</div>

<div class="modal fade rtl" tabindex="-1" role="dialog" id="deals-modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content rtl">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle"></h5>
        
      </div>
      <div class="modal-body" >
        <p id="modalText" ></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">خروج</button>
      </div>
    </div>
  </div>
</div>



			<script type="text/javascript">
				
function updateBalance(){
	
	<?php if(isset($_SESSION['id'])){?>
	var userId=<?php  echo $_SESSION['id']; ?>;

			$.ajax({
					type:'post',
					url: 'deals/userBalance',
					data: "pair="+$('#pair').val() + "&userId="+userId ,

					success: function(result){

					var dec=$('#pair').val().includes('IRR')?2:6;
					var output=JSON.parse(result);
					first_curr=output[1][0];
					second_curr=output[1][1];
					first_balance=moneyFormat(output[0][0],6);
					first_usable=moneyFormat(output[0][2],6);
					second_balance=moneyFormat(output[0][1],dec);
					second_usable=moneyFormat(output[0][3],dec);
	
						$("#mySellBalance").html('موجودی'+first_curr +' من:<br> <strong>کل موجودی </strong>: '+ first_balance +'<br><strong> قابل استفاده</strong>: '+ first_usable );
						$("#myBuyBalance").html('موجودی'+second_curr +' من:<br> <strong>کل موجودی </strong>: '+ second_balance +'<br><strong> قابل استفاده</strong>: '+ second_usable );
						}
					});

		<?php } else {?>
			$("#mySellBalance").html("Balance Unknown, Please Login ");
			$("#myBuyBalance").html("Balance Unknown, Please Login ");
		<?php }?>

}



$("#pair").change(function(){
updateBalance();
towTables();	
userActiveOrdersView();
})


$("#buyButton").click(function(){

	putOrder("buy","#buyAmount","#buyPrice");	
	updateBalance();
towTables();	

})

$("#sellButton").click(function(){
	
		putOrder("sell","#sellAmount","#sellPrice");
		updateBalance();
towTables();	

})


function putOrder(orderType,_amount,_price){

	if(!numValidity(_amount)){
			$(_amount).focus();

			}else if(!numValidity(_price)){
				$(_price).focus();
			}else if(<?php if(!isset($_SESSION['id'])){echo "true";}else{echo "false";}?> ){

				alert ("You are NOT Loged in!");

			}else{ 
		
				$.ajax({
							type:"POST",
							url: "deals/putAnOrder",
							data: "orderType="+ orderType +"&pair="+$("#pair").val()+ "&amount=" + $(_amount).val() +"&price=" +$(_price).val() +"&userId=" +<?php if(isset($_SESSION['id'])){ echo $_SESSION['id'];} else {echo 0;}?>,
							success: function(result){
					$("#modalTitle").html("سفارش");
                    $("#modalText").html(result);
                    $("#deals-modal").modal();


									}
						});

 					$(_amount).val("");
					 $(_price).val("");



				}
}






			</script>