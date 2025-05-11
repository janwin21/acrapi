<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/acrapi/curl_helper.php');
	$restAPIBaseURL = "http://localhost/acrapi";
	
	header('Content-Type: application/json');
	$method = $_SERVER['REQUEST_METHOD'];
	$uri = $_SERVER['REQUEST_URI'];
	$path = parse_url($uri, PHP_URL_PATH);
	$normalized_path = rtrim($path, '/');
	
	try {
		if($_SERVER['REQUEST_METHOD'] === "DELETE") {
			$result = json_encode([$path]);

			if (preg_match("#^/acrapi/api/v1/unassign-role/companies/(\d+)/users/(\d+)/roles/(\d+)/?$#",$normalized_path, $matches)) {
				$result = sendRequest($restAPIBaseURL."/api.php/unassign-role/companies/$matches[1]/users/$matches[2]/roles/$matches[3]",'DELETE');
			}

			echo $result;
		}
	} catch (Exception $e) {
		echo $e->getMessage();
	}
?>