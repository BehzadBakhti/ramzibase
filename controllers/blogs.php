<?php

class Blogs extends Controller
{
	protected function Index(){

		$viewmodel=new BlogModel();
		$this -> returnView($viewmodel->Index(), true);	
	}




protected function BlogTable(){
		$myBlogModel= new BlogModel();
		$table=$myBlogModel->BlogTable();
		echo $table;

}

protected function BlogHome(){
	$myBlogModel= new BlogModel();
	$data=$myBlogModel->BlogHome();
	echo $data;

}


protected function BlogPage(){
	$myBlogModel= new BlogModel();
	$data=$myBlogModel->BlogPage();
	echo $data;

}


protected function saveBlog(){
	$title=$_POST['title'];
	$body=$_POST['body'];
	$publishState=$_POST['publishState'];
	$BlogId=explode('_', $_POST['AncId'])[1];

		$myBlogModel= new BlogModel();
		$out=$myBlogModel->saveBlog
	($title,$body,$publishState,$BlogId);
	
			echo "اطلاعیه با موفقیت ثبت شد";

}	

protected function singleBlogData(){
	$BlogId=explode('_', $_POST['AncId'])[1];
		$myBlogModel= new BlogModel();
		$out=$myBlogModel->singleBlogData($BlogId);
	
			echo json_encode($out);
}


protected function deleteBlogDB(){
	$BlogId=explode('_', $_POST['AncId'])[1];
		$myBlogModel= new BlogModel();
		$out=$myBlogModel->deleteBlogDB($BlogId);
	
}
//End of file*****
}