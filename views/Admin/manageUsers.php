<h2 class="pt-2"> مدیریت کاربران</h2>

<div class=" col-md-6 input-group"> 
			<div>
			  <label class="input-group-text" for="userCondition">وضعیت</label>
			  </div>
			  <select class="custom-select flex-3" id="userCondition">
			    <option selected>همه</option>
			    <option >بررسی نشده</option>
			    <option >تایید شده</option>
			    <option >تایید نشده</option>
			   <option >بلاک شده</option>
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
							      <th scope="col">نام کاربری</th>
							      <th scope="col">وضعیت</th>
							      <th scope="col">تاریخ ثبت نام</th>
							      <th scope="col">تاریخ تایید</th>
							     
							    </tr>
							  </thead>
							  <tbody id="mangeUserTable">

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
		loadUsersTable(page);
		$("#loadBtn").click(function(){

				loadUsersTable(page);
				});

$("#tableFooter").on('click','.paginationlink', function(){
			 	
		           page = $(this).attr("id"); 
		          
		          loadUsersTable(page);  
		      });

});

		 
$("#mangeUserTable").on('click','.tableRow', function(){
			 		 var tableData = $(this).children("td").map(function() {
      				  return $(this).text();
   					}).get();
   					userEmail=tableData[0].replace( /\s/g, "");
		          
		$.ajax({
				type:'POST',
				url:"admin/checkUserData",
				data:"userEmailToCheck="+userEmail,
				success: function(data){
	 	
				$("#mainBodyAdmin").html(data);

				}

			})

	});

function loadUsersTable(page){ 

	var groupIndex=$("#userCondition option:selected").index();
	var numToShow=$("#numberToShow option:selected").val();

	var group="";
	  	switch (groupIndex){
	  		case 0:
			group="all"
			break;
			case 1:
			group="unconfirmed"
			break;
			case 2:
			group="confirmed"
			break;
			case 3:
			group="notconfirm"
			break;

			case 4:
			
			group="blocked"
			break;

	  	};

     


	$.ajax({

				type:"POST",
				url:"admin/AdminUsersTable",
				data: "userCondition=" + group +"&numToShow=" +numToShow +"&page="+ page,
				success: function(result){
					
				output=result.split("|||");
        		  $("#mangeUserTable").html(output[0]);
        	
        		  $("#tableFooter").html(output[1]);
				}
			});


	}



</script>