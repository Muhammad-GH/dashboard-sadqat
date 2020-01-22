<?php
/**
 * Template Name: Charity Form Step 3
 */
?>
<?php 
if(isset($_REQUEST['submit-campaign'])){

	if ( ! function_exists( 'wp_handle_upload' ) ) {
    	require_once( ABSPATH . 'wp-admin/includes/file.php' );
	}
	
	$user_email  = $_REQUEST['user_email'];
	$first_name  = $_REQUEST['first_name'];
	$last_name  = $_REQUEST['last_name'];
	$phone  = $_REQUEST['phone'];
	$birthday  = $_REQUEST['birthday'];
	$passport  = $_REQUEST['passport'];
	$idnumber  = $_REQUEST['idnumber'];
	$upload_passport  = $_REQUEST['upload-passport'];
	$upload_national_id  = $_REQUEST['upload-national-id'];
	$country  = $_REQUEST['country'];
	$address12  = $_REQUEST['address12'];
	$address_22  = $_REQUEST['address_22'];
	$city  = $_REQUEST['city'];
	$state  = $_REQUEST['state'];
	$postcode12  = $_REQUEST['postcode12'];
	$charity_certificate  = $_REQUEST['charity-certificate'];
	$board_of_trustees  = $_REQUEST['board-of-trustees'];
	
	
	$campaign_id  = $_REQUEST['campaign_id'];
	
	$movefile_passport = wp_handle_upload(  $_FILES['upload-passport'], array( 'test_form' => false ) );
	if ( $movefile_passport && ! isset( $movefile_passport['error'] ) ) {
		
		$attachment = array(
			"post_mime_type" => $movefile_passport ["type"],
			"post_title" => addslashes( $_FILES["upload-passport"]["name"] ),
			"post_content" => "",
			"post_status" => "inherit",
			"post_parent" => $campaign_id
		);

		$passport_file_id = wp_insert_attachment( $attachment, $movefile_passport ["file"] );
		require_once( ABSPATH."wp-admin/includes/image.php" );
		$attach_data = wp_generate_attachment_metadata( $passport_file_id, $movefile_passport ["file"] );
		wp_update_attachment_metadata( $passport_file_id, $attach_data );
		
		//echo "File1 is valid, and was successfully uploaded.\n";
		//var_dump( $movefile_passport );
	} else {
		echo $movefile_passport['Error upload-passport'];
	}
	
	//upload-national-id field
	$movefile_passport1 = wp_handle_upload(  $_FILES['upload-national-id'], array( 'test_form' => false ) );
	if ( $movefile_passport1 && ! isset( $movefile_passport1['error'] ) ) {
		
		$attachment = array(
			"post_mime_type" => $movefile_passport1 ["type"],
			"post_title" => addslashes( $_FILES["upload-national-id"]["name"] ),
			"post_content" => "",
			"post_status" => "inherit",
			"post_parent" => $campaign_id
		);

		$passport_file_id1 = wp_insert_attachment( $attachment, $movefile_passport1 ["file"] );
		require_once( ABSPATH."wp-admin/includes/image.php" );
		$attach_data = wp_generate_attachment_metadata( $passport_file_id1, $movefile_passport1 ["file"] );
		wp_update_attachment_metadata( $passport_file_id1, $attach_data );
		
		//echo "File2 is valid, and was successfully uploaded.\n";
		//var_dump( $movefile_passport );
	} else {
		echo $movefile_passport1['Error upload-national-id'];
	}
	
	//charity-certificate field
	$movefile_passport2 = wp_handle_upload(  $_FILES['charity-certificate'], array( 'test_form' => false ) );
	if ( $movefile_passport2 && ! isset( $movefile_passport2['error'] ) ) {
		
		$attachment = array(
			"post_mime_type" => $movefile_passport2 ["type"],
			"post_title" => addslashes( $_FILES["charity-certificate"]["name"] ),
			"post_content" => "",
			"post_status" => "inherit",
			"post_parent" => $campaign_id
		);

		$passport_file_id2 = wp_insert_attachment( $attachment, $movefile_passport2 ["file"] );
		require_once( ABSPATH."wp-admin/includes/image.php" );
		$attach_data = wp_generate_attachment_metadata( $passport_file_id2, $movefile_passport2 ["file"] );
		wp_update_attachment_metadata( $passport_file_id2, $attach_data );
		
		//echo "File2 is valid, and was successfully uploaded.\n";
		//var_dump( $movefile_passport );
	} else {
		echo $movefile_passport2['Error charity-certificate'];
	}
	
	//board-of-trustees field
	$movefile_passport3 = wp_handle_upload(  $_FILES['board-of-trustees'], array( 'test_form' => false ) );
	if ( $movefile_passport3 && ! isset( $movefile_passport3['error'] ) ) {
		
		$attachment = array(
			"post_mime_type" => $movefile_passport3 ["type"],
			"post_title" => addslashes( $_FILES["board-of-trustees"]["name"] ),
			"post_content" => "",
			"post_status" => "inherit",
			"post_parent" => $campaign_id
		);

		$passport_file_id3 = wp_insert_attachment( $attachment, $movefile_passport3 ["file"] );
		require_once( ABSPATH."wp-admin/includes/image.php" );
		$attach_data = wp_generate_attachment_metadata( $passport_file_id3, $movefile_passport3 ["file"] );
		wp_update_attachment_metadata( $passport_file_id3, $attach_data );
		
		//echo "File2 is valid, and was successfully uploaded.\n";
		//var_dump( $movefile_passport );
	} else {
		echo $movefile_passport3['Error charity-certificate'];
	}
	
	update_post_meta( $campaign_id, '_campaign_user_email', $user_email );
	update_post_meta( $campaign_id, '_campaign_first_name', $first_name );
	update_post_meta( $campaign_id, '_campaign_last_name', $last_name );
	update_post_meta( $campaign_id, '_campaign_phone', $phone );
	update_post_meta( $campaign_id, '_campaign_birthday', $birthday );
	update_post_meta( $campaign_id, '_campaign_passport', $passport );
	update_post_meta( $campaign_id, '_campaign_idnumber', $idnumber );
	update_post_meta( $campaign_id, '_campaign_upload-passport', $passport_file_id );
	update_post_meta( $campaign_id, '_campaign_upload-national-id', $passport_file_id1 );
	update_post_meta( $campaign_id, '_campaign_country', $country );
	update_post_meta( $campaign_id, '_campaign_city', $city );
	update_post_meta( $campaign_id, '_campaign_state', $state );
	update_post_meta( $campaign_id, '_campaign_postcode12', $postcode12 );
	update_post_meta( $campaign_id, '_campaign_charity-certificate', $passport_file_id2 );
	update_post_meta( $campaign_id, '_campaign_board-of-trustees', $passport_file_id3 );
	

	$meta = get_post_meta( $campaign_id,'_campaign_submission_data',true );
	
	$meta['user_email'] = $user_email;
	$meta['first_name'] = $first_name;
	$meta['last_name'] = $last_name;
	$meta['phone'] = $phone;
	$meta['birthday'] = $birthday;
	$meta['passport'] = $passport;
	$meta['idnumber'] = $idnumber;
	$meta['upload-passport'] = $passport_file_id;
	$meta['upload-national-id'] = $passport_file_id1;
	$meta['country'] = $country;
	$meta['address12'] = $address12;
	$meta['address_22'] = $address_22;
	$meta['city'] = $city;
	$meta['state'] = $state;
	$meta['postcode12'] = $postcode12;
	$meta['charity-certificate'] = $passport_file_id2;
	$meta['board-of-trustees'] = $passport_file_id3;
	
	
	
	update_post_meta( $campaign_id, '_campaign_submission_data', $meta );
	
	echo '<pre>';
	print_r($meta );
	print_r($array);
	echo '</pre>';
	
	$to = 'fahimku@gmail.com';
	$subject = 'Campaign Registration Step 3 Approved';
	$body .= '<html><head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Saqaqat</title>
    </head>
    <body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0" style="
    background-color: #f6f6f6;
">
        <div style="
    width:100%;
    -webkit-text-size-adjust:none !important;
    margin:0;
    padding: 70px 0 70px 0;
">
        <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
            <tbody><tr>
                <td align="center" valign="top">
                                        <table border="0" cellpadding="0" cellspacing="0" width="520" id="template_container" style="
    box-shadow:0 0 0 1px #f3f3f3 !important;
    border-radius:3px !important;
    background-color: #ffffff;
    border: 1px solid #e9e9e9;
    border-radius:3px !important;
    padding: 20px;
">
                        <tbody><tr>
                            <td align="center" valign="top">
                                <!-- bg -->
                                <table border="0" cellpadding="0" cellspacing="0" width="520" bgcolor="#ffffff">
                                    <tbody><tr>
                                        <td>
                                            <img src="https://staging-gridshub.site/sadaqat-demo/wp-content/uploads/2019/09/sadaqat-_Presentation02.jpg" style="
    width: 600px;" alt="Saqaqat">
                                        </td>
                                    </tr>
                                </tbody></table>
                                <!-- End bg -->
                            </td>
                        </tr>
						<tr>
                            <td align="center" valign="top">
                                <!-- Header -->
                                <table border="0" cellpadding="0" cellspacing="0" width="520" id="template_header" style="
    color: #00000;
    border-top-left-radius:3px !important;
    border-top-right-radius:3px !important;
    border-bottom: 0;
    font-weight:bold;
    line-height:100%;
    text-align: center;
    vertical-align:middle;
" bgcolor="#ffffff">
                                    <tbody><tr>
                                        <td>
                                            <h1 style="
    color: #000000;
    margin:0;
    padding: 28px 24px;
    display:block;
    font-size:32px;
    font-weight: 500;
    line-height: 1.2;
">Campaign Registration Step 3 Approved</h1>
                                        </td>
                                    </tr>
                                </tbody></table>
                                <!-- End Header -->
                            </td>
                        </tr>
                        <tr>
                            <td align="center" valign="top">
                                <!-- Body -->
                                <table border="0" cellpadding="0" cellspacing="0" width="520" id="template_body">
                                    <tbody><tr>
                                        <td valign="top" style="
    border-radius:3px !important;
">
                                            <!-- Content -->
                                            <table border="0" cellpadding="20" cellspacing="0" width="100%">
                                                <tbody><tr>
                                                    <td valign="top">
                                                        <div style="
    color: #000000;
    font-size:14px;
    line-height:150%;
    text-align:left;
">';
		$body .= 'Thank you for submitting your campaign. We will Check your Details';
		$body .= '</div>
														</td>
													</tr>
												</tbody></table>
												<!-- End Content -->
											</td>
										</tr>
									</tbody></table>
									<!-- End Body -->
								</td>
							</tr>
							<tr>
								<td align="center" valign="top">
									<!-- Footer -->
									<table border="0" cellpadding="10" cellspacing="0" width="600" id="template_footer" style="
	border-top:0;
	-webkit-border-radius:3px;
">
										<tbody><tr>
											<td valign="top">
												<table border="0" cellpadding="10" cellspacing="0" width="100%">
													<tbody><tr>
														<!--<td colspan="2" valign="middle" id="credit" style="
	border:0;
	color: #000000;
	font-size:12px;
	line-height:125%;
	text-align:center;
">
															<p><a href="https://staging-gridshub.site/sadaqat-demo">Saqaqat</a></p>
														</td>-->
														<td style="text-align: center;">
												<img src="https://staging-gridshub.site/sadaqat-demo/wp-content/uploads/2019/09/03-e1557741298343.png" style="
    width: 200px;" alt="Saqaqat">
                                        </td>
													</tr>
												</tbody></table>
											</td>
										</tr>
									</tbody></table>
									<!-- End Footer -->
								</td>
							</tr>
						</tbody></table>
					</td>
				</tr>
			</tbody></table>
		</div>
	

</body></html>';
	$headers = array('Content-Type: text/html; charset=UTF-8');
	 
	wp_mail( $to, $subject, $body, $headers );
	
	wp_redirect( 'http://staging-gridshub.site/sadaqat-demo/thank-you/?success=yes' );
}

