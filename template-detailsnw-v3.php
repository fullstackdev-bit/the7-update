<?php
/* Template Name: Property Detail-2 v3 */  
/**
 * Media Albums template. Uses dt_gallery post type and dt_gallery_category taxonomy.
 *
 * @package The7
 * @since 1.0.0
 */
session_start();
if(isset($_GET['id']) ){
	$adults=1;
	$children="";
	 $resultDate=[];
	$adults=trim($_GET['Ad']);
	$children=trim($_GET['C']);
	$RoomTypeId=$_GET['id'];
	$url = "https://api2.rms.com.au/rmsxml/rms_api.aspx";
	$xml_new = '<RMSRoomTypeRQ> 
					<ShowAreas/>
						<AgentId>1</AgentId>
						<RMSClientId>10774</RMSClientId>
						<RoomTypes>
							<RoomType>
								<RoomTypeId>'.$RoomTypeId.'</RoomTypeId>
							</RoomType>
						</RoomTypes>
				</RMSRoomTypeRQ>';
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
			
			header("location:".site_url()."");
			exit();

		}else{
		    
			$response_new=simplexml_load_string($response_new);
			$response_new = json_decode( json_encode($response_new) , 1);
			$final_result1 = array();
			
			 
			
			
			
			$final_result1 = $response_new['RoomTypes']['RoomType'];
			
			$MaxOccupancy=$final_result1['MaxOccupancy'];
			
			$requirements=$final_result1['Requirements']['Requirement'];
			$areas=$final_result1['Areas']['Area'];
			$fullAddress=$areas['Address']['Addr1'].' '.$areas['Address']['Town'].' ,'.$areas['Address']['State'].' ,'.$areas['Address']['PostCode'];
			$lat=$areas['Latitude'];
			$lon=$areas['Longitude'];
			$attributes=$final_result1['Attributes']['Attribute'];
			$final_attributes="";
			$td=1;
			foreach($attributes as $singleAttributes){
				$singAttr=strtolower($singleAttributes['Name']);
				$singAttr = str_replace(' ', '-', $singAttr);
				if($td==1){
					$final_attributes=$singAttr;
				}else{
					$final_attributes.=','.$singAttr;
				}
				$td++;
			}
			$images= array();
			$allImages=$final_result1['Images']['Image'];
			foreach($allImages as $Img){
				array_push($images,$Img);
			}
		}	


		
		if(isset($_GET['A']) && isset($_GET['D']) && isset($_GET['Ad'])){
			
			
			
			
			
			// --------------------------- CHECK --------------------------
			$xml2_rate ='<RMSAvailRateChartRQ>
												  <AgentId>1</AgentId>
												  <RMSClientId>10774</RMSClientId>
												  <Start>'.$_GET['A'].'</Start>
												  <End>'.$_GET['D'].'</End>
												  <RoomTypes>
												  <RoomType RoomTypeId="'.$RoomTypeId.'" /> 
												  
												  </RoomTypes>';
												  
												  if(isset($_GET['Ad']) && $_GET['Ad']!=""){
												  $xml2_rate.='<Adults>'.$_GET['Ad'].'</Adults>';
												  }
												  
												  if($_GET['C']!=""){
													  $xml2_rate.='<Children>'.$_GET['C'].'</Children>';
												  }
												
												  $xml2_rate.='<ExcludeInvalidRates></ExcludeInvalidRates></RMSAvailRateChartRQ>';
												  
					$headers3_rate = array(
							"Content-type: text/xml",
							"Content-length: " . strlen($xml2_rate),
							"username:RMSXMLP",
							"password:M83e6g7",
							"Connection: close",
						);

						$ch3_rate = curl_init(); 
						curl_setopt($ch3_rate, CURLOPT_URL,$url);
						curl_setopt($ch3_rate, CURLOPT_RETURNTRANSFER, 1);
						curl_setopt($ch3_rate, CURLOPT_USERPWD, "RMSXMLP:M83e6g7");
						curl_setopt($ch3_rate, CURLOPT_TIMEOUT, 10);
						curl_setopt($ch3_rate, CURLOPT_POST, true);
						curl_setopt($ch3_rate, CURLOPT_POSTFIELDS, $xml2_rate);
						curl_setopt($ch3_rate, CURLOPT_HTTPHEADER, $headers3_rate);
						curl_setopt($ch3_rate, CURLOPT_TIMEOUT, 400); // the timeout in seconds

						$response3_rate = curl_exec($ch3_rate);
						$err3_rate = curl_error($ch3_rate);

						curl_close($ch3_rate);
						
						
						$response3_rate=simplexml_load_string($response3_rate);
												
						$response3_rate = json_decode(json_encode($response3_rate) , 1);
						
						$final_result_rate = $response3_rate['RoomTypes']['RoomType'];
						
						echo "<pre>";
							print_r($final_result_rate);
						echo "</pre>";
						
						$dayAvailablity=$final_result_rate['BookingRangeAvailable'];
						
						// condition end here for checking date range
						if($final_result_rate['BookingRangeAvailable']=='true'){
							
							// echo "dt";
							
							
							
							
							
							$chargeTypeId = $final_result_rate['ChargeTypes']['ChargeType']['ChargeTypeId'];
							if($chargeTypeId!=""){
								$chargeTypeId = $final_result_rate['ChargeTypes']['ChargeType'][0]['ChargeTypeId'];
							}
							
							echo "<br />";
							echo "charge id is ".$chargeTypeId."<br />";
							
							
							echo "<pre>";
								print_r($final_result_rate['ChargeTypes']);
							echo "</pre>";
			
							// --------------------- END HERE -------------------------------
			
				$start=$_GET['A'];
				$end=$_GET['D'];
				$xml ='<RMSQuoteRQ>
						  <RMSClientId>10774</RMSClientId>
						  <AgentId>1</AgentId>
						  <Quotes>
							<Quote>
							  <QuoteItem>
								<RoomTypeId>'.$RoomTypeId.'</RoomTypeId>
								<NoOfRooms>1</NoOfRooms>';
								
								$first=strtotime($start);
								$second=strtotime($end);
								
								$datediff=$second-$first;
								$totalDiff=round($datediff / (60 * 60 * 24));
								
								//if($totalDiff<7){
								
								
								$xml.='<ChargeTypeId>'.$chargeTypeId.'</ChargeTypeId>';
								//}else{
								//	$xml.='<ChargeTypeId>3</ChargeTypeId>';
								//}

								$xml.='<BookingSourceId></BookingSourceId>
								<ArrivalDate>'.$_GET['A'].'T00:00:00</ArrivalDate>
								<DepartureDate>'.$_GET['D'].'T00:00:00</DepartureDate>';
								
								 if(isset($_GET['Ad']) && $_GET['Ad']!=""){
								  $xml.='<Adults>'.$_GET['Ad'].'</Adults>';
								  }
						  
								  if($_GET['C']!=""){
									  $xml.='<Children>'.$_GET['C'].'</Children>';
								  }
						  
								$xml.='<Infants>0</Infants>
								<Additionals1>0</Additionals1>
								<Additionals2>0</Additionals2>
								<Additionals3>0</Additionals3>
								<Additionals4>0</Additionals4>
								<Additionals4>0</Additionals4>
								<CurrencyId>5</CurrencyId>
							  </QuoteItem>
								 </Quote>
						  </Quotes>
						</RMSQuoteRQ>';
						
				$headers = array(
							"Content-type: text/xml",
							"Content-length: " . strlen($xml),
							"username:RMSXMLP",
							"password:M83e6g7",
							"Connection: close",
						);	
						
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
				}else{
						$response=simplexml_load_string($response);	
						$response = json_decode( json_encode($response) , 1);
						
						
						// echo "<pre>";
						// print_r($response);
						// echo "</pre>";
						
						
						$noofRooms = $response['Quotes']['Quote']['QuoteItem']['NoOfRooms'];
						$chargeId  = $response['Quotes']['Quote']['QuoteItem']['ChargeTypeId'];
						
						$nightDetail=array();
						$allNight=$response['Quotes']['Quote']['QuotedPrice']['NightlyBreakdown']['Night'];
						
						foreach($allNight as $singleNight){
								
								// echo "<pre>";
								// print_r($singleNight);
								// echo "</pre>";
								
								$night=array();
								$night["Date"]=$singleNight["@attributes"]["Date"];
								$night["Price"]=$singleNight["@attributes"]["Price"];
								
								array_push($nightDetail,$night);
							
						}
							
											
												
												
												if ($response["TotalPrice"] > 0) {

													//die("good");
													// echo "---------------------<br />";
													// echo "<pre>";
														// print_r($response);
													// echo "</pre>";
													// echo "---------------------<br />";
													
													
												$finalPrice= $response["TotalPrice"];
												$finalDeposit= $response["TotalDeposit"];
												$bookingAvailable=true;
												} else  {
												
												$xml2 ='<RMSAvailRateChartRQ>
												  <AgentId>1</AgentId>
												  <RMSClientId>10774</RMSClientId>
												  <Start>'.$_GET['A'].'</Start>
												  <End>'.$_GET['D'].'</End>
												  <RoomTypes>
												  <RoomType RoomTypeId="'.$RoomTypeId.'" /> 
												  
												  </RoomTypes>';
												  
												  if(isset($_GET['Ad']) && $_GET['Ad']!=""){
												  $xml2.='<Adults>'.$_GET['Ad'].'</Adults>';
												  }
												  
												  if($_GET['C']!=""){
													  $xml2.='<Children>'.$_GET['C'].'</Children>';
												  }
												
												  $xml2.='<ExcludeInvalidRates></ExcludeInvalidRates></RMSAvailRateChartRQ>';
												  
					$headers3 = array(
							"Content-type: text/xml",
							"Content-length: " . strlen($xml2),
							"username:RMSXMLP",
							"password:M83e6g7",
							"Connection: close",
						);

						$ch3 = curl_init(); 
						curl_setopt($ch3, CURLOPT_URL,$url);
						curl_setopt($ch3, CURLOPT_RETURNTRANSFER, 1);
						curl_setopt($ch3, CURLOPT_USERPWD, "RMSXMLP:M83e6g7");
						curl_setopt($ch3, CURLOPT_TIMEOUT, 10);
						curl_setopt($ch3, CURLOPT_POST, true);
						curl_setopt($ch3, CURLOPT_POSTFIELDS, $xml2);
						curl_setopt($ch3, CURLOPT_HTTPHEADER, $headers3);
						curl_setopt($ch3, CURLOPT_TIMEOUT, 400); // the timeout in seconds

						$response3 = curl_exec($ch3);
						$err3 = curl_error($ch3);

						curl_close($ch3);

						if ($err3) {
								//die("No Hotel Found");
						}else{
							
												$response3=simplexml_load_string($response3);
												
												$response3 = json_decode(json_encode($response3) , 1);
												
												// echo "<pre>";
													// print_r($response3);
												// echo "</pre>";
												
												// die();
												
												
												
												$final_result = array();
												$final_result = $response3['RoomTypes']['RoomType'];
												$bookingAvailable=  $final_result["BookingRangeAvailable"];
  				
												$finalPrice=$final_result['ChargeTypes']['ChargeType']['TotalPriceAfterDiscount'];
												$finalDeposit=0;
				
													
												}
																						
										}
						
						
				}	

			// condition end here for checking date range
			}
			
		}
		
				if(!isset($_GET['A'])){
				$start_availabe_date=date('Y-m-d');
				}else{
				$start_availabe_date=$_GET['A'];	
				}
				$end_available_date=date('Y-m-d', strtotime('+18 month'));
			
				$check_available_xml='<RMSAvailRateChartRQ>
								  <AgentId>1</AgentId>
								  <RMSClientId>10774</RMSClientId>
								  <Start>'.$start_availabe_date.'</Start>
								  <End>'.$end_available_date.'</End>
								  <RoomTypes>
									<RoomType RoomTypeId="'.$RoomTypeId.'">
									</RoomType>
								  </RoomTypes>
								</RMSAvailRateChartRQ>';
								
					$headers_avl = array(
						"Content-type: text/xml",
						"Content-length: " . strlen($check_available_xml),
						"username:RMSXMLP",
						"password:M83e6g7",
						"Connection: close",
						);		

				$ch_chk = curl_init();
				curl_setopt($ch_chk, CURLOPT_URL,$url);
				curl_setopt($ch_chk, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch_chk, CURLOPT_USERPWD, "RMSXMLP:M83e6g7");
				curl_setopt($ch_chk, CURLOPT_TIMEOUT, 10);
				curl_setopt($ch_chk, CURLOPT_POST, true);
				curl_setopt($ch_chk, CURLOPT_POSTFIELDS, $check_available_xml);
				curl_setopt($ch_chk, CURLOPT_HTTPHEADER, $headers_avl);
				curl_setopt($ch_chk, CURLOPT_TIMEOUT, 400); // the timeout in seconds
				$response_result = curl_exec($ch_chk);
				$err_response = curl_error($ch_chk);
				curl_close($ch_chk);

				if(!$err_response){
						$response_result=simplexml_load_string($response_result);
						
						$response_result = json_decode(json_encode($response_result) , 1);

						$response_result=$response_result['RoomTypes']['RoomType']['Availability'];
			
						foreach($response_result as $result_data){
							if($result_data['@attributes']['Available']=='true'){
								$avlDate=date("j-n-Y", strtotime($result_data['@attributes']['Date']));
								array_push($resultDate,$avlDate);   
							}
						}
				}
				
				
		
		/// for checking room available for number of people
				$check_available_xml1='<RMSAvailRateChartRQ>
								  <AgentId>1</AgentId>
								  <RMSClientId>10774</RMSClientId>
								  <Start>'.$_GET['A'].'</Start>
								  <End>'.$_GET['D'].'</End>
								  <Adults>'.$_GET['Ad'].'</Adults>';
								  
				if($_GET['C']!=""){
				  $check_available_xml1.='<Children>'.$_GET['C'].'</Children>';
				}				  		  
				$check_available_xml1.='<RoomTypes>
									<RoomType RoomTypeId="'.$RoomTypeId.'">
									</RoomType>
								  </RoomTypes>
								<ExcludeInvalidRates></ExcludeInvalidRates></RMSAvailRateChartRQ>';
								
					$headers_avl1 = array(
						"Content-type: text/xml",
						"Content-length: " . strlen($check_available_xml1),
						"username:RMSXMLP",
						"password:M83e6g7",
						"Connection: close",
						);		

				$ch_chk12 = curl_init();
				curl_setopt($ch_chk12, CURLOPT_URL,$url);
				curl_setopt($ch_chk12, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch_chk12, CURLOPT_USERPWD, "RMSXMLP:M83e6g7");
				curl_setopt($ch_chk12, CURLOPT_TIMEOUT, 10);
				curl_setopt($ch_chk12, CURLOPT_POST, true);
				curl_setopt($ch_chk12, CURLOPT_POSTFIELDS, $check_available_xml1);
				curl_setopt($ch_chk12, CURLOPT_HTTPHEADER, $headers_avl1);
				curl_setopt($ch_chk12, CURLOPT_TIMEOUT, 400); // the timeout in seconds
				$response_result222 = curl_exec($ch_chk12);
				$err_response222 = curl_error($ch_chk12);
				curl_close($ch_chk12);

				if(!$err_response222){
						$response_result222=simplexml_load_string($response_result222);
						$response_result222 = json_decode(json_encode($response_result222) , 1);
						$response_result222=$response_result222['RoomTypes']['RoomType']['Availability'];
						
						if(sizeof($response_result222)>0){
							$dayAvailablity="true";
						}else{
							$dayAvailablity="false";
						}
				}
				
		/// end here for number of people
				
				
		
			
		
		// if bookingForm
		if(isset($_POST['book'])){
				
				$_SESSION["bookingDetail"]=array();
				//$fullAddress
				$_SESSION['bookingDetail']['address']=$fullAddress;
				$_SESSION['bookingDetail']['images']=$images;
				// number of rooms
				$_SESSION['bookingDetail']['NoOfRooms']=$noofRooms; 
				// night details
				$_SESSION['bookingDetail']['nightDetail']=$nightDetail; 
				
				$_SESSION["bookingDetail"]["TotalPrice"]=$finalPrice;
				
				$_SESSION["bookingDetail"]["requirements"]=$requirements;
				
				if($finalDeposit > 0) {
				$_SESSION["bookingDetail"]['TotalDeposit']=$finalDeposit;
				}else{
				$_SESSION["bookingDetail"]['TotalDeposit']=$finalPrice;
				}
				$_SESSION["bookingDetail"]['id']=$RoomTypeId;
				$_SESSION["bookingDetail"]['Ad']=$_GET['Ad'];
				$_SESSION["bookingDetail"]['chargeId']=$chargeId;
				$_SESSION["bookingDetail"]['C']=$_GET['C'];
				$_SESSION["bookingDetail"]['A']=$start;
				$_SESSION["bookingDetail"]['D']=$end;
				$_SESSION["bookingDetail"]['name']=$final_result1['Name'];
				
				// add here for pet_friendly	
				$pet_friendly=0;
				$final_attributes=explode(",",$final_attributes);
				if (in_array("pet-friendly", $final_attributes)){
					$pet_friendly=1;
				}
				$_SESSION["bookingDetail"]['pet']=$pet_friendly;
				// end here for pet_friendly
				
				$p_name=strtolower($final_result1['Name']);
				$p_name = preg_replace('/\s+/', '-', $p_name);  
				header("location:".site_url()."/book/".$p_name."");
				//header("location:".site_url()."/book/");
				exit();
		}
		// end here 
		
												
}else{
	header("location:".site_url()."");
	exit();
}
get_header('api'); ?>



