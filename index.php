<?php

error_reporting(E_ALL & ~E_NOTICE);

//$db = pg_connect("dbname=dd9n7qflnjtae8 user=ynezixirsjupio password=8aa84c7e317c93709b62657ac0a26d2f8696df1eaee0f6bb108e6cd3a2ca4d22");
$db = pg_connect("host=ec2-54-235-133-42.compute-1.amazonaws.com port=5432 dbname=dd9n7qflnjtae8 user=ynezixirsjupio password=8aa84c7e317c93709b62657ac0a26d2f8696df1eaee0f6bb108e6cd3a2ca4d22");
echo $db;

if(!$db) {echo "error";}
pg_query($db,"INSERT INTO public.Customer VALUES ('c01','Somkit')");
$result = pg_query($db,"SELECT COUNT(*) FROM public.Customer");
$list = pg_fetch_row($result);
echo  "result = $list[0]";
echo "/////";
pg_query($db,"SELECT * FROM pg_catalog().pg_tables()");
echo  "result = $list[0]";


$API_URL = 'https://api.line.me/v2/bot/message/reply';
$ACCESS_TOKEN = 'vEcA9SC+uVHF+zBZZQod5Yp/fS2Xn+lUkqHKi1EE1OGXZjtGJlfwrKfkLFu+wOyVPGomLXbzjZOWaK7MQjJsJ3c0kPBhnDo2vxEdES6a2Kk8PnQNwJRLHbPslhqvzC1xk8lM8HLtnERPSG8oXBLNvwdB04t89/1O/w1cDnyilFU='; // Access Token ค่าที่เราสร้างขึ้น
$POST_HEADER = array('Content-Type: application/json', 'Authorization: Bearer ' . $ACCESS_TOKEN);
$request = file_get_contents('php://input');   // Get request content
$request_array = json_decode($request, true);   // Decode JSON to Array
if ( sizeof($request_array['events']) > 0 )
{
 foreach ($request_array['events'] as $event)
 {
  $reply_message = '';
  $reply_token = $event['replyToken'];
  if ( $event['type'] == 'message' ) 
  {
   if( $event['message']['type'] == 'text' )
   {
    $text = $event['message']['text'];
	$car = array('"1"',"1","ค้นหารถ","รถ","หารถ","ยี่ห้อรถ");
	$tel = array("tel","เบอร์","หาเบอร์","2",'"2"',"โทร","เบอร์โทร");
	$check = 0;
	
	foreach ($car as $value)
	{
		if($text == $value)
		{
			$check=1;
		}
	}
	foreach ($tel as $value)
	{
		if($text == $value)
		{
			$check=2;
		}
	}
	
	if($check ==1)
	{
		$result = pg_query($db,"SELECT COUNT(*) FROM Customer");
		$list = pg_fetch_row($result);
		$reply_message = " result = $list[0]";
	}
	elseif($check ==2)
	{
		pg_query($db,"INSERT INTO Customer VALUES ('c01','Somkit')");
		$reply_message = 'อู่คุณวิชัย 023334444';
	}
	elseif($text==3)
	{
		$reply_message = 'บัญชีประจำเดือน ธันวาคม 2561, ค่าใช้จ่าย 3,000 บาท, เงินสดหมุนเวียน 400,000 บาท ต้องการเพิ่มข้อมูล กด "4"';
	}
	
		
	   
	else
		$reply_message = 'พิมพ์ "1" เมื่อต้องการค้นหารถ, พิมพ์ "2" เมื่อต้องการค้นหาเบอร์ติดต่อของบริษัท, พิมพ์ "3" เมื่อต้องการตรวจสอบการเงิน';
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
