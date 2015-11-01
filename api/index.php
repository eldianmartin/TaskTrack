<?php
if($_SERVER['REQUEST_METHOD'] == "POST"){	
	$obj = json_decode(file_get_contents('php://input'));
	$_GET["action"]($obj);
	$result = $_GET["action"]($obj);	
}else{
	$json = array("status" => 0, "msg" => $_SERVER['REQUEST_METHOD']);
}
function login($obj){
	$name = isset($obj->name)?$obj->name:'';
	$password = isset($obj->password)?$obj->password:'';
	$rememberme = isset($obj->rememberme)?$obj->rememberme:false;
  
	$Log->in($userName,md5($userPassword),$rememberMe)
  if(){	
			
			
  }else{	
				
  }
	return array("status" => 1, "msg" => $rememberme );
}


/* Output header */
header('Content-type: application/json');
echo json_encode($result);


?>