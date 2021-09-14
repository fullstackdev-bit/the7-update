<?php 
ini_set('error_reporting', E_ALL);
include("../../../wp-config.php");
 $resultDate=[];
$start_availabe_date=date('Y-m-d');
$end_available_date=date('Y-m-d', strtotime('+1 month'));
$url = "https://api2.rms.com.au/rmsxml/rms_api.aspx";
	
$xml_new = '<RMSAvailRateChartRQ>
  <AgentId>1</AgentId>
  <RMSClientId>10774</RMSClientId>
  <Start>'.$start_availabe_date.'</Start>
  <End>'.$end_available_date.'</End>
  <RoomTypes>
	<RoomType RoomTypeId="85">
	</RoomType>
</RoomTypes>
</RMSAvailRateChartRQ>';

	$headers_new = array(
						"Content-type: text/xml",
						"Content-length: " . strlen($xml_new),
						"username:RMSXMLP",
						"password:M83e6g7",
						"Connection: close",
		);

		$ch1 = curl_init();
		curl_setopt($ch1, CURLOPT_URL,$url);
		curl_setopt($ch1, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch1, CURLOPT_USERPWD, "RMSXMLP:M83e6g7");
		curl_setopt($ch1, CURLOPT_TIMEOUT, 10);
		curl_setopt($ch1, CURLOPT_POST, true);
		curl_setopt($ch1, CURLOPT_POSTFIELDS, $xml_new);
		curl_setopt($ch1, CURLOPT_HTTPHEADER, $headers_new);
		curl_setopt($ch1, CURLOPT_TIMEOUT, 400); // the timeout in seconds
		$response_new = curl_exec($ch1);
		$err_new = curl_error($ch1);
		if($err_new){
			
			//die("here i am");
			
			// header("location:".site_url()."");
			// exit();

		}else{
			$response_new=simplexml_load_string($response_new);
			
			$response_new = json_decode( json_encode($response_new) , 1);
			
			$response_new=$response_new['RoomTypes']['RoomType']['Availability'];
			
			foreach($response_new as $result_data){
				
				if($result_data['@attributes']['Available']=='true'){
				 array_push($resultDate,$result_data['@attributes']['Date']);
				}
				
				//echo json_encode($result_data);
			}
			
			echo json_encode($resultDate);
		}  
		
		
			
			//$final_result1 = $response_new['RoomTypes']['RoomType'];
?>