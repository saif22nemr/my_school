<?php
	//Routes
	include 'connect.php';
	$tpl = 'include/template/'; //Template Directory
	$fun = 'include/function/';
	$css = 'layout/css/'; // Css Directory
	$js = 'layout/js/'; // Js Directory
	$lang = 'include/languages/'; //languages Directory

	include $fun.'function.php';
//	include $lang."english.php";
	include $tpl."header.php";
	if(!isset($noNavbar)) // this conditioin for if you not need navbar 
		include $tpl.'navbar.php';

?>