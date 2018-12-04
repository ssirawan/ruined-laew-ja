<?php
$access_token = 'uGf6Ts7gXkqHiGr/Po4FwcY6RR0eBSgOm2gfzoq5lx0l4JN2B1nOt/liGAVBba3BPGomLXbzjZOWaK7MQjJsJ3c0kPBhnDo2vxEdES6a2Knm56TyLscmr/gn9Etn7ur+K9c3/1cVgLBWkjldvKtSXAdB04t89/1O/w1cDnyilFU=';
$url = 'https://api.line.me/v2/oauth/verify';
$headers = array('Authorization: Bearer ' . $access_token);
$ch = curl_init($url);curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
$result = curl_exec($ch);
curl_close($ch);
echo $result;
?>
