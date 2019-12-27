<?php
	$dsn = "mysql:host=localhost;dbname=school";
	$user = 'root';
	$password = '';
	$option = array(
		PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
	);
	try{
		$con = new PDO($dsn,$user,$password,$option);
		$con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION); // that for error mode in pdo
		//echo "You Are Connected";
	}catch(PDOException $e){
		echo "The Connection Is Fail!!  Resones: ".$e->getMessage();
	}
?>