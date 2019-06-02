<?php 





class BlogModel extends Model


{

	function Index()
	{
		return;
	}




function BlogTable(){
  	$output="";
	 $query="SELECT * FROM Blog ORDER BY Blog_date DESC ";
	$this->query($query);
	$result= $this-> resultSet();
	$totlaRows=sizeof($result);
			/// create table

			for($i=0;$i<$totlaRows;$i++){

				if (isset($result[$i])) {
						$row=$result[$i];

					  	$output.='
						<tr class="tableRow" id="AncId_'.$row["id"].'">
					      <td> 
					      	<div class="tableCell">
					      	'.($i+1).'
					     	 </div>
					      </td>
					      <td>
					      	<div class="tableCell">
					      	'.$row["title"].'
							</div>
					      </td>
					      <td>
					      	<div class="tableCell">
					      	'.$row["Blog_date"].'
							</div>
					      </td>
					      <td>
						      <div class="tableCell">
						      '.$row["status"].'
						      </div>
					      </td>

					   

					      	
					    </tr>
					  	';
					  }

					}

			//*******************************
			
		//*************************
		return $output;

}

function BlogHome(){
  	$output='<div >';
	 $query="SELECT * FROM Blog WHERE (status='published')  ORDER BY Blog_date DESC ";
	$this->query($query);
	$result= $this-> resultSet();
	$totlaRows=sizeof($result);
			/// create table

			for($i=0;$i<$totlaRows;$i++){

				if (isset($result[$i])) {
						$row=$result[$i];

					  	$output.='
					  	<div class="m-3">
				<div><span  style=" font-size:18px;">'.$row["title"].'</span> <span calss="text-muted"> '.date('Y-M-d',strtotime($row["Blog_date"])).'</span></div>
				<div> '.implode(' ', array_slice(explode(' ', $row["body"]), 0, 15)).'...<a href="'. ROOT_URL.'Blogs"> متن کامل</a>  </div></div>
					  	';
					  }

					}
$output.='</div >';
		return $output;

}

function BlogPage(){
  	$output='<div >';
	 $query="SELECT * FROM Blog WHERE (status='published')  ORDER BY Blog_date DESC ";
	$this->query($query);
	$result= $this-> resultSet();
	$totlaRows=sizeof($result);
			/// create table

			for($i=0;$i<$totlaRows;$i++){

				if (isset($result[$i])) {
						$row=$result[$i];

					  	$output.='
					  	<div class="m-5">
				<div><span  style=" font-size:18px;">'.$row["title"].'</span> <span class="mx-5 text-right w-60"> '.date('Y-M-d',strtotime($row["Blog_date"])).'</span></div>
				<div> '. $row["body"].' </div></div>
					  	';
					  }

					}
		$output.='</div >';
		return $output;

}

 function saveBlog($title,$body,$publishState,$BlogId){
 	if($BlogId>0){
	 	$query="UPDATE Blog SET title=:title, body=:body, status=:status WHERE id=:id ";
	 	$this->query($query);
		$this-> dataBind(':id',$BlogId);

 	}else{
		$query="INSERT INTO Blog (title, body, status) VALUES (:title, :body, :status)";
		$this->query($query);

 	}

	
	$this-> dataBind(':title',$title);
	$this-> dataBind(':body',$body);
	$this-> dataBind(':status',$publishState);
	$result= $this-> executeQuery();

}	


function  singleBlogData ($BlogId){
 
	 	$query="SELECT * FROM Blog WHERE id=:id ";
		$this->query($query);
		$this-> dataBind(':id',$BlogId);
	
		$result= $this-> singleResult();
		return $result;
}	

function  deleteBlogDB ($BlogId){
 
	 	$query="DELETE FROM Blog WHERE id=:id ";
		$this->query($query);
		$this-> dataBind(':id',$BlogId);
	
		$result= $this-> executeQuery();
		return;
}

//End of file**********
}