<div class="page-title title-center solid-bg breadcrumbs-mobile-off page-title-responsive-enabled">
			<div class="wf-wrap">
			<div class="page-title-head hgroup">
			    <h1><?php echo $final_result1['Name']; ?></h1></div>
			    	</div>
		</div>

<?php if ( presscore_is_content_visible() ): ?>

<div id="main" <?php presscore_main_container_classes() ?> <?php presscore_main_container_style() ?> >
    
	<?php do_action( 'presscore_main_container_begin' ) ?>

    <div class="main-gradient"></div>
    <div class="wf-wrap">
    <div class="wf-container-main">

	<?php do_action( 'presscore_before_content' ) ?>

<?php endif ?>


<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<style>
/* Make the image fully responsive */
.carousel-inner img { width: 100%; height: 100%; }

</style>
<?php   if(sizeof($resultDate)>0){   ?>
<style>
.ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default {
    color: #ffffff;
    background:#3C485C ;
}
.ui-state-disabled .ui-state-default {
    color: black;
    background: white;
}

@charset "utf-8";
/* CSS Document */

.cust_testimonials h2 {
	color: #333;
	text-align: center;
	text-transform: uppercase;
	font-family: "Roboto", sans-serif;
	font-weight: bold;
	position: relative;
	margin: 30px 0 60px;
}
.cust_testimonials h2::after {
	content: "";
	width: 100px;
	position: absolute;
	margin: 0 auto;
	height: 3px;
	background: #3d495e;
	left: 0;
	right: 0;
	bottom: -10px;
}
.cust_testimonials .col-center {
	margin: 0 auto;
	float: none !important;
}
.cust_testimonials .carousel {
	margin: 50px auto;
	padding: 0 70px;
}
.cust_testimonials .carousel .item {
	color: #999;
	font-size: 14px;
    text-align: center;
	overflow: hidden;
    min-height: 290px;
}
.cust_testimonials .carousel .item .img-box {
	width: 150px;
	height: 150px;
	margin: 0 auto;
	padding: 5px;
	border: 1px solid #ddd;
	border-radius: 50%;
}
.cust_testimonials .carousel .img-box img {
	width: 100%;
	height: 100%;
	display: block;
	border-radius: 50%;
}
.cust_testimonials .carousel .testimonial {
	padding: 30px 0 10px;
}
.cust_testimonials .carousel .overview {	
	font-style: italic;
}
.cust_testimonials .carousel .overview b {
	text-transform: uppercase;
    color: #3d495e;
    font-size: 15px;
}
.cust_testimonials .carousel .carousel-control {
	width: 40px;
    height: 40px;
    margin-top: -20px;
    top: 50%;
	background: none;
}
.cust_testimonials .carousel-control i {
    font-size: 68px;
	line-height: 42px;
    position: absolute;
    display: inline-block;
	color: rgba(0, 0, 0, 0.8);
    text-shadow: 0 3px 3px #e6e6e6, 0 0 0 #000;
}
.cust_testimonials .carousel .carousel-indicators {
	bottom: -40px;
}
.cust_testimonials {
    background-color: #f9f9f9;
    padding-top: 20px;
    margin-top: 40px;
	display:none;
}
</style>

<?php
} 
	?>
