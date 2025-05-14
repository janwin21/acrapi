<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/acrapi/cors.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/acrapi/curl_helper.php');
	$restAPIBaseURL = "http://localhost/acrapi";
	
	header('Content-Type: application/json');
	$method = $_SERVER['REQUEST_METHOD'];
	$uri = $_SERVER['REQUEST_URI'];
	$headers = getallheaders();
	
	try {
		if($_SERVER['REQUEST_METHOD'] === "POST") {
			$result = sendRequest($restAPIBaseURL.'/api.php/assign-roles','POST', file_get_contents('php://input'),headers: [
					"Authorization" => $headers["Authorization"] ?? ''
				]);
			echo $result;
		} else {
			throw new Exception("$method are not allowed in $uri");
		}
	} catch (Exception $e) {
		echo $e->getMessage();
	}
?>