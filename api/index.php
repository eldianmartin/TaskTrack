<?php
session_start();
require_once("lib/connection.php");
require_once("lib/enum.php");
require_once("lib/user.php");
if($_SERVER['REQUEST_METHOD'] == "POST"){	
	$obj = json_decode(file_get_contents('php://input'));	
	$result = $_GET["action"]($obj);	
}else{
	$json = array("status" => 0, "msg" => $_SERVER['REQUEST_METHOD']);
}

function session($obj){

  if(!isset($_SESSION['id']) && isSet($_COOKIE["tasktrack"])){	  
	  parse_str($_COOKIE["tasktrack"]);
    $user =new user();	
	  $listUser = $user->getbyid($id);
	  if(count($listUser)>0){	    
	    $_SESSION['id'] = $listUser[0]->id;
	    $_SESSION['name'] = $listUser[0]->name;  
	    $_SESSION['type_id'] = $listUser[0]->type_id;   
    }else{
        logout();
    }			
	 }
   
  $id=isset($_SESSION['id'])?$_SESSION['id']:'';
  $name=isset($_SESSION['id'])?$_SESSION['id']:'';
  $typeid=isset($_SESSION['id'])?$_SESSION['id']:'';
    
  return array("id" =>  $id, "name" =>$name,"type_id" => $typeid);	
}

function login($obj){
	$name = isset($obj->name)?$obj->name:'';
	$password = isset($obj->password)?$obj->password:'';
	$rememberme = isset($obj->rememberme)?$obj->rememberme:false;
	
  $user =new user();	
  $listUser = $user->getbynameandpassword($name,$password);
  if(count($listUser)>0){	    
    $_SESSION['id'] = $listUser[0]->id;
    $_SESSION['name'] = $listUser[0]->name;  
    $_SESSION['type_id'] = $listUser[0]->type_id;
    
    if($rememberme){
      setcookie("tasktrack", "id=".$listUser[0]->id, time() + 86400,"/");	
	}
	return array("status" => "success", "msg" => "Login Successful");			
  }else{	
  return array("status" => "warning", "msg" => "Your User name and password is incorrect!" );
  }

}

function logout($obj){
    setcookie ("tasktrack","", time() - 3600,"/");
    $_SESSION['id'] = '';
    $_SESSION['name'] = '';
    $_SESSION['type_id'] = ''; 

}
function createuser($obj){
try {
  $user =new user();	
  $name = isset($obj->name)?$obj->name:'';
	$password = isset($obj->password)?$obj->password:'';
	$type_id = isset($obj->type_id)?$obj->type_id->key:0;
  
  $id = $user->insert($name,$password,$type_id);
  if(isset($id)){
    return array("status" => "success", "msg" => "Create Successful");			
  }else{
    return array("status" => "warning", "msg" => "Create Fail");			
  }
}catch (Exception $e) {			
  return array("status" => "warning", "msg" =>$e->getMessage());		
		
} 
	
 
}
function getusertype($obj){
   $UserType = new UserType();  
   $result = array();
    foreach($UserType->array as $item => $itemkey)
  	{
      if($itemkey != 1){
        array_push($result,array("key" => $itemkey, "value" => $item ));
      }
			  
  	}
    return $result;
  
}
function binddatauser($obj){
    $user =new user();	
	 return $user->getallexceptsys();
}
/* Output header */
header('Content-type: application/json');
echo json_encode($result);


?>