get_header();
global $borntogive_options;
borntogive_sidebar_position_module();
$pageSidebarGet = get_post_meta(get_the_ID(),'borntogive_select_sidebar_from_list', true);
$pageSidebarStrictNo = get_post_meta(get_the_ID(),'borntogive_strict_no_sidebar', true);
$pageSidebarOpt = $borntogive_options['page_sidebar'];
if($pageSidebarGet != ''){
	$pageSidebar = $pageSidebarGet;
}elseif($pageSidebarOpt != ''){
	$pageSidebar = $pageSidebarOpt;
}else{
	$pageSidebar = '';
}
if($pageSidebarStrictNo == 1){
	$pageSidebar = '';
}
$sidebar_column = get_post_meta(get_the_ID(),'borntogive_sidebar_columns_layout',true);
$sidebar_column = ($sidebar_column=='')?4:$sidebar_column;
if(!empty($pageSidebar)&&is_active_sidebar($pageSidebar)) {
$left_col = 12-$sidebar_column;
$class = $left_col;  
}else{
$class = 12;  
}
$page_header = get_post_meta(get_the_ID(),'borntogive_pages_Choose_slider_display',true);
if($page_header==3||$page_header==4) {
	get_template_part( 'pages', 'flex' );
}
elseif($page_header==5) {
	get_template_part( 'pages', 'revolution' );
} else{
	get_template_part( 'pages', 'banner' );
}
?>
<!--<link rel='stylesheet' id='charitable-datepicker-css'  href='http://staging-gridshub.site/sadaqat-demo/wp-content/plugins/charitable/assets/css/charitable-datepicker.min.css' type='text/css' media='all' />-->
<!-- Start Body Content -->
<style>
	 #success, #fail{
		display: none;
	}

	#message, #success, #fail {
		font-size: 15px;
		margin-top: 5px;
	}
	#success {
		color: green;
	}
	#fail {
		color: orange;
	}
	#question {
		    font-size: 15px;
	}

	.button{
		
	}

	.button:hover:enabled{
		
	}

	.button:disabled{
		opacity: .5;
		cursor: default;
	} 
	[type="date"] {
	  background:#fff url(https://cdn1.iconfinder.com/data/icons/cc_mono_icon_set/blacks/16x16/calendar_2.png)  98% 50% no-repeat !important ;
	  cursor: pointer;
	}
	[type="date"]::-webkit-inner-spin-button {
	  display: none;
	}
	[type="date"]::-webkit-calendar-picker-indicator {
	  opacity: 0;
	}
	#dateofbirth {
		
	}

