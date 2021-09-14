<?php
/* Template Name: Property Detail */

/**
 * Media Albums template. Uses dt_gallery post type and dt_gallery_category taxonomy.
 *
 * @package The7
 * @since 1.0.0
 */
session_start();

if(isset($_GET['id']) && isset($_GET['A']) && isset($_GET['D'])){
	
	$RoomTypeId=$_GET['id'];
	$start=$_GET['A'];
	$end=$_GET['D'];
	
	$url = "https://api2.rms.com.au/rmsxml/rms_api.aspx";
	
	$xml ='<RMSQuoteRQ>
  <RMSClientId>10774</RMSClientId>
  <AgentId>1</AgentId>
  <Quotes>
    <Quote>
      <QuoteItem>
        <RoomTypeId>'.$RoomTypeId.'</RoomTypeId>
        <NoOfRooms>1</NoOfRooms>
        <ChargeTypeId>2</ChargeTypeId>

        <BookingSourceId></BookingSourceId>
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



	
	
	
}else{
	
	header("location:".site_url()."");
	exit();
}
 
 

get_header('api'); ?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<style>
/* Make the image fully responsive */


.carousel-inner img { width: 100%; height: 100%; }
</style>
<?php 
	
	
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
								die("No Hotel Found");
						}else{
							
												$response=simplexml_load_string($response);
												
												$response = json_decode( json_encode($response) , 1);
												
												
												
												$chargeId=$response['Quotes']['Quote']['QuoteItem']['ChargeTypeId'];
												
												
												// echo "<pre>";
												// print_r($response);
												// echo "</pre>";
												// die();
												
												
												if ($response["TotalPrice"] > 0) { 
												
												$finalPrice= $response["TotalPrice"];
												$finalDeposit= $response["TotalDeposit"];
												
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
												  
  				
												$finalPrice=$final_result['ChargeTypes']['ChargeType']['TotalPriceAfterDiscount'];
												$finalDeposit=0;
				
													
												}
																						
										}
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
													

														
												}else{
													
													$response_new=simplexml_load_string($response_new);
							
													$response_new = json_decode( json_encode($response_new) , 1);
													
													
													
													
													
													
													$final_result1 = array();
													$final_result1 = $response_new['RoomTypes']['RoomType'];
													
													$areas=$final_result1['Areas']['Area'];
													
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
			<h5>Price: <?php echo $finalPrice." ";  echo "AUD"; ?></h5>
            
			<?php if($finalDeposit > 0) { ?>
			<h5>Deposit: <?php echo $finalDeposit." ";  echo "AUD"; ?></h5>
            <?php } ?>
		</div>
		<div class="iconsPart">
			<?php 
		//echo $final_attributes ; 
		
		$final_attributes=explode(",",$final_attributes);
		
		
	//	foreach($final_attributes as $singleAttributes){
		if (in_array("1-bedroom", $final_attributes)){
	//	if (strpos($singleAttributes, '') !== false) {
			echo "<span class='iconItem'><img src='". esc_url( get_template_directory_uri() )  ."/images/bedroom.png' alt='bedroom'/></span>";
		}
		
		if (in_array("2-bedroom", $final_attributes)){
		//if (strpos($singleAttributes, '2-bedroom') !== false) {
			echo "<span class='iconItem'><img src='". esc_url( get_template_directory_uri() )  ."/images/2-bedroom.png' alt='bedroom'/></span>";
		}
		
		if (in_array("3-bedroom", $final_attributes)){
		//if (strpos($singleAttributes, '3-bedroom') !== false) {
			echo "<span class='iconItem'><img src='". esc_url( get_template_directory_uri() )  ."/images/3-bedroom.png' alt='bedroom'/></span>";
		}
		
		if (in_array("1-bathroom", $final_attributes)){
		//if (strpos($singleAttributes, 'bathroom') !== false) {
			echo "<span class='iconItem'><img src='". esc_url( get_template_directory_uri() )  ."/images/bathroom.png' alt='bathroom'/></span>";
		}
		
		if (in_array("pet-friendly", $final_attributes)){
		//if (strpos($singleAttributes, 'pet-friendly') !== false) {
			echo "<span class='iconItem'><img src='". esc_url( get_template_directory_uri() )  ."/images/pet-friendly.png' alt='pet friendly'/></span>";
		}
	
		if (in_array("air-conditioning", $final_attributes)){
		//if (strpos($singleAttributes, 'air-conditioning') !== false) {
			echo "<span class='iconItem'><img src='". esc_url( get_template_directory_uri() )  ."/images/air-conditioning.png' alt='air conditioning'/></span>";
		}	
		 
		if (in_array("swimming-pool", $final_attributes)){ 
		//if (strpos($singleAttributes, 'swimming-pool') !== false) {
			echo "<span class='iconItem'><img src='". esc_url( get_template_directory_uri() )  ."/images/swimming-pool.png' alt='swimming pool'/></span>";
		}		
	//	}
	?>
		</div>
	</div>
    <?php if(sizeof($final_result1['Description']) > 0 && $final_result1['Description'] != ""){ ?>
	<p><?php echo $final_result1['Description']; ?></p>  
   
    <?php } ?>
</div>
<!-- #content -->

<aside id="sidebar" class="sidebar">
	<div class="sidebar-content">
		<section id="search-2" class="widget widget_search"> 
			<!-- Material form contact -->
			<div class="card">
				<h5 class="card-header info-color white-text text-center py-4"> <strong>Book Now</strong> </h5>
				
				<!--Card content-->
				<div class="card-body bookingForm pt-0"> 
					
					<!-- Form -->
					<form action="<?php echo site_url(); ?>/payment" class="text-center" method='POST' id="makePaymentForm" style="color: #757575;">
						<input type="hidden" id="id" name="id" value="<?php echo $_GET['id']; ?>" />
                        <?php if($finalDeposit > 0) { ?>
						<input type="hidden" id="price" name="price" value="<?php echo $finalDeposit; ?>" />
                        <?php } else { ?>
                        <input type="hidden" id="price" name="price" value="<?php echo $finalPrice; ?>" />
                        <?php } ?>
						<input type="hidden" id="Ad" name="Ad" value="<?php echo $_GET['Ad']; ?>" />
						
						<input type="hidden" id="chargeId" name="chargeId" value="<?php echo $chargeId; ?>" />
						
						<input type="hidden" id="C" name="C" value="<?php echo $_GET['C']; ?>" />
						<input type="hidden" id="A" name="A" value="<?php echo $start; ?>" />
						<input type="hidden" id="D" name="D" value="<?php echo $end; ?>" />
						<div class="md-form mt-3">
							<input type="text" id="start" name="start" class="form-control" value="<?php echo $start; ?>" placeholder="	Start Date*" disabled />
						</div>
						<div class="md-form mt-3">
							<input type="text" id="end" name="end" class="form-control" value="<?php echo $end; ?>" placeholder="End Date*" disabled />
						</div>
						
						<!-- Name -->
						<div class="md-form mt-3">
							<input type="text" id="fname" name="fname" class="form-control" placeholder="First Name*"   required />
						</div>
						<!-- Name -->
						<div class="md-form mt-3">
							<input type="text" id="lname" name="lname" class="form-control" placeholder="Last Name*"   required />
						</div>
						
						<!-- E-mail -->
						<div class="md-form mt-3">
							<input type="email" id="email" name="email" class="form-control" placeholder="Email*" required />
						</div>
						<div class="md-form mt-3">
							<input type="text" id="phone" name="phone" class="form-control" placeholder="Contact Number*" required />
						</div>
						<div class="md-form full mt-3">
							<input type="text" id="address" name="address" class="form-control" placeholder="Address*" required />
						</div>
                        
						<div class="md-form mt-3">
							<input type="text" id="city" name="city" class="form-control" placeholder="Town/City*" required />
						</div>
						<div class="md-form mt-3">
							<input type="text" id="PostCode" name="PostCode" class="form-control" placeholder="PostCode*" required />
						</div>
						
                        <div class="md-form full mt-3">
							<select id="country" name="country" class="form-control" required>
									<option value="Afghanistan" title="Afghanistan">Afghanistan</option>
									<option value="Åland Islands" title="Åland Islands">Åland Islands</option>
									<option value="Albania" title="Albania">Albania</option>
									<option value="Algeria" title="Algeria">Algeria</option>
									<option value="American Samoa" title="American Samoa">American Samoa</option>
									<option value="Andorra" title="Andorra">Andorra</option>
									<option value="Angola" title="Angola">Angola</option>
									<option value="Anguilla" title="Anguilla">Anguilla</option>
									<option value="Antarctica" title="Antarctica">Antarctica</option>
									<option value="Antigua and Barbuda" title="Antigua and Barbuda">Antigua and Barbuda</option>
									<option value="Argentina" title="Argentina">Argentina</option>
									<option value="Armenia" title="Armenia">Armenia</option>
									<option value="Aruba" title="Aruba">Aruba</option>
									<option value="Australia" title="Australia" selected>Australia</option>
									<option value="Austria" title="Austria">Austria</option>
									<option value="Azerbaijan" title="Azerbaijan">Azerbaijan</option>
									<option value="Bahamas" title="Bahamas">Bahamas</option>
									<option value="Bahrain" title="Bahrain">Bahrain</option>
									<option value="Bangladesh" title="Bangladesh">Bangladesh</option>
									<option value="Barbados" title="Barbados">Barbados</option>
									<option value="Belarus" title="Belarus">Belarus</option>
									<option value="Belgium" title="Belgium">Belgium</option>
									<option value="Belize" title="Belize">Belize</option>
									<option value="Benin" title="Benin">Benin</option>
									<option value="Bermuda" title="Bermuda">Bermuda</option>
									<option value="Bhutan" title="Bhutan">Bhutan</option>
									<option value="Bolivia, Plurinational State of" title="Bolivia, Plurinational State of">Bolivia, Plurinational State of</option>
									<option value="Bonaire, Sint Eustatius and Saba" title="Bonaire, Sint Eustatius and Saba">Bonaire, Sint Eustatius and Saba</option>
									<option value="Bosnia and Herzegovina" title="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
									<option value="Botswana" title="Botswana">Botswana</option>
									<option value="Bouvet Island" title="Bouvet Island">Bouvet Island</option>
									<option value="Brazil" title="Brazil">Brazil</option>
									<option value="British Indian Ocean Territory" title="British Indian Ocean Territory">British Indian Ocean Territory</option>
									<option value="Brunei Darussalam" title="Brunei Darussalam">Brunei Darussalam</option>
									<option value="Bulgaria" title="Bulgaria">Bulgaria</option>
									<option value="Burkina Faso" title="Burkina Faso">Burkina Faso</option>
									<option value="Burundi" title="Burundi">Burundi</option>
									<option value="Cambodia" title="Cambodia">Cambodia</option>
									<option value="Cameroon" title="Cameroon">Cameroon</option>
									<option value="Canada" title="Canada">Canada</option>
									<option value="Cape Verde" title="Cape Verde">Cape Verde</option>
									<option value="Cayman Islands" title="Cayman Islands">Cayman Islands</option>
									<option value="Central African Republic" title="Central African Republic">Central African Republic</option>
									<option value="Chad" title="Chad">Chad</option>
									<option value="Chile" title="Chile">Chile</option>
									<option value="China" title="China">China</option>
									<option value="Christmas Island" title="Christmas Island">Christmas Island</option>
									<option value="Cocos (Keeling) Islands" title="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option>
									<option value="Colombia" title="Colombia">Colombia</option>
									<option value="Comoros" title="Comoros">Comoros</option>
									<option value="Congo" title="Congo">Congo</option>
									<option value="Congo, the Democratic Republic of the" title="Congo, the Democratic Republic of the">Congo, the Democratic Republic of the</option>
									<option value="Cook Islands" title="Cook Islands">Cook Islands</option>
									<option value="Costa Rica" title="Costa Rica">Costa Rica</option>
									<option value="Côte d'Ivoire" title="Côte d'Ivoire">Côte d'Ivoire</option>
									<option value="Croatia" title="Croatia">Croatia</option>
									<option value="Cuba" title="Cuba">Cuba</option>
									<option value="Curaçao" title="Curaçao">Curaçao</option>
									<option value="Cyprus" title="Cyprus">Cyprus</option>
									<option value="Czech Republic" title="Czech Republic">Czech Republic</option>
									<option value="Denmark" title="Denmark">Denmark</option>
									<option value="Djibouti" title="Djibouti">Djibouti</option>
									<option value="Dominica" title="Dominica">Dominica</option>
									<option value="Dominican Republic" title="Dominican Republic">Dominican Republic</option>
									<option value="Ecuador" title="Ecuador">Ecuador</option>
									<option value="Egypt" title="Egypt">Egypt</option>
									<option value="El Salvador" title="El Salvador">El Salvador</option>
									<option value="Equatorial Guinea" title="Equatorial Guinea">Equatorial Guinea</option>
									<option value="Eritrea" title="Eritrea">Eritrea</option>
									<option value="Estonia" title="Estonia">Estonia</option>
									<option value="Ethiopia" title="Ethiopia">Ethiopia</option>
									<option value="Falkland Islands (Malvinas)" title="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option>
									<option value="Faroe Islands" title="Faroe Islands">Faroe Islands</option>
									<option value="Fiji" title="Fiji">Fiji</option>
									<option value="Finland" title="Finland">Finland</option>
									<option value="France" title="France">France</option>
									<option value="French Guiana" title="French Guiana">French Guiana</option>
									<option value="French Polynesia" title="French Polynesia">French Polynesia</option>
									<option value="French Southern Territories" title="French Southern Territories">French Southern Territories</option>
									<option value="Gabon" title="Gabon">Gabon</option>
									<option value="Gambia" title="Gambia">Gambia</option>
									<option value="Georgia" title="Georgia">Georgia</option>
									<option value="Germany" title="Germany">Germany</option>
									<option value="Ghana" title="Ghana">Ghana</option>
									<option value="Gibraltar" title="Gibraltar">Gibraltar</option>
									<option value="Greece" title="Greece">Greece</option>
									<option value="Greenland" title="Greenland">Greenland</option>
									<option value="Grenada" title="Grenada">Grenada</option>
									<option value="Guadeloupe" title="Guadeloupe">Guadeloupe</option>
									<option value="Guam" title="Guam">Guam</option>
									<option value="Guatemala" title="Guatemala">Guatemala</option>
									<option value="Guernsey" title="Guernsey">Guernsey</option>
									<option value="Guinea" title="Guinea">Guinea</option>
									<option value="Guinea-Bissau" title="Guinea-Bissau">Guinea-Bissau</option>
									<option value="Guyana" title="Guyana">Guyana</option>
									<option value="Haiti" title="Haiti">Haiti</option>
									<option value="Heard Island and McDonald Islands" title="Heard Island and McDonald Islands">Heard Island and McDonald Islands</option>
									<option value="Holy See (Vatican City State)" title="Holy See (Vatican City State)">Holy See (Vatican City State)</option>
									<option value="Honduras" title="Honduras">Honduras</option>
									<option value="Hong Kong" title="Hong Kong">Hong Kong</option>
									<option value="Hungary" title="Hungary">Hungary</option>
									<option value="Iceland" title="Iceland">Iceland</option>
									<option value="India" title="India">India</option>
									<option value="Indonesia" title="Indonesia">Indonesia</option>
									<option value="Iran, Islamic Republic of" title="Iran, Islamic Republic of">Iran, Islamic Republic of</option>
									<option value="Iraq" title="Iraq">Iraq</option>
									<option value="Ireland" title="Ireland">Ireland</option>
									<option value="Isle of Man" title="Isle of Man">Isle of Man</option>
									<option value="Israel" title="Israel">Israel</option>
									<option value="Italy" title="Italy">Italy</option>
									<option value="Jamaica" title="Jamaica">Jamaica</option>
									<option value="Japan" title="Japan">Japan</option>
									<option value="Jersey" title="Jersey">Jersey</option>
									<option value="Jordan" title="Jordan">Jordan</option>
									<option value="Kazakhstan" title="Kazakhstan">Kazakhstan</option>
									<option value="Kenya" title="Kenya">Kenya</option>
									<option value="Kiribati" title="Kiribati">Kiribati</option>
									<option value="Korea, Democratic People's Republic of" title="Korea, Democratic People's Republic of">Korea, Democratic People's Republic of</option>
									<option value="Korea, Republic of" title="Korea, Republic of">Korea, Republic of</option>
									<option value="Kuwait" title="Kuwait">Kuwait</option>
									<option value="Kyrgyzstan" title="Kyrgyzstan">Kyrgyzstan</option>
									<option value="Lao People's Democratic Republic" title="Lao People's Democratic Republic">Lao People's Democratic Republic</option>
									<option value="Latvia" title="Latvia">Latvia</option>
									<option value="Lebanon" title="Lebanon">Lebanon</option>
									<option value="Lesotho" title="Lesotho">Lesotho</option>
									<option value="Liberia" title="Liberia">Liberia</option>
									<option value="Libya" title="Libya">Libya</option>
									<option value="Liechtenstein" title="Liechtenstein">Liechtenstein</option>
									<option value="Lithuania" title="Lithuania">Lithuania</option>
									<option value="Luxembourg" title="Luxembourg">Luxembourg</option>
									<option value="Macao" title="Macao">Macao</option>
									<option value="Macedonia, the former Yugoslav Republic of" title="Macedonia, the former Yugoslav Republic of">Macedonia, the former Yugoslav Republic of</option>
									<option value="Madagascar" title="Madagascar">Madagascar</option>
									<option value="Malawi" title="Malawi">Malawi</option>
									<option value="Malaysia" title="Malaysia">Malaysia</option>
									<option value="Maldives" title="Maldives">Maldives</option>
									<option value="Mali" title="Mali">Mali</option>
									<option value="Malta" title="Malta">Malta</option>
									<option value="Marshall Islands" title="Marshall Islands">Marshall Islands</option>
									<option value="Martinique" title="Martinique">Martinique</option>
									<option value="Mauritania" title="Mauritania">Mauritania</option>
									<option value="Mauritius" title="Mauritius">Mauritius</option>
									<option value="Mayotte" title="Mayotte">Mayotte</option>
									<option value="Mexico" title="Mexico">Mexico</option>
									<option value="Micronesia, Federated States of" title="Micronesia, Federated States of">Micronesia, Federated States of</option>
									<option value="Moldova, Republic of" title="Moldova, Republic of">Moldova, Republic of</option>
									<option value="Monaco" title="Monaco">Monaco</option>
									<option value="Mongolia" title="Mongolia">Mongolia</option>
									<option value="Montenegro" title="Montenegro">Montenegro</option>
									<option value="Montserrat" title="Montserrat">Montserrat</option>
									<option value="Morocco" title="Morocco">Morocco</option>
									<option value="Mozambique" title="Mozambique">Mozambique</option>
									<option value="Myanmar" title="Myanmar">Myanmar</option>
									<option value="Namibia" title="Namibia">Namibia</option>
									<option value="Nauru" title="Nauru">Nauru</option>
									<option value="Nepal" title="Nepal">Nepal</option>
									<option value="Netherlands" title="Netherlands">Netherlands</option>
									<option value="New Caledonia" title="New Caledonia">New Caledonia</option>
									<option value="New Zealand" title="New Zealand">New Zealand</option>
									<option value="Nicaragua" title="Nicaragua">Nicaragua</option>
									<option value="Niger" title="Niger">Niger</option>
									<option value="Nigeria" title="Nigeria">Nigeria</option>
									<option value="Niue" title="Niue">Niue</option>
									<option value="Norfolk Island" title="Norfolk Island">Norfolk Island</option>
									<option value="Northern Mariana Islands" title="Northern Mariana Islands">Northern Mariana Islands</option>
									<option value="Norway" title="Norway">Norway</option>
									<option value="Oman" title="Oman">Oman</option>
									<option value="Pakistan" title="Pakistan">Pakistan</option>
									<option value="Palau" title="Palau">Palau</option>
									<option value="Palestinian Territory, Occupied" title="Palestinian Territory, Occupied">Palestinian Territory, Occupied</option>
									<option value="Panama" title="Panama">Panama</option>
									<option value="Papua New Guinea" title="Papua New Guinea">Papua New Guinea</option>
									<option value="Paraguay" title="Paraguay">Paraguay</option>
									<option value="Peru" title="Peru">Peru</option>
									<option value="Philippines" title="Philippines">Philippines</option>
									<option value="Pitcairn" title="Pitcairn">Pitcairn</option>
									<option value="Poland" title="Poland">Poland</option>
									<option value="Portugal" title="Portugal">Portugal</option>
									<option value="Puerto Rico" title="Puerto Rico">Puerto Rico</option>
									<option value="Qatar" title="Qatar">Qatar</option>
									<option value="Réunion" title="Réunion">Réunion</option>
									<option value="Romania" title="Romania">Romania</option>
									<option value="Russian Federation" title="Russian Federation">Russian Federation</option>
									<option value="Rwanda" title="Rwanda">Rwanda</option>
									<option value="Saint Barthélemy" title="Saint Barthélemy">Saint Barthélemy</option>
									<option value="Saint Helena, Ascension and Tristan da Cunha" title="Saint Helena, Ascension and Tristan da Cunha">Saint Helena, Ascension and Tristan da Cunha</option>
									<option value="Saint Kitts and Nevis" title="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
									<option value="Saint Lucia" title="Saint Lucia">Saint Lucia</option>
									<option value="Saint Martin (French part)" title="Saint Martin (French part)">Saint Martin (French part)</option>
									<option value="Saint Pierre and Miquelon" title="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>
									<option value="Saint Vincent and the Grenadines" title="Saint Vincent and the Grenadines">Saint Vincent and the Grenadines</option>
									<option value="Samoa" title="Samoa">Samoa</option>
									<option value="San Marino" title="San Marino">San Marino</option>
									<option value="Sao Tome and Principe" title="Sao Tome and Principe">Sao Tome and Principe</option>
									<option value="Saudi Arabia" title="Saudi Arabia">Saudi Arabia</option>
									<option value="Senegal" title="Senegal">Senegal</option>
									<option value="Serbia" title="Serbia">Serbia</option>
									<option value="Seychelles" title="Seychelles">Seychelles</option>
									<option value="Sierra Leone" title="Sierra Leone">Sierra Leone</option>
									<option value="Singapore" title="Singapore">Singapore</option>
									<option value="Sint Maarten (Dutch part)" title="Sint Maarten (Dutch part)">Sint Maarten (Dutch part)</option>
									<option value="Slovakia" title="Slovakia">Slovakia</option>
									<option value="Slovenia" title="Slovenia">Slovenia</option>
									<option value="Solomon Islands" title="Solomon Islands">Solomon Islands</option>
									<option value="Somalia" title="Somalia">Somalia</option>
									<option value="South Africa" title="South Africa">South Africa</option>
									<option value="South Georgia and the South Sandwich Islands" title="South Georgia and the South Sandwich Islands">South Georgia and the South Sandwich Islands</option>
									<option value="South Sudan" title="South Sudan">South Sudan</option>
									<option value="Spain" title="Spain">Spain</option>
									<option value="Sri Lanka" title="Sri Lanka">Sri Lanka</option>
									<option value="Sudan" title="Sudan">Sudan</option>
									<option value="Suriname" title="Suriname">Suriname</option>
									<option value="Svalbard and Jan Mayen" title="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option>
									<option value="Swaziland" title="Swaziland">Swaziland</option>
									<option value="Sweden" title="Sweden">Sweden</option>
									<option value="Switzerland" title="Switzerland">Switzerland</option>
									<option value="Syrian Arab Republic" title="Syrian Arab Republic">Syrian Arab Republic</option>
									<option value="Taiwan, Province of China" title="Taiwan, Province of China">Taiwan, Province of China</option>
									<option value="Tajikistan" title="Tajikistan">Tajikistan</option>
									<option value="Tanzania, United Republic of" title="Tanzania, United Republic of">Tanzania, United Republic of</option>
									<option value="Thailand" title="Thailand">Thailand</option>
									<option value="Timor-Leste" title="Timor-Leste">Timor-Leste</option>
									<option value="Togo" title="Togo">Togo</option>
									<option value="Tokelau" title="Tokelau">Tokelau</option>
									<option value="Tonga" title="Tonga">Tonga</option>
									<option value="Trinidad and Tobago" title="Trinidad and Tobago">Trinidad and Tobago</option>
									<option value="Tunisia" title="Tunisia">Tunisia</option>
									<option value="Turkey" title="Turkey">Turkey</option>
									<option value="Turkmenistan" title="Turkmenistan">Turkmenistan</option>
									<option value="Turks and Caicos Islands" title="Turks and Caicos Islands">Turks and Caicos Islands</option>
									<option value="Tuvalu" title="Tuvalu">Tuvalu</option>
									<option value="Uganda" title="Uganda">Uganda</option>
									<option value="Ukraine" title="Ukraine">Ukraine</option>
									<option value="United Arab Emirates" title="United Arab Emirates">United Arab Emirates</option>
									<option value="United Kingdom" title="United Kingdom">United Kingdom</option>
									<option value="United States" title="United States">United States</option>
									<option value="United States Minor Outlying Islands" title="United States Minor Outlying Islands">United States Minor Outlying Islands</option>
									<option value="Uruguay" title="Uruguay">Uruguay</option>
									<option value="Uzbekistan" title="Uzbekistan">Uzbekistan</option>
									<option value="Vanuatu" title="Vanuatu">Vanuatu</option>
									<option value="Venezuela, Bolivarian Republic of" title="Venezuela, Bolivarian Republic of">Venezuela, Bolivarian Republic of</option>
									<option value="Viet Nam" title="Viet Nam">Viet Nam</option>
									<option value="Virgin Islands, British" title="Virgin Islands, British">Virgin Islands, British</option>
									<option value="Virgin Islands, U.S." title="Virgin Islands, U.S.">Virgin Islands, U.S.</option>
									<option value="Wallis and Futuna" title="Wallis and Futuna">Wallis and Futuna</option>
									<option value="Western Sahara" title="Western Sahara">Western Sahara</option>
									<option value="Yemen" title="Yemen">Yemen</option>
									<option value="Zambia" title="Zambia">Zambia</option>
									<option value="Zimbabwe" title="Zimbabwe">Zimbabwe</option>
								</select>
						</div>
						<!-- Add payment fields and dates fields here -->
						
						<div class="md-form full mt-3">
							<input type="text" class="form-control" id="holdername" name="holdername" placeholder="Holder Name"  required />
						</div>
						
						<div class="md-form full mt-3">
								<select name="cardtype" id="cardtype" required class="form-control">
									<option value="Visa" selected="selected">Visa</option>
									<option value="MasterCard">MasterCard</option>
									<option value="Discover">Discover</option>
									<option value="Amex">American Express</option>
								</select>
						</div>
						
						<div class="md-form full mt-3">
							<input type="text" class="form-control" id="cardNumber" name="cardNumber" placeholder="Valid Card Number" autocomplete="cc-number" required />
						</div>
						<div class="md-form mt-3">
							<input type="text" class="form-control" id="cardExpiry" name="cardExpiry" placeholder="Expiry MM / YY" autocomplete="cc-exp" required />
						</div>
						<div class="md-form mt-3">
							<input type="text" class="form-control" id="cvv" name="cvv" placeholder="CVV" autocomplete="cc-exp" required />
						</div>
						<div class="md-form full mt-3">
							<span style="color:red"><?php echo $_SESSION['result']; ?></span>
						</div>
						<!-- Send button -->
						<div class="md-form full">
							<button class="btn btn-outline-info btn-rounded btn-block z-depth-0 my-4 waves-effect" type="submit">Book Now</button>
						</div>
					</form>
					<!-- Form --> 
					
				</div>
			</div>
			<!-- Material form contact --> 
		</section>
		<section id="recent-posts-2" class="widget widget_recent_entries">
			            
         <iframe src="https://maps.google.com/maps?q=<?php echo $lat; ?>, <?php echo $lon; ?>&amp;z=15&amp;output=embed" width="360" height="270" frameborder="0" style="border:0"></iframe>   
		</section>
	</div>
</aside>

<?php
$_SESSION['request_data']="";
$_SESSION['result']="";

 get_footer(); ?>
