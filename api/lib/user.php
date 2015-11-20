<?php
class user{
		var $id;
		var $name;
		var $password;
		var $type_id;		
		
	public function getbynameandpassword($name,$password){
    $Connection =new CreateConnection();
	  $mysqli = $Connection->connectToDatabase();
		$name=$mysqli->real_escape_string($name);
    $password=$mysqli->real_escape_string($password);
		$SQL = "SELECT * FROM user WHERE name='".$name."' and password='". $password ."' ";
		
    $result =$mysqli->query("$SQL");	
    
		$listUser = array();
		while($row =$result->fetch_object())
		{
			$listUser[] = $row;
		} 	
			
		$Connection->closeConnection();
		return $listUser;	
  }	
  public function getbyid($id){
    $Connection =new CreateConnection();
	  $mysqli = $Connection->connectToDatabase();
		$name=$mysqli->real_escape_string($name);
    $password=$mysqli->real_escape_string($password);
		$SQL = "SELECT * FROM user WHERE id=".$id."";
		
    $result =$mysqli->query("$SQL");	
    
		$listUser = array();
		while($row =$result->fetch_object())
		{
			$listUser[] = $row;
		} 	
			
		$Connection->closeConnection();
		return $listUser;	
  }	
   public function getallexceptsys(){
    $Connection =new CreateConnection();
	  $mysqli = $Connection->connectToDatabase();	
    $UserType = new UserType();
		$SQL = "SELECT id,name,type_id FROM user WHERE id!=".$UserType->System."";
		
    $result =$mysqli->query("$SQL");	
    
		$listUser = array();
		while($row =$result->fetch_object())
		{
			$listUser[] = $row;
		} 	
			
		$Connection->closeConnection();
		return $listUser;	
  }	
	public function insert($name,$password,$type_id){
    $Connection =new CreateConnection();
	  $mysqli = $Connection->connectToDatabase();

	  $name=$mysqli->real_escape_string($name);
	  $password=$mysqli->real_escape_string($password);
	  $type_id=$mysqli->real_escape_string($type_id);
    
	  $SQL = "insert into user(name,password,type_id) values('".$name."','".$password."',".$type_id.")";	
	  $result = $mysqli->query($SQL);
		if(!$result){
			throw new Exception($mysqli->error);
		}		
		$id= $mysqli->insert_id;
		return $id;
     
     
    
  }	
}
?>