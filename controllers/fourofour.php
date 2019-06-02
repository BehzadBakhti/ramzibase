<?php

class FourOFour extends Controller
{
	protected function Index(){

		$viewmodel=new FourOFourModel();
			
					
					$this -> returnView($viewmodel->Index(), true);
			
	}

	
//End of file*****
}