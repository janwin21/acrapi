<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/acrapi/curl_helper.php');
	$restAPIBaseURL = "http://localhost/acrapi";
	
	header('Content-Type: application/json');
	$method = $_SERVER['REQUEST_METHOD'];
	$uri = $_SERVER['REQUEST_URI'];
	$path = parse_url($uri, PHP_URL_PATH);
	$normalized_path = rtrim($path, '/');
	
	try {
		if($_SERVER['REQUEST_METHOD'] === "GET") {
			$result = json_encode([$path]);

			if($path === "/acrapi/api/v1/users/") {
				$result = sendRequest($restAPIBaseURL.'/api.php/users','GET');
			} elseif($path === "/acrapi/api/v1/users/companies/") {
				$result = sendRequest($restAPIBaseURL.'/api.php/users/companies','GET');
			} elseif (preg_match("#^/acrapi/api/v1/users/(\d+)/companies/?$#",$normalized_path, $matches)) {
				$result = sendRequest($restAPIBaseURL."/api.php/users/$matches[1]/companies",'GET');
			} elseif($path === "/acrapi/api/v1/users/roles/") {
				$result = sendRequest($restAPIBaseURL.'/api.php/users/roles','GET');
			} elseif (preg_match("#^/acrapi/api/v1/users/(\d+)/roles/?$#",$normalized_path, $matches)) {
				$result = sendRequest($restAPIBaseURL."/api.php/users/$matches[1]/roles",'GET');
			}

			echo $result;
		} elseif($_SERVER['REQUEST_METHOD'] === "PUT") {
			$result = json_encode([$path]);

			if (preg_match("#^/acrapi/api/v1/users/(\d+)/?$#",$normalized_path, $matches)) {
				$result = sendRequest($restAPIBaseURL."/api.php/users/$matches[1]",'PUT', file_get_contents('php://input'));
			}

			echo $result;
		} else {
			throw new Exception("$method are not allowed in $uri");
		}
	} catch (Exception $e) {
		echo $e->getMessage();
	}
?>