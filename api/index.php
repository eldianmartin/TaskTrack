<?php
session_start();
require_once("lib/connection.php");
require_once("lib/user.php");
require_once("lib/data.php");
require_once("lib/issue.php");
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
    $role =new role();
	  $listUser = $user->getbyid($id);
	  if(count($listUser)>0){	    
	    $_SESSION['id'] = $listUser[0]->id;
	    $_SESSION['name'] = $listUser[0]->name;  
	    $_SESSION['group_id'] = $listUser[0]->group_id;        
       $_SESSION['role'] = $role->getbyid($listUser[0]->group_id); 
    }else{
        logout();
    }			
	 }
   
  $id=isset($_SESSION['id'])?$_SESSION['id']:'';
  $name=isset($_SESSION['name'])?$_SESSION['name']:'';
  $group_id=isset($_SESSION['group_id'])?$_SESSION['group_id']:'';
    $listRole=isset($_SESSION['role'])?$_SESSION['role']:[];
  return array("id" =>  $id, "name" =>$name,"group_id" => $group_id,"role"=>$listRole);	
}

function login($obj){
	$name = isset($obj->name)?$obj->name:'';
	$password = isset($obj->password)?$obj->password:'';
	$rememberme = isset($obj->rememberme)?$obj->rememberme:false;
	
  $user =new user();	
  $listUser = $user->getbynameandpassword($name,$password);
  if(count($listUser)>0){	    
  $role =new role();
    $_SESSION['id'] = $listUser[0]->id;
    $_SESSION['name'] = $listUser[0]->name;  
    $_SESSION['group_id'] = $listUser[0]->group_id;
     $_SESSION['role'] = $role->getbyid($listUser[0]->group_id); 
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
    $_SESSION['group_id'] = ''; 
    $_SESSION['role']='';
}
function createuser($obj){
  try {
    $user =new user();	
    $name = isset($obj->name)?$obj->name:'';
	  $password = isset($obj->password)?$obj->password:'';
	  $group_id = isset($obj->group_id)?$obj->group_id:0;
  
    $id = $user->insert($name,$password,$group_id);
    if(isset($id)){
      return array("status" => "success", "msg" => "Create Successful");			
    }else{
      return array("status" => "warning", "msg" => "Create Fail");			
    }
  }catch (Exception $e) {			
    return array("status" => "warning", "msg" =>$e->getMessage());		
		
  } 
}
function edituser($obj){
  try {
    $user =new user();	
      $user->id = isset($obj->id)?$obj->id:'';
      $user->name = isset($obj->name)?$obj->name:'';
	    $user->password = isset($obj->password)?$obj->password:'';
	    $user->group_id = isset($obj->group_id)?$obj->group_id:0;  
      $user->update();
    
      return array("status" => "success", "msg" => "Update Successful");			
    
  }catch (Exception $e) {			
    return array("status" => "warning", "msg" =>$e->getMessage());		
		
  } 
}
function deleteuser($obj){ 
  $user =new user();	
  foreach ($obj as &$userid) {
     $user->deletebyid($userid);
  }
  return array("status" => "success", "msg" =>"User(s) deleted");		
}

function binddatauser($obj){
    $user =new user();	
	 return $user->getallexceptsys();
}

function getuserbyid($obj){
  $user =new user();	
   $listUser = $user->getbyid($obj);
	  if(count($listUser)>0){	    
	    return $listUser[0];
	   
    }else{
       return "";
    }		
 
}

function getusergroups($obj){
   $group = new group();   
    return  $group->getall();
  
}
function getstates($obj){
   $state = new state();    
    return $state->getall();
  
}
function getpriorities($obj){
   $priority = new priority();    
    return $priority->getall();
  
}
function getcustomers($obj){
   $User = new User();       
    return $User->getbytype(7);
  
}
function gettesters($obj){
   $User = new User();        
    return $User->getbytype(5);
  
}
function getprogramers($obj){
   $User = new User();        
    return $User->getbytype(4);
  
}
function getissues($obj){
   $issue = new issue();        
    return $issue->getall();
  
}
function updateissue($obj){
    try {
    $issue =new issue();	
    $issue->id = isset($obj->id)?$obj->id:'';
    $issue->title = isset($obj->title)?$obj->title:'';
	  $issue->description = isset($obj->description)?$obj->description:'';
	  $issue->customer_id = isset($obj->customer_id) && $obj->customer_id!="0" ?$obj->customer_id:'null';
    $issue->programer_id = isset($obj->programer_id) && $obj->programer_id!="0"?$obj->programer_id:'null';
    $issue->tester_id = isset($obj->tester_id) && $obj->tester_id!="0"?$obj->tester_id:'null';
    $issue->state = isset($obj->state)?$obj->state:1;
    $issue->priority = isset($obj->priority)?$obj->priority:1;
    $issue->modifier = isset($_SESSION['id'] )?$_SESSION['id'] :'null';
    $issue->update();
     return array("status" => "success", "msg" =>"Issue updated");		
  }catch (Exception $e) {			
    return array("status" => "warning", "msg" =>$e->getMessage());		
		
  } 
  
}

function createissue($obj){
  try {
    $issue =new issue();	
    $issue->title = isset($obj->title)?$obj->title:'';
	  $issue->description = isset($obj->description)?$obj->description:'';
	  $issue->customer_id = isset($obj->customer_id)?$obj->customer_id:'null';
    $issue->programer_id = isset($obj->programer_id)?$obj->programer_id:'null';
    $issue->tester_id = isset($obj->tester_id)?$obj->tester_id:'null';
    $issue->state = isset($obj->state)?$obj->state:1;
    $issue->priority = isset($obj->priority)?$obj->priority:1;
    $issue->creator = isset($_SESSION['id'] )?$_SESSION['id'] :'null';
    $id = $issue->insert();
    if(isset($id)){
      return array("status" => "success", "msg" => "Create Successful");			
    }else{
      return array("status" => "warning", "msg" => "Create Fail");			
    }
  }catch (Exception $e) {			
    return array("status" => "warning", "msg" =>$e->getMessage());		
		
  } 
}
function getissuebyid($obj){
  $issue =new issue();	
   $list = $issue->getbyid($obj);
	  if(count($list)>0){	    
	    return $list[0];
	   
    }else{
       return "";
    }		
 
}
function getstatereport($obj){
  $issue =new issue();	
  $list = $issue->getstatereport();
  return $list;
	
}
function gettopcustomer($obj){
  $issue =new issue();	
  $list = $issue->gettopcustomer($obj);
  return $list;
}
function gettopprogramer($obj){
 $issue =new issue();	
  $list = $issue->gettopprogramer($obj);
  return $list;
}
function getissueaging($obj){
  $issue =new issue();	
  $list = $issue->getaging();
  return $list;
}
/* Output header */
header('Content-type: application/json');
echo json_encode($result);


?>