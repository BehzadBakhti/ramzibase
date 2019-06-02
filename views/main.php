<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="بازار مبادله مستقیم بیتکوین، اتریوم، لایتکوین، ریپل و ارزهای دیجیتال دیگر. خرید و فروش به روش اکسچنج های بین المللی. ">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">
   

	     <link rel="stylesheet" type="text/css" href="<?php echo ROOT_URL; ?>assets/css/Styles.css? 13:33:50">
       <link rel="stylesheet" type="text/css" href="<?php echo ROOT_URL; ?>assets/css/loader.css? 21:30:00">
        
         <link href="https://use.fontawesome.com/releases/v5.0.7/css/all.css" rel="stylesheet">
        <!--   usage:  <i class="far fa-question-circle "></i>  question mark inside a circle -->

        <link href="https://cdn.materialdesignicons.com/2.3.54/css/materialdesignicons.min.css" rel="stylesheet" type="text/css" />
        <!--   usage: <i class="mdi mdi-bell"></i>   bell -->

        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <!--   usage: <i class="material-icons">tag_faces</i>   bell -->
        
        <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
        <script src="https://www.gstatic.com/charts/loader.js"></script>
       



     <title>RamziBase! خرید و فروش بیتکوین، اتریوم؛ لایتکوین، ریپل و دیگر ارزهای دیجیتال</title>


        <script src='https://www.google.com/recaptcha/api.js'></script>
  </head>

  <body class="light-gray">

 <nav class="navbar navbar-expand-md navbar-dark   fixed-top" style="padding: 5px 10px; margin: 0px; direction: rtl;">

  <a class="navbar-brand mainlogo" href="<?php echo ROOT_URL ; ?>"></a>

  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse " id="navbarSupportedContent" >
    <ul class="navbar-nav ml-auto mt-md-0" >

      <li class="nav-item " id="homepage">
        <a class="nav-link "  href="<?php echo ROOT_URL; ?>">صفحه نخست</a>
      </li>
       <li class="nav-item">
        <a class="nav-link " href="<?php echo ROOT_URL; ?>blogs">وبلاگ</a>
      </li>

      <li class="nav-item" >
        <a class="nav-link" href="<?php echo ROOT_URL; ?>deals">معاملات</a>
      </li>
<?php if(isset($_SESSION['id'])){?>

      <li class="nav-item">
        <a class="nav-link " href="<?php echo ROOT_URL; ?>funds">کیف پول</a>
      </li>

<?php  }?>
<?php if(isset($_SESSION['user_level']) AND $_SESSION['user_level']!='ordinary'){?>
      <li class="nav-item ">

        <a class="nav-link " href="<?php echo ROOT_URL; ?>admin">مدیریت</a>

      </li>
<?php }?>
    </ul>
    <div class="form-inline my-2 my-lg-0">
    <?php if(isset($_SESSION['id'])){?>

      <a  class="nav-left" href="<?php echo ROOT_URL; ?>users/profile"><i class="fas fa-user"></i> حساب کاربری</a>
      <a class="nav-left"  href="<?php echo ROOT_URL ; ?>users/Logout" >خروج</a>


   <?php } else { ?>
      <button class="nav-left"  data-toggle="modal" data-target="#logInSignUpModal" > ورود/ ثبت نام </button>

   <?php  }?>
    </div>
  </div>
</nav>
  <hr style="margin: 2px">



<?php require($view); ?>




<footer class="footer p-5 second-color">

    <div class=" col-sm-3 mb-5">
                   <p> &copy; ramzibase <?php echo date("Y");?> </p>
        </div>
    <div class="row  mx-2">
        

        <div class=" col-sm-5  text-right  rtl">
             <div class="col-md-12">
                         <a href="<?php echo ROOT_URL; ?>features" target="_blank"> راهنمای استفاده</a>
                </div>
                 
        </div>
        <div class=" col-sm-3  text-right  rtl">
          <div class="alert alert-success" style="display:none;" id="ContactAlert"></div>
          <form class="my-2" id="contactUsForm">
                
                <div class="form-group ">
                  <label for="senderName">نام و نام خانوادگی</label>
                  <input type="text" class=" form-control rounded" style="background-color: transparent; color: #BBCCBB" id="senderName" placeholder="علی محمدی">
                </div>
                <div class="form-group">
                  <label for="senderEmail">آدرس ایمیل</label>
                  <input type="email" class="form-control rounded" style="background-color: transparent; color: #BBCCBB" id="senderEmail" placeholder="name@example.com">
                </div>
               
                <div class="form-group">
                  <label for="messageBody">متن پیام</label>
                  <textarea class="form-control rounded" style="background-color: transparent; color: #BBCCBB" id="messageBody" rows="5" ></textarea>
                </div>
                <button type="button" id="contactUsBtn" class="btn btn-primary rounded">ارسال پیام</button>
           </form>
        </div>
        <div class=" col-sm-3  text-right  rtl">
             
                 <div class="col-md-12 ">
                  
                  <div class="row py-2">
                    <h5  >ارتباط با ما:</h5> 
                     <div class="col-sm-12 ">
                     
                      </div>

                      <div class="col-sm-2 " >
                         
                         <a href="mailto:support@ramzibase.com" target="_top"><i class="far fa-envelope" style="font-size: 25px"></i></a>
                      </div>
                      <div class="col-sm-2 ">
                        
                        <a  href="https://www.instagram.com/ramzibase" target="_top"><i class="fab fa-instagram" style="font-size: 25px"></i> </a>
                      </div>
                      <div class="col-sm-2 ">
                     
                        <a  href="https://t.me/ramzibase" target="_top"><i class="fab fa-telegram" style="font-size: 25px"></i></a>
                      </div>
                 
                        
                   </div>
                   <div class="row ">
                    <div class="col-sm-12 ">
                        <i class="fas fa-phone-square " style="font-size: 25px"></i>
                        <span>02177147083</span>
                      </div>
                      <div class="col-sm-12 py-2">
                        <i class="fas fa-map-marker-alt" style="font-size: 25px"></i>
                        <span class="px-2">تهران، تهرانپارس، خیابان خدابنده، پلاک 140</span>
                      </div>
                    </div>
                  </div>
        </div>

    </div>


