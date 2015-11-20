<?php 
	class CreateConnection
	{
		var $host="localhost";
    	var $username="root";
    	var $password="";
    	var $database="tasktrack";
    	var $myconn;
		
		
		function connectToDatabase()
    	{
        	$conn= mysqli_connect($this->host,$this->username,$this->password,$this->database);
        	if($conn)// testing the connection
        	{   
				$this->myconn = $conn;            
        	}
        	return $this->myconn;

    	}
		
		
				
		function closeConnection() // close the connection
    	{
        	mysqli_close($this->myconn);        
    	}
	}
?>