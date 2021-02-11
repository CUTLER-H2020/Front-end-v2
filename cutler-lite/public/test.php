<?php


$url = "http://92.45.59.250:8004/engine-rest/process-definition/Process_1rhx5yk:1:dc2241f4-75be-11ea-b3bd-0a0027000002/xml";


function curlGet($durl){
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $durl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$r = curl_exec($ch);
curl_close($ch);
return $r;
}



echo curlGet($url);