</footer>



    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js" integrity="sha384-a5N7Y/aK3qNeh15eJKGWxsqtnX/wWdSZSKp+81YjTmS15nvnvxKHuzaWwXHDli+4" crossorigin="anonymous"></script>



<!-- Modal -->
<div class="modal fade rtl" id="logInSignUpModal" tabindex="-1" role="dialog" >
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header primary-dark">
        <h5 class="modal-title "  id="loginModalTitle">ورود به حساب کاربری</h5>

      </div>
      <div class="modal-body primary-light">

  <div class="alert alert-danger" style="display:none" id="LoginAlert"></div>
			<form class="form-group " style=" text-align: right" >
				<input type="hidden" name="loginActive" id="loginActive" value="1">

			 	 <div class="form-group">
				    <label   for="email">آدرس ایمیل </label>
				    <input type="email" class="form-control" id="email" placeholder="آدرس ایمیل را وارد کنید">
		   		  </div>

				  <div class="form-group">
				    <label   for="password">رمز عبور</label>
				    <input class="form-control" type="password"  id="password" data-container="body" data-toggle="popover" data-placement="top" data-content="رمز عبور بایستی شامل 6 کاراکتر یا بیشتر باشد" placeholder="رمز عبور را وارد کنید">
				  </div>

           <div class="form-group " hidden="true" id="ConfPasswordDiv">
            <label   for="ConfPassword">تکرار رمز عبور </label>
            <input class="form-control " type="password"  id="ConfPassword" placeholder="تکرار رمز عبور را وارد کنید">


            <div class="form-check form-check-inline">
              <label class="form-check-label my-2" for="acceptRules"> <a href="<?php echo ROOT_URL; ?>rules" target="_blank">قوانین سایت </a> را قبول می‌کنم</label>
              <input class="form-check-input" type="checkbox" id="acceptRules" value="option1">

            </div>
          </div>

          <!-- <div class="g-recaptcha" data-sitekey="6Lf8W1IUAAAAAEB1UXe43WswONXfV8slVTEU9yZT"></div> -->
			</form>


      </div>
      <div class="modal-footer ">
      	<span id="notAmember">عضو نیستید؟</span> <a id="toggleLogin" class="ml-4" href="#"> ثبت نام</a>
        <a id="forgotPass" href="#"> رمز عبور را فراموش کرده ام</a>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">خروج</button>
        <button type="button" class="btn btn-primary" id="loginSignupButton">ورود</button>
      </div>
    </div>
  </div>
</div>

    <script>
   function moneyFormat(value, d){

   return value.toFixed(d).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
    }


var rules=0;
$("#toggleLogin").click(function(){

		if($("#loginActive").val()=="1"){

			$("#loginActive").val("0");
			$("#loginModalTitle").html("ثبت نام");
			$("#loginSignupButton").html("ثبت نام");
			$("#toggleLogin").html("ورود");
			$("#notAmember").html("قبلاً ثبت نام کرده اید؟");
      $("#ConfPasswordDiv").attr('hidden', false);
       $("#loginSignupButton").attr('disabled', true);

			}else {

			$("#loginActive").val("1");
			$("#loginModalTitle").html("ورود به حساب کاربری");
			$("#loginSignupButton").html("ورود");
			$("#toggleLogin").html("ثبت نام");
			$("#notAmember").html("عضو نیستید؟");
       $("#ConfPasswordDiv").attr('hidden', true);
      $("#loginSignupButton").attr('disabled', false);
			}
})

