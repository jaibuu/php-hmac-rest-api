<?php

if (!function_exists('curl_init')) {
	die('Curl module not installed!' . PHP_EOL);
}


$route = '/v1/create';
//$route = '/test/4';
//$route = '/doesntexist';
//$route = '/skip/auth';

if (isset($argv[1])) {
	$host = 'http://' . $argv[1] . $route;
} else {
	$host = "http://api.example.com" . $route;
}

$privateKey = '8c484c8c89547cncy4mc8nzxbcvi4eba66e10fba74dbf9e99c22f';
$cryptKey = 'wbHPNKi@t-4t@k(!b9xh^gVJ&ywi0z$5';

$time = time();
$id = 1;

$data = ['name' => 'Super long name'];

$iv = mcrypt_create_iv(16, MCRYPT_DEV_URANDOM);
$ciphered = mcrypt_encrypt(
    MCRYPT_RIJNDAEL_128,
    $cryptKey,
    json_encode($data),
    'ctr',
    $iv
);

if(false){
    $payload = ['payload' => base64_encode(json_encode(
        $data
    ))];
}else{

    $payload = ['payload' => base64_encode(
    	$iv.$ciphered
    )];
}

$message = buildMessage($time, $id, $payload);
$hash = hash_hmac('sha256', $message, $privateKey);

$headers = ['API_ID: ' . $id, 'API_TIME: ' . $time, 'API_HASH: ' . $hash];

$method = 'POST';
$ch = curl_init();

curl_setopt($ch, CURLOPT_VERBOSE, TRUE);
curl_setopt($ch, CURLOPT_URL, $host);

switch($method) {
    case 'POST':
    	curl_setopt($ch, CURLOPT_POST, TRUE);
    	curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    	break;
    case 'GET':
    	break;
    default:
        $data = http_build_query($payload);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        break;
}

// curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");

curl_setopt($ch, CURLOPT_HEADER, TRUE);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLINFO_HEADER_OUT, TRUE);

$result = curl_exec($ch);
if ($result === FALSE) {
	echo "Curl Error: " . curl_error($ch);
} else {
	echo PHP_EOL;
	echo "Request: " . PHP_EOL;
	echo curl_getinfo($ch, CURLINFO_HEADER_OUT);	
	echo PHP_EOL;

	echo "Response:" . PHP_EOL;
	echo $result; 
	echo PHP_EOL;
}

curl_close($ch);


function buildMessage($time, $id, $data) {
	return $time . $id . http_build_query($data, '', '&');
}

?>
