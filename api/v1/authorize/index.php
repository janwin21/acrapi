<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/acrapi/curl_helper.php');
	$restAPIBaseURL = "http://localhost/acrapi";
	
	header('Content-Type: application/json');
	$method = $_SERVER['REQUEST_METHOD'];
	$uri = $_SERVER['REQUEST_URI'];
	$path = parse_url($uri, PHP_URL_PATH);
	$normalized_path = rtrim($path, '/');
	
	try {
		$query_data = [
			"role" => $_GET["role"] ?? null,
			"action" => $_GET["action"] ?? null
		];

		if($_SERVER['REQUEST_METHOD'] === "GET" and preg_match("#^/acrapi/api/v1/authorize/(\d+)/permission/?$#",$normalized_path, $matches)) {
			$result = sendRequest($restAPIBaseURL."/api.php/authorize/$matches[1]/permission",'GET', [], $query_data);
			echo $result;
		} else {
			throw new Exception("$method are not allowed in $uri");
		}
	} catch (Exception $e) {
		echo $e->getMessage();
	}
?>