//Logging Sign up

$("#acceptRules").on('change', function(){

           if($("#acceptRules").is(":checked")) {
                $("#loginSignupButton").attr('disabled', false);
                rules=1;

              }else{
               $("#loginSignupButton").attr('disabled', true);
                rules=0;
              }
            });

$("#loginSignupButton").click(function(){

		if(!passValidity("#password") && $("#loginActive").val()=="0"){
			$("#password").focus()
 			$("#password").addClass("is-invalid");
			$("#password").popover('show')
			return;
		}else{
			$("#password").removeClass("is-invalid");
			$("#password").popover('hide')
		}

        if(($("#loginActive").val()=="0") && ($("#password").val()!==$("#ConfPassword").val()) ){
          $("#LoginAlert").html("تکرار رمز عبور با عبارت اولیه همخوانی ندارد").show();
            return;
        }

        if(page_nav==7){
          ctrlpage='loginSignup';
        }else{
        ctrlpage='users/loginSignup';
        }

      $.ajax({
  			type:"POST",
  			url:ctrlpage,
  			data: "email=" + $("#email").val() +"&password=" +$("#password").val() +"&loginActive=" +$("#loginActive").val() +"&rules="+rules /*+ "&g-recaptcha-response=" + grecaptcha.getResponse()*/,
  			success: function(result){

  							if(result.indexOf('!') > -1){

  								$("#LoginAlert").addClass('alert-danger')
                  				$("#LoginAlert"). removeClass('alert-success')
	                  				if(result.indexOf('موفقیت') > -1){
	                  					$("#LoginAlert").removeClass('alert-danger')
	                   					$("#LoginAlert").addClass('alert-success')
	                  				}

  							  $("#LoginAlert").html(result).show();
  							}else{
                  
  						    window.location.assign("<?php echo ROOT_URL;?>home");
  							}
  					}
  		  });
  })



$("#forgotPass").click(function(){
        if($("#email").val()==""){
                   $("#LoginAlert").addClass('alert-danger')
                   $("#LoginAlert"). removeClass('alert-success')
                   $("#LoginAlert").html("لطفاً ایمیل خود را وارد کنید").show();
            return;
        }

        if(page_nav==7){
          ctrlpage='forgotPassword';
        }else{
        ctrlpage='users/forgotPassword';
        }
	
      $.ajax({
        type:"POST",
        url:ctrlpage,
        data: "email=" + $("#email").val(),

        success: function(result){
                
                if(result.indexOf('!') > -1){
                  $("#LoginAlert").addClass('alert-danger')
                  $("#LoginAlert"). removeClass('alert-success')
                  $("#LoginAlert").html(result).show();
                }else{
                   $("#LoginAlert").removeClass('alert-danger')
                   $("#LoginAlert").addClass('alert-success')
                   $("#LoginAlert").html(result).show();
                }
            }
        });
  	})


function passValidity(field){
  output="";
  var pattern= new RegExp(/^.{6,}$/);
    if(pattern.test($(field).val()) && $(field).val()!=0 ){
     
     
      output=true;
    }else {
      
      
      output= false;
    }
  return output;
}



function numValidity(field){
  output="";
  var pattern= new RegExp(/^\d{0,12}(\.\d{1,9})?$/);
    if(pattern.test($(field).val()) && $(field).val()!=0 ){
      $(field).removeClass("is-invalid");
      output=true;
    }else {
      $(field).addClass("is-invalid");
      output= false;
    }
  return output;
}



function adrrValidity(field){
  output="";
  var pattern= new RegExp(/^[a-zA-Z0-9]+$/);
    if(pattern.test($(field).val())){
      $(field).removeClass("is-invalid");
      output=true;
    }else {
      $(field).addClass("is-invalid");
      output= false;
    }
  return output;
}

$(document).ready(function () {

       $(".navbar-nav").children('li').eq(page_nav).addClass("active"); //$(".navbar-nav :nth-child("+page+")").html();
    
          $(function () {
			  $('[data-toggle="popover"]').popover()
			})
});

$("#contactUsBtn").click(function(){
  
    var myFormData= new FormData();
   
    myFormData.append("senderName",$("#senderName").val());
    myFormData.append("senderEmail",$("#senderEmail").val());
    myFormData.append("messageBody",$("#messageBody").val());
   
    //console.log(myFormData.getAll("shebaNum"))
    $.ajax({
        type:"POST",
        url: "Home/contactUs",
        
           data: myFormData,   
           cache: false,
           contentType: false,
           enctype: 'multipart/form-data',
           processData: false,
        success: function(output){
          if(output=='success')
          {
             ("#ContactAlert").html('پیام شما با موفقیت ارسال شد').show()
          }else{
             alert(output)
          }
        }
    });


});

    </script>
  </body>
</html>
