<?php
include "database.php";

class Oprations extends Database
{
	
	public function insert($table,$data){
	//prd($this->con);
		$sql = "";
		$sql .= "INSERT INTO ".$table;
		$sql .= " (".implode(",", array_keys($data)).") VALUES ";
		$sql .= "('".implode("','", array_values($data))."')";
		$query = mysqli_query($this->con,$sql);
		if($query){
		  return true;
		}else{
			//echo mysql_error();
		}
	}
public function get_data($table){
	ECHO $sql = "Select * FROM ".$table;
	 $query = mysqli_query($this->con,$sql);
	$array = array();
	while($data = mysqli_fetch_assoc($query)){
		$array[] = $data;
	}
	return $array;
}
public function get_record_byid($table,$where){
	
	$sql = "";
	$condition = "";
	foreach($where as $key=>$val){
			$condition .=$key ." ='".$val."' AND ";
			//$condition .= $key . "='" . $value . "' AND ";
	}
	$condition = substr($condition, 0, -5);
 echo  $sql = "select * from ".$table. " WHERE ".$condition;
	$query = mysqli_query($this->con,$sql);
	$result = mysqli_fetch_array($query);
	//prd($result);
	return $result; 
}
public function update_record($table,$where,$fields){
$sql = "";
$condition = "";
foreach ($where as $key => $value) {
// id = '5' AND m_name = 'something'
$condition .= $key . "='" . $value . "' AND ";
}
$condition = substr($condition, 0, -5);
foreach ($fields as $key => $value) {
//UPDATE table SET m_name = '' , qty = '' WHERE id = '';
$sql .= $key . "='".$value."', ";
}
$sql = substr($sql, 0,-2);
$sql = "UPDATE ".$table." SET ".$sql." WHERE ".$condition;
if(mysqli_query($this->con,$sql)){
return true;
}
}/*
$sql = "";
$condition = "";
foreach ($where as $key => $value) {
// id = '5' AND m_name = 'something'
$condition .= $key . "='" . $value . "' AND ";
}
$condition = substr($condition, 0, -5);
$sql .= "SELECT * FROM ".$table." WHERE ".$condition;
$query = mysqli_query($this->con,$sql);
$row = mysqli_fetch_array($query);
return $row; */
}
 function prd($data=false){
		if(!empty($data)){
			echo "<pre>";
			print_r($data);
			echo "</pre>"; 
			die();
		}else{
			echo "No data";
		}
	}
$obj = new Oprations;

if(!empty($_POST["submit"])  && $_POST["submit"]=="Store"){
	$data = $_POST;
	unset($data["submit"]);
	$check= $obj->insert("users",$data);
	if($check){
	   header("location:index.php?msg=Record Inserted");
	}
}
if(!empty($_POST["edit"])  && $_POST["edit"]=="Update"){
	$data = $_POST;
	$where = array("id"=>$data["id"]);
	
	unset($data["edit"],$data["id"]);
	$fields = $data;
	$check= $obj->update_record 	("users",$where,$fields);
	if($check){
	   header("location:index.php?msg=Record Updated Successfully");
	}
}
?>