<?php

class AboutUs extends Controller
{
	protected function Index(){

					$viewmodel=new AboutUsModel();
					$this -> returnView($viewmodel->Index(), true);
				
	}

}