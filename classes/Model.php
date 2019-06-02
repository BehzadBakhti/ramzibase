<?php

abstract class Model{
protected $dbh;
protected $stmt;

	public function __construct(){
	$this->dbh= new PDO("mysql:host=".DB_HOST."; dbname=".DB_NAME, DB_USER, DB_PASS);
	$this->dbh->exec("SET CHARACTER SET 'utf8'");
	$this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}

	public function query($query){
		$this->stmt=$this->dbh->prepare($query);
	}

	public function dataBind($param,$value,$type=null){
		if(is_null($type)){

			switch (true) {
				case is_int($value):
					$type=PDO::PARAM_INT;
					break;
				case is_bool($value):
					$type=PDO::PARAM_BOOL;
					break;
				case is_null($value):
					$type=PDO::PARAM_NULL;
					break;
				default:
					$type=PDO::PARAM_STR;

			}
		}
		$this->stmt->bindValue($param,$value,$type);

	}

	public function executeQuery(){
		try{
			$this->stmt->execute();

			} catch (PDOException $e) {
		    echo  $e->getMessage ();
		}

		
	}

	public function singleResult(){ 
		$this->executeQuery();
		return $this->stmt->fetch(PDO::FETCH_ASSOC);

	}

	public function resultSet(){ 
		$this->executeQuery();
		return $this->stmt->fetchAll(PDO::FETCH_ASSOC);

	}
}