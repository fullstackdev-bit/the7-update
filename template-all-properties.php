<?php

/* Template Name: All Properties */



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



$url = "https://api2.rms.com.au/rmsxml/rms_api.aspx";



$xml = '<RMSRoomTypeRQ>

	  <AgentId>1</AgentId>

	  <RMSClientId>10774</RMSClientId>

	</RMSRoomTypeRQ>';




get_header();





if ( presscore_is_content_visible() ): ?>

<!-- Content -->
<link rel='stylesheet' id='js_composer_front-css'  href='https://executiveescapes.com.au/wp-content/plugins/js_composer/assets/css/js_composer.min.css?ver=5.5.2' type='text/css' media='all' />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
<style>
.hide {
	display: none !important;
}
.post-entry-content {
	display: inline-block;
	margin-top: -100px;
	width: 75%;
	background-color: #f7f7f7;
	z-index: 99;
	position: relative;
	height: 150px;
	text-align: left;
	padding: 25px 30px 30px 30px;
	overflow: hidden;
}
img.searchlistimg {
	height: 280px!important;
transition : transform .25s ease-out!important;
}
.dt_portfolio {
	text-align: center;
}
.post-thumbnail-wrap:hover img.searchlistimg {
	transform: scale(1.2);
}
.post-thumbnail-wrap {
	height: 280px;
	width: auto;
	position: relative;
}
.dt-css-grid .wf-cell {
	opacity: 1!important;
	max-width : 400px;
	margin-bottom: 20px;
}
label {
	display: block;
	font-weight: 600;
	font-size: 14px;
	color: #555;
}
#rms-booking input[type="text"], #rms-booking input[type="submit"], #rms-booking select {
	width: 100%!important;
	display: block;
	padding: 0.5em;
	background: #f8f8f8;
	border: 1px #bbb solid;
	border-radius: 4px;
	margin-bottom: 10px;
	line-height: 16px !important;
}
.ui-accordion-content-first #rms-booking input[type="submit"] {
	padding: 0.5em !important;
	border-color: #fff;
}
#rms-booking input[type="submit"]:hover {
	background: #00406e;
}
#rms-booking input[type="submit"] {
	background: #3d495e;
	border-color: #0276bd;
	color: #fff;
	font-weight: 600;
	text-transform: uppercase;
	text-align: center !important;
	padding: 1em !important;
	font-size: 18px !important;
	font-family: "Cut the crap" !important;
}
.ui-accordion .ui-accordion-content {
	padding: 1em 0;
	border-top: 0;
	overflow: auto;
	background: #fff;
}
.ui-accordion-header.ui-state-default {
	background: #3d495e;
	color: #fff;
	font-size: 1.25em;
	font-weight: bold;
	padding-left: 2.2em;
	padding: .5em 0;
	font-family: "Cut the crap" !important;
}
</style>

