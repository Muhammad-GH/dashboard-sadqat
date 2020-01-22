<?php
/**
 * Template Name: Charity Form Step 2
 */
?>

<?php 

if(isset($_REQUEST['submit-campaign'])){
	
	$campaign_video  = $_REQUEST['campaign-video'];
	$campaign_video_description  = $_REQUEST['campaign_video_description'];
	
	$campaign_id  = $_REQUEST['campaign_id'];
	
	update_post_meta( $campaign_id, '_campaign_campaign-video', $campaign_video );
	update_post_meta( $campaign_id, '_campaign_campaign_video_description', $campaign_video_description );

	$meta = get_post_meta( $campaign_id,'_campaign_submission_data',true );
	$meta['campaign-video'] = $campaign_video;
	$meta['campaign_video_description'] = $campaign_video_description;
	update_post_meta( $campaign_id, '_campaign_submission_data', $meta );
	
	echo '<pre>';
	print_r($meta );
	print_r($array);
	echo '</pre>';
	
	//wp_mail( 'fahimku@gmail.com', 'Campaign Registration Step 2 Approved', 'Thank you for submitting your campaign. First part of your campaign is approved' );
	
	$to = 'fahimku@gmail.com';
	$subject = 'Campaign Registration Step 2 Approved';
	//$body = 'Thank you for submitting your campaign. First part of your campaign is approved';
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
">Campaign Registration Step 2 Approved</h1>
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
		$body .= 'Thank you for submitting your campaign. Second part of your campaign is approved';
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
	.charitable-form-field1 label {
		font-size: 15px;
		font-family: 'Open Sans', sans-serif;
		font-weight: 600;
		color: #757575;
	}
</style>
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600&display=swap" rel="stylesheet">
<!-- Start Body Content -->
<div id="main-container">
  	<div class="content">
   		<div class="container">
       		<div class="row">
            	<div class="col-md-<?php echo esc_attr($class); ?>" id="content-col">
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
						<form method="post" id="charitable-campaign-submission-form" class="charitable-form" enctype="multipart/form-data">
						<div class="charitable-form-fields cf">
							<div class="col-md-2"></div>
							<div class="col-md-8">
							<div class="charitable-form-header">Tell your Story</div>
							<div class="para-step2 col-md-12">
							<p>Creating a personalized video on the campaign always adds the personal touch and will support in improving your chances of a successful fundraising campaign. Our recommendation is to upload the campaign video by using personalized story telling techniques of individuals and or communities that you wish to raise funds for.</p>
							
							<i>Before You Create…</i>
							
							<ol>
								<li>State your campaign right away and the objectives of your campaign</li>
								<li>Make your tagline standout and stress on the impact it will make</li>
								<li>Personalize your video with actual footage to convey the story to potential donors</li>
							</ol>
							</div>
							<div id="charitable_field_campaign-video" class="charitable-form-field charitable-form-field-text col-md-12">
								<label for="charitable_field_campaign-video_element">Campaign Video (maximum of 3 minutes)</label>
								<input type="url" name="campaign-video" id="charitable_field_campaign-video_element" value="<?php echo $campaign_video; ?>">
							</div>
							
							<div id="charitable_field_post_content" class="charitable-form-field charitable-form-field-editor required-field fullwidth col-md-12">
								<label for="post_content">Campaign Goal</label>
								
								<?php

									$content = '';
									$editor_id = 'charitable_field_description_element';
									$settings = array( 
									'textarea_name' => 'campaign_video_description',
									'value'     => 'campaign_video_description'
									);
									wp_editor( $content, $editor_id, $settings );

									?>
							</div>
							
							<div class="charitable-form-field1 col-md-6">
								
								<label>Enter Captcha:<abbr class="required" title="required">*</abbr></label><br />
								<input id="text-captcha" type="text" name="captcha" required="1"/>
								<p><br />
								<img src="https://www.allphptricks.com/demo/2018/may/create-simple-captcha-script/captcha.php?rand=rand();" id="captcha_image">
								</p>
								<p>Cant read the image?
								<a id="text-captcha-link" href="javascript: refreshCaptcha();">click here</a>
								to refresh</p>
								
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
            		<?php //echo do_shortcode("[charitable_submit_campaign]"); ?>
					
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script>
/* $(document).ready(function(){
   $("#charitable_field_campaign-video_element").prop('required',true);
}); */
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