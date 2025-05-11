<?php
	$server = "localhost";
	$username= "root";
	$password="";
	$database = "access_control_management";
	$port = 3307;
	
	$conn = mysqli_connect($server,$username,$password,$database, $port);
	
	if(!$conn)
	{	
		die('Connection failed: '.mysqli_connect_error());
	}
?>
		