<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/acrapi/curl_helper.php');
	$restAPIBaseURL = "http://localhost/acrapi/v1";
	
	try
	{
		$users = sendRequest($restAPIBaseURL.'/api.php/users','GET');
		// $users = json_decode($users,true);
		print_r($users);
		
		/*
		//get specific employee record
		$employeeid=2;
		$employee = sendRequest($restAPIBaseURL."/api.php/employees/$employeeid",'GET');
		$employee = json_decode($employee,true);
		print_r($employee);
		
		
		$data = array(
			'emp_name'=>'Richard Cue',
			'emp_code'=>'emp103',
			'emp_email'=>'rich@gmail.com',
			'emp_phone'=>'1828238',
			'emp_address'=>'Makati',
			'emp_designation'=>'Manager',
			'emp_joining_date' => '2025-03-05'
			);
	
		$result = sendRequest($restAPIBaseURL.'/api.php/employees','POST',$data);
		$result = json_decode($result,true);
		print_r($result);
	
		$employeeId = 1;
	
		$data = array(
			'emp_name'=>'John Doe',
			'emp_email'=>'john_doe12@gmail.com'
			);
		$result = sendRequest($restAPIBaseURL."/api.php/employees/$employeeId",'PUT',$data);
		$result = json_decode($result,true);
		print_r($result);
	
		$employeeId = 5;
		$result = sendRequest($restAPIBaseURL."/api.php/employees/$employeeId",'DELETE');
		$result = json_decode($result,true);
		print_r($result);
	*/
	
	}
	catch (Exception $e)
	{
		echo $e->getMessage();
	}
?>