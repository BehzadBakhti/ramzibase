<?php

class Posts extends Controller
{
	protected function Index(){

		$viewmodel=new PostModel();
		$this -> returnView($viewmodel->Index(), true);	
	}




protected function AnnounceTable(){
		$myPostModel= new PostModel();
		$table=$myPostModel->AnnounceTable();
		echo $table;

}

protected function AnnounceHome(){
	$myPostModel= new PostModel();
	$data=$myPostModel->AnnounceHome();
	echo $data;

}


protected function AnnouncePage(){
	$myPostModel= new PostModel();
	$data=$myPostModel->AnnouncePage();
	echo $data;

}


protected function saveAnnounce(){
	$title=$_POST['title'];
	$body=$_POST['body'];
	$publishState=$_POST['publishState'];
	$announceId=explode('_', $_POST['AncId'])[1];

		$myPostModel= new PostModel();
		$out=$myPostModel->saveAnnounce($title,$body,$publishState,$announceId);
	
			echo "اطلاعیه با موفقیت ثبت شد";

}	

protected function singleAnnounceData(){
	$announceId=explode('_', $_POST['AncId'])[1];
		$myPostModel= new PostModel();
		$out=$myPostModel->singleAnnounceData($announceId);
	
			echo json_encode($out);
}


protected function deleteAnnounceDB(){
	$announceId=explode('_', $_POST['AncId'])[1];
		$myPostModel= new PostModel();
		$out=$myPostModel->deleteAnnounceDB($announceId);
	
}
//End of file*****
}