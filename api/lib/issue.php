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
 
}
?>