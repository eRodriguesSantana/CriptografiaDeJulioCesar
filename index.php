<?php
$url = "https://api.codenation.dev/v1/challenge/dev-ps/generate-data?token=85a2176d9da8676a986f115a110ce84f5bbc0125";

$ch = curl_init();

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL, $url);

$result = curl_exec($ch);

curl_close($ch);

$result = json_decode($result, true);
print_r($result);

$fp = fopen("answer.json", "w+");
 
fwrite($fp, json_encode($result));

fclose($fp);

?>