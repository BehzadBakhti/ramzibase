<?php 
?>

<div class="container-fluid  mt-5 pt-2 ">

  <div class="row rtl justify-content-center">


    <div class="col-lg-5 rtl mr-2" > 
        
       <div class="row  primary-dark mb-2 pt-1 pb-4 ">
         <h4 class="fund-titles col-sm-12 "> مدیریت موجودی حسابها </h4> 
          <div class="col-md-6 mb-2">
            
            <form class="border p-1  h-100" id="wdr_form">

                <h5  class="m-1">برداشت از حساب</h5>
       
                <div class="form-inline form-group ">
                  <label for="currency" class="w-25">واحد پول</label>
                  <select id="currency_wdr"  class="form-control w-73" >
                   
                    <option>ریال</option>
                    <option> بیتکوین</option>
                    <option> اتریوم</option>
                    <option> بیتکوین کش</option>
                    <option> لایتکوین</option>
                  </select>
                </div>

                <div class="form-inline form-group ">
                  <label for="amountToHandle_wdr" class="w-25">مقدار</label>
                  <input type="text" id="amountToHandle_wdr"  class="form-control w-73" required="true"  placeholder="مقدار را وارد کنید">
                </div>

                 <div class="form-inline form-group ">
                    <label for="cryptoAddress_wdr" class="w-25">آدرس</label>
                    <input type="text" id="cryptoAddress_wdr"  class="form-control w-73" disabled="true" placeholder="آدرس wallet جهت دریافت ">
                </div>

                <?php if(isset($_SESSION['id'])){?>
                <button id="wdr_btn" type="button" class="btn ordinaryBtn w-50 mb-3" ><span>برداشت از حساب</span></button>
                <?php } else { ?>

                <button id="wdr_btn" type="button" class="btn ordinaryBtn w-50 " data-toggle="modal" data-target="#notLogedInModal"><span>برداشت از حساب</span></button>
                <?php  }?>
            </form>
          </div>

          <div class="col-md-6  mb-2 ">

            <form class="border p-1  h-100" id="#dep_form">
              <h5 class="">افزایش موجودی</h5>

                <div class="form-inline form-group ">
                  <label for="currency_dep" class="w-25">واحد پول</label>
                  <select id="currency_dep" class="form-control w-73" >
                   
                    <option>ریال</option>
                    <option> بیتکوین</option>
                    <option> اتریوم</option>
                    <option> بیتکوین کش</option>
                    <option> لایتکوین</option>
                  </select>
                </div>

   

                <div class="form-inline form-group">
                  <label for="amountToHandle_dep" class="w-25">مقدار</label>
                  <input type="text" id="amountToHandle_dep" class="form-control w-73" placeholder="مقدار را وارد کنید">
                </div>
                <div class="form-inline form-group" style="visibility: hidden;">
                  <label  class="w-25"></label>
                  <input type="text"  class="form-control w-73" >
                </div>
                  <?php if(isset($_SESSION['id'])){?>
                  <button id="dep_btn" type="button" class="btn secondaryBtn w-50  mb-1"><span>افزایش موجودی</span></button>
                  <?php } else { ?>

                  <button id="dep_btn" type="button" class="btn secondaryBtn w-50 mb-1" data-toggle="modal" data-target="#notLogedInModal"><span>افزایش موجودی</span></button>
                  <?php  }?>

            </form>
          </div>
       </div>

       <div class="row primary-dark mb-2 p-1">
          <div class="col-sm-12 mb-1">
                <h3 class="fund-titles"> موجودی حسابها </h3>
                
                <?php  if(isset($_SESSION['id'])) require("userBalanceTable.php");?>  
          </div> 
       </div>

     </div>

    <div class="col-lg-6 rtl  mr-4 ">

      <div class="row primary-dark mb-2 p-1">
          <div class="col-sm-12 mb-1">

          <h3 class="fund-titles" >آدرس های فعال </h3> 
          <?php  if(isset($_SESSION['id'])) require("cryptoAddressTable.php");?>

          </div>
      </div>
      
      <div class="row primary-dark mb-1 p-1">
          <div class="col-sm-12 mb-1">
        <h3 class="fund-titles"> تیکت های فعال  </h3>
        <?php  if(isset($_SESSION['id'])) require("activeTicketsTable.php");?>
      </div>
     </div>

    </div>



  </div>
 

<hr>

</div>
       <div id="chartPreloader" class="baseLoader" type="hidden" style="position: fixed; top:0%; bottom:0; left:0; right: 0;" >
          <div class="spinner"></div> 
       </div>

<div class="modal" tabindex="-1" role="dialog" id="notLogedInModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content rtl">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle">کاربر ناشناس</h5>
 
      </div>
      <div class="modal-body" >
        <p id="modalText">ابتدا به حساب کاربری خود وارد شوید</p>
      </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="paymentPageBtn">صفحه پرداخت</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">خروج</button>
      </div>
    </div>
  </div>
