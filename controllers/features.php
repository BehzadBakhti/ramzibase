<?php

class Features extends Controller
{
	protected function Index(){

		$viewmodel=new FeaturesModel();
			
					
					$this -> returnView($viewmodel->Index(), true);
			
	}

	
//End of file*****
}