<?php
/*
copyright @ medantechno.com
Modified by Ilyasa
And Modified by Farzain - zFz ( Faraaz )
2017
*/
require_once('./line_class.php');

$channelAccessToken = 'cyMPLJnW8Bw4aU3UU2aD5Pc+RRIBY3O1FCMosyOo+oxXCMi9OeC3KKfOF5XesauA4UXY9yBSTwPusn8XO07G6GbFbh9kYCkx1wx6Er85PNfTlUW62rCxZ92RJP3imIAT7CzZjiGmd1DdOKqjSoMwtQdB04t89/1O/w1cDnyilFU='; //Your Channel Access Token
$channelSecret = '67fa8c075ad4d5e1970d135a79a44b1e';//Your Channel Secret

$client = new LINEBotTiny($channelAccessToken, $channelSecret);

$userId 	= $client->parseEvents()[0]['source']['userId'];
$replyToken = $client->parseEvents()[0]['replyToken'];
$message 	= $client->parseEvents()[0]['message'];
$profil = $client->profil($userId);
$pesan_datang = $message['text'];

if($message['type']=='sticker')
{	
	$balas = array(
							'UserID' => $profil->userId,	
                                                        'replyToken' => $replyToken,							
							'messages' => array(
								array(
										'type' => 'text',									
										'text' => 'Terima Kasih Stikernya.'										
									
									)
							)
						);
						
}
else
$pesan=str_replace(" ", "%20", $pesan_datang);
$key = 'f56bcd90-e402-4688-aa05-087396c06182'; //API SimSimi
$url = 'http://sandbox.api.simsimi.com/request.p?key='.$key.'&lc=id&ft=1.0&text='.$pesan;
$json_data = file_get_contents($url);
$url=json_decode($json_data,1);
$diterima = $url['response'];
if($message['type']=='text')
{
if($url['result'] == 404)
	{
		$balas = array(
							'UserID' => $profil->userId,	
                                                        'replyToken' => $replyToken,													
							'messages' => array(
								array(
										'type' => 'text',					
										'text' => 'Mohon Gunakan Bahasa Indonesia Yang Benar :D.'
									)
							)
						);
				
	}
else
if($url['result'] != 100)
	{
		
		
		$balas = array(
							'UserID' => $profil->userId,
                                                        'replyToken' => $replyToken,														
							'messages' => array(
								array(
										'type' => 'text',					
										'text' => 'Maaf '.$profil->displayName.' Server Kami & Razan Muhammad Sedang Sibuk Sekarang.'
									)
							)
						);
				
	}
	else{
		$balas = array(
							'UserID' => $profil->userId,
                                                        'replyToken' => $replyToken,														
							'messages' => array(
								array(
										'type' => 'text',					
										'text' => ''.$diterima.''
									)
							)
						);
						
	}
}
 
$result =  json_encode($balas);

file_put_contents('./reply.json',$result);


$client->replyMessage($balas);

$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient('cyMPLJnW8Bw4aU3UU2aD5Pc+RRIBY3O1FCMosyOo+oxXCMi9OeC3KKfOF5XesauA4UXY9yBSTwPusn8XO07G6GbFbh9kYCkx1wx6Er85PNfTlUW62rCxZ92RJP3imIAT7CzZjiGmd1DdOKqjSoMwtQdB04t89/1O/w1cDnyilFU=');
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => '67fa8c075ad4d5e1970d135a79a44b1e']);
$response = $bot->leaveRoom('<roomId>');
echo $response->getHTTPStatus() . ' ' . $response->getRawBody();
