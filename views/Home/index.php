

<section id="showCase " id="particles-js">





    <div class=" home-image  particles-js-canvas-el"   >
   
    		<div  class=" text-center">
    			   <h1 id="heading" >بازار معاملات ارزهای دیجیتال</h1>
   				   <p id="description" class=" lead mb-3">کاملترین بازار ایرانی خرید و فروش به شیوه خودکار</p>
                <?php if(isset($_SESSION['id'])) {?>
                          <a href="<?php echo ROOT_URL; ?>features" class="btn main-red btn-lg mb-3 homeBtn">می خواهم بیشتر بدانم</a>
                <?php } else { ?>
                					<button class="btn main-red btn-lg mb-3 homeBtn"  data-toggle="modal" data-target="#logInSignUpModal" > ورود / ثبت نام </button>
                <?php } ?>
    		</div>


  </div>



</section>

  <!-- HOME ICON SECTION -->
  <section id="home-icons" class="py-4 rtl">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-4 mb-3 text-center">
          <i class="fas fa-money-bill-alt mb-1 faicon"></i>
          <p style="font-size: 24px; font-weight: bolder;"  id="volume24h">0 ریال</p>
          <p>حجم معاملات در 24 ساعت گذشته</p>

        </div>
        <div class="col-md-4 mb-3 text-center">
          <i class="fas fa-money-bill-alt mb-1 faicon" ></i>
          <p style="font-size: 24px; font-weight: bolder;"  id="volume7d">0 ریال</p>
          <p>حجم معاملات در یک هفته گذشته</p>

        </div>
        <div class="col-md-4 mb-3 text-center">
          <i class="fas fa-money-bill-alt mb-1 faicon"></i>
          <p style="font-size: 24px; font-weight: bolder;"   id="volume1m">0 ریال</p>
          <p >حجم معاملات در یک ماه گذشته</p>

        </div>
      </div>
    </div>
  </section>



  <section id="home-news" class="p-5 ">
    <div class="dark-overlay">
      <div class="container-fluid rtl">
        
          <div class="container pt-4 text-right">
            <h4 class="mb-2">اطلاعیه ها</h4>
       
            	<div class="col-md-12" id="AnnounceHomeBody">
            	<!-- *******************************************-->
            	</div>
            	

        </div>
     
    </div>
  </section>

	<section id="home-features" class="py-4  mt-5 rtl">
		<?php require('features.php') ?>
  </section>



  <script type="text/javascript">
    var page_nav=0;
    $(document).ready(function(){
loadHomeAncJS()
          $.ajax({
            type:'GET',
            url: "Home/tradeHistory",

            success: function(result){
            //  alert(result)
            array=JSON.parse(result)
                  $("#volume24h").html(moneyFormat(array[0],0)+ " ریال");
                  $("#volume7d").html(moneyFormat(array[1],0)+ " ریال");
                  $("#volume1m").html(moneyFormat(array[2],0)+ " ریال");

                }
          });


    })
function loadHomeAncJS(){
          $.ajax({

        type:"GET",
        url:"posts/AnnounceHome",

        success: function(result){

              $("#AnnounceHomeBody").html(result);
          
        }
      });


}
    

  </script>
