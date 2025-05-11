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
			if($path === "/acrapi/api/v1/roles/") {
				$result = sendRequest($restAPIBaseURL.'/api.php/roles','GET');
				echo $result;
			} elseif(preg_match("#^/acrapi/api/v1/roles/created-by/(\d+)/?$#",$normalized_path, $matches)) {
				$result = sendRequest($restAPIBaseURL."/api.php/roles/created-by/$matches[1]",'GET');
				echo $result;
			}
		} elseif($_SERVER['REQUEST_METHOD'] === "POST") {
			$result = sendRequest($restAPIBaseURL.'/api.php/roles','POST', file_get_contents('php://input'));
			echo $result;
		} elseif($_SERVER['REQUEST_METHOD'] === "PUT") {
			$result = json_encode([$path]);

			if (preg_match("#^/acrapi/api/v1/roles/(\d+)/users/(\d+)/?$#",$normalized_path, $matches)) {
				$result = sendRequest($restAPIBaseURL."/api.php/roles/$matches[1]/users/$matches[2]",'PUT', file_get_contents('php://input'));
			}

			echo $result;
		} else {
			throw new Exception("$method are not allowed in $uri");
		}
	} catch (Exception $e) {
		echo $e->getMessage();
	}
?>