<div id="content" class="content gaba" role="main">
	<div id="demo" class="carousel slide" data-ride="carousel"> 
		<!-- Indicators -->
		<ul class="carousel-indicators">
			<?php $td1=0; foreach($images as $singImg){ ?>
			<li data-target="#demo" data-slide-to="<?php echo $td1; ?>" class="<?php if($td1==0){ echo 'active';} ?>"></li>
			<?php $td1++; } ?>
		</ul>
		<!-- The slideshow -->
		<div class="carousel-inner">
			<?php $td=1; foreach($images as $singImg){ ?>
			<div class="carousel-item <?php if($td==1){ echo 'active';} ?>"> <img src="<?php  echo $singImg; ?>" alt="Los Angeles" width="1100" height="500"> </div>
			<?php $td++; } ?>
		</div>
		<!-- Left and right controls --> 
		<a class="carousel-control-prev" href="#demo" data-slide="prev"> <span class="carousel-control-prev-icon"></span> </a> <a class="carousel-control-next" href="#demo" data-slide="next"> <span class="carousel-control-next-icon"></span> </a> </div>
	<span class="cp-load-after-post"></span>
	<div class="itemDetails">
		<div class="textPart">
			<h3><?php echo $final_result1['Name']; ?></h3>
			
			<?php /*
			<h5>Price: <?php echo $finalPrice." ";  echo "AUD"; ?></h5>
			<?php if($finalDeposit > 0) { ?>
			<h5>Deposit: <?php echo $finalDeposit." ";  echo "AUD"; ?></h5>
            <?php } */ ?>
			
			
		</div>
		<div class="iconsPart">
			<?php 
		$final_attributes=explode(",",$final_attributes);

		if (in_array("1-bedroom", $final_attributes)){
			echo "<span class='iconItem'><img src='". esc_url( get_template_directory_uri() )  ."/images/bedroom.png' alt='bedroom'/></span>";
		}
		if (in_array("2-bedroom", $final_attributes)){
			echo "<span class='iconItem'><img src='". esc_url( get_template_directory_uri() )  ."/images/2-bedroom.png' alt='bedroom'/></span>";
		}
		if (in_array("3-bedroom", $final_attributes)){
			echo "<span class='iconItem'><img src='". esc_url( get_template_directory_uri() )  ."/images/3-bedroom.png' alt='bedroom'/></span>";
		}
		if (in_array("4-bedroom", $final_attributes)){
			echo "<span class='iconItem'><img src='". esc_url( get_template_directory_uri() )  ."/images/4-bedroom.png' alt='bedroom'/></span>";
		}
		if (in_array("5-bedroom", $final_attributes)){
			echo "<span class='iconItem'><img src='". esc_url( get_template_directory_uri() )  ."/images/5-bedroom.png' alt='bedroom'/></span>";
		}
		if (in_array("1-bathroom", $final_attributes)){
			echo "<span class='iconItem'><img src='". esc_url( get_template_directory_uri() )  ."/images/bathroom.png' alt='bathroom'/></span>";
		}
		if (in_array("2-bathroom", $final_attributes)){
			echo "<span class='iconItem'><img src='". esc_url( get_template_directory_uri() )  ."/images/2-bathroom.png' alt='bathroom'/></span>";
		}
		if (in_array("3-bathroom", $final_attributes)){
			echo "<span class='iconItem'><img src='". esc_url( get_template_directory_uri() )  ."/images/3-bathroom.png' alt='bathroom'/></span>";
		}
		if (in_array("4-bathroom", $final_attributes)){
			echo "<span class='iconItem'><img src='". esc_url( get_template_directory_uri() )  ."/images/4-bathroom.png' alt='bathroom'/></span>";
		}
		
		if($MaxOccupancy>1 && $MaxOccupancy<=10){
			echo "<span class='iconItem'><img src='https://executiveescapes.com.au/wp-content/uploads/2019/02/max-occ-".$MaxOccupancy.".png' alt='".$MaxOccupancy." Occupancy'/></span>";
		}
		
		if (in_array("pet-friendly", $final_attributes)){
			echo "<span class='iconItem'><img src='". esc_url( get_template_directory_uri() )  ."/images/pet-friendly.png' alt='pet friendly'/></span>";
		}
			
		if (in_array("internet", $final_attributes)){
			echo "<span class='iconItem'><img src='". esc_url( get_template_directory_uri() )  ."/images/wifi.png' alt='air conditioning'/></span>";
		}	
		if (in_array("swimming-pool", $final_attributes)){ 
			echo "<span class='iconItem'><img src='". esc_url( get_template_directory_uri() )  ."/images/swimming-pool.png' alt='swimming pool'/></span>";
		}
		if (in_array("1-car-space", $final_attributes)){
			echo "<span class='iconItem'><img src='". esc_url( get_template_directory_uri() )  ."/images/1-carport.png' alt='secure parking'/></span>";
		}	
		
		if (in_array("2-car-spaces", $final_attributes)){
			echo "<span class='iconItem'><img src='". esc_url( get_template_directory_uri() )  ."/images/2-carport.png' alt='secure parking'/></span>";
		}	
		

	?>
		</div>
	</div>
	
	<?php if(isset($_GET['A']) && isset($_GET['D']) && isset($_GET['Ad'])){ ?>
	
	
	
	<?php if($dayAvailablity=='true'){ ?>
	
	<?php if($bookingAvailable=='true' && ($finalPrice>0 || $finalDeposit>0)){ ?>
	
	
	
	<div class="bookingDetails"><h4>Booking Details</h4>
	<table class="table">
    <thead>
      <tr>
        <th>Arrival</th>
        <th>Departure</th>
        <th>Number of Night(s)</th>
        <th>Adult(s)</th>
        <th>Children</th>
        <th>Total Cost</th>
		<?php  if($finalDeposit>0){ ?>
        <th>Deposit Amount</th>
		<?php } ?>
		<th></th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td data-title="Arrival"><?php echo date('d-m-Y',strtotime($_GET['A'])); ?></td>
        <td data-title="Departure"><?php echo date('d-m-Y',strtotime($_GET['D'])); ?></td>
		<td data-title="No of night(s)"><?php echo $nights = (strtotime($_GET['D']) - strtotime($_GET['A'])) / 86400; ?></td>
        <td data-title="Adult(s)"><?php echo $_GET['Ad']; ?></td>
        <td data-title="Children"><?php echo $_GET['C']; ?></td>
		
		
		<?php if($dayAvailablity=='true'){ ?>
        <td data-title="Total Cost"><?php if($finalPrice>0){ echo $finalPrice;?> AUD <?php } ?></td>
		<?php  if($finalDeposit>0){ ?>
        <td data-title="Deposit Amount"><?php echo $finalDeposit;?> AUD</td>
		<?php } ?>
		<?php }else{ ?>
		<td data-title="Total Cost"></td>
		<td data-title="Deposit Amount"></td>
		<?php } ?>
		
		
		<td class="formBtn">
		<?php if($dayAvailablity=='true'){ ?>
		<?php    if($bookingAvailable=='true' && ($finalPrice>0 || $finalDeposit>0)){ ?>
		<form method="post">
		<input type="submit" name="book" class="bt btn-outline-info btn-rounded btn-block" value="Book Now" />
		</form>
		<?php  }else{ ?>
			<b>Property Unavailable</b>
		<?php } ?>
		<?php }else{ ?>
			<b>Property Unavailable</b>	
		<?php } ?>
		</td>
      </tr> 
	</tbody>
	</table>
    <p style="font-size:14px;"><b>*Please note a $100.00 AUD service fee is included in the total cost.</b></p>
    </div>
	
	<?php }else { ?>
	
	<p style="font-weight:bold;margin-top:10px;">Sorry we do not have any properties available for your current search criteria. Please change your search criteria or get in touch with us on +61 8 9286 2641 or at info@executiveescapes.com.au to see if we can assist you further.</p>

	
	<?php } ?>
	
	
	<?php } else { ?>
	
	<p style="font-weight:bold;margin-top:10px;">Sorry we do not have any properties available for your current search criteria. Please change your search criteria or get in touch with us on +61 8 9286 2641 or at info@executiveescapes.com.au to see if we can assist you further.</p>
	
	
	
	<?php } ?>
	
	
	
	
	<?php } ?>
	
	
	
    <?php  if(sizeof($final_result1['Description']) > 0 && $final_result1['Description'] != ""){ ?>
	<p><?php echo $final_result1['Description']; ?></p>  
    <?php } ?>
	
	<?php
	/*
	  <table class="table table-bordered">
		<thead>
		  <tr>
			<th>Description</th>
			<th>Unit</th>
			<th>Quantity</th>
			<th>Amount</th>
		  </tr>
		</thead>
		<tbody>
		<?php foreach($requirements as $singleItem) {
		
			$fullDescription="";
			$fullDescription=$singleItem['Name'];
			
			if(!empty($singleItem['Note'])){
				$fullDescription=$fullDescription." - ".$singleItem['Note'];
			}

		?>
		  <tr>
			<td><?php echo $fullDescription; ?></td>
			<td><?php echo $singleItem['Amount']; ?></td>
			<td><input type="number" id="record_<?php echo $singleItem['ID']; ?>"  min='0' max='10' value="0" /></td>
			<td><?php echo $singleItem['Amount']; ?></td>
		  </tr>
		<?php } ?>  
		</tbody>
	</table>

	*/
	?>	

