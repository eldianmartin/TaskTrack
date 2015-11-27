<?php
class issue{
		var $id;
		var $creator;
		var $created;
		var $modifier;
    var $modified;
    var $title;
    var $description;
    var $customer_id;
    var $programer_id;
    var $tester_id;
    var $priority;
    var $state;
		
 
	public function insert(){
    $Connection =new CreateConnection();
	  $mysqli = $Connection->connectToDatabase();
	 
	  $this->title=$mysqli->real_escape_string($this->title);
	  $this->description=$mysqli->real_escape_string($this->description);
    
	  $SQL = "insert into issue(creator,created,title,description,customer_id,programer_id,tester_id,priority,state) values(".$this->creator.",NOW(),'".$this->title."','".$this->description."',".$this->customer_id.",".$this->programer_id.",".$this->tester_id.",".$this->priority.",".$this->state.")";	
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
	 
	  $this->title=$mysqli->real_escape_string($this->title);
	  $this->description=$mysqli->real_escape_string($this->description);
    
	  $SQL = "update issue set modifier=".$this->modifier.",modified=NOW(),title='".$this->title."',description='".$this->description."',customer_id=".$this->customer_id.",programer_id=".$this->programer_id.",tester_id=".$this->tester_id.",priority=".$this->priority.",state=".$this->state." Where id=".$this->id;	
	  $result = $mysqli->query($SQL);
		if(!$result){
			throw new Exception($mysqli->error);
		}		
		
  }	
   public function getall(){
    $Connection =new CreateConnection();
	  $mysqli = $Connection->connectToDatabase();	
    
		$SQL = "SELECT i.*,u.name as creatorname  FROM issue i inner join user u on i.creator = u.id ORDER BY created DESC";
		
    $result =$mysqli->query("$SQL");	
    
		$list = array();
		while($row =$result->fetch_object())
		{
			$list[] = $row;
		} 	
			
		$Connection->closeConnection();
		return $list;	
  }	
   public function getbyid($id){
    $Connection =new CreateConnection();
	  $mysqli = $Connection->connectToDatabase();
		
		$SQL = "SELECT * FROM issue WHERE id=".$id."";
		
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