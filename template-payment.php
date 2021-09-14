<?php
/* Template Name: Payment */

/**
 * Media Albums template. Uses dt_gallery post type and dt_gallery_category taxonomy.
 *
 * @package The7
 * @since 1.0.0
 */
session_start();
	
$url = "https://api2.rms.com.au/rmsxml/rms_api.aspx";

$back_url= $_SERVER['HTTP_REFERER'];

if(!$back_url){
	
	header("location:".site_url()."");
	exit(); 
}

if(isset($_POST)){ 
			
			
			$_SESSION['request_data']=$_POST;

			if(!isset($_SESSION['bookingDetail']['A']) && !isset($_SESSION['bookingDetail']['D'])){
				
				header("location:".site_url()."");
				exit();
			}
	
			// First check card details valid or not
	
			$curl_nw = curl_init();
			
			$cardExpiry=$_POST['cardExpiry'];
			
			$cardExpiry=str_replace('/', '', $cardExpiry);
			
			
			$dataValue="<Txn>
							<PostUsername>CottesloeBchHse743</PostUsername>
							<PostPassword>396580c9</PostPassword>
							<CardHolderName>".$_POST['holdername']."</CardHolderName>
							<CardNumber>".$_POST['cardNumber']."</CardNumber>
							<Amount>".$_SESSION['bookingDetail']['TotalDeposit']."</Amount>
							<DateExpiry>".$cardExpiry."</DateExpiry>
							<Cvc2>".$_POST['cvv']."</Cvc2>
							<InputCurrency>AUD</InputCurrency>
							<TxnType>Purchase</TxnType>
						</Txn>";

			curl_setopt_array($curl_nw, array(
			  CURLOPT_URL => "https://sec.paymentexpress.com/pxpost.aspx",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 30,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_POSTFIELDS => $dataValue,
			  CURLOPT_HTTPHEADER => array(
				"cache-control: no-cache",
				"content-type: application/xml"
			  ),
			));

			$response_data = curl_exec($curl_nw);
			$err_result = curl_error($curl_nw);

			curl_close($curl_nw);

			if ($err_result) {
			  echo "cURL Error #:" . $err_result;
			  die();
			} else {
				
				$response_data=simplexml_load_string($response_data);			
				$response_data = json_decode( json_encode($response_data) , 1);
				
				
				if($response_data['Transaction']['Authorized']==0){
					
					$_SESSION['result']=$response_data['Transaction']['CardHolderResponseDescription'];
					header("location:".$back_url."");
					die();
					
				}else{
					
								
					
								$_SESSION['request_data']="";
								$_SESSION['result']="";
								
					
								$arrival = $_SESSION['bookingDetail']['A'];
								$arrival= date("Y-m-d", strtotime($arrival) );   

								$departure=$_SESSION['bookingDetail']['D'];
								$departure= date("Y-m-d", strtotime($departure) );   
								
								
								
								
								
								
								// add booking quotes start here 
								
								$xml_quote='<RMSQuoteRQ>
											   <RMSClientId>10774</RMSClientId>
											   <AgentId>1</AgentId>
											   <Quotes>
												<Quote>
												  <QuoteItem>
												<RoomTypeId>'.$_SESSION["bookingDetail"]['id'].'</RoomTypeId>
												<NoOfRooms>'.$_SESSION['bookingDetail']['NoOfRooms'].'</NoOfRooms>
												<ChargeTypeId>'.$_SESSION['bookingDetail']['chargeId'].'</ChargeTypeId>

												<BookingSourceId>29</BookingSourceId>
												<ArrivalDate>'.$arrival.'T00:00:00</ArrivalDate>
												<DepartureDate>'.$departure.'T00:00:00</DepartureDate>
												<Adults>'. $_SESSION['bookingDetail']['Ad'].'</Adults>';
										
										if($_SESSION['bookingDetail']['C']!=""){
											$xml_quote.='<Children>'.$_SESSION['bookingDetail']['C'].'</Children>';
										}else{
											$xml_quote.='<Children>0</Children>';
										}
								
											$xml_quote.='<Infants>0</Infants>
												<Additionals1>0</Additionals1>
												<Additionals2>0</Additionals2>
												<Additionals3>0</Additionals3>
												<Additionals4>0</Additionals4>
												<Additionals4>0</Additionals4>
												</QuoteItem>
												 </Quote>
										  </Quotes></RMSQuoteRQ>';
										  
										  
								$headers_new1 = array(
										"Content-type: text/xml",
										"Content-length: " . strlen($xml_quote),
										"username:RMSXMLP",
										"password:M83e6g7",
										"Connection: close",
									);	


								$ch23 = curl_init(); 
										curl_setopt($ch23, CURLOPT_URL,$url);
										curl_setopt($ch23, CURLOPT_RETURNTRANSFER, 1);
										curl_setopt($ch23, CURLOPT_USERPWD, "RMSXMLP:M83e6g7");
										curl_setopt($ch23, CURLOPT_TIMEOUT, 10);
										curl_setopt($ch23, CURLOPT_POST, true);
										curl_setopt($ch23, CURLOPT_POSTFIELDS, $xml_quote);
										curl_setopt($ch23, CURLOPT_HTTPHEADER, $headers_new1);
										curl_setopt($ch23, CURLOPT_TIMEOUT, 400); // the timeout in seconds

										$response23 = curl_exec($ch23);
										$err23 = curl_error($ch23);
										curl_close($ch23);									
								
								
								// end here 
								
								
								
										
								$xml ='<RMSBookingRQ>
								  <RMSClientId>10774</RMSClientId>
								  <AgentId>1</AgentId>
								  <PaymentId>4</PaymentId>
								  <Token>1</Token> 
								  <CCFees>0</CCFees>
								  <ReceiptType>CreditCard</ReceiptType>
								  <Bookings>
									<Booking>
									  <BookingPrice>	
									 	<Price>'.$_SESSION['bookingDetail']['TotalPrice'].'</Price>
										<Deposit>'.$_SESSION['bookingDetail']['TotalDeposit'].'</Deposit>
										<CurrencyId>5</CurrencyId> 
										<Discount Id="0">0</Discount>
										<OriginalPrice>'.$_SESSION['bookingDetail']['TotalPrice'].'</OriginalPrice>	
									  </BookingPrice>
									  <BookingItem>
										<Agency>false</Agency>
										<NoOfRooms>'.$_SESSION['bookingDetail']['NoOfRooms'].'</NoOfRooms>
										<ChargeTypeId>'.$_SESSION['bookingDetail']['chargeId'].'</ChargeTypeId>
										<BookingSourceId>29</BookingSourceId>
										<RoomTypeId>'.$_SESSION['bookingDetail']['id'].'</RoomTypeId>
										<ArrivalDate>'.$arrival.'T00:00:00</ArrivalDate>
										<DepartureDate>'.$departure.'T00:00:00</DepartureDate>
										<Adults>'. $_SESSION['bookingDetail']['Ad'].'</Adults>';
										
									
								if($_SESSION['bookingDetail']['C']!=""){
									$xml.='<Children>'.$_SESSION['bookingDetail']['C'].'</Children>';
								}else{
									$xml.='<Children>0</Children>';
								}
								
								$xml.='<ETA>14:01</ETA>';
										
								$xml.='</BookingItem>
									</Booking>
								  </Bookings>
								  <ContactDetail>
								    <CCConsent>0</CCConsent>
									<FirstName>'.$_POST['fname'].'</FirstName>
									<LastName>'.$_POST['lname'].'</LastName>
									<Mobile>'.$_POST['phone'].'</Mobile>
									<EmailAddress>'.$_POST['email'].'</EmailAddress>
									<AddressDetail>
									  <Address>'.$_POST['address'].'</Address>
									  <City>'.$_POST['city'].'</City>
									  <PostCode>'.$_POST['PostCode'].'</PostCode>
									  <Country>'.$_POST['country'].'</Country>
									</AddressDetail>
								  </ContactDetail>
								  <PaymentDetail>
									<HolderName>'.$_POST['holdername'].'</HolderName>
									<CardType>'.$_POST['cardtype'].'</CardType>
									<Number>'.$_POST['cardNumber'].'</Number>
									<CCVCode>'.$_POST['cvv'].'</CCVCode>
									<ExpireDate>'.$_POST['cardExpiry'].'</ExpireDate> 
									<Reference>1</Reference>
									<IssueNo></IssueNo>
								  </PaymentDetail>
								</RMSBookingRQ>'; 
								
								
						
						$headers = array(
										"Content-type: text/xml",
										"Content-length: " . strlen($xml),
										"username:RMSXMLP",
										"password:M83e6g7",
										"Connection: close",
									);
									
									
									
					
				}
				
							 
			}
	
			// end here 
	

	
	
		

		
	
}else{
	
	header("location:".site_url()."");
	exit();
}
 

