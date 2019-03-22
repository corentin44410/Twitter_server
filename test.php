<?php

// NOTE: Be sure to uncomment the following line in your php.ini file.
// ;extension=php_openssl.dll

// **********************************************
// *** Update or verify the following values. ***
// **********************************************


// Replace the accessKey string value with your valid access key.
$accessKey = '07006bb5156e4476846f4c7a2666692a';

// Replace or verify the region.

// You must use the same region in your REST API call as you used to obtain your access keys.
// For example, if you obtained your access keys from the westus region, replace 
// "westcentralus" in the URI below with "westus".

// NOTE: Free trial access keys are generated in the westcentralus region, so if you are using
// a free trial access key, you should not need to change this region.
$host = 'https://francecentral.api.cognitive.microsoft.com';
// $host = 'https://francecentral.api.cognitive.microsoft.com';
// $path = '/text/analytics/v2.0/sentiment';
$path = '/text/analytics/v2.0/sentiment';

function GetSentiment($host, $path, $key, $data) {

	$headers = "Content-type: text/json\r\n" .
		"Ocp-Apim-Subscription-Key: $key\r\n";

	$data = json_encode ($data);
	// print_r($data);
	
	// NOTE: Use the key 'http' even if you are making an HTTPS request. See:
	// https://php.net/manual/en/function.stream-context-create.php
	$options = array (
		'http' => array (
			'header' => $headers,
			'method' => 'POST',
			'content' => $data
		)
	);
	$context  = stream_context_create ($options);
	$result = file_get_contents ($host . $path, false, $context);
	//print_r($result);
	return json_decode($result);
}

?>