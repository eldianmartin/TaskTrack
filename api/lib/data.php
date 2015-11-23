<?php
class role{
		
   public function getbyid($groupID){
    $Connection =new CreateConnection();
	  $mysqli = $Connection->connectToDatabase();	
   
		$SQL = "SELECT name FROM role WHERE group_id=".$groupID."";
		
    $result =$mysqli->query("$SQL");	
    
		$list = array();
		while($row =$result->fetch_object())
		{
			$list[] = $row;
		} 	
			
		$Connection->closeConnection();
		return $list;	
  }	
  
}
class group{
		
   public function getall(){
    $Connection =new CreateConnection();
	  $mysqli = $Connection->connectToDatabase();	
   
		$SQL = "SELECT * FROM usergroup WHERE id!=1";
		
    $result =$mysqli->query("$SQL");	
    
		$list = array();
		while($row =$result->fetch_object())
		{
			$list[] = $row;
		} 	
			
		$Connection->closeConnection();
		return $list;	
  }	
  
}
class state{		
   public function getall(){
    $Connection =new CreateConnection();
	  $mysqli = $Connection->connectToDatabase();	
   
		$SQL = "SELECT * FROM state";
		
    $result =$mysqli->query("$SQL");	
    
		$list = array();
		while($row =$result->fetch_object())
		{
			$list[] = $row;
		} 	
			
		$Connection->closeConnection();
		return $list;	
  }	
  
}
class priority{		
   public function getall(){
    $Connection =new CreateConnection();
	  $mysqli = $Connection->connectToDatabase();	
   
		$SQL = "SELECT * FROM priority";
		
    $result =$mysqli->query("$SQL");	
    
		$list = array();
		while($row =$result->fetch_object())
		{
			$list[] = $row;
		} 	
			
		$Connection->closeConnection();
		return $list;	
  }	
  
}
?>