</div>



<script type="text/javascript">
  var page_nav=3;
	var op_type="deposit";	
  var currency="IRR";
  var userWalletAddress="";
$(document).ready(function(){

 

  <?php if(isset($_SESSION['id'])) { ?>
  updateBalance();
  getCryptoAddresses();
  getActiveTickets();
  <?php } ?>

});


$("#currency_wdr").change(function(){
  
    if($("#currency_wdr option:selected").index()=="0"){
         $('#cryptoAddress_wdr').attr('disabled', true);
        
    }else{
      $('#cryptoAddress_wdr').attr('disabled', false);


    }
  });


$("#currency_dep").change(function(){

  	if($("#currency_dep option:selected").index()=="0"){
         $('#amountToHandle_dep').attr('disabled', false);

  	}else{
     
          $('#amountToHandle_dep').attr('disabled', true);
   
  	}
	});



$("#dep_btn").click(function(){

  <?php if($_SESSION['confirmed']!='confirmed'){ ?>

      alert('حساب کاربری شما '+ '<?php echo $_SESSION['confirmed'];?>' + ' می‌باشد. در این شرایط امکان افزایش موجودی وجود ندارد.')

      return;

   <?php } ?>

    op_type="deposit";
	 switch ($("#currency_dep option:selected").index()){
  			    case 0:
  			        currency="IRR";
  			        break;
  			    case 1:
  			        currency="BTC";
  			        break;
  			    case 2:
  			         currency="ETH";
                 break;
            case 3:
                 currency="BCH";
                 break;
            case 4:
                 currency="LTC";
  			        break;
  			}
/*   switch ($("#payment_dep option:selected").index()){
            case 0:
                payment="auto";
                break;
            case 1:
                payment="manual";
                fileProperty=document.getElementById("recipitFile").files[0];
                break;
        }*/
        
    if(currency=='IRR' && (!numValidity("#amountToHandle_dep") || $("#amountToHandle_dep").val()<1000))
      {
        $("#amountToHandle_dep").focus();
      }else{
        amountToHandle=$("#amountToHandle_dep").val();

        operationSelect();
        getCryptoAddresses();
      }

});


$("#wdr_btn").click(function(){
    op_type="withdraw";
   switch ($("#currency_wdr option:selected").index()){
          case 0:
              currency="IRR";
              break;
          case 1:
              currency="BTC";
              break;
          case 2:
               currency="ETH";
              break;
          case 3:
                 currency="BCH";
                 break;
          case 4:
                 currency="LTC";
                break;
      }
  
 


  if(!numValidity("#amountToHandle_wdr"))
      {
            $("#amountToHandle_wdr").focus();
      }else if(currency!='IRR' && !adrrValidity('#cryptoAddress_wdr')){
            $('#cryptoAddress_wdr').focus();

      }else{
            amountToHandle=$("#amountToHandle_wdr").val();

          operationSelect();
      }

  updateBalance();
  getCryptoAddresses();
  getActiveTickets();

});
var paymentPage=""

function operationSelect(){
 $("#chartPreloader").show();
  var myFormData= new FormData();
  myFormData.append("op_type",op_type);
  myFormData.append("currency",currency);
  myFormData.append("amountToHandle",amountToHandle)
  if(currency!='IRR'){
       myFormData.append("userWalletAddress", $('#cryptoAddress_wdr').val());
     }

  $.ajax({
        type:"POST",
        url:"funds/oprationSelector",
        data: myFormData,
        cache: false,
        contentType: false,
        enctype: 'multipart/form-data',
        processData: false,
        async: false,
        success: function(result){
            if(op_type=='deposit'){
                if(currency=="IRR" ){
                   
                   array=JSON.parse(result)
             //      console.log(array);
                   paymentPage=array['url'];
                          $("#paymentPageBtn").show();
                          $("#modalTitle").html("نتیجه");
                          $("#modalText").html(array['comment']);

                          $("#notLogedInModal").modal();

                         // window.open(paymentPage,'_blank');
                      
                         $("#dep_form")[0].reset();

                      }else {
                          $("#paymentPageBtn").hide();
                          $("#modalTitle").html("آدرس");
                          $("#modalText").html(result);
                          $("#notLogedInModal").modal();
                          $("#dep_form")[0].reset();
                        }
              }else if(op_type=='withdraw'){
                        $("#paymentPageBtn").hide();
                        $("#modalTitle").html("نتیجه");
                        $("#modalText").html(result);
                        $("#notLogedInModal").modal();
                        $("#wdr_form")[0].reset();

              }
            }
      });

$(document).ajaxComplete(function(){
    $("#chartPreloader").hide();
});

}
$("#paymentPageBtn").click(function(){


window.open(paymentPage,'_blank')
$("#dep_form")[0].reset();

});


</script>