</style>
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600&display=swap" rel="stylesheet">
<div id="main-container">
  	<div class="content">
   		<div class="container">
       		<div class="row">
            	<div class="col-md-<?php echo esc_attr($class); ?>" id="content-col">
            		<?php //echo do_shortcode("[charitable_submit_campaign]"); ?>
					<?php
						if ( is_user_logged_in() ):

						global $current_user;
						get_currentuserinfo();
						$author_query = array(
											'post_type' => 'campaign',
											'post_status' => 'pending', 
											'posts_per_page' => '1',
											'order'     => 'DESC',
											'author' => $current_user->ID
										);
						$author_posts = new WP_Query($author_query);
						if ( $author_posts->have_posts() ):
						while($author_posts->have_posts()) : $author_posts->the_post();
						?>
					<form method="post" id="charitable-campaign-submission-form" class="charitable-form charitable-campaign-form charitable-form-step3" enctype="multipart/form-data">
						<div class="charitable-form-fields cf row">
							<div class="charitable-form-header">
								<h2>Your Personal Information</h2>
								<p><strong>Note:</strong> All fields are required. you can save your progress at any point by clicking on save below.</p>
							</div>
							<div class="col-md-2"></div>
							<div class="col-md-8">
							<div id="charitable_field_user_email" class="charitable-form-field charitable-form-field-email required-field col-md-6">
								<label for="charitable_field_user_email_element">Your Email<abbr class="required" title="required">*</abbr></label>
								<input type="email" name="user_email" id="charitable_field_user_email_element" value="<?php echo $user_email; ?>" required="1">
							</div>
							
							<div id="charitable_field_first_name" class="charitable-form-field charitable-form-field-text required-field col-md-6">
								<label for="charitable_field_first_name_element">First name<abbr class="required" title="required">*</abbr></label>
								<input type="text" name="first_name" id="charitable_field_first_name_element" value="<?php echo $first_name; ?>" required="1">
							</div>
							
							<div id="charitable_field_last_name" class="charitable-form-field charitable-form-field-text required-field col-md-6">
								<label for="charitable_field_last_name_element">Last name<abbr class="required" title="required">*</abbr></label>
								<input type="text" name="last_name" id="charitable_field_last_name_element" value="<?php echo $last_name; ?>" required="1">
							</div>
							
							<div id="charitable_field_phone" class="charitable-form-field charitable-form-field-text col-md-6">
								<label for="charitable_field_phone_element">Your Phone Number</label>
								<input type="text" name="phone" id="charitable_field_phone_element" value="<?php echo $phone; ?>">
								<p class="charitable-field-help">Please include your international dialing code.</p>
							</div>
							
							<div id="charitable_field_birthday" class="charitable-form-field charitable-form-field-datepicker col-md-12">
								<label for="dateofbirth charitable_field_birthday_element">Birthday</label>
								<input type="date" name="birthday" value="<?php echo $birthday; ?>" id="charitable_field_birthday_element dateofbirth">
							</div>
							
							
							<div id="charitable_field_passport" class="charitable-form-field charitable-form-field-text col-md-6">
								<label for="charitable_field_passport_element">Your Passport Number<abbr class="required" title="required">*</abbr></label>
								<input type="text" name="passport" id="charitable_field_passport_element" value="<?php echo $passport; ?>" required="1">
							</div>
							
							<div id="charitable_field_idnumber" class="charitable-form-field charitable-form-field-text col-md-6">
								<label for="charitable_field_idnumber_element">Your Personal ID Number<abbr class="required" title="required">*</abbr></label>
								<input type="text" name="idnumber" id="charitable_field_idnumber_element" value="<?php echo $idnumber; ?>" required="1">
							</div>
							
							<div id="charitable_field_upload-passport" class="choose-file charitable-form-field charitable-form-field-picture col-md-12">
								<label>Upload Passport<abbr class="required" title="required">*</abbr></label>
								<p class="charitable-field-help">Upload Passport picture to display on your campaign page.</p>
								<input type="file" name="upload-passport" class="filestyle" id="charitable_field_upload-passport_element" value="<?php echo $upload_passport; ?>" required="1">				 
								<?php if (!empty($passport_file_id)) { echo wp_get_attachment_link( $passport_file_id ); } ?>									
							</div>
							
							<div id="charitable_field_upload-national-id" class="choose-file charitable-form-field charitable-form-field-picture col-md-12">
								<label>Upload National ID<abbr class="required" title="required">*</abbr></label>
								<p class="charitable-field-help">Upload Upload National ID picture to display on your campaign page.</p>
								<input type="file" name="upload-national-id" class="filestyle" id="charitable_field_upload-national-id_element" value="<?php echo $upload_national_id; ?>" required="1">
								<?php if (!empty($passport_file_id1)) {echo wp_get_attachment_link( $passport_file_id1 ); } ?>							
							</div>
							
							<div class="col-md-12 charitable-form-header"><h2>Please Enter your address below.</h2></div>
							
							<div id="charitable_field_country" class="charitable-form-field charitable-form-field-select col-md-6">
								<label for="charitable_field_country_element">Country</label>
								<select name="country" id="charitable_field_country_element" value="<?php echo $country; ?>">
												<option value="AF">Afghanistan</option> 				
													<option value="AX">Åland Islands</option> 				
													<option value="AL">Albania</option> 				
													<option value="DZ">Algeria</option> 				
													<option value="AD">Andorra</option> 				
													<option value="AO">Angola</option> 				
													<option value="AI">Anguilla</option> 				
													<option value="AQ">Antarctica</option> 				
													<option value="AG">Antigua and Barbuda</option> 				
													<option value="AR">Argentina</option> 				
													<option value="AM">Armenia</option> 				
													<option value="AW">Aruba</option> 				
													<option value="AU">Australia</option> 				
													<option value="AT">Austria</option> 				
													<option value="AZ">Azerbaijan</option> 				
													<option value="BS">Bahamas</option> 				
													<option value="BH">Bahrain</option> 				
													<option value="BD">Bangladesh</option> 				
													<option value="BB">Barbados</option> 				
													<option value="BY">Belarus</option> 				
													<option value="BE">Belgium</option> 				
													<option value="PW">Belau</option> 				
													<option value="BZ">Belize</option> 				
													<option value="BJ">Benin</option> 				
													<option value="BM">Bermuda</option> 				
													<option value="BT">Bhutan</option> 				
													<option value="BO">Bolivia</option> 				
													<option value="BQ">Bonaire, Saint Eustatius and Saba</option> 				
													<option value="BA">Bosnia and Herzegovina</option> 				
													<option value="BW">Botswana</option> 				
													<option value="BV">Bouvet Island</option> 				
													<option value="BR">Brazil</option> 				
													<option value="IO">British Indian Ocean Territory</option> 				
													<option value="VG">British Virgin Islands</option> 				
													<option value="BN">Brunei</option> 				
													<option value="BG">Bulgaria</option> 				
													<option value="BF">Burkina Faso</option> 				
													<option value="BI">Burundi</option> 				
													<option value="KH">Cambodia</option> 				
													<option value="CM">Cameroon</option> 				
													<option value="CA">Canada</option> 				
													<option value="CV">Cape Verde</option> 				
													<option value="KY">Cayman Islands</option> 				
													<option value="CF">Central African Republic</option> 				
													<option value="TD">Chad</option> 				
													<option value="CL">Chile</option> 				
													<option value="CN">China</option> 				
													<option value="CX">Christmas Island</option> 				
													<option value="CC">Cocos (Keeling) Islands</option> 				
													<option value="CO">Colombia</option> 				
													<option value="KM">Comoros</option> 				
													<option value="CG">Congo (Brazzaville)</option> 				
													<option value="CD">Congo (Kinshasa)</option> 				
													<option value="CK">Cook Islands</option> 				
													<option value="CR">Costa Rica</option> 				
													<option value="HR">Croatia</option> 				
													<option value="CU">Cuba</option> 				
													<option value="CW">CuraÇao</option> 				
													<option value="CY">Cyprus</option> 				
													<option value="CZ">Czech Republic</option> 				
													<option value="DK">Denmark</option> 				
													<option value="DJ">Djibouti</option> 				
													<option value="DM">Dominica</option> 				
													<option value="DO">Dominican Republic</option> 				
													<option value="EC">Ecuador</option> 				
													<option value="EG">Egypt</option> 				
													<option value="SV">El Salvador</option> 				
													<option value="GQ">Equatorial Guinea</option> 				
													<option value="ER">Eritrea</option> 				
													<option value="EE">Estonia</option> 				
													<option value="ET">Ethiopia</option> 				
													<option value="FK">Falkland Islands</option> 				
													<option value="FO">Faroe Islands</option> 				
													<option value="FJ">Fiji</option> 				
													<option value="FI">Finland</option> 				
													<option value="FR">France</option> 				
													<option value="GF">French Guiana</option> 				
													<option value="PF">French Polynesia</option> 				
													<option value="TF">French Southern Territories</option> 				
													<option value="GA">Gabon</option> 				
													<option value="GM">Gambia</option> 				
													<option value="GE">Georgia</option> 				
													<option value="DE">Germany</option> 				
													<option value="GH">Ghana</option> 				
													<option value="GI">Gibraltar</option> 				
													<option value="GR">Greece</option> 				
													<option value="GL">Greenland</option> 				
													<option value="GD">Grenada</option> 				
													<option value="GP">Guadeloupe</option> 				
													<option value="GT">Guatemala</option> 				
													<option value="GG">Guernsey</option> 				
													<option value="GN">Guinea</option> 				
													<option value="GW">Guinea-Bissau</option> 				
													<option value="GY">Guyana</option> 				
													<option value="HT">Haiti</option> 				
													<option value="HM">Heard Island and McDonald Islands</option> 				
													<option value="HN">Honduras</option> 				
													<option value="HK">Hong Kong</option> 				
													<option value="HU">Hungary</option> 				
													<option value="IS">Iceland</option> 				
													<option value="IN" selected="selected">India</option> 				
													<option value="ID">Indonesia</option> 				
													<option value="IR">Iran</option> 				
													<option value="IQ">Iraq</option> 				
													<option value="IE">Republic of Ireland</option> 				
													<option value="IM">Isle of Man</option> 				
													<option value="IL">Israel</option> 				
													<option value="IT">Italy</option> 				
													<option value="CI">Ivory Coast</option> 				
													<option value="JM">Jamaica</option> 				
													<option value="JP">Japan</option> 				
													<option value="JE">Jersey</option> 				
													<option value="JO">Jordan</option> 				
													<option value="KZ">Kazakhstan</option> 				
													<option value="KE">Kenya</option> 				
													<option value="KI">Kiribati</option> 				
													<option value="KW">Kuwait</option> 				
													<option value="KG">Kyrgyzstan</option> 				
													<option value="LA">Laos</option> 				
													<option value="LV">Latvia</option> 				
													<option value="LB">Lebanon</option> 				
													<option value="LS">Lesotho</option> 				
													<option value="LR">Liberia</option> 				
													<option value="LY">Libya</option> 				
													<option value="LI">Liechtenstein</option> 				
													<option value="LT">Lithuania</option> 				
													<option value="LU">Luxembourg</option> 				
													<option value="MO">Macao S.A.R., China</option> 				
													<option value="MK">Macedonia</option> 				
													<option value="MG">Madagascar</option> 				
													<option value="MW">Malawi</option> 				
													<option value="MY">Malaysia</option> 				
													<option value="MV">Maldives</option> 				
													<option value="ML">Mali</option> 				
													<option value="MT">Malta</option> 				
													<option value="MH">Marshall Islands</option> 				
													<option value="MQ">Martinique</option> 				
													<option value="MR">Mauritania</option> 				
													<option value="MU">Mauritius</option> 				
													<option value="YT">Mayotte</option> 				
													<option value="MX">Mexico</option> 				
													<option value="FM">Micronesia</option> 				
													<option value="MD">Moldova</option> 				
													<option value="MC">Monaco</option> 				
													<option value="MN">Mongolia</option> 				
													<option value="ME">Montenegro</option> 				
													<option value="MS">Montserrat</option> 				
													<option value="MA">Morocco</option> 				
													<option value="MZ">Mozambique</option> 				
													<option value="MM">Myanmar</option> 				
													<option value="NA">Namibia</option> 				
													<option value="NR">Nauru</option> 				
													<option value="NP">Nepal</option> 				
													<option value="NL">Netherlands</option> 				
													<option value="AN">Netherlands Antilles</option> 				
													<option value="NC">New Caledonia</option> 				
													<option value="NZ">New Zealand</option> 				
													<option value="NI">Nicaragua</option> 				
													<option value="NE">Niger</option> 				
													<option value="NG">Nigeria</option> 				
													<option value="NU">Niue</option> 				
													<option value="NF">Norfolk Island</option> 				
													<option value="KP">North Korea</option> 				
													<option value="NO">Norway</option> 				
													<option value="OM">Oman</option> 				
													<option value="PK">Pakistan</option> 				
													<option value="PS">Palestinian Territory</option> 				
													<option value="PA">Panama</option> 				
													<option value="PG">Papua New Guinea</option> 				
													<option value="PY">Paraguay</option> 				
													<option value="PE">Peru</option> 				
													<option value="PH">Philippines</option> 				
													<option value="PN">Pitcairn</option> 				
													<option value="PL">Poland</option> 				
													<option value="PT">Portugal</option> 				
													<option value="QA">Qatar</option> 				
													<option value="RE">Reunion</option> 				
													<option value="RO">Romania</option> 				
													<option value="RU">Russia</option> 				
													<option value="RW">Rwanda</option> 				
													<option value="BL">Saint Barthélemy</option> 				
													<option value="SH">Saint Helena</option> 				
													<option value="KN">Saint Kitts and Nevis</option> 				
													<option value="LC">Saint Lucia</option> 				
													<option value="MF">Saint Martin (French part)</option> 				
													<option value="SX">Saint Martin (Dutch part)</option> 				
													<option value="PM">Saint Pierre and Miquelon</option> 				
													<option value="VC">Saint Vincent and the Grenadines</option> 				
													<option value="SM">San Marino</option> 				
													<option value="ST">São Tomé and Príncipe</option> 				
													<option value="SA">Saudi Arabia</option> 				
													<option value="SN">Senegal</option> 				
													<option value="RS">Serbia</option> 				
													<option value="SC">Seychelles</option> 				
													<option value="SL">Sierra Leone</option> 				
													<option value="SG">Singapore</option> 				
													<option value="SK">Slovakia</option> 				
													<option value="SI">Slovenia</option> 				
													<option value="SB">Solomon Islands</option> 				
													<option value="SO">Somalia</option> 				
													<option value="ZA">South Africa</option> 				
													<option value="GS">South Georgia/Sandwich Islands</option> 				
													<option value="KR">South Korea</option> 				
													<option value="SS">South Sudan</option> 				
													<option value="ES">Spain</option> 				
													<option value="LK">Sri Lanka</option> 				
													<option value="SD">Sudan</option> 				
													<option value="SR">Suriname</option> 				
													<option value="SJ">Svalbard and Jan Mayen</option> 				
													<option value="SZ">Swaziland</option> 				
													<option value="SE">Sweden</option> 				
													<option value="CH">Switzerland</option> 				
													<option value="SY">Syria</option> 				
													<option value="TW">Taiwan</option> 				
													<option value="TJ">Tajikistan</option> 				
													<option value="TZ">Tanzania</option> 				
													<option value="TH">Thailand</option> 				
													<option value="TL">Timor-Leste</option> 				
													<option value="TG">Togo</option> 				
													<option value="TK">Tokelau</option> 				
													<option value="TO">Tonga</option> 				
													<option value="TT">Trinidad and Tobago</option> 				
													<option value="TN">Tunisia</option> 				
													<option value="TR">Turkey</option> 				
													<option value="TM">Turkmenistan</option> 				
													<option value="TC">Turks and Caicos Islands</option> 				
													<option value="TV">Tuvalu</option> 				
													<option value="UG">Uganda</option> 				
													<option value="UA">Ukraine</option> 				
													<option value="AE">United Arab Emirates</option> 				
													<option value="GB">United Kingdom (UK)</option> 				
													<option value="US">United States (US)</option> 				
													<option value="UY">Uruguay</option> 				
													<option value="UZ">Uzbekistan</option> 				
													<option value="VU">Vanuatu</option> 				
													<option value="VA">Vatican</option> 				
													<option value="VE">Venezuela</option> 				
													<option value="VN">Vietnam</option> 				
													<option value="WF">Wallis and Futuna</option> 				
													<option value="EH">Western Sahara</option> 				
													<option value="WS">Western Samoa</option> 				
													<option value="YE">Yemen</option> 				
													<option value="ZM">Zambia</option> 				
													<option value="ZW">Zimbabwe</option> 				
										</select>
							</div>
							
							<div id="charitable_field_address12" class="charitable-form-field charitable-form-field-text col-md-6">
								<label for="charitable_field_address12_element">Street</label>
								<input type="text" name="address12" id="charitable_field_address12_element" value="<?php echo $address12; ?>">
							</div>
							
							<div id="charitable_field_address_22" class="charitable-form-field charitable-form-field-text col-md-6">
								<label for="charitable_field_address_22_element">Street Line 2</label>
								<input type="text" name="address_22" id="charitable_field_address_22_element" value="<?php echo $address_22; ?>">
							</div>
							
							<div id="charitable_field_city" class="charitable-form-field charitable-form-field-text col-md-6">
								<label for="charitable_field_city_element">City</label>
								<input type="text" name="city" id="charitable_field_city_element" value="<?php echo $city; ?>">
							</div>
							
							<div id="charitable_field_state" class="charitable-form-field charitable-form-field-text col-md-6">
								<label for="charitable_field_state_element">State/Province/Region</label>
								<input type="text" name="state" id="charitable_field_state_element" value="<?php echo $state; ?>">
							</div>
							
							<div id="charitable_field_postcode12" class="charitable-form-field charitable-form-field-text col-md-6">
								<label for="charitable_field_postcode12_element">Postal code</label>
								<input type="text" name="postcode12" id="charitable_field_postcode12_element" value="<?php echo $postcode12; ?>">
							</div>
							
							<div id="charitable_field_charity-certificate" class="choose-file charitable-form-field charitable-form-field-picture col-md-6">
								<label>Registered Charity Certificate / License<abbr class="required" title="required">*</abbr></label>
								<p class="charitable-field-help">Upload charity certificate picture to display on your campaign page.</p>
								
								
								<input type="file" name="charity-certificate" class="filestyle" id="charitable_field_charity-certificate_element" value="<?php echo $charity_certificate; ?>" required="1">
								
								<?php if (!empty($passport_file_id2)) { echo wp_get_attachment_link( $passport_file_id2 ); } ?>								
							</div>
							<div class="col-md-12"></div>
							
							
							<div id="charitable_field_charity-certificate" class="choose-file charitable-form-field charitable-form-field-picture col-md-6">
								<label>Board of Trustees<abbr class="required" title="required">*</abbr></label>
								<p class="charitable-field-help">Upload Board of Trustees picture to display on your campaign page.</p>
								<input type="file" name="board-of-trustees" class="filestyle" id="charitable_field_board-of-trustees_element" value="<?php echo $board_of_trustees; ?>" required="1">	
								
								<?php if (!empty($passport_file_id3)) { echo wp_get_attachment_link( $passport_file_id3 ); } ?>
							</div>
							<div class="charitable-form-field col-md-12"></div>
							
							<div class="charitable-form-field1 col-md-6">
								<div class="">
								<label>Enter Captcha:<abbr class="required" title="required">*</abbr></label><br />
								<input id="text-captcha" type="text" name="captcha" required="1"/>
								<p><br />
								<img src="https://www.allphptricks.com/demo/2018/may/create-simple-captcha-script/captcha.php?rand=rand();" id="captcha_image">
								</p>
								<p>Cant read the image?
								<a id="text-captcha-link" href="javascript: refreshCaptcha();">click here</a>
								to refresh</p></div>
								
							</div>
													
							<div class="charitable-form-field charitable-submit-field col-md-12">
								<input class="button button-primary" type="submit" name="submit-campaign" value="Submit">		
							</div>
							<input type="hidden" name="campaign_id" value="<?php echo $_REQUEST['campaign_id']; ?>">
						</div>
						<div class="col-md-2"></div>
						</div>
			
						
					</form>
					<?php           
						endwhile;
						else: ?>
							<h3 class="alert alert-danger"><?php _e( 'Not allow to access this page' ); ?></h3>
						<?php endif;

						wp_reset_query();
						
					else :
						echo "<h3 class='alert alert-success'>Not logged in. Please <a href='charitable-login/'>Login</a> to Access this page.</h3>";
					endif;
					?>
                </div>
                <?php if(is_active_sidebar($pageSidebar)) { ?>
                    <!-- Sidebar -->
                    <div class="col-md-<?php echo esc_attr($sidebar_column); ?>" id="sidebar-col">
                    	<?php dynamic_sidebar($pageSidebar); ?>
                    </div>
                    <?php } ?>
            	</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="https://www.jquery-az.com/boots/js/bootstrap-filestyle.min.js"> </script>

<script>
	$('.filestyle').filestyle({
	 
	//buttonName : 'btn-success',
	 
	buttonText : 'Upload Image'
	 
	});
</script>
<script>
//Refresh Captcha
function refreshCaptcha(){
    var img = document.images['captcha_image'];
    img.src = img.src.substring(
 0,img.src.lastIndexOf("?")
 )+"?rand="+Math.random()*1000;
}
</script>
<?php get_footer(); ?>