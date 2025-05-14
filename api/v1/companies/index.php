<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/acrapi/cors.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/acrapi/curl_helper.php');
	$restAPIBaseURL = "http://localhost/acrapi";
	
	header('Content-Type: application/json');
	$method = $_SERVER['REQUEST_METHOD'];
	$uri = $_SERVER['REQUEST_URI'];
	$path = parse_url($uri, PHP_URL_PATH);
	$normalized_path = rtrim($path, '/');
	$headers = getallheaders();
	
	try {
		if($_SERVER['REQUEST_METHOD'] === "POST") {
			$result = sendRequest($restAPIBaseURL.'/api.php/companies','POST', file_get_contents('php://input'),headers: [
					"Authorization" => $headers["Authorization"] ?? ''
				]);
			echo $result;
		} elseif($_SERVER['REQUEST_METHOD'] === "GET") {
			if($path === "/acrapi/api/v1/companies/") {
				$result = sendRequest($restAPIBaseURL.'/api.php/companies','GET',headers: [
					"Authorization" => $headers["Authorization"] ?? ''
				]);
				echo $result;
			} elseif (preg_match("#^/acrapi/api/v1/companies/(\d+)/users/?$#",$normalized_path, $matches)) {
				$result = sendRequest($restAPIBaseURL."/api.php/companies/$matches[1]/users",'GET',headers: [
					"Authorization" => $headers["Authorization"] ?? ''
				]);
				echo $result;
			}
		} elseif($_SERVER['REQUEST_METHOD'] === "PUT") {
			$result = json_encode([$path]);

			if (preg_match("#^/acrapi/api/v1/companies/(\d+)/?$#",$normalized_path, $matches)) {
				$result = sendRequest($restAPIBaseURL."/api.php/companies/$matches[1]",'PUT', file_get_contents('php://input'),headers: [
					"Authorization" => $headers["Authorization"] ?? ''
				]);
			}

			echo $result;
		} else {
			throw new Exception("$method are not allowed in $uri");
		}
	} catch (Exception $e) {
		echo $e->getMessage();
	}
?>