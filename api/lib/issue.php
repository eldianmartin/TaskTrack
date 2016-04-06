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
    
		$SQL = "SELECT i.*,u.name as creatorname  FROM issue i inner join user u on i.creator = u.id ORDER BY i.state,created DESC";
		
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
		
		$SQL = "SELECT i.*,u.name as creatorname,u1.name as modifiername FROM issue i left join user u on i.creator = u.id left join user u1 on i.modifier = u1.id WHERE i.id=".$id." ";
		
    $result =$mysqli->query("$SQL");	
    
		$list = array();
		while($row =$result->fetch_object())
		{
			$list[] = $row;
		} 	
			
		$Connection->closeConnection();
		return $list;	
  }	
  public function getstatereport(){
    $Connection =new CreateConnection();
	  $mysqli = $Connection->connectToDatabase();	
    
		$SQL = "SELECT s.* , (Select Count(1) from issue where state = s.id) as issuecount FROM state s order by id";
		
    $result =$mysqli->query("$SQL");	
    
		$list = array();
		while($row =$result->fetch_object())
		{
			$list[] = $row;
		} 	
			
		$Connection->closeConnection();
		return $list;	
  }	
  public function gettopcustomer($obj){
    $Connection =new CreateConnection();
	  $mysqli = $Connection->connectToDatabase();	
    $from=$mysqli->real_escape_string($obj->from);
     $to=$mysqli->real_escape_string($obj->to);
		$SQL = "select u.id,u.name, ";
    $SQL .="(select count(1) from issue where (state = 1 or state=2) and customer_id=u.id and date(created) >= '".$from."' AND date(created) <= '".$to."') as onprogress, ";
    $SQL .="(select count(1) from issue where (state = 3 or state=4 or state=5) and customer_id=u.id and date(created) >= '".$from."' AND date(created) <= '".$to."') as done, ";
     $SQL .="(select count(1) from issue where (state = 6) and customer_id=u.id and date(created) >= '".$from."' AND date(created) <= '".$to."') as reject, ";
     $SQL .="(select count(1) from issue where  customer_id=u.id and date(created) >= '".$from."' AND date(created) <= '".$to."') as total "  ;
    $SQL .="from user u where u.group_id = 7 order by total desc";
    $result =$mysqli->query("$SQL");	
   
		$list = array();
		while($row =$result->fetch_object())
		{
			$list[] = $row;
		} 	
			
		$Connection->closeConnection();
		return $list;	
  }	
  public function gettopprogramer($obj){
    $Connection =new CreateConnection();
	  $mysqli = $Connection->connectToDatabase();	
    $from=$mysqli->real_escape_string($obj->from);
     $to=$mysqli->real_escape_string($obj->to);
		$SQL = "select u.id,u.name, ";
    $SQL .="(select count(1) from issue where (state = 1 or state=2) and programer_id=u.id and date(created) >= '".$from."' AND date(created) <= '".$to."') as onprogress, ";
    $SQL .="(select count(1) from issue where (state = 3 or state=4 or state=5) and programer_id=u.id and date(created) >= '".$from."' AND date(created) <= '".$to."') as done, ";
     $SQL .="(select count(1) from issue where (state = 6) and programer_id=u.id and date(created) >= '".$from."' AND date(created) <= '".$to."') as reject, ";
     $SQL .="(select count(1) from issue where  programer_id=u.id and date(created) >= '".$from."' AND date(created) <= '".$to."') as total "  ;
    $SQL .="from user u where u.group_id = 4 order by total desc";
    $result =$mysqli->query("$SQL");	
		$list = array();
		while($row =$result->fetch_object())
		{
			$list[] = $row;
		} 	
	
		$Connection->closeConnection();
		return $list;	
  }	
  public function getaging(){
    $Connection =new CreateConnection();
    $mysqli = $Connection->connectToDatabase();	
    
    $SQL = "select i.title, IFNULL(u1.name,'Unassigned') as programer_name,IFNULL(u2.name,'Unassigned') as customer_name,i.created, DATEDIFF(Now(), date(i.created)) AS days,i.customer_id,i.programer_id from issue i left join user u1 on u1.id = i.programer_id left join user u2 on u2.id = i.customer_id where i.state = 1 or i.state = 2 order by days Desc";
		
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