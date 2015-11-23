<?php
class user{
		var $id;
		var $name;
		var $password;
		var $group_id;		
		
  public function deletebyid($id){
    $Connection =new CreateConnection();
	  $mysqli = $Connection->connectToDatabase();
		$id=$mysqli->real_escape_string($id);
    
		$SQL = "DELETE FROM user WHERE id=".$id."";
		
    $mysqli->query("$SQL");	
    
		$Connection->closeConnection();
		
  }	
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
    
		$SQL = "SELECT id,name,group_id FROM user WHERE id!=1";
		
    $result =$mysqli->query("$SQL");	
    
		$list = array();
		while($row =$result->fetch_object())
		{
			$list[] = $row;
		} 	
			
		$Connection->closeConnection();
		return $list;	
  }	
  public function getbytype($type){
    $Connection =new CreateConnection();
	  $mysqli = $Connection->connectToDatabase();
		
		$SQL = "SELECT id,name FROM user WHERE group_id=".$type."";
		
    $result =$mysqli->query("$SQL");	
    
		$listUser = array();
		while($row =$result->fetch_object())
		{
			$listUser[] = $row;
		} 	
			
		$Connection->closeConnection();
		return $listUser;	
  }	
	public function insert($name,$password,$group_id){
    $Connection =new CreateConnection();
	  $mysqli = $Connection->connectToDatabase();

	  $name=$mysqli->real_escape_string($name);
	  $password=$mysqli->real_escape_string($password);
	  $group_id=$mysqli->real_escape_string($group_id);
    
	  $SQL = "insert into user(name,password,group_id) values('".$name."','".$password."',".$group_id.")";	
	  $result = $mysqli->query($SQL);
		if(!$result){
			throw new Exception($mysqli->error);
		}		
		$id= $mysqli->insert_id;
		return $id;
     
     
    
  }	
  public function update(){
    $Connection =new CreateConnection();
	  $mysqli = $Connection->connectToDatabase();
    
    $this->id=$mysqli->real_escape_string($this->id);
	  $this->name=$mysqli->real_escape_string($this->name);
	  $this->password=$mysqli->real_escape_string($this->password);
	  $this->group_id=$mysqli->real_escape_string($this->group_id);
    
	  $SQL = "update user set name ='".$this->name."',password= '".$this->password."',group_id= ".$this->group_id." where id=". $this->id."";	
	  $result = $mysqli->query($SQL);
		if(!$result){
			throw new Exception($mysqli->error);
		}		
	
  }	
}
?>