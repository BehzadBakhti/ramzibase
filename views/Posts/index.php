



 <div>
  <div class="container mt-5 py-2   rtl " style="min-height: 55vh;">
  	<h3>اطلاعیه ها</h3>
  	<div class="col-sm-12 text-right" id="AnnouncePageBody">

	
  </div>
</div>
</div>


<script type="text/javascript">





 $(document).ready(function loadPageAncJS(){
          $.ajax({

        type:"GET",
        url:"posts/AnnouncePage",

        success: function(result){
 
			if(result=="<div ></div >"){
			   $("#AnnouncePageBody").html("<div >اطلاعیه ای موجود نیست</div >");
			   console.log(result)
			}else{

			     $("#AnnouncePageBody").html(result);
			}
        }
      });


})
</script>