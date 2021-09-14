<?php

/* Template Name: Search - list3 */



/**

 * Blog list template.

 *

 * @package The7

 * @since 1.0.0

 */



// File Security Check

if ( ! defined( 'ABSPATH' ) ) {

	exit;

}

$config = presscore_config();

$config->set( 'template', 'blog' );

$config->set( 'template.layout.type', 'list' );



// add content controller

add_action( 'presscore_before_main_container', 'presscore_page_content_controller', 15 );



$arrival="";

$departure="";

$adults=1;

$children="";

$infants="";



if(isset($_GET['A'])  && $_GET['A']!=""){

	$arrival=trim($_GET['A']);

}



if(isset($_GET['D'])  && $_GET['D']!=""){

	$departure=trim($_GET['D']);

}



if(isset($_GET['Ad'])  && $_GET['Ad']!=""){

	$adults=trim($_GET['Ad']);

}



if(isset($_GET['C'])  && $_GET['C']!=""){

	$children=trim($_GET['C']);

}



// if(isset($_GET['I'])  && $_GET['I']!=""){

	// $infants=trim($_GET['I']);

// }















$url = "https://api2.rms.com.au/rmsxml/rms_api.aspx";





// print_r($_GET);



if($_GET['A']!="" && $_GET['D']!="" ){

	

$xml ='<RMSAvailRateChartRQ>

  <AgentId>1</AgentId>

  <RMSClientId>10774</RMSClientId>

  <Start>'.$_GET['A'].'</Start>

  <End>'.$_GET['D'].'</End>

  <Adults>'.$_GET['Ad'].'</Adults>';

  

  if($_GET['C']!=""){

	  $xml.='  <Children>'.$_GET['C'].'</Children>';

  }

  

  // if($_GET['I']!=""){

	   // $xml.='<Infants>'.$_GET['I'].'</Infants>';

  // }

  

	$xml.='<ExcludeInvalidRates></ExcludeInvalidRates></RMSAvailRateChartRQ>';



// <RoomTypes>

    // <RoomType RoomTypeId="13">

    // </RoomType>

// </RoomTypes>



	//  <RoomTypes><RoomType><Areas><AreaId>15</AreaId></Areas></RoomType></RoomTypes>

}else{

	

	$xml = '<RMSPropertyRQ>

	  <AgentId>1</AgentId>

	  <RMSClientId>10774</RMSClientId>

	  <ReturnAllProperties>1</ReturnAllProperties>

	</RMSPropertyRQ>';

	

	

}









get_header();





if ( presscore_is_content_visible() ): ?>



<!-- Content -->

<link rel='stylesheet' id='js_composer_front-css'  href='https://executiveescapes.com.au/wp-content/plugins/js_composer/assets/css/js_composer.min.css?ver=5.5.2' type='text/css' media='all' />

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">  


<style>

.hide { display: none !important; }

