<?php
if($_SERVER['REQUEST_METHOD'] == "POST"){
	
	// Get data
	$json = file_get_contents('php://input');
	$obj = json_decode($json);
	$_GET["action"]($obj);
	$result = $_GET["action"]($obj);
	
}else{
	$json = array("status" => 0, "msg" => $_SERVER['REQUEST_METHOD']);
}
function login($obj){
	$name = $obj->name;
	return array("status" => 1, "msg" => $name);
	
}


/* Output header */
	header('Content-type: application/json');
	echo json_encode($result);


?>