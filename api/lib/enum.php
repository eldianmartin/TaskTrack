<?php 
class Enum{
	function __get($key = null){
		return $this->array[$key];
	}
	function Parse($value){
		return array_search($value,$this->array);
	}
  function GetAll(){
    $result = array();
    foreach($this->array as $item => $itemkey)
  	{
			  array_push($result,array("key" => $itemkey, "value" => $item ));
  	}
    return $result;
  }
}
class UserType extends Enum{
	var $array=array("System"=>1,"Head of Developer"=>2,"IT Head of Support"=>3,"Developer"=>4,"IT Tester"=>5,"IT Helpdesk"=>6,"Client"=>7);	
}
?>