.post-entry-content { display: inline-block; margin-top: -100px; width: 75%; background-color: #f7f7f7; z-index: 99; position: relative; height: 150px; text-align: left; padding: 25px 30px 30px 30px; overflow: hidden; }

img.searchlistimg { height: 280px!important; transition : transform .25s ease-out!important; }

.dt_portfolio { text-align: center; }

.post-thumbnail-wrap:hover img.searchlistimg { transform: scale(1.2); }

.post-thumbnail-wrap { height: 280px; width: auto; position: relative; }

.dt-css-grid .wf-cell { opacity: 1!important; max-width : 400px; margin-bottom: 20px; }

label { display: block; font-weight: 600; font-size: 14px; color: #555; }

#rms-booking input[type="text"], #rms-booking input[type="submit"], #rms-booking select { width: 100%!important; display: block; padding: 0.5em; background: #f8f8f8; border: 1px #bbb solid; border-radius: 4px; margin-bottom: 10px; line-height: 16px !important; }

.ui-accordion-content-first #rms-booking input[type="submit"] { padding: 0.5em !important; border-color: #fff; }

#rms-booking input[type="submit"]:hover { background: #00406e; }

#rms-booking input[type="submit"] { background: #3d495e; border-color: #0276bd; color: #fff; font-weight: 600; text-transform: uppercase; text-align: center !important; padding: 1em !important; font-size: 18px !important; font-family: "Cut the crap" !important; }

.ui-accordion .ui-accordion-content { padding: 1em 0; border-top: 0; overflow: auto; background: #fff; }

.ui-accordion-header.ui-state-default { background: #3d495e; color: #fff; font-size: 1.25em; font-weight: bold; padding-left: 2.2em; padding: .5em 0; font-family: "Cut the crap" !important; }

</style>



<div id="content" class="content" role="main">

<div class="row">

		<div id="booking" class="ui-accordion ui-widget ui-helper-reset" role="tablist">

			<h3 class="ui-accordion-header ui-state-default ui-accordion-header-active ui-state-active ui-corner-top ui-accordion-icons" role="tab" id="ui-id-1" aria-controls="ui-id-2" aria-selected="true" aria-expanded="true" tabindex="0" style="float: left;width: 100%;clear: both;">

			<div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom ui-accordion-content-active ui-accordion-content-first" id="ui-id-2" aria-labelledby="ui-id-1" role="tabpanel" aria-hidden="false" style="display: block;float: left;width: 100%;clear: both;">

				<form name="rms-booking" id="rms-booking" method="GET" action="https://executiveescapes.com.au/search/" style="float: left;width: 100%;clear: both;">

					<div class="vc_col-sm-10 vc_col-lg-10 vc_col-md-10"> 

						

						<!-- start -->

						

						<div class="vc_col-sm-12 vc_col-lg-3 vc_col-md-3 input arrival">

							<label> <span>Arrival*</span> </label>

							<input class="dateRange arrival-date-nw-1" type="text" name="A" placeholder="Arrival" required  value="<?php echo $arrival; ?>">

						</div>

						<div class="vc_col-sm-12 vc_col-lg-3 vc_col-md-3 input departure">

							<label> <span>Departure*</span> </label>

							<input class="dateRange departure-date-nw-1" type="text" name="D" placeholder="Departure" required  value="<?php echo $departure; ?>">

						</div>

						<!-- end -->

						

						 

							<div class=" adults vc_col-sm-12 vc_col-lg-3 vc_col-md-3">

								<label> <span>Adults(s)</span> </label>

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

							<div class="children vc_col-sm-12 vc_col-lg-3 vc_col-md-3">

								<label> <span>Children</span> </label>

								

								<select name="C" id="C">

									<option value=""></option>

									<option value="1" <?php if($children==1){ echo 'selected'; } ?>>1</option>

									<option value="2" <?php if($children==2){ echo 'selected'; } ?>>2</option>

									<option value="3" <?php if($children==3){ echo 'selected'; } ?>>3</option>

									<option value="4" <?php if($children==4){ echo 'selected'; } ?>>4</option>

									<option value="5" <?php if($children==5){ echo 'selected'; } ?>>5</option>

								</select>

								</div>

							<?php /*

								<div class="children vc_col-sm-12 vc_col-lg-4 vc_col-md-4">

									<label>

										<span>Infants(0-2)</span>

									</label>

									<span class="select-icon">

										<select name="I" id="I">

											<option value=""></option>

											<option value="1" <?php if($infants==1){ echo 'selected'; } ?>>1</option>

											<option value="2" <?php if($infants==2){ echo 'selected'; } ?>>2</option>

											<option value="3" <?php if($infants==3){ echo 'selected'; } ?>>3</option>

											<option value="4" <?php if($infants==4){ echo 'selected'; } ?>>4</option>

											<option value="5" <?php if($infants==5){ echo 'selected'; } ?>>5</option>

										</select>

									</span>

								</div>

								*/

								?>

						 

					</div>

					<div class="vc_col-sm-12 vc_col-lg-2 vc_col-md-2 submit">

						<div class="search-button">

							<label> <span>&nbsp;</span> </label>

							<input name="submit" type="submit" value="Search">

						</div>

					</div>

				</form> 

				<div class="vc_col-sm-12 vc_col-lg-12 vc_col-md-12">

					<div class="vc_col-sm-3 vc_col-lg-3 vc_col-md-3 PropertyInput">

						<label> <span>Property/Location Name</span> </label>

						<span>

						<input type="text" id="property_name" name="property_name" placeholder="Property Name" value=""  />

						</span> </div>

					<div class="vc_col-sm-9 vc_col-lg-9 vc_col-md-9 checkboxes">

						<div class=" adults">

							<input type="checkbox" class="custom_features" value="pet-friendly"/>

							<label for="petfriendly">Pet Friendly</label>

						</div>

						<div class=" adults">

							<input type="checkbox"  class="custom_features"  value="air-conditioning"/>

							<label for="airconditioned">Air Conditioned</label>

						</div>

						<div class=" adults">

							<input type="checkbox"  class="custom_features"  value="internet"/>

							<label for="wifi">Wi-Fi</label>

						</div>

						<div class=" adults">

							<input type="checkbox" class="custom_features"  value="swimming-pool"/>

							<label for="swimmingpool">Swimming Pool</label>

						</div>

						<div class=" adults">

							<input type="checkbox" class="custom_features"  value="secure-parking" />

							<label for="carport">Secure Parking</label>

						</div>

					</div>

				</div>

			</div>

		</div>

	</div>

	<div class="dt-css-grid" style="clear:both; grid-gap:10px;grid-template-columns: auto auto auto;">

		<?php

		

					$start_dt = strtotime($_GET['A']);

					$end_dt = strtotime($_GET['D']);



					$days_between = ceil(abs($end_dt - $start_dt) / 86400);

					

					if($days_between>2){

				

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

							

						?>

		<h1>No Hotel Found</h1>

		<?php	

						

						}else{

							

						 

							$response=simplexml_load_string($response);

							

							$response = json_decode( json_encode($response) , 1);

				

							$final = array();

							

							$final = $response['RoomTypes']['RoomType'];

							

							

							// echo "<pre>";

								// print_r($final);

							// echo "</pre>";

							

							

							

							foreach($final as $singleRoomPoperty){

								

											

								if($singleRoomPoperty['BookingRangeAvailable']=="true"){

									

									if(sizeof($singleRoomPoperty['ChargeTypes'])>0){



									// echo "BookingRangeAvailable====>>>>".$singleRoomPoperty['BookingRangeAvailable'];

							

									  $RoomTypeId=$singleRoomPoperty['RoomTypeId'];   

									

										

										$xml_new = '<RMSRoomTypeRQ>

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



												curl_close($ch1);

												

												if($err_new){

													

													//	die('Something went wrong');

														

												}else{

													

													$response_new=simplexml_load_string($response_new);

							

													$response_new = json_decode( json_encode($response_new) , 1);

															

													

													$final_result = array();

													$final_result = $response_new['RoomTypes']['RoomType'];

													

													

													$attributes=$final_result['Attributes']['Attribute'];

													

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

													

													

													$image=$final_result['Images']['Image'][0];

													

														$extract_attributes=explode(",",$final_attributes);

		

														foreach($extract_attributes as $singleAttributes){

														

																if (strpos($singleAttributes, 'bedroom') !== false) {

															//		echo "<h1>".$singleAttributes."</h1>";

																}

																

																

																if (strpos($singleAttributes, 'bathroom') !== false) {

															//		echo "<h1>".$singleAttributes."</h1>";

																}

															

																if (strpos($singleAttributes, 'pet-friendly') !== false) {

															//		echo "<h1>".$singleAttributes."</h1>";

																}

															

																if (strpos($singleAttributes, 'air-conditioning') !== false) {

															//		echo "<h1>".$singleAttributes."</h1>";

																}	

																

																if (strpos($singleAttributes, 'swimming-pool') !== false) {

															//		echo "<h1>".$singleAttributes."</h1>";

																}		

														}

													

													

													 

												?>

		<div class="visible wf-cell vc_col-xs-12 property_attribute" data-search=1 data-name="<?php echo $final_result['Name']; ?>" data-attributes="<?php echo $final_attributes; ?>">

			<article class="post visible dt_portfolio type-dt_portfolio status-publish">

				<div class="post-thumbnail-wrap  ">

					<div class="post-thumbnail"> <a href="<?php echo home_url(); ?>/details/?id=<?php echo $final_result['RoomTypeId'];?>&A=<?php echo $arrival; ?>&D=<?php echo $departure; ?>&Ad=<?php echo $adults  ?>&C=<?php echo $children; ?>" class="post-thumbnail-rollover" target="">

						<?php if($image != ""){ ?>

						<img class=" searchlistimg iso-lazy-load preload-me iso-layzr-loaded" src="<?php echo $image; ?>" >

						<?php } else { ?>

						<img class=" searchlistimg iso-lazy-load preload-me iso-layzr-loaded" src="<?php bloginfo('template_url'); ?>/images/No_Image_Available.jpg" >

						<?php } ?>

						</a> </div>

				</div>

				<div class="post-entry-content new">

					<h3 class="entry-title"> <a href="<?php echo home_url(); ?>/details/?id=<?php echo $final_result['RoomTypeId'];?>&A=<?php echo $arrival; ?>&D=<?php echo $departure; ?>&Ad=<?php echo $adults  ?>&C=<?php echo $children; ?>" target="" title="Woodlands Retreat" rel="bookmark"><?php echo $final_result['Name']; ?></a> </h3>

					

					<div class="propertyBottom"><div class="iconsList">
                    
<?php 
		//echo $final_attributes ; 
		
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
		
		if (in_array("1-bathroom", $final_attributes)){
			echo "<span class='iconItem'><img src='". esc_url( get_template_directory_uri() )  ."/images/bathroom.png' alt='bathroom'/></span>";
		}
		
		if (in_array("pet-friendly", $final_attributes)){
			echo "<span class='iconItem'><img src='". esc_url( get_template_directory_uri() )  ."/images/pet-friendly.png' alt='pet friendly'/></span>";
		}
	
		if (in_array("air-conditioning", $final_attributes)){
			echo "<span class='iconItem'><img src='". esc_url( get_template_directory_uri() )  ."/images/air-conditioning.png' alt='air conditioning'/></span>";
		}	
		 
		if (in_array("swimming-pool", $final_attributes)){ 
			echo "<span class='iconItem'><img src='". esc_url( get_template_directory_uri() )  ."/images/swimming-pool.png' alt='swimming pool'/></span>";
		}	
	?>

</div>

					

					<a class="btn btn-outline-info btn-rounded z-depth-0 waves-effect" href="<?php echo home_url(); ?>/details/?id=<?php echo $final_result['RoomTypeId'];?>&A=<?php echo $arrival; ?>&D=<?php echo $departure; ?>&Ad=<?php echo $adults  ?>&C=<?php echo $children; ?>"  target="">Book Now</a></div> </div>

			</article>

		</div>

		<?php 

												

													}

													

										}

								}

									

									}

					}}else{

						?>

						<h3 style="color:red;">Atleast 3 days gap required in between arrival and departure date.</h3>

						<?php

					}

						?>

	</div>

</div>

<!-- #content -->

</div>

<?php do_action('presscore_after_content');



endif; // if content visible



get_footer(); ?>

