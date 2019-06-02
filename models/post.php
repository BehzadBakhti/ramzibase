<?php 





class PostModel extends Model


{

	function Index()
	{
		return;
	}




function AnnounceTable(){
  	$output="";
	 $query="SELECT * FROM announce ORDER BY announce_date DESC ";
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
					      	'.$row["announce_date"].'
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

function AnnounceHome(){
  	$output='<div >';
	 $query="SELECT * FROM announce WHERE (status='published')  ORDER BY announce_date DESC ";
	$this->query($query);
	$result= $this-> resultSet();
	$totlaRows=sizeof($result);
			/// create table

			for($i=0;$i<$totlaRows;$i++){

				if (isset($result[$i])) {
						$row=$result[$i];

					  	$output.='
					  	<div class="m-3">
				<div><span  style=" font-size:18px;">'.$row["title"].'</span> <span calss="text-muted"> '.date('Y-M-d',strtotime($row["announce_date"])).'</span></div>
				<div> '.implode(' ', array_slice(explode(' ', $row["body"]), 0, 15)).'...<a href="'. ROOT_URL.'posts"> متن کامل</a>  </div></div>
					  	';
					  }

					}
$output.='</div >';
		return $output;

}

function AnnouncePage(){
  	$output='<div >';
	 $query="SELECT * FROM announce WHERE (status='published')  ORDER BY announce_date DESC ";
	$this->query($query);
	$result= $this-> resultSet();
	$totlaRows=sizeof($result);
			/// create table

			for($i=0;$i<$totlaRows;$i++){

				if (isset($result[$i])) {
						$row=$result[$i];

					  	$output.='
					  	<div class="m-5">
				<div><span  style=" font-size:18px;">'.$row["title"].'</span> <span class="mx-5 text-right w-60"> '.date('Y-M-d',strtotime($row["announce_date"])).'</span></div>
				<div> '. $row["body"].' </div></div>
					  	';
					  }

					}
		$output.='</div >';
		return $output;

}

 function saveAnnounce($title,$body,$publishState,$announceId){
 	if($announceId>0){
	 	$query="UPDATE announce SET title=:title, body=:body, status=:status WHERE id=:id ";
	 	$this->query($query);
		$this-> dataBind(':id',$announceId);

 	}else{
		$query="INSERT INTO announce (title, body, status) VALUES (:title, :body, :status)";
		$this->query($query);

 	}

	
	$this-> dataBind(':title',$title);
	$this-> dataBind(':body',$body);
	$this-> dataBind(':status',$publishState);
	$result= $this-> executeQuery();

}	


function  singleAnnounceData ($announceId){
 
	 	$query="SELECT * FROM announce WHERE id=:id ";
		$this->query($query);
		$this-> dataBind(':id',$announceId);
	
		$result= $this-> singleResult();
		return $result;
}	

function  deleteAnnounceDB ($announceId){
 
	 	$query="DELETE FROM announce WHERE id=:id ";
		$this->query($query);
		$this-> dataBind(':id',$announceId);
	
		$result= $this-> executeQuery();
		return;
}

//End of file**********
}