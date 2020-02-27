<?php

echo '<h1>Validate CURL</h1>';

echo '<pre>';

var_dump($_GET['token'] ?? '');

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'psr-jwt:8080/curl/validate');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $_GET['token'] ?? ''
]);

$response = curl_exec($ch);

if (!$response) {
    var_dump(curl_error($ch));
}

echo $response;

curl_close($ch);
echo '</pre>';

echo '<p><a href="http://localhost:8080/curl">Back</a></p>';

die();