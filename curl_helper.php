<?php
	function sendRequest($url,$method='GET',$data=[],$query_data=[])
	{
		$queryParams = http_build_query($query_data);

		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$url."?".$queryParams);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		
		switch ($method)
		{
			case 'GET':
				curl_setopt($ch,CURLOPT_HTTPGET,true);
				break;
			
			case 'POST':
				curl_setopt($ch,CURLOPT_POST,true);
				curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
				break;
			
			case 'PUT':
				curl_setopt($ch,CURLOPT_CUSTOMREQUEST,'PUT');
				curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
				break;
			
			case 'DELETE':
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST,'DELETE');
				break;
		}
		
		$response = curl_exec($ch);
		curl_close($ch);

		return $response;
	}
	
?>