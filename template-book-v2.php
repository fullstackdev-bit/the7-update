<?php
/* Template Name: Booking-v2 */

/**
 * Media Albums template. Uses dt_gallery post type and dt_gallery_category taxonomy.
 *
 * @package The7
 * @since 1.0.0
 */
session_start();
get_header('api');

// echo "<pre>";
	// print_r($_SESSION);
// echo "</pre>"; 

if( sizeof($_SESSION['bookingDetail'])==0){
	
	header("location:".site_url()."");
	exit(); 
}


$p_name=strtolower($_SESSION['bookingDetail']['name']);
$p_name = preg_replace('/\s+/', '-', $p_name);

?> 

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<style>
/* Make the image fully responsive */
.carousel-inner img { width: 100%; height: 100%; }
.custom-tick input#accept {
    float: left;
}
.custom-tick p {
    float: left;
    padding: 8px 0px 0px 15px;
}

</style>

<div class="page-title title-center solid-bg breadcrumbs-mobile-off page-title-responsive-enabled">
			<div class="wf-wrap">
			<div class="page-title-head hgroup">
			    <h1><?php echo $_SESSION['bookingDetail']['name']; ?></h1></div>
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



<?php
	
	//foreach($_SESSION['bookingDetail']['images'] as $singleImage){
			//echo $singleImage;
		//}
	
?>





<div class="bookingPage">
<div id="demo" class="carousel slide" data-ride="carousel"> 
		<!-- Indicators -->
		<ul class="carousel-indicators">
			<?php $td1=0; foreach($_SESSION['bookingDetail']['images'] as $singleImage){ ?>
			<li data-target="#demo" data-slide-to="<?php echo $td1; ?>" class="<?php if($td1==0){ echo 'active';} ?>"></li>
			<?php $td1++; } ?>
		</ul>
		<!-- The slideshow -->
		<div class="carousel-inner">
			<?php $td=1; foreach($_SESSION['bookingDetail']['images'] as $singleImage){ ?>
			<div class="carousel-item <?php if($td==1){ echo 'active';} ?>"> <img src="<?php  echo $singleImage; ?>" alt="" width="1100" height="500"> </div>
			<?php $td++; } ?>
		</div>
		<!-- Left and right controls --> 
		<a class="carousel-control-prev" href="#demo" data-slide="prev"> <span class="carousel-control-prev-icon"></span> </a> <a class="carousel-control-next" href="#demo" data-slide="next"> <span class="carousel-control-next-icon"></span> </a> </div>

	<div class="bookingDetails">
		<h4>Booking Details</h4>
		<table class="table">
			<thead>
				<tr>
					<th>Property Name</th>
					<th>Arrival</th>
					<th>Departure</th>
					<th>Number of Night(s)</th>
					<th>Adult(s)</th>
					<th>Children</th>
					<th>Total Cost</th>
					<th>Payment Required</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td data-title="Property Name"><?php echo $_SESSION['bookingDetail']['name']; ?></td>
					<td data-title="Arrival"><?php echo date('d-m-Y',strtotime( $_SESSION['bookingDetail']['A'])); ?></td>
					<td data-title="Departure"><?php echo date('d-m-Y',strtotime($_SESSION['bookingDetail']['D'])); ?></td>
					<td data-title="Noofnights"><?php echo $nights = (strtotime($_SESSION['bookingDetail']['D']) - strtotime($_SESSION['bookingDetail']['A'])) / 86400; ?></td>
					<td data-title="Adult(s)"><?php echo $_SESSION['bookingDetail']['Ad']; ?></td>
					<td data-title="Children"><?php echo $_SESSION['bookingDetail']['C']; ?></td>
					<td data-title="Price"><span id="totalPrice-dtl"><?php echo $_SESSION['bookingDetail']['TotalPrice'];?></span> AUD</td>
					<td data-title="Price"><span id="totalDeposite-dtl"><?php echo $_SESSION['bookingDetail']['TotalDeposit'];?></span> AUD</td>  

				</tr>
			</tbody>
		</table>
	</div> 
	<?php if(!empty($_SESSION['bookingDetail']['requirements'] )){	?>
	<div class="bookingDetails">
		<h4>Additional</h4>
		<table class="table table-bordered">
		<thead>
		  <tr>
			<th>Description</th>
			<th>Unit</th>
			<th>Quantity</th>
			<th>Amount</th>
		  </tr>
		</thead>
		<!-- Form --> 
		<form action="<?php echo site_url(); ?>/payment/<?php echo $p_name; ?>" class="text-center" method='POST' id="makePaymentForm" style="color: #757575;">
		
		<tbody>
		<?php foreach($_SESSION['bookingDetail']['requirements'] as $singleItem) {
			
			// echo "<pre>";
			// print_r($singleItem);
			// echo "</pre>";
			
			$fullDescription="";
			$fullDescription=$singleItem['Name'];
			
			if(!empty($singleItem['Note'])){
				$fullDescription=$fullDescription." - ".$singleItem['Note'];
			}

		?>
		  <tr>
			<td><?php echo $fullDescription; ?></td>
			<td><?php echo $singleItem['Amount']; ?></td>
			<td>
			<input type="number" name="record[<?php echo $singleItem['Id'] ?>]" id="deep record_<?php echo $singleItem['Id']; ?>" data-amount="<?php echo $singleItem['Amount']; ?>" class="refInputClass" data-refId="<?php echo $singleItem['Id'];?>"  min='0' max='10' value="0" />
			<input type="hidden" name="additionalPrice[<?php echo $singleItem['Id'] ?>]" value="<?php echo $singleItem['Amount']; ?>" />
			<input type="hidden" name="additionalName[<?php echo $singleItem['Id'] ?>]" value="<?php echo $singleItem['Name']; ?>" />
			<input type="hidden" name="additionalSundry[<?php echo $singleItem['Id'] ?>]" value="<?php echo $singleItem['Sundry_Id']; ?>" />
			</td>
            <?php ?>
			<td><span class="amountDetail" id="amount_<?php echo $singleItem['Id']; ?>">0.00</span></td>
		  </tr>
		<?php } ?>  
		</tbody>
		</table>
	</div>
	
	<?php } ?>
	<div class="checkoutForm">
		<h4>Guest Details</h4>
		<!--Card content-->
		<div class="card-body bookingForm"> 
			
			
				
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
				<div class="md-form mt-3">
					<input type="text" id="address" name="address" class="form-control" placeholder="Address*" required />
				</div>
				<div class="md-form mt-3">
					<input type="text" id="city" name="city" class="form-control" placeholder="Town/City*" required />
				</div>
				<div class="md-form mt-3">
					<input type="text" id="PostCode" name="PostCode" class="form-control" placeholder="PostCode*" required />
				</div>
				<div class="md-form mt-3">
					<select id="country" name="country" class="form-control" required>
						<option value="" title="Select Country" selected>Select Country</option>
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
						<option value="Australia" title="Australia">Australia</option>
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
				
				<?php if($_SESSION['bookingDetail']['pet']==1){ ?>
				<div class="md-form mt-6">
					<select id="Pets" name="Pets" class="form-control" >
						<option value="">Number Of Pets</option>
						<option value="1 pet">1</option>
						<option value="2 pets">2</option>
						<option value="3 pets">3</option>
						<option value="4 pets">4</option>
						<option value="5+ pets">5+</option>
					</select>
				</div>
				<?php } ?>
			
				<!--	<input type="hidden" id="BookingSource" name="BookingSource" class="form-control" placeholder="Booking Source"  /> -->
			
				<div class="md-form mt-6">
					<input type="text" id="Note" name="Note" class="form-control" placeholder="Res Note"  />
				</div>
				
				<div class="md-form mt-6">
					<select id="Reason" name="Reason" class="form-control" >
						<option value="">Reason for Visit</option>
						<option value="Corporate">Corporate</option>
						<option value="Education & Training">Education & Training</option>
						<option value="Funeral">Funeral</option>
						<option value="Insurance">Insurance</option>
						<option value="Leisure">Leisure</option>
						<option value="Local Event">Local Event</option>
						<option value="Medical">Medical</option>
						<option value="Owner">Owner</option>
						<option value="Relocation">Relocation</option>
						<option value="Renovation">Renovation</option>
						<option value="Sports">Sports</option>
						<option value="Waiting Settlement">Waiting Settlement</option>
						<option value="Wedding">Wedding</option>
					</select>
				</div>
				<!-- Add payment fields and dates fields here -->
				
		<h4>Payment Details</h4>
				<div class="md-form mt-3">
					<input type="text" class="form-control" id="holdername" name="holdername" placeholder="Card Holder Name"  required />
				</div>
				<div class="md-form mt-3">
					<select name="cardtype" id="cardtype" required class="form-control">
						<option value="" selected="selected">Card Type</option>
						<option value="Visa">Visa</option>
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
				<div class="md-form full mt-3"> <span style="color:red"><?php echo $_SESSION['result']; ?></span> </div>
				
				<div class="custom-tick">
				<input type="checkbox" id="accept" name="accept"  value="true" required /><p>I agree to the <a target="_blank" href="<?php echo site_url(); ?>/terms-conditions/">terms & conditions</a></p> 
				</div>

				
			
				<!-- Send button -->
				<div class="md-form full">
					<button class="btn btn-outline-info btn-rounded btn-block z-depth-0 my-4 waves-effect" type="submit">Book Now</button>
				</div>
				
			</form>
			<!-- Form --> 
			
		</div>
	</div>
