<?php
/**
 * Template Name: Create Campaign Template
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


<!-- Start Body Content -->
<div id="main-container">
  	<div class="content">
   		<div class="container">
       		<div class="row">
            	<div id="content-col">
					
					<div class="text-center">
						<img src="http://staging-gridshub.site/sadaqat-demo/wp-content/uploads/2019/09/Create_compaign_03_03_03_03.png" class="img-fluid" alt="Saqaqat">
					</div>
					
					<hr/>
					
					
					 <div  class="row campign-tabs">
						<div class="col-md-3 col-xs-5">
						  <!-- Nav tabs -->
						  <ul class="nav nav-tabs tabs-left sideways">
							<li class="active"><a href="#donors2" data-toggle="tab">1.&nbsp;&nbsp; Get Started</a></li>
							<li><a href="#donors3" data-toggle="tab">2.&nbsp;&nbsp; Tell Your story</a></li>
							<li><a href="#donors4" data-toggle="tab">3.&nbsp;&nbsp; Payment Information</a></li>
							<li><a href="#donors5" data-toggle="tab">4.&nbsp;&nbsp; Enhance</a></li>
							<li><a href="#donors6" data-toggle="tab">5.&nbsp;&nbsp; Add Giving Levels</a></li>
							<li><a href="#donors7" data-toggle="tab">6.&nbsp;&nbsp; Preview</a></li>
						  </ul>
						</div>

						<div class="col-md-9 col-xs-7">
						  <!-- Tab panes -->
						  <div class="tab-content">
							<div class="tab-pane active" id="donors2">
								<img src="http://staging-gridshub.site/sadaqat-demo/wp-content/uploads/2019/07/Create_compaign_07.png" class="img-fluid" alt="Saqaqat">
							</div>
							<div class="tab-pane" id="donors3">
								<img src="http://staging-gridshub.site/sadaqat-demo/wp-content/uploads/2019/09/tell-your-story_03-2.png" class="img-fluid" alt="Saqaqat">
							</div>
							<div class="tab-pane" id="donors4">
								<img src="http://staging-gridshub.site/sadaqat-demo/wp-content/uploads/2019/09/dollar_03_03-1.png" class="img-fluid" alt="Saqaqat">
							</div>
							<div class="tab-pane" id="donors5">
								<img src="http://staging-gridshub.site/sadaqat-demo/wp-content/uploads/2019/09/enhance_03-1.png" class="img-fluid" alt="Saqaqat">
							</div>
							<div class="tab-pane" id="donors6">
								<img src="http://staging-gridshub.site/sadaqat-demo/wp-content/uploads/2019/09/Add-giving-level_03_03.png" class="img-fluid" alt="Saqaqat">
							</div>
							<div class="tab-pane" id="donors7">
								<img src="http://staging-gridshub.site/sadaqat-demo/wp-content/uploads/2019/09/preview_03_03.png" class="img-fluid" alt="Saqaqat">
							</div>
						  </div>
						</div>

						<div class="clearfix"></div>

					  </div>

      
					
                </div>
            </div>
		</div>
	</div>
</div>

<?php get_footer(); ?>