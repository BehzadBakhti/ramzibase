<?php 

/**
* 
*/
class TableUpdates extends Controller
{
	protected function Index(){

		$viewmodel=new TableUpdateModel();
		$this -> returnView($viewmodel->Index(), true);
	}

		protected function orderBook(){
		$pair=$_POST['pair'];
		$buy_sell=$_POST['sell_buy'];
		$viewmodel=new TableUpdateModel();
		echo $viewmodel->orderBook($pair,$buy_sell);
	}

protected function userActiveOrders(){
		$pair=$_POST['pair'];
		$userId=$_POST['userId'];
		$viewmodel=new TableUpdateModel();
		echo $viewmodel->userActiveOrders($pair,$userId);
	}

protected function tradeBook(){
		
		$viewmodel=new TableUpdateModel();
		echo $viewmodel->tradeBook();
	}



protected function myBalanceTable(){
		
		$viewmodel=new TableUpdateModel();
		echo $viewmodel->myBalanceTable();
	}
}

 ?>