<h2 class="pt-2"> مدیریت کاربران</h2>

<div class=" col-md-6 input-group"> 
			<div>
			  <label class="input-group-text" for="msgCondition">وضعیت</label>
			  </div>
			  <select class="custom-select flex-3" id="msgCondition">
			    <option selected>همه</option>
			    <option >جدید</option>
			    <option >مشاهده شده</option>
			    <option >پاسخ داده شده</option>
			 
			  </select>
			<div>
			  <label class="input-group-text" for="numberToShow">نمایش در صفحه</label>
			  </div>
			  <select class="custom-select flex-3" id="numberToShow">
			    <option selected>20</option>
			    <option >50</option>
			    <option >100</option>
			  
			  </select>

			  <button type="button" name="search" id="loadBtn" style=" color: #308fdd;"><i class="fas fa-retweet fa-lg"></i></button>  
</div>

<div>
	
		<table class="table table-sm  table-striped table-bordered" >

							  <thead class="thead-dark">
							    <tr>
							     
							      <th scope="col">ایمیل</th>
							      <th scope="col">نام فرستنده</th>
							      <th scope="col">وضعیت</th>
							      <th scope="col">زمان ارسال</th>
							      
							     
							    </tr>
							  </thead>
							  <tbody id="mangeMsgTable">

							  <!---PHP FILLS HERE-->

							</tbody>
				</table>
				
</div>
<nav >
	<ul class="pagination justify-content-center" id="tableFooter">
		

	</ul>		
</nav>
<script type="text/javascript">
$(document).ready(function(){
		var page=1;
		loadMsgTable(page);
		$("#loadBtn").click(function(){

				loadMsgTable(page);
				});

$("#tableFooter").on('click','.paginationlink', function(){
			 	
		           page = $(this).attr("id"); 
		          
		          loadMsgTable(page);  
		      });

});

		 
$("#mangeMsgTable").on('click','.tableRow', function(){


	var MsgNumber=$(this).closest("tr").attr("id");
	
				 		 		          
		$.ajax({
				type:'POST',
				url:"admin/checkSingleMsg",
				data:"MsgNumber="+MsgNumber,
				success: function(data){
	 	
				$("#mainBodyAdmin").html(data);

				}

			})

	});

function loadMsgTable(page){ 

	var groupIndex=$("#msgCondition option:selected").index();
	var numToShow=$("#numberToShow option:selected").val();

	var group="";
	  	switch (groupIndex){
	  		case 0:
			group="all"
			break;
			case 1:
			group="new"
			break;
			case 2:
			group="seen"
			break;
			case 3:
			group="answered"
			break;

	  	};

     


	$.ajax({

				type:"POST",
				url:"admin/UserMsgTable",
				data: "msgCondition=" + group +"&numToShow=" +numToShow +"&page="+ page,
				success: function(result){
					
				output=result.split("|||");
        		  $("#mangeMsgTable").html(output[0]);
        	
        		  $("#tableFooter").html(output[1]);
				}
			});


	}



</script>