<div id="content" class="content" role="main"> 
	<div class="row">

		 <div class="ui-accordion ui-widget ui-helper-reset" role="tablist">
		  <div class="ui-accordion-header ui-state-default ui-accordion-header-active ui-state-active ui-corner-top ui-accordion-icons" role="tab" id="ui-id-1" aria-controls="ui-id-2" aria-selected="true" aria-expanded="true" tabindex="0" style="float: left;width: 100%;clear: both;">

			<div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom ui-accordion-content-active ui-accordion-content-first" id="ui-id-2" aria-labelledby="ui-id-1" role="tabpanel" aria-hidden="false" style="display: block;float: left;width: 100%;clear: both;">

				<div class="vc_col-sm-12 vc_col-lg-12 vc_col-md-12">

					 <div class="vc_col-sm-3 vc_col-lg-3 vc_col-md-3">

						<label> <span>Property Name</span> </label>

						<span>

						<input type="text" id="property_name" name="property_name" placeholder="Property Name" value=""  />

						</span> </div> 

					<div class="vc_col-sm-9 vc_col-lg-9 vc_col-md-9 checkboxes">

						<div class=" adults">

							<input type="checkbox" class="custom_features" value="1-bedroom"/>

							<label for="petfriendly">1 Bedroom</label>

						</div>

						<div class=" adults">

							<input type="checkbox"  class="custom_features"  value="2-bedroom"/>

							<label for="2-bedroom">2 Bedroom</label>

						</div>

						<div class=" adults">

							<input type="checkbox"  class="custom_features"  value="3-bedroom"/>

							<label for="3-bedroom">3 Bedroom</label>

						</div>
						
						<div class=" adults">

							<input type="checkbox"  class="custom_features"  value="4-bedroom"/>

							<label for="4-bedroom">4 Bedroom</label>

						</div>


						<div class=" adults">

							<input type="checkbox"  class="custom_features"  value="5-bedroom"/>

							<label for="5-bedroom">5 Bedroom</label>

						</div>
                        
						<div class=" adults">

							<input type="checkbox" class="custom_features"  value="1-bathroom"/>

							<label for="1-bathroom">1 Bathroom</label>

						</div>
						
						 <div class=" adults">

							<input type="checkbox" class="custom_features"  value="2-bathroom"/>

							<label for="2-bathroom">2 Bathroom</label>

						</div>

						<div class=" adults">

							<input type="checkbox" class="custom_features"  value="secure-parking" />

							<label for="secure-parking">Secure Parking</label>

						</div> 
						
						<div class=" adults">

							<input type="checkbox" class="custom_features"  value="pet-friendly" />

							<label for="pet-friendly">Pet Friendly</label>

						</div>
						
						<div class=" adults">

							<input type="checkbox" class="custom_features"  value="swimming-pool" />

							<label for="swimming-pool">Swimming Pool</label>

						</div>
						
					</div>

				</div>
				
				</div>
				
			</div>
		</div>		
 
  <div class="dt-css-grid" style="clear:both; grid-gap:10px;grid-template-columns: auto auto auto;">
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

							

						?>
    <h1>No Hotel Found</h1>
    <?php	

						

						}else{

							

						 

							$response=simplexml_load_string($response);

							

							$response = json_decode( json_encode($response) , 1);
							

				

							$final = array();

							

							$final = $response['RoomTypes']['RoomType'];
							
							//echo "max occupancy::". $MaxOccupancy=$final['MaxOccupancy'];
							
							
							foreach($final as $singleRoomPoperty){
								
								$MaxOccupancy=$singleRoomPoperty['MaxOccupancy'];
								$attributes=$singleRoomPoperty['Attributes']['Attribute'];
													
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
													
													$image=$singleRoomPoperty['Images']['Image'][0];
													$allImages=$singleRoomPoperty['Images']['Image'];
													
													foreach($allImages as $Img){
												
														
														array_push($images,$Img);
													}

												?>
    <div class="visible wf-cell vc_col-xs-12 property_attribute" data-search=1 data-name="<?php echo $singleRoomPoperty['Name']; ?>" data-attributes="<?php echo $final_attributes; ?>">
      <article class="post visible dt_portfolio type-dt_portfolio status-publish">
        <div class="post-thumbnail-wrap  ">
          <div class="post-thumbnail"> <a href="<?php echo home_url(); ?>/details/?id=<?php echo $singleRoomPoperty['RoomTypeId'];?>"  class="post-thumbnail-rollover" target="">
            <?php if($image != ""){ ?>
            <img class=" searchlistimg iso-lazy-load preload-me iso-layzr-loaded" src="<?php echo $image; ?>" >
            <?php } else { ?>
            <img class=" searchlistimg iso-lazy-load preload-me iso-layzr-loaded" src="<?php bloginfo('template_url'); ?>/images/No_Image_Available.jpg" >
            <?php } ?>
            </a> </div>
        </div>
        <div class="post-entry-content new">
          <h3 class="entry-title"> <a href="<?php echo home_url(); ?>/details/?id=<?php echo $singleRoomPoperty['RoomTypeId'];?>" target="" title="Woodlands Retreat" rel="bookmark"><?php echo $singleRoomPoperty['Name']; ?></a> </h3>
          <div class="propertyBottom">
            <div class="iconsList">
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
		
		if (in_array("pet-friendly", $final_attributes)){
			echo "<span class='iconItem'><img src='". esc_url( get_template_directory_uri() )  ."/images/pet-friendly.png' alt='pet friendly'/></span>";
		}
	
		if (in_array("internet", $final_attributes)){
			echo "<span class='iconItem'><img src='". esc_url( get_template_directory_uri() )  ."/images/wifi.png' alt='air conditioning'/></span>";
		}	
		 
		if (in_array("swimming-pool", $final_attributes)){ 
			echo "<span class='iconItem'><img src='". esc_url( get_template_directory_uri() )  ."/images/swimming-pool.png' alt='swimming pool'/></span>";
		}	
		
		if($MaxOccupancy>1 && $MaxOccupancy<=10){
			echo "<span class='iconItem'><img src='https://executiveescapes.com.au/wp-content/uploads/2019/02/max-occ-".$MaxOccupancy.".png' alt='".$MaxOccupancy." Occupancy'/></span>";
		}
	?>
            </div>
            <a class="btn btn-outline-info btn-rounded z-depth-0 waves-effect" href="<?php echo home_url(); ?>/details/?id=<?php echo $singleRoomPoperty['RoomTypeId'];?>"  target="">Book Now</a></div>
        </div>
      </article>
    </div>
    <?php 

												

				

									}   

					}

						?>
  </div>
</div>

<!-- #content -->

</div>
<?php do_action('presscore_after_content');



endif; // if content visible



get_footer(); ?>
