<?php

//$displayName;
function replyToUser($userID,$message,$ac_token){
	
	// Make a POST Request to Messaging API to reply to sender
	$url = 'https://api.line.me/v2/bot/message/push';
	$data = [
		'to' => $userID,
		'messages' => [$message]
	];
	$post = json_encode($data);
	$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $ac_token);

	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	$result = curl_exec($ch);
	curl_close($ch);
	//echo $result . "\r\n";
}

/*
function requestForProfile($ac_token,$userID){
	
	// Make a GET request to Messaging API to get profile
	$url = 'https://api.line.me/v2/bot/profile/' . $userID;
	$headers = array('Authorization: Bearer ' . $ac_token);
	
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
	
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	$response = curl_exec($ch);
	curl_close($ch);
	
	
	$temp_pos = stripos($response, "displayName");
	if($temp_pos===FALSE) exit("Unable to find the start position of displayName");
	$start_pos = $temp_pos + 14;
	if(stripos($response, "pictureUrl")===FALSE&&stripos($response, "statusMessage")===FALSE){
		$end_pos = -2;
	}else if(stripos($response, "pictureUrl"===FALSE)&&stripos($response, "statusMessage")!=FALSE)
	
	$displayName = substr($response, $start_pos, $end_pos);
	// Build message to reply back
	//$displayName = $response['userId'];
	$messages = [
		'type' => 'text',
		'text' => "Respond :" . $displayName
	];
		
	
	
	replyToUser($userID,$messages,$ac_token);
				
	return $displayName;
				
		

}
$access_token = 'kjFApu9NrI3EaPZnNGjc87fHL/JPsSyFr0kY1Detwn69x8DtLM1kV241eOtcCJIgNWBRGLeRH+AI3U393nRDc8MDaGu6TmaAVoYpZOdZ3jYs+obFkCu3zMNQ/sQkaZknOxEEH+me7jEMaKQwQ+vBzwdB04t89/1O/w1cDnyilFU=';




*/

// Get POST body content
$access_token = 'kjFApu9NrI3EaPZnNGjc87fHL/JPsSyFr0kY1Detwn69x8DtLM1kV241eOtcCJIgNWBRGLeRH+AI3U393nRDc8MDaGu6TmaAVoYpZOdZ3jYs+obFkCu3zMNQ/sQkaZknOxEEH+me7jEMaKQwQ+vBzwdB04t89/1O/w1cDnyilFU=';
$headers = array('Content-Type: application/json');
$url = 'http://lineprofile-env.ap-southeast-1.elasticbeanstalk.com/LINEUSER/bbb';
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			$content = file_get_contents('php://input');
			
			//$postString = http_build_query($data);
			
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			
			// Get the response
			$res = curl_exec($ch);
			$info = curl_getinfo($ch,CURLINFO_HTTP_CODE);
			curl_close($ch);

			$userID = "Uf5df21e3f24bc76070171ef959bf81b5";
			$messages;
			if($res===false||!is_string($res)||!strlen($res)){
				$messages = [
					'type' => 'text',
					'text' => "\nFALSE " . curl_errno($res)
				];
				echo $messages;
			}else{
				
				$messages = [
					'type' => 'text',
					'text' => "respond:" . $info
					
				];
				echo $messages;
			}
			
			// Send the return value of curl connection to the user by messaging	
			replyToUser($userID,$messages,$access_token);































/*


// Parse JSON
$events = json_decode($content, true);

$messages;

echo "Just a test";
echo $events . "\r\n";
$userID = 'a';
// Validate parsed JSON data
if (!is_null($events['events'])) {
		
		// Loop through each event
		foreach ($events['events'] as $event) {
			
			// Get replyToken
			$replyToken = $event['replyToken'];
			
			// Get userID
			$source = $event['source'];
			$userID = $source['userId'];
			
			
			// Get timeStamp
			$timeStamp = $event['timestamp'];
			
			// Request for profile and send a push message
			$displayName = requestForProfile($access_token,$userID);

		
			$headers = array('Content-Type: application/x-www-form-urlencoded');
			
			
			// Build connection to EB and send data to EB
			// Now I only send a userID to test the connection, if the connection
			// succeeds, I will send userName later.
			
			$data = array(
				'userID' => $userID,
				'displayName' => $displayName
			);

			
			$url = 'http://lineprofile-env.ap-southeast-1.elasticbeanstalk.com/';
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			if(curl_errno($ch)){
				$messages = [
					'type' => 'text',
					'text' => "\nch False " . curl_error($ch)
				];
				
			}else{
				
				$messages = [
					'type' => 'text',
					'text' => "\nch True" 
				];
				
			}
			
			// Send the return value of curl connection to the user by messaging	
			replyToUser($userID,$messages,$access_token);
			
			$postString = http_build_query($data);
			
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			
			// Get the response
			$res = curl_exec($ch);
			$info = curl_getinfo($ch,CURLINFO_HTTP_CODE);
			curl_close($ch);

			
			
			
			// Define whether the connection succeeds or not
			if($res===false||!is_string($res)||!strlen($res)){
				$messages = [
					'type' => 'text',
					'text' => "\nFALSE " . curl_errno($res)
				];
				echo $messages;
			}else{
				
				$messages = [
					'type' => 'text',
					'text' => "respond:" . $displayName
				];
				echo $messages;
			}
			
			// Send the return value of curl connection to the user by messaging	
			replyToUser($userID,$messages,$access_token);
			
			
	
		}
	
}


*/
	/*	function getUserID(){
			$access_token = 'kjFApu9NrI3EaPZnNGjc87fHL/JPsSyFr0kY1Detwn69x8DtLM1kV241eOtcCJIgNWBRGLeRH+AI3U393nRDc8MDaGu6TmaAVoYpZOdZ3jYs+obFkCu3zMNQ/sQkaZknOxEEH+me7jEMaKQwQ+vBzwdB04t89/1O/w1cDnyilFU=';

			// Get POST body content
			$content = file_get_contents('php://input');
			// Parse JSON
			$events = json_decode($content, true);

			$messages;

			echo "Just a test";
			echo $events . "\r\n";
			$userID = 'a';
			// Validate parsed JSON data
			while (!is_null($events['events'])) {
					
					// Loop through each event
					foreach ($events['events'] as $event) {
						
						// Get replyToken
						$replyToken = $event['replyToken'];
						
						// Get userID
						$source = $event['source'];
						$userID = $source['userId'];
					
						
						
						
					}
			}
			return $userID;
		}
		
		
			
		$data = array(
			'userID' => getUserID()
		);

			
		$url = '13.250.89.6';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		if(curl_errno($ch)){
			echo curl_error($ch);
				
		}else{
			echo "init succeeds";
				
		}
			
		// Send the return value of curl connection to the user by messaging	
		
			
		$postString = http_build_query($data);
			

		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			
		// Get the response
		$res = curl_exec($ch);
		$info = curl_getinfo($ch,CURLINFO_HTTP_CODE);
		curl_close($ch);
		
		echo "Finished";
*/
echo "what's up  ";

echo "Hello Line BOT";