<?php
/**
* 
*/
class Router 
{
	private $controller;
	private $action;
	private $request;


	public function __construct($request)
	{
		
		$this  -> request=$request;
			if($this -> request['controller']== ""){

				$this-> controller='home';
			}	else{
				$this -> controller=$this->request['controller'];

			}
			if($this->request['action']==""){
				$this->action='index';
			}else{
				$this->action=$this->request['action'];
			}
//print_r($this->action);
		}

		public function createController(){

			//check class
			if(class_exists($this->controller)){
				$parents=class_parents($this->controller);
				//check extension
				if(in_array('controller', $parents)){
						if(method_exists($this->controller, $this->action)){

							if($this->controller=='admin'){      
								if(!isset($_SESSION['user_level']) OR $_SESSION['user_level']=='ordinary'){
							
										$this->action='access_denied';
									}else if($this->action=='highLevelOps' AND $_SESSION['user_level']!='owner'){
										$this->action='access_denied';
									}
							}
							
							return new $this->controller($this->action,$this->request);
								

						}else
						{
							//method not found
							$this->controller='fourofour';
							$this->action='index';
							$request['action']=$this->action;
							$request['controller']=	$this->controller;
								return new $this->controller($this->action,$this->request);
						}

return;

				}else{
					//method not found
					$this->controller='fourofour';
							$this->action='index';
							$request['action']=$this->action;
							$request['controller']=	$this->controller;
						return new $this->controller($this->action,$this->request);
				}
			}else{
							$this->controller='fourofour';
							$this->action='index';
							$request['action']=$this->action;
							$request['controller']=	$this->controller;
				//method not found
						return new $this->controller($this->action,$this->request);
			}
		}
	}