</div>
<!-- #content -->
<aside id="sidebar" class="sidebar">
	<div class="sidebar-content">
		<section id="search-2" class="widget widget_search"> 
			<!-- Material form contact -->
			<div class="card">
				<h5 class="card-header info-color white-text text-center py-4"> <strong> Check Availability</strong> 
                <h4 class="hme-note2">*Minimum 3 nights allowed to book</h4>
                </h5>
				<!--Card content-->
				<div class="card-body bookingForm pt-0"> 
					<!-- Form -->
					<form action="" class="text-center" method='get'  style="color: #757575;">
						<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
						<div class="md-form mt-3">
							<span>Arrival*</span>
				<input autocomplete="off" type="text" id="A" name="A" class="form-control arrival-date " value="<?php echo $start; ?>" placeholder="" required  />
						</div>
						<div class="md-form mt-3">
							<span>Departure*</span><input  autocomplete="off" type="text" id="D" name="D" class="form-control departure-date" value="<?php echo $end; ?>" placeholder="" required  />
						</div>
						<!-- Name -->
						<div class="md-form mt-3">
							<span>Adult(s)</span>
							
							<select name="Ad" id="Ad">
									<option value="1" <?php if($adults==1){ echo 'selected'; } ?> >1</option>

									<option value="2" <?php if($adults==2){ echo 'selected'; } ?>>2</option>

									<option value="3" <?php if($adults==3){ echo 'selected'; } ?>>3</option>

									<option value="4" <?php if($adults==4){ echo 'selected'; } ?>>4</option>

									<option value="5" <?php if($adults==5){ echo 'selected'; } ?>>5</option>

									<option value="6" <?php if($adults==6){ echo 'selected'; } ?>>6</option>

									<option value="7" <?php if($adults==7){ echo 'selected'; } ?>>7</option>

									<option value="8" <?php if($adults==8){ echo 'selected'; } ?>>8</option>
							</select>
						</div>
						<!-- Name -->
						<div class="md-form mt-3">
							<span>Children</span>
							<select name="C" id="C">
									<option value=""></option>

									<option value="1" <?php if($children==1){ echo 'selected'; } ?>>1</option>

									<option value="2" <?php if($children==2){ echo 'selected'; } ?>>2</option>

									<option value="3" <?php if($children==3){ echo 'selected'; } ?>>3</option>

									<option value="4" <?php if($children==4){ echo 'selected'; } ?>>4</option>

									<option value="5" <?php if($children==5){ echo 'selected'; } ?>>5</option>
							</select>
						</div>
						<!-- E-mail -->
						
						
						<!-- Send button -->
						<div class="md-form full">
							<button class="btn btn-outline-info btn-rounded btn-block z-depth-0 my-2 waves-effect" type="submit" name="submit">Submit</button>
						
						</div>
					</form>
					<!-- Form --> 
				</div>
			</div>
			<!-- Material form contact --> 
		</section>
		<section id="recent-posts-2" class="widget widget_recent_entries">
         <iframe src="https://maps.google.com/maps?q=<?php echo $lat; ?>, <?php echo $lon; ?>&amp;z=13&amp;output=embed" width="360" height="270" frameborder="0" style="border:0"></iframe>   
		</section>
        
        <?php dynamic_sidebar( 'new-detail-contact' ); ?>  
		
	</div>
