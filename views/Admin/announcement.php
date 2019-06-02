<h1 class="pt-2"> اطلاعیه ها</h1>


	<div class="row  mx-5">
		
				<div class="col-md-12 py-3 border rounded">
					<form role="form">
						<div class="form-group">
							  <div class="form-inline form-group">
									<div  class="w-10 text-left">
										عنوان:
									</div>
									<input type="text" class="form-control w-73" autocomplete="off"  id="announceTitle" placeholder="عنوان اطلاعیه را وارد نمایید" />
							 </div>


						</div>
						<div class="form-group">
							 

						<div class="form-inline form-group">

							<div  class="w-10 text-left">
								متن اطلاعیه:
							</div>
							
							<textarea class="form-control w-73" style="height: 100px;" id="announceBody"></textarea>
						</div>
						</div>
						<button type="button" class="btn btn-danger" id="newAnnounceBtn">
							اطلاعیه جدید
						</button>
						 
						<button type="button" class="btn btn-success" id="publishBtn">
							انتشار 
						</button>

						<button type="button" class="btn btn-primary" id="draftBtn">
							ذخیره پیشنویس
						</button>
						<button type="button" class="btn btn-primary" id="deleteAnnounce">
							حذف اطلاعیه
						</button>

					</form>

				</div>

		<div class="col-md-12 py-3 my-2 border rounded" style="height: 400px; overflow: auto;">
			<table class="table">
				<thead>
					<tr>
						<th>
							#
						</th>
						<th>
							عنوان اطلاعیه
						</th>
						<th>
							تاریخ 
						</th>
						<th>
							وضعیت
						</th>

						<th>
							حذف
						</th>
					</tr>
				</thead>
				<tbody id="AnnounceTableBody">
					

				</tbody>
				
			</table>
			
		</div>
	</div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="deleteAnnounceModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle">حذف اطلاعیه</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p id="modalText">آیا میخواهید اطلاعیه حذف شود؟</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">خروج</button>
        <button type="button" class="btn btn-warning " id="deleteAnnounceModalBtn"  data-dismiss="modal">حذف</button>
      </div>
    </div>
  </div>
</div>




<script type="text/javascript">
	AncId='AncId_0';
	$(document).ready(function(){
		loadAnnounceTableJs()

	})

//EVENTS ********************************************

$("#publishBtn").click(function(){
	saveAnnounceJs('published');
	loadAnnounceTableJs()
})


$("#draftBtn").click(function(){
	saveAnnounceJs('draft');
	loadAnnounceTableJs()
})

$("#deleteAnnounce").click(function(){
	$('#deleteAnnounceModal').modal();
	
	
})

$("#deleteAnnounceModalBtn").click(function(){

	deleteAnnounceJS()
	
})


$("#newAnnounceBtn").click(function(){
	AncId='AncId_0';
	$("#announceTitle").val("");
	$("#announceBody").val("");

})


$("#AnnounceTableBody").on('click','tr', function(){
	AncId = $(this).attr("id");
   					
		          
		$.ajax({
				type:'POST',
				url:"posts/singleAnnounceData",
				data:"AncId="+AncId,
				success: function(data){
	array=JSON.parse(data);

	 	$("#announceTitle").val(array['title'])
		$("#announceBody").val(array['body'])	

				}

			})
			
});





// Functions*************************************
function saveAnnounceJs(state){
	if($("#announceTitle").val()==""){

		return
	}
	if($("#announceBody").val()==""){

		return
	}
		title=$("#announceTitle").val();
		body=$("#announceBody").val();

		publishState=state;

			$.ajax({

						type:"POST",
						url:"posts/saveAnnounce",
						data:"title="+title+"&body="+body+ "&publishState="+publishState+"&AncId="+AncId,
						success: function(result){
					
		        		alert(result)
		        		$("#announceTitle").val("");
						$("#announceBody").val("");
		        	
						}
					});

}

function  loadAnnounceTableJs(){

	$.ajax({

				type:"GET",
				url:"posts/AnnounceTable",
				
				success: function(result){
			
        		  $("#AnnounceTableBody").html(result);
        	
				}
			});

}

function deleteAnnounceJS(){

      if(AncId=='AncId_0'){
      	return;
      }else{
			$.ajax({
					type:'POST',
					url:"posts/deleteAnnounceDB",
					data:"AncId="+AncId,
					success: function(data){
			
					AncId='AncId_0';
					loadAnnounceTableJs()
					$("#announceTitle").val("");
					$("#announceBody").val("");
					}

				})
		}
}


</script>