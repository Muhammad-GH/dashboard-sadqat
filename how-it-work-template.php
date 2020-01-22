<?php
/**
 * Template Name: How it work
 */
?>
<?php 
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
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<!-- Start Body Content -->
<div id="main-container">
  	<div class="content">
   		<div class="container">
       		<div class="row">
            	<div id="content-col">
					<div class="charitable-form-header">
						<h2>How Sadaqat Works</h2>		
					</div>
					
					<div class="row mbr-justify-content-center">

						<div class="col-lg-6 mbr-col-md-10">
							<div class="wrap">
								<div class="ico-wrap ico-wrap1">01</div>
								<div class="text-wrap vcenter">
									<h4 class="mbr-section-title3 display-11">Charity Crowdfunding</h4>
									<p class="mbr-text">Charity based crowdfunding is a way to donate money for charitable causes by asking a large number of contributors to individually donate a small amount to it. Sadaqat-UmmahCrowdfunding platform is built on this model.</p>
								</div>
							</div>
						</div>
						<div class="col-lg-6 mbr-col-md-10">
							<div class="wrap">
								<div class="ico-wrap ico-wrap2">
									02
								</div>
								<div class="text-wrap vcenter">
									<h4 class="mbr-section-title3 display-22">Reward Based Crowdfunding</h4>
									<p class="mbr-text">In neward based crowdfunding you will give something of cash,but you will get back something in kind, meaning non-crash</p>
								</div>
							</div>
						</div>
						<div class="col-lg-6 mbr-col-md-10">
							<div class="wrap">
								<div class="ico-wrap ico-wrap3">
									03
								</div>
								<div class="text-wrap vcenter">
									<h4 class="mbr-section-title3 display-33">Equity Crowdfunding</h4>
									<p class="mbr-text">Equity crowdfunding gives you,as an investor,a share in the company that you have invested in.</p>
								</div>
							</div>
						</div>
						<div class="col-lg-6 mbr-col-md-10">
							<div class="wrap">
								<div class="ico-wrap ico-wrap4">
									04
								</div>
								<div class="text-wrap vcenter">
									<h4 class="mbr-section-title3 display-44">Peer-2-peer Crowdfunding</h4>
									<p class="mbr-text">The term lending crowdfunding is a bit heavy for most people, thus.</p>
								</div>
							</div>
						</div>
					</div>
					
					
					<div class="row justify-content-md-center flow-image">
						<div class="col-xs-12 col-lg-3 flow-box1">
							<div class="flowbox-title">
								Plan
							</div>
							<div class="flowbox-content">
								Lorem Ipsum is simply dummy text of the printing and typesetting industry
							</div>
						</div>
						<div class="col-xs-12 col-lg-3 flow-box1">
							<div class="flowbox-title">
								Sign Up
							</div>
							<div class="flowbox-content">
								Lorem Ipsum is simply dummy text of the printing and typesetting industry
							</div>
						</div>
						<div class="col-xs-12 col-lg-3 flow-box1">
							<div class="flowbox-title">
								Create
							</div>
							<div class="flowbox-content">
								Lorem Ipsum is simply dummy text of the printing and typesetting industry
							</div>
						</div>
					</div>
					
					<div class="bg-2"></div>
					
					<div class="row justify-content-md-center flow-area">
						<div class="col-xs-12 col-lg-3 flow-box">
							<div class="flowbox-title">
								Onboarding
							</div>
							<div class="flowbox-content">
								Lorem Ipsum is simply dummy text of the printing and typesetting industry
							</div>
						</div>
						<div class="flow-arrow"></div>
						<div class="col-xs-12 col-lg-3 flow-box">
							<div class="flowbox-title">
								Go Live
							</div>
							<div class="flowbox-content">
								Lorem Ipsum is simply dummy text of the printing and typesetting industry
							</div>
						</div>
						<div class="flow-arrow1"></div>
						<div class="col-xs-12 col-lg-3 flow-box">
							<div class="flowbox-title">
								Mentor
							</div>
							<div class="flowbox-content">
								Lorem Ipsum is simply dummy text of the printing and typesetting industry
							</div>
						</div>
					</div>
					
					<div class="bg-2"></div>
					
					<div class="row justify-content-md-center flow-area">
						<div class="col-xs-12 col-lg-3 flow-box">
							<div class="flowbox-title">
								Promote
							</div>
							<div class="flowbox-content">
								Lorem Ipsum is simply dummy text of the printing and typesetting industry
							</div>
						</div>
						<div class="flow-arrow"></div>
						<div class="col-xs-12 col-lg-3 flow-box">
							<div class="flowbox-title">
								Crowdfund
							</div>
							<div class="flowbox-content">
								Lorem Ipsum is simply dummy text of the printing and typesetting industry
							</div>
						</div>
						<div class="flow-arrow1"></div>
						<div class="col-xs-12 col-lg-3 flow-box">
							<div class="flowbox-title">
								Finish Line
							</div>
							<div class="flowbox-content">
								Lorem Ipsum is simply dummy text of the printing and typesetting industry
							</div>
						</div>
					</div>
					
					<div class="bg-2"></div>
					
					<div class="row justify-content-md-center flow-area">
						<div class="col-xs-12 col-lg-3 flow-box">
							<div class="flowbox-title">
								Fund Release
							</div>
							<div class="flowbox-content">
								Lorem Ipsum is simply dummy text of the printing and typesetting industry
							</div>
						</div>
						<div class="flow-arrow"></div>
						<div class="col-xs-12 col-lg-3 flow-box">
							<div class="flowbox-title">
								Crowdfund
							</div>
							<div class="flowbox-content">
								Lorem Ipsum is simply dummy text of the printing and typesetting industry
							</div>
						</div>
						<div class="flow-arrow1"></div>
						<div class="col-xs-12 col-lg-3 flow-box">
							<div class="flowbox-title">
								Progress
							</div>
							<div class="flowbox-content">
								Lorem Ipsum is simply dummy text of the printing and typesetting industry
							</div>
						</div>
					</div>
					<div class="bg-3"></div>
					<div class="row justify-content-md-center">
						<div class="col-xs-12 col-lg-3 flow-box">
							<div class="flowbox-title">
								Credibility
							</div>
							<div class="flowbox-content">
								Lorem Ipsum is simply dummy text of the printing and typesetting industry
							</div>
						</div>
					</div>
					
					
					<div class="text-center">
					<!--<img src="http://staging-gridshub.site/sadaqat-demo/wp-content/uploads/2019/07/image01.png" class="img-fluid" alt="Saqaqat">-->
					
					<div class="row">
						<div class="col-md-12 mt-5 mb-5 ml-5 mr-5">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English.</div>
					</div>
					
					<img src="http://staging-gridshub.site/sadaqat-demo/wp-content/uploads/2019/07/image02.png" class="img-fluid" alt="Saqaqat">
					</div>
                </div>
                
            	</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>