</aside>





<?php
$_SESSION['request_data']="";
$_SESSION['result']="";
 get_footer('detail'); ?>
 <?php   if(sizeof($resultDate)>0){   ?>
 <script> 
 jQuery(document).ready(function(){	 
 
/* jQuery.post( "<?php echo get_template_directory_uri();?>/ajax.php", { "roomTypeId": <?php echo $RoomTypeId; ?> })
  .done(function( data ) {
    console.log(data)
  });
  
  */
 
 //var availableDates = ["6-12-2018","7-12-2018"];
 var availableDates = <?php echo json_encode($resultDate); ?>;
 
 // console.log(availableDates);

function available(date) {
	
  dmy = date.getDate() + "-" + (date.getMonth()+1) + "-" + date.getFullYear();
  //console.log(dmy);
  if (jQuery.inArray(dmy, availableDates) != -1) {
    return [true, "","Available"];
  } else {
    return [false,"","unAvailable"];
  }
}

jQuery('.arrival-date').datepicker({ 
		beforeShowDay: available,
		dateFormat: 'yy-mm-dd',
		onSelect: function(date){

        var selectedDate = new Date(date);
        var msecsInADay = 86400000*3;
        var endDate = new Date(selectedDate.getTime() + msecsInADay);
		
		//console.log(endDate);

       //Set Minimum Date of EndDatePicker After Selected Date of StartDatePicker
        jQuery(".departure-date").datepicker( "option", "minDate", endDate );    

    }

}); 
jQuery('.departure-date').datepicker({dateFormat: 'yy-mm-dd',beforeShowDay: available}); 
});
 </script>
 <?php   } else{  ?>
  <script> 
 jQuery(document).ready(function(){	
 
jQuery('.arrival-date').datepicker({dateFormat: 'yy-mm-dd'}); 
jQuery('.departure-date').datepicker({dateFormat: 'yy-mm-dd'}); 
});
 </script>
 
 <?php }  ?>