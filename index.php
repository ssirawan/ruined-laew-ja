<?php

error_reporting(E_ALL & ~E_NOTICE);

$db = pg_connect("host=ec2-54-235-133-42.compute-1.amazonaws.com port=5432 dbname=dd9n7qflnjtae8 user=ynezixirsjupio password=8aa84c7e317c93709b62657ac0a26d2f8696df1eaee0f6bb108e6cd3a2ca4d22");
echo $db;

/*
if(!$db) {echo "error";}
pg_query($db,"INSERT INTO public.Customer VALUES ('c01','Somkit')");
$result = pg_query($db,"SELECT COUNT(*) FROM public.Customer");
$list = pg_fetch_row($result);
echo  "result = $list[0]";
echo "/////";
$result2 = pg_query($db,"SELECT 1+1");
$list2 = pg_fetch_row($result2);
echo  "result = $list2[0] <br>";

$result = pg_query($db,"SELECT datname FROM pg_catalog.pg_tables");
while ($list = pg_fetch_row($result))
echo  "result = $list[0]<br>";

//pg_query($db,"CREATE TABLE Cus (c1 varchar(40) NOT NULL) ");

pg_query($db,"INSERT INTO Cus VALUES ('10')");
$result = pg_query($db,"SELECT COUNT(*) FROM Cus");
$list = pg_fetch_row($result);
echo  "result = $list[0] <br>";
$result = pg_query($db,"SELECT * FROM Cus");
while ($list = pg_fetch_row($result))
echo  "result = $list[0]<br>";


pg_query($db,"CREATE TABLE Garage (
gar_id varchar(10) NOT NULL,
gar_name varchar(40) NOT NULL),
gar_tel varchar(10) NOT NULL
PRIMARY KEY(gar_id)");

pg_query($db,"INSERT INTO Garage VALUES ('g01','อู่คุณ A','0812223333'),
('g02','อู่คุณ B','0833224444')"),
('g03','อู่คุณ C','0845554445')"));
$result = pg_query($db,"SELECT * FROM Garage");
$list = pg_fetch_row($result);
echo "result = $list";

*/

$API_URL = 'https://api.line.me/v2/bot/message/reply';
$ACCESS_TOKEN = 'vEcA9SC+uVHF+zBZZQod5Yp/fS2Xn+lUkqHKi1EE1OGXZjtGJlfwrKfkLFu+wOyVPGomLXbzjZOWaK7MQjJsJ3c0kPBhnDo2vxEdES6a2Kk8PnQNwJRLHbPslhqvzC1xk8lM8HLtnERPSG8oXBLNvwdB04t89/1O/w1cDnyilFU='; // Access Token ค่าที่เราสร้างขึ้น
$POST_HEADER = array('Content-Type: application/json', 'Authorization: Bearer ' . $ACCESS_TOKEN);
$request = file_get_contents('php://input');  // Get request content
$request_array = json_decode($request, true);   // Decode JSON to Array
if ( sizeof($request_array['events']) > 0 )
{
 foreach ($request_array['events'] as $event)
 {
  $reply_message = '';
  $reply_token = $event['replyToken'];
  if ( $event['type'] == 'message' ) 
  {
   $userid = $event['source']['userId'];
   
   $findtable = pg_query($db,"SELECT COUNT(*) FROM $userid");
   if( pg_fetch_result($findtable) == 0)
   {
	   pg_query($db,"CREATE TABLE $userid (Reply varchar(100) NOT NULL)");
   }
   if( $event['message']['type'] == 'text' )
   {
    $text = $event['message']['text'];
   	if($text=='showid')
   	{
	   $reply_message = $userid;
   	}
    	elseif($text == 'Total')
    	{
	$qq = pg_query($db,"SELECT COUNT(*) FROM $userid ");
	$yyy = pg_fetch_row($qq);
	$reply_message = "มีข้อมูลในระบบทั้งหมด ".$yyy[0]." ข้อมูล ณ date("d/m/Y") date("เวลา h:i:sa")";
    	}
    	else
    	{
	$add = pg_query($db,"INSERT INTO $userid VALUES ('$text')");
	$reply_message = "ระบบได้ทำการเพิ่ม '".$text."' เข้าสู่ฐานข้อมูลแล้ว"."\n"."กรุณาพิมพ์ 'Total' เพื่อตรวจสอบจำนวนข้อมูลในระบบ";}
   	}
   else
    $reply_message = 'ระบบได้รับ '.ucfirst($event['message']['type']).' ของคุณแล้ว';
  
  }
  else
   $reply_message = 'ระบบได้รับ Event '.ucfirst($event['type']).' ของคุณแล้ว';
 
  if( strlen($reply_message) > 0 )
  {
   //$reply_message = iconv("tis-620","utf-8",$reply_message);
   $data = [
    'replyToken' => $reply_token,
    'messages' => [['type' => 'text', 'text' => $reply_message]]
   ];
   $post_body = json_encode($data, JSON_UNESCAPED_UNICODE);
   $send_result = send_reply_message($API_URL, $POST_HEADER, $post_body);
   echo "Result: ".$send_result."\r\n";
  }
 }
}
echo "OK";




function send_reply_message($url, $post_header, $post_body)
{
 $ch = curl_init($url);
 curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 curl_setopt($ch, CURLOPT_HTTPHEADER, $post_header);
 curl_setopt($ch, CURLOPT_POSTFIELDS, $post_body);
 curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
 $result = curl_exec($ch);
 curl_close($ch);
 return $result;
}
?>
