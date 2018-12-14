<?php

error_reporting(E_ALL & ~E_NOTICE);

$db = pg_connect("host=ec2-54-235-133-42.compute-1.amazonaws.com port=5432 dbname=dd9n7qflnjtae8 user=ynezixirsjupio password=8aa84c7e317c93709b62657ac0a26d2f8696df1eaee0f6bb108e6cd3a2ca4d22");
echo $db;
/*
pg_query($db,"CREATE TABLE CarPoll (
Brand varchar(20) NOT NULL,
Vote int
)");
*/
//pg_query($db,"INSERT INTO CarPoll VALUES ('Benz',0),('BMW',0),('Toyota',0)");
$result = pg_query($db,"SELECT * FROM CarPoll");
while ($list = pg_fetch_row($result))
{
	echo $list[0].list[1]."<br>";
}

/*
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
   $roww = pg_query($db,"SELECT * FROM CarPoll"); // ตัวแปร = ชื่อแบรนด์ ละ row
   $list = pg_fetch_array($roww);
   $carlist = ("Benz","BMW","Toyota");
   if( $event['message']['type'] == 'text' )
   {
    $text = $event['message']['text'];
    foreach ($carlist as $value)
    {
	    if($text == $value)
	    {
		    $count = pg_fetch_array(pg_query($db,"SELECT Vote FROM CarPoll WHERE Brand = $value "))[1];
		    $count+=1;
		    pg_query($db,"UPDATE CarPoll SET Count = $count ");
		    //$reply_message = 'AAA';
	    }
    }
   	if($text=='Benz')
   	{
	   $count = pg_query($db,"SELECT Count FROM CarPoll WHERE Brand = 'Benz' ");	
	   pg_query($db,"UPDATE CarPoll SET Count +=1 ");
	   $reply_message = "โหวต Benz เรียบร้อยแล้ว คะแนนปัจจุบันคือ"."\n"."";
   	}
    	elseif($text == 'Total')
    	{
	$qq = pg_query($db,"SELECT COUNT(*) FROM $userid ");
	$yyy = pg_fetch_row($qq);
	$reply_message = "มีข้อมูลในระบบทั้งหมด ".$yyy[0]." ข้อมูล ณ ".date("d/m/Y")." เวลา ".date("h:i:sa");
    	}
    	else
    	{
	//$reply_message = "ร่วมโหวตแบรนด์รถยนต์ที่คุณสนใจ"."\n". "ตัวแปรชื่อแบรนด์";	
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
*/