</div>
<script>

jQuery(document).ready(function(){
	
	var totalPrice=<?php echo $_SESSION['bookingDetail']['TotalPrice'];?>;
	var totalDeposite=<?php echo $_SESSION['bookingDetail']['TotalDeposit'];?>;
	

	
	// jQuery(".refInputClass").bind('change', function (e) {
	jQuery(".refInputClass").bind('keyup change click', function (e) {
	    
	  if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
	      return false;
	  }else{
		  
		var resData = /^\d*$/.test(jQuery(this).val());
		//console.log(resData);
		var refId=jQuery(this).data("refid");  
		if(resData && (jQuery(this).val()!="" && jQuery(this).val()<=10) ){
		
			//console.log("here i am");
			
			var tPrice=totalPrice;
			var tDeposite=totalDeposite;
			
			var currentQuantity=parseInt(jQuery(this).val());
			var amount=parseInt(jQuery(this).data("amount"));
			var totalAmount=currentQuantity*amount;
			
			jQuery("#amount_"+refId+"").html(totalAmount.toFixed(2));
			
			//console.log(totalPrice);
			//console.log(totalDeposite);
		
			jQuery(".amountDetail").each(function(){
				var sumAdditonal=parseInt(jQuery(this).html());
				tPrice=tPrice+sumAdditonal;
				tDeposite=tDeposite+(sumAdditonal/2);
			});
			jQuery("#totalPrice-dtl").html(tPrice.toFixed(2));
			jQuery("#totalDeposite-dtl").html(tDeposite.toFixed(2)); 
		
		}else{
			
			jQuery(this).val("")
			jQuery("#amount_"+refId+"").html("0.00");
		}
		
    	}
	});
	
	
	
});
</script>

<?php get_footer(); ?>