get_header();

?>
<?php

		$ch = curl_init(); 
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_USERPWD, "RMSXMLP:M83e6g7");
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_TIMEOUT, 400); // the timeout in seconds

		$response = curl_exec($ch);
		$err = curl_error($ch);
		curl_close($ch);
		if ($err) {
				die("Something went wrong! Try again later");
		}else{
			
			$response=simplexml_load_string($response);
							
			$response = json_decode( json_encode($response) , 1);
			
			if(isset($response["Error"])){ 
				
				echo "<h1>".$response["Error"]["Message"]."</h1>"; 
			
			}else{				
			
				$refrenceNo = $response['Bookings']['Booking']['BookingReference'];
				
				if($refrenceNo!=""){
					
					$xml2='<RMSCompleteBookingRQ>
							    <RMSClientId>10774</RMSClientId>
								<AgentId>1</AgentId>
							  <BookingReference>'.$refrenceNo.'</BookingReference> 
							  <Action>Confirm</Action>
							</RMSCompleteBookingRQ>';
						
					$headers2 = array(
								"Content-type: text/xml",
								"Content-length: " . strlen($xml2),
								"username:RMSXMLP",
								"password:M83e6g7",
								"Connection: close",
					);
					
					$ch2 = curl_init(); 
					curl_setopt($ch2, CURLOPT_URL,$url);
					curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($ch2, CURLOPT_USERPWD, "RMSXMLP:M83e6g7");
					curl_setopt($ch2, CURLOPT_TIMEOUT, 10);
					curl_setopt($ch2, CURLOPT_POST, true);
					curl_setopt($ch2, CURLOPT_POSTFIELDS, $xml2);
					curl_setopt($ch2, CURLOPT_HTTPHEADER, $headers2);
					curl_setopt($ch2, CURLOPT_TIMEOUT, 400); // the timeout in seconds

					$response2 = curl_exec($ch2);
					$err2 = curl_error($ch2);
					curl_close($ch2);
					if ($err2) {
							die("Something went wrong! Try again later"); 
					}else{
			
						$response2=simplexml_load_string($response2);	
						
			echo "<h1>Thank you for your booking. Your booking number is #".$refrenceNo."</h1> <br/> Thank you for choosing to book with Executive Escapes – We look forward to having you stay with us! <br/> You will receive your booking confirmation email shortly.";  
			$_SESSION['bookingDetail']="";
						
						//print_r($response2);

					}						
					
			
					
				}else{
					
					echo"<h3>Something went wrong! Try again later</h3>";
				}
			}
		}

?>

	
	<?php get_footer(); ?>