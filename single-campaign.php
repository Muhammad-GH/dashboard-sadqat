<?php 
get_header();
global $borntogive_options, $borntogive_allowed_tags;
borntogive_sidebar_position_module();
$pageSidebarGet = get_post_meta(get_the_ID(),'borntogive_select_sidebar_from_list', true);
$pageSidebarStrictNo = get_post_meta(get_the_ID(),'borntogive_strict_no_sidebar', true);
$pageSidebarOpt = $borntogive_options['campaign_sidebar'];
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
} else {
	get_template_part( 'pages', 'banner' );
}
$campaign = new Charitable_Campaign( get_the_ID() );
$donated = $campaign->get_percent_donated_raw();
$time_left = $campaign->get_time_left();
$raw_end_date = $campaign->get_end_time();
$end_date = date_i18n(get_option('date_format'), $raw_end_date);
$goal = $campaign->get_monetary_goal();
$donation_achieved = charitable_format_money( $campaign->get_donated_amount() );
$currency = '';
$donors = $campaign->get_donor_count();
if(have_posts()):while(have_posts()):the_post();
$campaign_desc = get_post_meta(get_the_ID(), '_campaign_description', true);
$single_cam_show_description = (isset($options['single_cam_show_description']))?$options['single_cam_show_description']:1;
$single_cam_show_stdt = (isset($options['single_cam_show_stdt']))?$options['single_cam_show_stdt']:1;
$single_cam_show_endt = (isset($options['single_cam_show_endt']))?$options['single_cam_show_endt']:1;
$single_cam_show_donors = (isset($options['single_cam_show_donors']))?$options['single_cam_show_donors']:1;
$campaign_progress_sh = get_post_meta(get_the_ID(), 'borntogive_campaign_progress_sh', true);
?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
<!-- Main Content -->
    <div id="main-container">
    	<div class="content">
        	<div class="container">
            	<div class="row">
					<div class="col-md-12 campaign-title">
						<h2><?php echo get_the_title(); ?></h2>
					</div>
					<div class="post-media" style="background-image: url('<?php echo wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) ); ?>');">
                        	
                        </div>
                	<div class="col-md-8" id="content-col">
                    	
                    	
	
						<div id="tabs" class="campaign-tabs">
							<div class="tabbable full-width-tabs">
								<ul class="nav nav-tabs">
									<li class="active take-all-space-you-can"><a href="#story" data-toggle="tab">Story</a></li>
									<li class="take-all-space-you-can"><a href="#donors" data-toggle="tab">Donors</a></li>
								</ul>
								<div class="tab-content">
									<div class="tab-pane active" id="story">
										<?php the_content(); ?>	
										
										
									</div>
									<div class="tab-pane" id="donors">
										
										<?php
 
										if ( is_active_sidebar( 'custom-donar-widget' ) ) : ?>
											<div id="header-widget-area" class="chw-widget-area widget-area" role="complementary">
											<?php dynamic_sidebar( 'custom-donar-widget' ); ?>
											</div>
											 
										<?php endif; ?>
								
									</div>  
								</div> 
							</div> <!-- /tabbable -->
            
						</div>
						
						
		
						
                       
						
                    </div>
                    
                   
                    <!-- Sidebar -->
                    <div class="col-md-4" id="sidebar-col">
						
						<?php if($campaign_progress_sh == 1 || $campaign_progress_sh == ''){ ?>
							<div class="campaign-progress-wrap">
								
								<div class="campaign-cat">
									<div class="pull-left">
										<i class="fa fa-map-marker"></i> 
										Nepal								
									</div>
									<div class="pull-right">
											
											<?php
												$category = get_the_terms( $post->ID, 'campaign_category' );  
												$limit=2; // Set limit here
												$counter=0;										
													foreach ( $category as $cat){
														 if($counter<$limit){
															echo "<i class='fa fa-tags'></i> ";
															echo $cat->name;
															$counter++;
														}
													}
											?>
									</div>
								</div>
								<div class="spacer-40"></div>
							
						
								<div class="donate-amount-wrap">
									<div class="donate-amount"><strong><?php echo ''.$currency.$donation_achieved; ?></strong></div>
									<div class="donate-goal"><?php esc_html_e('funded off', 'borntogive'); ?> <strong class="accent-color"><?php echo esc_attr($goal); ?></strong> goals </div>
								</div>
								
								<div class="spacer-20"></div>

								<div class="progress">
									<div class="progress-bar progress-bar-striped" data-appear-progress-animation="<?php echo round($donated, 0, PHP_ROUND_HALF_EVEN).'%'; ?>" data-appear-animation-delay="100"><?php if($donated != ''){ ?>
									<span class="progress-bar-tooltip"><?php echo round($donated, 0, PHP_ROUND_HALF_EVEN).'%'; ?></span><?php } ?></div>
								</div>
								
								<div class="spacer-20"></div>
								
								
						<?php } ?>
						
						<?php if(($single_cam_show_stdt == 1 || $single_cam_show_stdt == '') || ($single_cam_show_endt == 1 || $single_cam_show_endt == '') || ($single_cam_show_donors == 1 || $single_cam_show_donors == '')) { ?>
								<div class="donar-details">
                            		
                          				<?php if($single_cam_show_donors == 1 || $single_cam_show_donors == ''){ ?>
											<div class="donar-Supporter"><?php echo esc_attr($donors); ?><span>Supporters</span></div>
										<?php } ?>
										<?php if($single_cam_show_stdt == 1 || $single_cam_show_stdt == ''){ ?>
                          					<div class="donar-timeleft"><?php echo ''.$time_left; ?></div>
										<?php } ?>
                          		<div class="spacer-20"></div>
                                	
									<div class="campaign-donation">
										<a data-trigger-modal="charitable-donation-form-modal" class="donate-button button" href="<?php echo charitable_get_permalink( 'campaign_donation_page', array( 'campaign_id' => $campaign->ID ) ); ?>" aria-label="<?php printf(
												/* translators: %s: campaign title */
												esc_attr_x( 'Make a donation to %s', 'make a donation to campaign', 'charitable' ), get_the_title( $campaign->ID )
											); ?>">
										<?php _e( 'Donate Now', 'charitable' ); ?>
										</a>
									</div>
                            	</div>
								<div class="spacer-20"></div>
								<?php } ?>
							</div>
							
							<div class="row partial-funding">
								<!--<div class="col-3">
								<img src="//media.launchgood.com/d1dfe4943c8b2df686045143cae7c3d8b163e4bd/img/Campaign_Badge-03.svg">
								</div>-->
								<div class="col-md-12 col-xs-12">
								<img src="//media.launchgood.com/d1dfe4943c8b2df686045143cae7c3d8b163e4bd/img/Campaign_Badge-03.svg" class="img-fluid" style="width: 70px;margin-bottom: 12px;'">
								<h3>Partial Funding</h3>
								<p class="ng-binding">This campaign will collect all funds raised by 
								<?php 
									$date = get_post_meta( $post->ID, '_campaign_end_date', true );

									if( $date != '' ) {
										echo date( "M j, Y g:i A", strtotime( $date ) );
									}
								?>.</p>
								</div>
							</div>
							
							
							<?php
								$widget_title   = apply_filters( 'widget_title', $view_args['title'] );
								$campaign_id    = $view_args[ 'campaign_id' ] == 'current' ? get_the_ID() : $view_args[ 'campaign_id' ];
								$campaign       = new Charitable_Campaign( $campaign_id );
								$creator        = new Charitable_User( $campaign->get_campaign_creator() );
								$campaigns      = $creator->get_campaigns();
								$has_links      = $creator->user_url || $creator->twitter || $creator->facebook;
							?>
							<div class="row charitable-campaign-creator">
								
								<div class="col-md-12 col-xs-12">
									<?php if (!empty($avatar)) {
											 echo get_avatar( get_the_author_meta( 'ID' ) );
											}
										 else {
											echo "<img src='https://media.launchgood.com/d1dfe4943c8b2df686045143cae7c3d8b163e4bd/img/user_default/lg-user-icon-3.png' class='img-fluid' alt='avatar-default' style='width: 70px;'>";
										
										 }										
										 ?>
									<div class="creator-summary">
										<h5 class="creator-name">
											Campaign By:<br>
											<a href="<?php echo get_author_posts_url( $creator->ID ) ?>" title="<?php echo esc_attr( sprintf( "%s's %s", $creator->get_name(), __( 'profile', 'charitable-ambassadors' ) ) ) ?>">
												<?php echo $creator->display_name ?>
											</a>
										</h5>
										<p><?php printf( _n( '%d campaign', '%d campaigns', $campaigns->post_count, 'charitable-ambassadors' ), $campaigns->post_count ) ?> | 0 Supported</p>
									</div>
									
									<a href="mailto:<?php echo $creator->get_email(); ?>" class="button button-email" type="submit" name="donate">Email Directly</a>
								</div>
							</div> 
							
							<!--<a data-trigger-modal="charitable-donation-form-modal" class="panel-link" href="<?php echo charitable_get_permalink( 'campaign_donation_page', array( 'campaign_id' => $campaign->ID ) ); ?>" aria-label="<?php printf(esc_attr_x( 'Make a donation to %s', 'make a donation to campaign', 'charitable' ), get_the_title( $campaign->ID )); ?>">
								<div class="panel panel-success panel-claim">
									<div class="panel-heading">$10 USD</div>
									 <div class="panel-body">
										<h3>Thank you for your support</h3><br>
										<p class="pitch-text">Thank you for your donation. Please pray for this project!</p>
								
										<div class="claimed">27 claimed</div>
										
									 </div>
								</div>
							</a>
							
							<a data-trigger-modal="charitable-donation-form-modal" class="panel-link" href="<?php echo charitable_get_permalink( 'campaign_donation_page', array( 'campaign_id' => $campaign->ID ) ); ?>" aria-label="<?php printf(esc_attr_x( 'Make a donation to %s', 'make a donation to campaign', 'charitable' ), get_the_title( $campaign->ID )); ?>">
								<div class="panel panel-success panel-claim">
									<div class="panel-heading">$50 USD</div>
									 <div class="panel-body">
										<h3>You are kind hearted</h3><br>
										<p class="pitch-text">Your Contribution will be a great Thank you for your donation. Please pray for this project!</p>
								
										<div class="claimed">27 claimed</div>
										
									 </div>
								</div>
							</a>
							
							<a data-trigger-modal="charitable-donation-form-modal" class="panel-link" href="<?php echo charitable_get_permalink( 'campaign_donation_page', array( 'campaign_id' => $campaign->ID ) ); ?>" aria-label="<?php printf(esc_attr_x( 'Make a donation to %s', 'make a donation to campaign', 'charitable' ), get_the_title( $campaign->ID )); ?>">
								<div class="panel panel-success panel-claim">
									<div class="panel-heading">$100 USD</div>
									 <div class="panel-body">
										<h3>You are generous soul</h3><br>
										<p class="pitch-text">I would love to pay it forward by supporting another in need with a cure bar.</p>
								
										<div class="claimed">27 claimed</div>
										
									 </div>
								</div>
							</a>-->
                   
            	</div> 
            </div>
			
			<div class="row">
				<div class="col-md-4">
					<a data-trigger-modal="charitable-donation-form-modal" class="panel-donate" href="<?php echo charitable_get_permalink( 'campaign_donation_page', array( 'campaign_id' => $campaign->ID ) ); ?>" aria-label="<?php printf(esc_attr_x( 'Make a donation to %s', 'make a donation to campaign', 'charitable' ), get_the_title( $campaign->ID )); ?>">
					<div class="media donate-box">
						<div class="media-left media-middle">
						  <div class="amount">$10</div>
						  <img src="http://staging-gridshub.site/sadaqat-demo/wp-content/uploads/2019/08/021-1.png" alt="dollor" style="height: 23px;width: 43px;">
						</div>
						<div class="media-body">
						  <h4 class="media-heading">Thank you for your support</h4>
						  <p>Your Contribution will be a great Thank you for your donation. Please pray for this project!</p>
						  <div class="d-button">
							<span class="amount-img">27</span> Donated
							<div class="claimed">Donate Now</div>
						  </div>
						</div>
						
					</div>
					</a>
				</div>
				<div class="col-md-4">
					<a data-trigger-modal="charitable-donation-form-modal" class="panel-donate" href="<?php echo charitable_get_permalink( 'campaign_donation_page', array( 'campaign_id' => $campaign->ID ) ); ?>" aria-label="<?php printf(esc_attr_x( 'Make a donation to %s', 'make a donation to campaign', 'charitable' ), get_the_title( $campaign->ID )); ?>">
					<div class="media donate-box">
						<div class="media-left media-middle">
						  <div class="amount">$50</div>
						  <img src="http://staging-gridshub.site/sadaqat-demo/wp-content/uploads/2019/08/021-1.png" alt="dollor" style="height: 23px;width: 43px;">
						</div>
						<div class="media-body">
						  <h4 class="media-heading">You are kind hearted</h4>
						  <p>Your Contribution will be a great Thank you for your donation. Please pray for this project!</p>
						 <div class="d-button">
							<span class="amount-img">27</span> Donated
							<div class="claimed">Donate Now</div>
						  </div>
						</div>
					</div>
					</a>
				</div>
				<div class="col-md-4">
				<a data-trigger-modal="charitable-donation-form-modal" class="panel-donate" href="<?php echo charitable_get_permalink( 'campaign_donation_page', array( 'campaign_id' => $campaign->ID ) ); ?>" aria-label="<?php printf(esc_attr_x( 'Make a donation to %s', 'make a donation to campaign', 'charitable' ), get_the_title( $campaign->ID )); ?>">
					<div class="media donate-box">
						<div class="media-left media-middle">
						  <div class="amount">$100</div>
						  <img src="http://staging-gridshub.site/sadaqat-demo/wp-content/uploads/2019/08/021-1.png" alt="dollor" style="height: 23px;width: 43px;">
						</div>
						<div class="media-body">
						  <h4 class="media-heading">You are generous soul</h4>
						  <p>I would love to pay it forward by supporting another in need with a cure bar.</p>
						  <div class="d-button">
							<span class="amount-img">27</span> Donated
							<div class="claimed">Donate Now</div>
						  </div>
						</div>
					</div>
					</a>
				</div>
			</div>
			
			<div class="share_buttons-single">
				<!--<h5>Share Now</h5>-->
				<?php if ($borntogive_options['switch_sharing'] == 1 && $borntogive_options['share_post_types']['4'] == '1') { ?>
					<?php borntogive_share_buttons(); ?>
				<?php } ?>
			</div>
			
        </div>
    </div>
	<script type="text/javascript">
		jQuery.noConflict()(function($){
			$('.donor-name:contains("Anonymous")').each(function () {
				$(this).parent().addClass("anonymous-box"); // matched td add NewClass
			});
		});
	</script>
	<script type="text/javascript">
		jQuery.noConflict()(function($){
			$(".custom-donation-input").attr("placeholder", "Type Custom amount");
		});
	</script>
<?php endwhile; endif;
get_footer(); ?>