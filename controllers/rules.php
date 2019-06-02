<?php

class Rules extends Controller
{
	protected function Index(){

		$viewmodel=new RulesModel();
			
					
					$this -> returnView($viewmodel->Index(), true);
			
	}

	
//End of file*****
}