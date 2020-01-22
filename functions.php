<?php
/* -----------------------------------------------------------------------------------
  Here we have all the custom functions for the theme
  Please be extremely cautious editing this file,
  When things go wrong, they tend to go wrong in a big way.
  You have been warned!
  ----------------------------------------------------------------------------------- */
/*
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link http://codex.wordpress.org/Theme_Development
 * @link http://codex.wordpress.org/Child_Themes
  ----------------------------------------------------------------------------------- */
$theme_info = wp_get_theme();
define('BORNTOGIVE_THEME_VERSION', ( WP_DEBUG ) ? time() : $theme_info->get('Version'));
define('BORNTOGIVE_INC_PATH', get_template_directory() . '/framework');
define('BORNTOGIVE_THEME_PATH', get_template_directory_uri());
define('BORNTOGIVE_FILEPATH', get_template_directory());

/* IMI ADMIN
================================================== */
if ( is_admin() ) {
	include_once BORNTOGIVE_INC_PATH . '/imi-admin/admin.php';
}
$opt_name = "borntogive_options";

// Remove old extensions of Redux from BornToGive Core Plugin
remove_action("redux/extensions/{$opt_name}/before", 'borntogive_register_custom_extension_loader', 0);

// Remove WPBakery redirect after activation
remove_action( 'admin_init', 'vc_page_welcome_redirect' );

if ( class_exists( 'Woocommerce' ) ) {
	// Remove Woocommerce redirect setup page
	if ( ! function_exists( 'remove_class_filters' ) ) {
		function remove_class_filters( $tag, $class, $method ) {
			$filters = $GLOBALS['wp_filter'][ $tag ];
			if ( empty ( $filters ) ) {
				return;
			}
			foreach ( $filters as $priority => $filter ) {
				foreach ( $filter as $identifier => $function ) {
					if ( is_array( $function) and is_a( $function['function'][0], $class ) and $method === $function['function'][1] ) {
						remove_filter(
							$tag,
							array ( $function['function'][0], $method ),
							$priority
						);
					}
				}
			}
		}
	}
	add_action( 'admin_init', 'disable_shop_redirect', 0 );
	function disable_shop_redirect() {
		remove_class_filters(
			'admin_init',
			'WC_Admin',
			'admin_redirects'
		);
	}
}

//Remove slider revolution Admin Notice
add_action( 'admin_init', 'borntogive_remove_revslider_notice' );
function borntogive_remove_revslider_notice() {
	update_option( 'revslider-valid-notice', false );
	update_option( 'revslider-valid', true );
}
//Set Visual Composer as theme        
add_action( 'init','borntogive_set_vc_as_theme');
function borntogive_set_vc_as_theme(){
	if( function_exists( 'vc_set_as_theme' ) ) {
		vc_set_as_theme( $notifier = false );
	}
}

/* THEME OPTIONS
================================================== */
if ( ! class_exists( 'ReduxFramework' ) ) {
	include_once BORNTOGIVE_INC_PATH . '/imi-admin/theme-options/ReduxCore/framework.php';
}
require_once BORNTOGIVE_INC_PATH . '/imi-admin/theme-options/barebones-config.php';
include_once(BORNTOGIVE_INC_PATH . '/includes.php');

/* -------------------------------------------------------------------------------------
  Load Translation Text Domain
  ----------------------------------------------------------------------------------- */
add_action('after_setup_theme', 'borntogive_theme_setup');
function borntogive_theme_setup() {
    load_theme_textdomain('borntogive', BORNTOGIVE_FILEPATH . '/language');
}
/* -------------------------------------------------------------------------------------
  Menu option
  ----------------------------------------------------------------------------------- */
function register_menu() {
    register_nav_menu('primary-menu', esc_html__('Primary Menu', 'borntogive'));
		register_nav_menu('footer-menu', esc_html__('Footer Menu', 'borntogive'));
}
add_action('init', 'register_menu');
/* -------------------------------------------------------------------------------------
  Set Max Content Width (use in conjuction with ".entry-content img" css)
  ----------------------------------------------------------------------------------- */
if (!isset($content_width))
    $content_width = 680;
/* -------------------------------------------------------------------------------------
  Configure WP2.9+ Thumbnails & gets the current post type in the WordPress Admin
  ----------------------------------------------------------------------------------- */
add_action( 'after_setup_theme', 'borntogive_theme_support_setup' );
if ( !function_exists( 'borntogive_theme_support_setup' ) ) {
	function borntogive_theme_support_setup() {
		add_theme_support('post-thumbnails');
		add_theme_support( 'title-tag' );
		add_theme_support('automatic-feed-links');
		set_post_thumbnail_size(958, 9999);
		//Mandatory
		add_image_size('borntogive-146x64','146','64',true);
		add_image_size('borntogive-600x400','600','400',true);
		add_image_size('borntogive-70x70','70','70',true);
		add_image_size('borntogive-1000x800','1000','800',true);
		add_image_size('borntogive-100x80','100','80',true);
		add_theme_support('post-formats', array('video', 'image', 'gallery', 'link'));
		add_theme_support( 'woocommerce' );
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );
	}
}
/* -------------------------------------------------------------------------------------
  Custom Gravatar Support
  ----------------------------------------------------------------------------------- */
if (!function_exists('borntogive_custom_gravatar')) {
    function borntogive_custom_gravatar($avatar_defaults) {
        $borntogive_avatar = get_template_directory_uri() . '/assets/images/img_avatar.png';
        $avatar_defaults[$borntogive_avatar] = 'Custom Gravatar (/assets/images/img_avatar.png)';
        return $avatar_defaults;
    }
    add_filter('avatar_defaults', 'borntogive_custom_gravatar');
}

/* -------------------------------------------------------------------------------------
  For Remove Dimensions from thumbnail image
  ----------------------------------------------------------------------------------- */
add_filter('post_thumbnail_html', 'borntogive_remove_thumbnail_dimensions', 10);
add_filter('image_send_to_editor', 'borntogive_remove_thumbnail_dimensions', 10);
function borntogive_remove_thumbnail_dimensions($html) {
    $html = preg_replace('/(width|height)=\"\d*\"\s/', "", $html);
    return $html;
}
/* -------------------------------------------------------------------------------------
  Excerpt More and  length
  ----------------------------------------------------------------------------------- */

if (!function_exists('borntogive_excerpt')) {
    function borntogive_excerpt($limit = 50, $closing ='...', $readmore = '') {
        return '<p>' . wp_trim_words(get_the_excerpt(), $limit).$closing. '<a href="'.get_permalink().'">'.$readmore.'</a></p>';
    }
}
/* -------------------------------------------------------------------------------------
  For Paginate
  ----------------------------------------------------------------------------------- */
if (!function_exists('borntogive_pagination')) {
    function borntogive_pagination($pages = '', $range = 4, $paged='') {
        $showitems = ($range * 2) + 1;
				$pagi = '';
		if($paged=='')
		{
			global $paged;
		}
        if (empty($paged))
            $paged = 1;
			if ($pages == '') {
            global $wp_query;
            $pages = $wp_query->max_num_pages;
            if (!$pages) {
                $pages = 1;
            }
        }
        if (1 != $pages) {
            $pagi .=  '<ul class="pagination">';
            $pagi .= '<li><a href="' . get_pagenum_link(1) . '" title="'.esc_html__('First','borntogive').'"><i class="fa fa-chevron-left"></i></a></li>';
            for ($i = 1; $i <= $pages; $i++) {
                if (1 != $pages && (!($i >= $paged + $range + 3 || $i <= $paged - $range - 3) || $pages <= $showitems )) {
                    $pagi .= ($paged == $i) ? "<li class=\"active\"><span>" . $i . "</span></li>" : "<li><a href='" . get_pagenum_link($i) . "' class=\"\">" . $i . "</a></li>";
                }
            }
           $pagi .= '<li><a href="' . get_pagenum_link($pages) . '" title="'.esc_html__('Last','borntogive').'"><i class="fa fa-chevron-right"></i></a></li>';
            $pagi .= '</ul>';
        }
				return $pagi;
    }
}
/* 	Comment Styling
  /*----------------------------------------------------------------------------------- */
if (!function_exists('borntogive_comment')) {
    function borntogive_comment($comment, $args, $depth) {
        $isByAuthor = false;
        if ($comment->comment_author_email == get_the_author_meta('email')) {
            $isByAuthor = true;
        }
        $GLOBALS['comment'] = $comment;
        ?>
        
        
        
        <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
            <div class="post-comment-block">
                <div id="comment-<?php comment_ID(); ?>">
                    <?php echo get_avatar($comment, $size = '80','', '',  array('class'=>'img-thumbnail')); ?>
                    <div class="post-comment-content">
        <?php
         echo preg_replace('/comment-reply-link/', 'comment-reply-link pull-right btn btn-default btn-xs', get_comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth'], 'reply_text' => 'REPLY'))), 1);
       echo '<h5>' . get_comment_author() .esc_html__(' says','borntogive').'</h5>';
        ?>            
                    <span class="meta-data">
            <?php
            echo get_comment_date();
            esc_html_e(' at ', 'borntogive');
            echo get_comment_time();
            ?>
                    </span>
            <?php if ($comment->comment_approved == '0') : ?>
                        <em class="moderation"><?php esc_html_e('Your comment is awaiting moderation.', 'borntogive') ?></em>
                        <br />
            <?php endif; ?>
            <div class="comment-text">
            <?php comment_text() ?>
            </div>
                </div>
            </div>
            <?php
        }
    }

// Permalink Structure Options
$options = get_option('borntogive_options');
// Event
$event_post_slug = (isset($options['event_post_slug']))?$options['event_post_slug']:'event';
if($event_post_slug == ''){
	$event_post_slug = 'event';
}
$event_post_title = (isset($options['event_post_title']))?$options['event_post_title']:'Events';
if($event_post_title == ''){
	$event_post_title = 'Events';
}
$event_post_all = (isset($options['event_post_all']))?$options['event_post_all']:'All Events';
if($event_post_all == ''){
	$event_post_all = 'All Events';
}
$event_post_categories = (isset($options['event_post_categories']))?$options['event_post_categories']:'Event Categories';
if($event_post_categories == ''){
	$event_post_categories = 'Event Categories';
}
$event_category_slug = (isset($options['event_category_slug']))?$options['event_category_slug']:'event-category';
if($event_category_slug == ''){
	$event_category_slug = 'event-category';
}
$event_post_tags = (isset($options['event_post_tags']))?$options['event_post_tags']:'Event Tags';
if($event_post_tags == ''){
	$event_post_tags = 'Event Tags';
}
$event_tag_slug = (isset($options['event_tag_slug']))?$options['event_tag_slug']:'event-tag';
if($event_tag_slug == ''){
	$event_tag_slug = 'event-tag';
}
$event_post_registerants = (isset($options['event_post_registerants']))?$options['event_post_registerants']:'Registrants';
if($event_post_registerants == ''){
	$event_post_registerants = 'Registrants';
}
$disable_event_archive = (isset($options['disable_event_archive']))?$options['disable_event_archive']:0;
$event_archive = $disable_event_archive ? false : true;
// Gallery
$gallery_post_slug = (isset($options['gallery_post_slug']))?$options['gallery_post_slug']:'gallery';
if($gallery_post_slug == ''){
	$gallery_post_slug = 'gallery';
}
$gallery_post_title = (isset($options['gallery_post_title']))?$options['gallery_post_title']:'Gallery';
if($gallery_post_title == ''){
	$gallery_post_title = 'Gallery';
}
$gallery_post_all = (isset($options['gallery_post_all']))?$options['gallery_post_all']:'Gallery Items';
if($gallery_post_all == ''){
	$gallery_post_all = 'Gallery Items';
}
$gallery_post_categories = (isset($options['gallery_post_categories']))?$options['gallery_post_categories']:'Gallery Categories';
if($gallery_post_categories == ''){
	$gallery_post_categories = 'Gallery Categories';
}
$gallery_category_slug = (isset($options['gallery_category_slug']))?$options['gallery_category_slug']:'gallery-category';
if($gallery_category_slug == ''){
	$gallery_category_slug = 'gallery-category';
}
$disable_gallery_archive = (isset($options['disable_gallery_archive']))?$options['disable_gallery_archive']:0;
$gallery_archive = $disable_gallery_archive ? false : true;
// Team
$team_post_slug = (isset($options['team_post_slug']))?$options['team_post_slug']:'team';
if($team_post_slug == ''){
	$team_post_slug = 'team';
}
$team_post_title = (isset($options['team_post_title']))?$options['team_post_title']:'Team';
if($team_post_title == ''){
	$team_post_title = 'Team';
}
$team_post_all = (isset($options['team_post_all']))?$options['team_post_all']:'Team';
if($team_post_all == ''){
	$team_post_all = 'Team';
}
$team_post_categories = (isset($options['team_post_categories']))?$options['team_post_categories']:'Team Categories';
if($team_post_categories == ''){
	$team_post_categories = 'Team Categories';
}
$team_category_slug = (isset($options['team_category_slug']))?$options['team_category_slug']:'team-category';
if($team_category_slug == ''){
	$team_category_slug = 'team-category';
}
$disable_team_archive = (isset($options['disable_team_archive']))?$options['disable_team_archive']:0;
$team_archive = $disable_team_archive ? false : true;
// Testimonials
$testimonial_post_slug = (isset($options['testimonial_post_slug']))?$options['testimonial_post_slug']:'testimonial';
if($testimonial_post_slug == ''){
	$testimonial_post_slug = 'testimonial';
}
$testimonial_post_title = (isset($options['testimonial_post_title']))?$options['testimonial_post_title']:'Testimonials';
if($testimonial_post_title == ''){
	$testimonial_post_title = 'Testimonials';
}
$testimonial_post_all = (isset($options['testimonial_post_all']))?$options['testimonial_post_all']:'Testimonials';
if($testimonial_post_all == ''){
	$testimonial_post_all = 'Testimonials';
}
$testimonial_post_categories = (isset($options['testimonial_post_categories']))?$options['testimonial_post_categories']:'Testimonial Categories';
if($testimonial_post_categories == ''){
	$testimonial_post_categories = 'Testimonial Categories';
}
$testimonial_category_slug = (isset($options['testimonial_category_slug']))?$options['testimonial_category_slug']:'testimonial-category';
if($testimonial_category_slug == ''){
	$testimonial_category_slug = 'testimonial-category';
}
$disable_testimonial_archive = (isset($options['disable_testimonial_archive']))?$options['disable_testimonial_archive']:0;
$testimonial_archive = $disable_testimonial_archive ? false : true;
// Campaigns
$campaign_post_slug = (isset($options['campaign_post_slug']))?$options['campaign_post_slug']:'campaigns';
if($campaign_post_slug == ''){
	$campaign_post_slug = 'campaigns';
}
$campaign_post_title = (isset($options['campaign_post_title']))?$options['campaign_post_title']:'Campaigns';
if($campaign_post_title == ''){
	$campaign_post_title = 'Campaigns';
}
$campaign_post_new = (isset($options['campaign_post_new']))?$options['campaign_post_new']:'Add Campaign';
if($campaign_post_new == ''){
	$campaign_post_new = 'Add Campaign';
}
$disable_campaign_archive = (isset($options['disable_campaign_archive']))?$options['disable_campaign_archive']:0;
$campaign_archive = $disable_campaign_archive ? false : true;
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if ( is_plugin_active( 'charitable/charitable.php' ) ) {
	function en_change_campaign_slug_base( $post_type_args ) {
		global $campaign_post_slug;
		$post_type_args[ 'rewrite' ][ 'slug' ] = $campaign_post_slug;
		return $post_type_args;
	}
	function en_change_campaign_menu_name( $campaign_post_title_args ) {
		global $campaign_post_title;
		$campaign_post_title_args[ 'labels' ][ 'menu_name' ] = $campaign_post_title;
		return $campaign_post_title_args;
	}
	function en_change_campaign_add_menu_name( $campaign_post_new_args ) {
		global $campaign_post_new;
		$campaign_post_new_args[ 'labels' ][ 'add_new' ] = $campaign_post_new;
		return $campaign_post_new_args;
	}
	function en_change_campaign_archive_page( $campaign_archive_page_args ) {
		global $campaign_archive;
		$campaign_archive_page_args[ 'has_archive' ] = $campaign_archive;
		return $campaign_archive_page_args;
	}
	add_filter( 'charitable_campaign_post_type', 'en_change_campaign_slug_base' );
	add_filter( 'charitable_campaign_post_type', 'en_change_campaign_menu_name' );
	add_filter( 'charitable_campaign_post_type', 'en_change_campaign_add_menu_name' );
	add_filter( 'charitable_campaign_post_type', 'en_change_campaign_archive_page' );
}

// Ajaxify header cart module
add_filter( 'woocommerce_add_to_cart_fragments', function($fragments) {
    ob_start();
    ?>
    <span class="cart-contents">
        <?php echo WC()->cart->get_cart_contents_count(); ?>
    </span>
    <?php $fragments['span.cart-contents'] = ob_get_clean();
    return $fragments;
} );

add_filter( 'woocommerce_add_to_cart_fragments', function($fragments) {
    ob_start();
    ?>
    <div class="header-quickcart">
        <?php woocommerce_mini_cart(); ?>
    </div>
    <?php $fragments['div.header-quickcart'] = ob_get_clean();
    return $fragments;
} );

				
function sadaqat_widgets_init() {
	
	register_sidebar( array(
		'name' => __( 'Footer Widget Area 1', 'borntogive' ),
		'id' => 'footer-widget-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	
	register_sidebar( array(
		'name' => __( 'Footer Widget Area 2', 'borntogive' ),
		'id' => 'footer-widget-2',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
		'name' => __( 'Footer Widget Area 3', 'borntogive' ),
		'id' => 'footer-widget-3',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	
	register_sidebar( array(
		'name' => __( 'Footer Widget Area 4', 'borntogive' ),
		'id' => 'footer-widget-4',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	
}
add_action( 'widgets_init', 'sadaqat_widgets_init' );

/**********Charity Form Customization****************/

function ed_rename_campaign_details_section_title( $fields ) {
    $fields[ 'campaign_fields' ][ 'legend' ] = __( 'Create a Campaign', 'charitable-ambassadors' );
	$fields[ 'donation_fields' ][ 'legend' ] = __( 'Team Member', 'charitable-ambassadors' );
	$fields[ 'user_fields' ][ 'legend' ] = __( 'Your Personal Information', 'charitable-ambassadors' );
    return $fields;
}
add_filter( 'charitable_campaign_submission_fields', 'ed_rename_campaign_details_section_title' );

function ed_remove_user_fields_from_campaign_submissions( $fields ) {
    unset( $fields[ 'user_fields' ][ 'legend' ] );
	unset( $fields[ 'campaign_fields' ][ 'legend' ] );
    return $fields;
}
add_filter( 'charitable_campaign_submission_fields', 'ed_remove_user_fields_from_campaign_submissions' );

/***********************/

/*function ed_charitable_add_tell_story_to_campaign_form( $fields, $form ) {
	
    $fields['tell_story_fields'] = array(
        'legend'   => __( 'Tell Your Story' ),
        'type'     => 'fieldset',
        'fields'   => array(
            'video_text' => array(
                'type'      => 'paragraph',
                'priority'  => 1,
                'fullwidth' => true,
                'content'   => __( 'Creating a personalized video on the campaign always adds the personal touch and will support in improving your chances of a successful fundraising campaign. Our recommendation is to upload the campaign video by using personalized story telling techniques of individuals and or communities that you wish to raise funds for.', 'ed-charitable' ),
            ),
        ),
        'priority' => 40,
        'page'     => 'campaign_details',
    );
    return $fields;
}
add_action( 'charitable_campaign_submission_fields', 'ed_charitable_add_tell_story_to_campaign_form', 10, 2 );*/

function ed_charitable_add_community_to_campaign_form( $fields, $form ) {
    $fields['bank_information'] = array(
        'legend'   => __( 'Bank Information' ),
        'type'     => 'fieldset',
		'priority' => 80,
		'page'     => 'campaign_details',
        'fields'   => array(
            'community_text' => array(
                'type'      => 'paragraph',
                'priority'  => 10,
                'fullwidth' => true,
                'content'   => __( 'Note: All field are required. you cannot save until all data is entered.' ),
            ),
            'currency' => array(
				'label'     => __( 'Bank account sattlement currency:', 'ed-charitable' ),
                'type'      => 'select',
                'priority'  => 11,
				'value'     => $form->get_user_value( 'currency' ),
                'fullwidth' => true,
				'options'   => array(
								'yes' => __( 'US Dollar', 'custom-namespace' ),
								'pkr'  => __( 'PKR', 'custom-namespace' ),
								'au'  => __( 'AU', 'custom-namespace' ),
								'na'  => __( 'NO', 'custom-namespace' ),
							),
            ),
			'account_name' => array(
				'label'     => __( 'Bank Account Class', 'ed-charitable' ),
                'type'      => 'text',
                'priority'  => 12,
				'value'     => $form->get_user_value( 'account_name' ),
            ),
			'bank-account-class' => array(
				'label'     => __( 'Select Account Class', 'ed-charitable' ),
                'type'      => 'select',
                'priority'  => 13,
				'value'     => $form->get_user_value( 'bank-account-class' ),
                'fullwidth' => true,
				'options'   => array(
								'none' => __( 'Select a Type', 'custom-namespace' ),
								'class1'  => __( 'Class 1', 'custom-namespace' ),
								'class2'  => __( 'Class 2', 'custom-namespace' ),
							),
            ),
			'bank-account-type' => array(
				'label'     => __( 'Select Account Type', 'ed-charitable' ),
                'type'      => 'select',
                'priority'  => 14,
				'value'     => $form->get_user_value( 'bank-account-type' ),
                'fullwidth' => true,
				'options'   => array(
								'none' => __( 'Select a Type', 'custom-namespace' ),
								'Current'  => __( 'Current', 'custom-namespace' ),
								'Saving'  => __( 'Saving', 'custom-namespace' ),
							),
            ),
			'bank-payment-method' => array(
				'label'     => __( 'Payment Method', 'ed-charitable' ),
                'type'      => 'select',
                'priority'  => 15,
				'value'     => $form->get_user_value( 'bank-payment-method' ),
                'fullwidth' => true,
				'options'   => array(
								'none' => __( 'Select a Type', 'custom-namespace' ),
								'Direct'  => __( 'Direct', 'custom-namespace' ),
								'bank-transfer'  => __( 'Bank Transfer', 'custom-namespace' ),
							),
            ),
			'bank-identifier' => array(
				'label'     => __( 'Bank Identifier, routing number, sort code, Swift or BSB', 'ed-charitable' ),
                'type'      => 'text',
                'priority'  => 16,
				'value'     => $form->get_user_value( 'bank-identifier' ),
            ),
			'account-number' => array(
				'label'     => __( 'Account Number', 'ed-charitable' ),
                'type'      => 'text',
                'priority'  => 17,
				'value'     => $form->get_user_value( 'account-number' ),
            ),
			'bank-name' => array(
				'label'     => __( 'Bank Name', 'ed-charitable' ),
                'type'      => 'text',
                'priority'  => 18,
				'value'     => $form->get_user_value( 'bank-name' ),
            ),
			'bank-country' => array(
				'label'         => __( 'Country', 'charitable-ambassadors' ), 
				'type'          => 'select',
				'options'       => charitable_get_location_helper()->get_countries(),		
				'priority'      => 19,
				'required'      => true,
				'value'         => $form->get_user_value( 'bank-country', charitable_get_option( 'country' ) ), 
				'data_type'     => 'meta' 
			),
			'bank-address' => array(
				'label'     => __( 'Street', 'charitable-ambassadors' ),
				'type'      => 'text',
				'priority'  => 20,
				'required'  => false,
				'value'     => $form->get_user_value( 'bank-address' ),
				'data_type'     => 'user',
			),
			'bank-address_2' => array(
				'label'     => __( 'Street Line 2', 'charitable-ambassadors' ),
				'type'      => 'text',
				'priority'  => 21,
				'required'  => false,
				'value'     => $form->get_user_value( 'bank-address_2' ),
				'data_type'     => 'user',
			),
			'bank-city' => array(
				'label'     => __( 'City', 'charitable-ambassadors' ),
				'type'      => 'text',
				'priority'  => 22,
				'required'  => false,
				'value'     => $form->get_user_value( 'bank-city' ),
				'data_type'     => 'user',
			),
			'bank-State' => array(
				'label'     => __( 'State/Province/Region', 'charitable-ambassadors' ),
				'type'      => 'text',
				'priority'  => 23,
				'required'  => false,
				'value'     => $form->get_user_value( 'bank-State' ),
				'data_type'     => 'user',
			),
			'bank-postalcode' => array(
				'label'     => __( 'Postcode Code', 'charitable-ambassadors' ),
				'type'      => 'text',
				'priority'  => 24,
				'required'  => false,
				'value'     => $form->get_user_value( 'bank-postalcode' ),
				'data_type'     => 'user',
			),
        ),
    );
    return $fields;
}
add_action( 'charitable_campaign_submission_fields', 'ed_charitable_add_community_to_campaign_form', 10, 2 );

/*********************/

function ed_add_campaign_funding_data1( $data, Charitable_Campaign $campaign ) {
    // Get the data that was submitted when the campaign was added.
    $submitted = $campaign->get( 'submission_data' );
    $campaign_form = new Charitable_Ambassadors_Campaign_Form();
    // Go through all user fields and add their value to the list of fields to display.
    foreach ( $campaign_form->get_campaign_fields() as $key => $field ) {
        $data[ $key ] = array(
            'label' => ( isset( $field[ 'label' ] ) ? $field[ 'label' ] : $key ),
            'value' => ( isset( $submitted[ $key ] ) ? $submitted[ $key ] : '-' )
        );
		// Replace 'my-picture-field' with the key of the picture field.
		if ( 'image' == $key && '-' != $data[ $key ]['value'] ) {
			$data[ $key ]['value'] = wp_get_attachment_link( $data[ $key ]['value'] );
		}
		
		// Replace 'campaign_category' with the key of the category/tags/terms fields.
		if ( 'campaign_category' == $key && '-' != $data[ $key ]['value'] ) {
			$data[ $key ]['value'] = implode(
				', ',
				array_map(
					function( $term_id ) {
						$term = get_term( $term_id, 'campaign_category' );
						return $term->name;
					},
					explode( ',', $data[ $key ]['value'] )
				)
			);
		}
    }
    return $data;
}
add_filter( 'charitable_ambassadors_campaign_funds_recipient_data', 'ed_add_campaign_funding_data1', 20, 2 );

/*********************/

function TargetAttachmentLink($campaign) {
    return preg_replace('/^<a([^>]+)>(.*)$/', '<a\\1 target="_blank">\\2', $campaign);
}
add_filter( 'wp_get_attachment_link', 'TargetAttachmentLink', 10, 6 );
/***************/

function ed_add_campaign_funding_data2( $data, Charitable_Campaign $campaign ) {
    // Get the data that was submitted when the campaign was added.
    $submitted = $campaign->get( 'submission_data' );
    $campaign_form = new Charitable_Ambassadors_Campaign_Form();
    // Go through all user fields and add their value to the list of fields to display.
    foreach ( $campaign_form->get_donation_options_fields() as $key => $field ) {
        $data[ $key ] = array(
            'label' => ( isset( $field[ 'label' ] ) ? $field[ 'label' ] : $key ),
            'value' => ( isset( $submitted[ $key ] ) ? $submitted[ $key ] : '-' )
        );
    }
    return $data;
}
add_filter( 'charitable_ambassadors_campaign_funds_recipient_data', 'ed_add_campaign_funding_data2', 20, 2 );

/*************************/

function ed_add_campaign_funding_data( $data, Charitable_Campaign $campaign ) {
    // Get the data that was submitted when the campaign was added.
    $submitted = $campaign->get( 'submission_data' );
    $campaign_form = new Charitable_Ambassadors_Campaign_Form();
    // Go through all user fields and add their value to the list of fields to display.
    foreach ( $campaign_form->get_user_fields() as $key => $field ) {
        $data[ $key ] = array(
            'label' => ( isset( $field[ 'label' ] ) ? $field[ 'label' ] : $key ),
            'value' => ( isset( $submitted[ $key ] ) ? $submitted[ $key ] : '-' )
        );
		
		// Replace 'my-picture-field' with the key of the picture field.
		if ( 'upload-national-id' == $key && '-' != $data[ $key ]['value'] ) {
			$data[ $key ]['value'] = wp_get_attachment_link( $data[ $key ]['value'] );
		}
		if ( 'upload-passport' == $key && '-' != $data[ $key ]['value'] ) {
			$data[ $key ]['value'] = wp_get_attachment_link( $data[ $key ]['value'] );
		}
		if ( 'charity-certificate' == $key && '-' != $data[ $key ]['value'] ) {
			$data[ $key ]['value'] = wp_get_attachment_link( $data[ $key ]['value'] );
		}
		if ( 'board-of-trustees' == $key && '-' != $data[ $key ]['value'] ) {
			$data[ $key ]['value'] = wp_get_attachment_link( $data[ $key ]['value'] );
		}
    }
    return $data;
}
add_filter( 'charitable_ambassadors_campaign_funds_recipient_data', 'ed_add_campaign_funding_data', 20, 2 );

/*****************/
function ed_charitable_ambassadors_remove_user_fields( $fields ) {
    // step1
	if ( is_page(1934) ) { 
		unset( $fields['user_fields'] );
		unset( $fields['bank_information'] );
	}
	// step2
	if ( is_page(1936) ) { 
		unset( $fields['campaign_fields'] );
		unset( $fields['donation_fields'] );
		unset( $fields['bank_information'] );
	}
	// step3
	if ( is_page(1938) ) { 
		unset( $fields['campaign_fields'] );
		unset( $fields['donation_fields'] );
		unset( $fields['bank_information'] );
	}
	/*if ( is_page(1848) ) { 
		unset( $fields['user_fields'] );
		unset( $fields['bank_information'] );
	}
	if ( is_page(1332) ) { 
		unset( $fields['campaign_fields'] );
		unset( $fields['donation_fields'] );
		unset( $fields['bank_information'] );
	}*/
    return $fields;
}
add_filter( 'charitable_campaign_submission_fields', 'ed_charitable_ambassadors_remove_user_fields' );

/*******************/

function ed_add_phone_number_field_to_campaign_submissions( $fields, Charitable_Ambassadors_Campaign_Form $form ) { 
    
    /*$fields[ 'campaign-goal2' ] = array(
		'label'         => __( 'Campaign Goal $', 'charitable-ambassadors' ),
        'type'          => 'number',		
        'priority'      => 48.5,
        'required'      => true,
        'value'         => $form->get_user_value( 'campaign-goal2' ),
        'data_type'     => 'meta' 
    );*/
	$fields['<h1>Campaign Information</h1>'] = array(
		'type'      => 'content',
		'priority'  => 45,
		'content'   => '<div class="charitable-form-header">Create a Campaign</div>',
	);
	
	/* $fields[ 'campaign_location' ] = array(
        'label'         => __( 'Campaign Location', 'charitable-ambassadors' ), 
        'type'          => 'text',		
        'priority'      => 56.5,
        'required'      => false,
        'value'         => $form->get_user_value( 'campaign_location' ),
        'data_type'     => 'meta',
'content'       => __( '<h3>Campaign Collaborators (Optional)</h3>If you would like to invite team members to co-manage the campaign, please add their respective email addresses. A maximum of three team members can manage any given campaign and they must be registered on the platform.', 'charitable-ambassadors' ),		
    ); */
	/* $fields[ 'campaign_location' ] = array(
		'label'         => __( 'Campaign Location', 'charitable-ambassadors' ),
        'type'          => 'paragraph',
        'priority'      => 56.5,
        'content'       => __( '<div class="charitable-form-field col-md-6"><label>Campaign Location</label><input class="pure-button pure-button-primary"></input><div class="result"></div></div>', 'charitable-ambassadors' )
    );
    return $fields; */
	 $fields[ 'campaign_location' ] = array(
		'label'         => __( 'Campaign Location', 'charitable-ambassadors' ),
        'type'          => 'paragraph',
        'priority'      => 56.5,
        'content'       => __( '<div class="charitable-form-field col-md-6"><label>Campaign Location</label><input name="campaign_location" id="pac-input" class="controls" type="text" placeholder="Search Location"></div><div id="map"></div>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDU5mKV4oCZcxKQfOka5Mz5LlcqS3eB2YU&libraries=places&signed_in=true&callback=initMap"></script>', 'charitable-ambassadors' )
    );
    return $fields;
	
	$fields[ 'campaign_country' ] = array(
        'label'         => __( 'Country', 'charitable-ambassadors' ), 
        'type'          => 'select',
		'options'       => charitable_get_location_helper()->get_countries(),		
        'priority'      => 58,
        'required'      => true,
        'value'         => $form->get_user_value( 'country', charitable_get_option( 'campaign_country' ) ), 
        'data_type'     => 'meta' 
    );
	
	$fields[ 'campaign_city' ] = array(
        'label'         => __( 'City', 'charitable-ambassadors' ), 
        'type'          => 'text', 
        'priority'      => 60,
		'placeholder'   => 'City',		
        'required'      => true,
        'value'         => $form->get_user_value( 'campaign_city' ), 
        'data_type'     => 'meta' 
    );
	
	$fields[ 'campaign_state' ] = array(
        'label'         => __( 'Province', 'charitable-ambassadors' ), 
        'type'          => 'text', 
        'priority'      => 62,
		'placeholder'   => 'Province',		
        'required'      => true,
        'value'         => $form->get_user_value( 'campaign_state' ), 
        'data_type'     => 'user' 
    );
	
	$fields[ '<h2>Team Member</h2>' ] = array(
        'type'          => 'paragraph',
        'priority'      => 66.5,
		'fullwidth'     => true,
		'id'      => 'Campaign Collaborators',
        'content'       => __( '<div class="col-md-12"><h3>Campaign Collaborators (Optional)</h3>If you would like to invite team members to co-manage the campaign, please add their respective email addresses. A maximum of three team members can manage any given campaign and they must be registered on the platform.</div>', 'charitable-ambassadors' )
    );
    return $fields;
}
add_filter( 'charitable_campaign_submission_campaign_fields', 'ed_add_phone_number_field_to_campaign_submissions', 10, 2 );

/******************/
function ed_charitable_make_goal_field_required( $fields ) {
    $fields['goal']['required'] = true;
	
	$fields['goal']['priority'] = 48;
	$fields['post_title']['priority'] = 50;
	$fields['description']['priority'] = 52;
	$fields['image']['priority'] = 54;
	$fields['campaign_category']['priority'] = 56;
	$fields['post_content']['priority'] = 66;
    return $fields;
}
add_filter( 'charitable_campaign_submission_campaign_fields', 'ed_charitable_make_goal_field_required' );


/*****************************/
function ed_charitable_ambassadors_set_default_campaign_goal( $fields, $form ) {
	if ( false !== $form->get_campaign() ) {
		return $fields;
	}
	if ( empty( $fields['goal']['value'] ) ) {
		$fields['goal']['value'] = 10;
	}
    return $fields;
}
add_filter( 'charitable_campaign_submission_campaign_fields', 'ed_charitable_ambassadors_set_default_campaign_goal', 10, 2 );

/*************************/

function ed_remove_categories_from_campaign_submissions( $fields ) {
    unset( $fields[ 'length' ] );
	unset( $fields[ 'campaign_tag' ] );
	//unset( $fields[ 'goal' ] );
	//step1
	/*if ( is_page(2) ) { 
		unset( $fields['campaign-video'] );
		unset( $fields['campaign_video_description'] );
	}*/
    return $fields;
}
add_filter( 'charitable_campaign_submission_campaign_fields', 'ed_remove_categories_from_campaign_submissions' );

/*************************/

function ed_change_taxonomy_fields_to_select( $fields ) {
	$fields['campaign_category']['type'] = 'select';
	$fields['campaign_category']['options'] = array( '' => 'Select category' ) + $fields['campaign_category']['options'];
	return $fields;
}
add_filter( 'charitable_campaign_submission_campaign_fields', 'ed_change_taxonomy_fields_to_select' );

/*************************/

function ed_rename_campaign_name_field_title( $fields ) {
    $fields[ 'post_title' ][ 'label' ] = __( 'Campaign Title', 'charitable-ambassadors' );
	$fields[ 'description' ][ 'label' ] = __( 'Campaign Tagline', 'charitable-ambassadors' );
	$fields[ 'goal' ][ 'label' ] = __( 'Campaign Goal $', 'charitable-ambassadors' );
	$fields[ 'image' ][ 'label' ] = __( 'Campaign Image', 'charitable-ambassadors' );
	$fields[ 'post_content' ][ 'label' ] = __( 'Campaign Goal', 'charitable-ambassadors' );
    return $fields;
}
add_filter( 'charitable_campaign_submission_campaign_fields', 'ed_rename_campaign_name_field_title' );

/*****************************/

function ed_add_phone_number_field_to_campaign_submissions_user_fields( $fields, Charitable_Ambassadors_Campaign_Form $form ) { 
    
	$fields['<h1>Tell your Story</h1>'] = array(
		'type'      => 'content',
		'priority'  => 19,
		'content'   => '<div class="charitable-form-header">Tell your Story</div><p>Creating a personalized video on the campaign always adds the personal touch and will support in improving your chances of a successful fundraising campaign. Our recommendation is to upload the campaign video by using personalized story telling techniques of individuals and or communities that you wish to raise funds for.</p>',
	);
	$fields['campaign-video'] = array(
		'label'     => __( 'Campaign Video (maximum of 3 minutes)', 'ed-charitable' ),
		'type'      => 'text', 
		'value'     => $form->get_campaign_value( 'campaign-video' ),
		'priority'  => 19.2,
		'required'  => false,
		'data_type' => 'meta',
	);
	$fields['campaign_video_description'] = array(
		'label'     => __( 'Campaign Description', 'ed-charitable' ),
		'type'      => 'editor', 
		'value'     => $form->get_campaign_value( 'campaign_video_description' ),
		'priority'  => 19.3,
		'required'  => false,
		'data_type' => 'meta',
	);
	/*$fields[''] = array(
		'type'      => 'content',
		'priority'  => 19.5,
		'content'   => '<div class="charitable-form-field charitable-submit-field"><input class="button button-secondary" type="submit" name="Save Changes" value="Save Changes"></div>',
	);*/
	$fields['<h1>Your Personal Information</h1>'] = array(
		'type'      => 'content',
		'priority'  => 19.6,
		'content'   => '<div class="charitable-form-header">Your Personal Information</div>',
	);
    $fields[ 'phone' ] = array(
        'label'         => __( 'Your Phone Number', 'charitable-ambassadors' ), 
        'type'          => 'text', 
        'priority'      => 26, 
        'required'      => false,
        'value'         => $form->get_user_value( 'phone' ), 
        'data_type'     => 'meta' 
    );
	
	// if ( isset( $_POST['birthday'] ) ) {
        // $value = $_POST['birthday'];
    // } elseif ( $form->get_campaign() ) {
        // $value = $form->get_campaign->birthday;
    // } else {
        // $value = '';
    // }
	$fields[ 'birthday' ] = array(
        'label'         => __( 'Birthday', 'charitable-ambassadors' ), 
		'type'      => 'datepicker',
        'priority'  => 28,
        'required'  => false,
        'data_type' => 'user',
		'value'         => $form->get_user_value( 'birthday' ), 
        'editable'  => false,
    );
	
	$fields[ 'passport' ] = array(
        'label'         => __( 'Your Passport Number', 'charitable-ambassadors' ), 
        'type'          => 'text', 
        'priority'      => 30, 
        'required'      => false,
        'value'         => $form->get_user_value( 'passport' ), 
        'data_type'     => 'meta' 
    );
	
	$fields[ 'idnumber' ] = array(
        'label'         => __( 'Your Personal ID Number', 'charitable-ambassadors' ), 
        'type'          => 'text', 
        'priority'      => 32, 
        'required'      => false,
        'value'         => $form->get_user_value( 'idnumber' ), 
        'data_type'     => 'meta' 
    );
	
	
	$campaign = $form->get_campaign();
    if ( $campaign ) {
        $campaign_id = $campaign->ID;
        $upload_passport  = $campaign->get( 'upload-passport' );
    }
    else {
        $campaign_id = 0;
        $upload_passport     = isset( $_POST['upload-passport'] ) ? $_POST['upload-passport'] : '';
    }
    $fields['upload-passport'] = array(
        'label'         => __( 'Upload Passport', 'charitable-ambassadors' ),
        'type'          => 'picture',
        'priority'      => 34.5,
        'required'      => false,
        'fullwidth'     => true,
        'size'          => 70,
        'uploader'      => true,
        'max_uploads'   => 1,
        'parent_id'     => $campaign_id,
        'value'         => $upload_passport,
        'data_type'     => 'meta',
        'page'          => 'campaign_details',
        'help'          => __( 'Upload Passport picture to display on your campaign page.', 'charitable-ambassadors' ),
    );
	
	$campaign = $form->get_campaign();
    if ( $campaign ) {
        $campaign_id = $campaign->ID;
        $upload_national_id     = $campaign->get( 'upload-national-id' );
    }
    else {
        $campaign_id = 0;
        $upload_national_id     = isset( $_FILES['upload-national-id'] ) ? $_FILES['upload-national-id'] : '';
    }
    $fields['upload-national-id'] = array(
        'label'         => __( 'Upload National ID', 'charitable-ambassadors' ),
        'type'          => 'picture',
        'priority'      => 36.5,
        'required'      => false,
        'fullwidth'     => true,
        'size'          => 70,
        'uploader'      => true,
        'max_uploads'   => 1,
        'parent_id'     => $campaign_id,
        'value'         => $upload_national_id,
        'data_type'     => 'meta',
        'page'          => 'campaign_details',
        'help'          => __( 'Upload Upload National ID picture to display on your campaign page.', 'charitable-ambassadors' ),
    );

	$fields[ '<h2>User Address</h2>' ] = array(
        'type'          => 'paragraph',
        'priority'      => 37,
		'fullwidth'     => true,
        'content'       => __( '<strong>Please Enter your address below.</strong>', 'charitable-ambassadors' )
    );
	
	$fields['address12'] = array(
        'label'     => __( 'Street', 'charitable-ambassadors' ),
        'type'      => 'text',
        'priority'  => 38,
        'required'  => false,
        'value'     => $form->get_user_value( 'address12' ),
		'data_type'     => 'user',
    );
    $fields['address_22'] = array(
        'label'     => __( 'Street Line 2', 'charitable-ambassadors' ),
        'type'      => 'text',
        'priority'  => 39,
        'required'  => false,
        'value'     => $form->get_user_value( 'address_22' ),
		'data_type'     => 'user',
    );
    $fields['postcode12'] = array(
        'label'     => __( 'Postcode / ZIP code', 'charitable-ambassadors' ),
        'type'      => 'text',
        'priority'  => 42,
        'required'  => false,
        'value'     => $form->get_user_value( 'postcode12' ),
		'data_type'     => 'user',
    );
	
	$campaign = $form->get_campaign();
    if ( $campaign ) {
        $campaign_id = $campaign->ID;
        $charity_certificate     = $campaign->get( 'charity-certificate' );
    }
    else {
        $campaign_id = 0;
        $charity_certificate     = isset( $_POST['charity-certificate'] ) ? $_POST['charity-certificate'] : '';
    }
    $fields['charity-certificate'] = array(
        'label'         => __( 'Registered Charity Certificate / License', 'charitable-ambassadors' ),
        'type'          => 'picture',
        'priority'      => 43.5,
        'required'      => false,
        'fullwidth'     => true,
        'size'          => 70,
        'uploader'      => true,
        'max_uploads'   => 1,
        'parent_id'     => $campaign_id,
        'value'         => $charity_certificate,
        'data_type'     => 'meta',
        'page'          => 'campaign_details',
        'help'          => __( 'Upload charity certificate picture to display on your campaign page.', 'charitable-ambassadors' ),
    );
	
	$campaign = $form->get_campaign();
    if ( $campaign ) {
        $campaign_id = $campaign->ID;
        $board_of_trustees     = $campaign->get( 'board-of-trustees' );
    }
    else {
        $campaign_id = 0;
        $board_of_trustees     = isset( $_POST['board-of-trustees'] ) ? $_POST['charity-certificate'] : '';
    }
    $fields['board-of-trustees'] = array(
        'label'         => __( 'Board of Trustees', 'charitable-ambassadors' ),
        'type'          => 'picture',
        'priority'      => 44.5,
        'required'      => false,
        'fullwidth'     => true,
        'size'          => 70,
        'uploader'      => true,
        'max_uploads'   => 1,
        'parent_id'     => $campaign_id,
        'value'         => $board_of_trustees,
        'data_type'     => 'meta',
        'page'          => 'campaign_details',
        'help'          => __( 'Upload Board of Trustees picture to display on your campaign page.', 'charitable-ambassadors' ),
    );
    return $fields;
}
add_filter( 'charitable_campaign_submission_user_fields', 'ed_add_phone_number_field_to_campaign_submissions_user_fields', 10, 2 );

/*****************/

function ed_remove_user_bio_field_from_campaign_submissions( $fields ) { 
    unset( $fields[ 'user_description' ] );
	unset( $fields[ 'organisation' ] );
	//step2
	if ( is_page(1936) ) { 
		unset( $fields['<h1>Your Personal Information</h1>'] );
		unset( $fields['user_email'] );
		unset( $fields['first_name'] );
		unset( $fields['last_name'] );
		unset( $fields['phone'] );
		unset( $fields['birthday'] );
		unset( $fields['passport'] );
		unset( $fields['idnumber'] );
		unset( $fields['upload-passport'] );
		unset( $fields['upload-national-id'] );
		unset( $fields['<h2>User Address</h2>'] );
		unset( $fields['country'] );
		unset( $fields['address12'] );
		unset( $fields['address_22'] );
		unset( $fields['city'] );
		unset( $fields['state'] );
		unset( $fields['postcode12'] );
		unset( $fields['charity-certificate'] );
		unset( $fields['board-of-trustees'] );
		
		unset( $fields['post_title'] );
		unset( $fields['description'] );
	}
	//Step3
	if ( is_page(1938) ) { 
		unset( $fields['<h1>Tell your Story</h1>'] );
		unset( $fields['campaign-video'] );
		unset( $fields['campaign_video_description'] );
	}
	
    return $fields;
}
add_filter( 'charitable_campaign_submission_user_fields', 'ed_remove_user_bio_field_from_campaign_submissions' );

/************************/

function ed_charitable_make_goal_field_user( $fields ) {
	
	
	$fields['user_email']['priority'] = 20;
	$fields['first_name']['priority'] = 22;
	$fields['last_name']['priority'] = 24;
	$fields['country']['priority'] = 37.5;
	$fields['city']['priority'] = 40;
	$fields['state']['priority'] = 41;
    return $fields;
}
add_filter( 'charitable_campaign_submission_user_fields', 'ed_charitable_make_goal_field_user' );

/*******************/

function ed_add_team_field_to_campaign_submissions( $fields, Charitable_Ambassadors_Campaign_Form $form ) { 
    
	$fields['team-name1'] = array(
        'label'     => __( 'Name', 'charitable' ),
        'type'      => 'text',
        'priority'  => 11,
        'required'  => false,
        'value'     => $form->get_user_value( 'team-name1' ),
		'data_type'     => 'user' 
    );
	
	$fields['team-email1'] = array(
        'label'     => __( 'Email', 'charitable' ),
        'type'      => 'email',
        'priority'  => 12,
        'required'  => false,
        'value'     => $form->get_user_value( 'team-email1' ),
		'data_type'     => 'user' 
    );
	$fields['team-name2'] = array(
        'label'     => __( 'Name', 'charitable' ),
        'type'      => 'text',
        'priority'  => 13,
        'required'  => false,
        'value'     => $form->get_user_value( 'team-name2' ),
		'data_type'     => 'user' 
    );
	
	$fields['team-email2'] = array(
        'label'     => __( 'Email', 'charitable' ),
        'type'      => 'email',
        'priority'  => 14,
        'required'  => false,
        'value'     => $form->get_user_value( 'team-email2' ),
		'data_type'     => 'user' 
    );
	$fields['team-name3'] = array(
        'label'     => __( 'Name', 'charitable' ),
        'type'      => 'text',
        'priority'  => 15,
        'required'  => false,
        'value'     => $form->get_user_value( 'team-name3' ),
		'data_type'     => 'user' 
    );
	
	$fields['team-email3'] = array(
        'label'     => __( 'Email', 'charitable' ),
        'type'      => 'email',
        'priority'  => 16,
        'required'  => false,
        'value'     => $form->get_user_value( 'team-email3' ),
		'data_type'     => 'user' 
    );
	$fields[ 'captcha' ] = array(
        'type'      => 'paragraph',
        'priority'      => 17,
		'fullwidth'     => true,
        'content'       => __( '<div class="col-md-6"><label><strong>Enter Captcha:</strong></label><br />
								<input id="text-captcha" type="text" name="captcha" required="1"/>
								<p><br />
								<img src="https://www.allphptricks.com/demo/2018/may/create-simple-captcha-script/captcha.php?rand=rand();" id="captcha_image">
								</p>
								<p>Cant read the image?
								<a id="text-captcha-link" href="javascript: refreshCaptcha();">click here</a>
								to refresh</p></div>', 'charitable-ambassadors' )
    );
	/*$fields[''] = array(
		'type'      => 'content',
		'priority'  => 17,
		'content'   => '<div class="charitable-form-field charitable-submit-field"><input class="button button-secondary" type="submit" name="Save Changes" value="Save Changes"></div>',
	);*/
    return $fields;
}
add_filter( 'charitable_campaign_submission_donation_options_fields', 'ed_add_team_field_to_campaign_submissions', 10, 2 );

/**************************/
function ed_remove_donation_field_from_campaign_submissions( $fields ) { 
    unset( $fields[ 'donation_options' ] );
	unset( $fields[ 'suggested_donations' ] );
	unset( $fields[ 'allow_custom_donations' ] );
    return $fields;
}
add_filter( 'charitable_campaign_submission_donation_options_fields', 'ed_remove_donation_field_from_campaign_submissions' );


function wpb_widgets_init() {
 
    register_sidebar( array(
        'name'          => 'Custom Donar Widget Area',
        'id'            => 'custom-donar-widget',
		'description' => __( 'Appears on posts and pages except the optional Front Page template, which has its own widgets' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="donar-title">',
        'after_title'   => '</h2>',
    ) );
 
}
add_action( 'widgets_init', 'wpb_widgets_init' );

/***************Get campaign*************/


add_filter("wcra_campaignpost_callback" , "wcra_campaignpost_callback_handler");
function wcra_campaignpost_callback_handler($param){
    $posts = get_posts( array(
            'paged' => $paged,
            'post__not_in' => get_option( 'sticky_posts' ),
            'posts_per_page' => -1,            
            'post_type' => array( 'campaign' ) // This is the line that allows to fetch multiple post types. 
        )
    ); 
	
    // Loop through the posts and push the desired data to the array we've initialized earlier in the form of an object
    foreach( $posts as $post ) {
        $id = $post->ID; 
        $post_thumbnail = ( has_post_thumbnail( $id ) ) ? get_the_post_thumbnail_url( $id ) : null;
		$categories = get_terms( 'campaign_category', array( 'hide_empty' => true, 'fields' => 'id=>name' ) );
		$tags = get_terms( 'campaign_tag', array( 'hide_empty' => false, 'fields' => 'id=>name' ) );

        $posts_data[] = (object) array( 
            'id' => $id, 
            'slug' => $post->post_name, 
            'type' => $post->post_type,
            'Campaign_title' => $post->post_title,
			'Creator Name' => $post->post_author,
			'campaign date' => $post->post_date,
			'campaign Goal' => $post->_campaign_goal,
			'campaign End Date' => $post->_campaign_end_date,
			'Campaign Category' => $categories,
			'Campaign Image' => $post_thumbnail,
			'campaign Content' => $post->post_content,
        );
    }                  
    return $posts_data;                   
}

/*********Donor list***************/
add_filter("wcra_donorlist_callback" , "wcra_donorlist_callback_handler");
function wcra_donorlist_callback_handler($param){
$donations = get_posts( array(
            'paged' => $paged,
            'post__not_in' => get_option( 'sticky_posts' ),
            'posts_per_page' => -1,            
            'post_type' => array( 'donation' ) // This is the line that allows to fetch multiple post types. 
        )
    ); 

	$donations = charitable_get_table( 'campaign_donations' )->get_donations_report( array(
		'campaign_id' => $campaigns->posts,
		'orderby'     => 'date',
		'order'       => 'DESC',
	) );
	
    // Loop through the posts and push the desired data to the array we've initialized earlier in the form of an object
    foreach ( $donations as $record ) {
        $donation = charitable_get_donation( $record->donation_id );
		$donor       = $donation->get_donor();

        $posts_data1[] = (object) array( 
            'donor_date' => $donation->get_date( 'l, F j, Y' ),
            'donor_name' => $donor->get_name(),
            'donor_campaign' => $record->campaign_name,
			'donor_amount' => $record->amount,
			'donor_status' => $donation->get_status_label(),
        );
    }                  
    return $posts_data1;                   
}


/********************/

include_once(BORNTOGIVE_INC_PATH . '/donor-api.php');
include_once(BORNTOGIVE_INC_PATH . '/compaign-login-api.php');
include_once(BORNTOGIVE_INC_PATH . '/login-api.php');
include_once(BORNTOGIVE_INC_PATH . '/donate-api.php');
include_once(BORNTOGIVE_INC_PATH . '/campaign-charts.php');

/*************/

function changeRestPrefix() {
    return "api"; 
}
add_filter( 'rest_url_prefix', 'changeRestPrefix');


//***************************//

function remove_menus1(){
// get current login user's role
$roles = wp_get_current_user()->roles;
 
// test role
if( !in_array('campaign_manager',$roles)){
return;
}
 
//remove menu from site backend.
//remove_menu_page( 'index.php' ); //Dashboard
remove_menu_page( 'edit.php' ); //Posts
remove_menu_page( 'upload.php' ); //Media
remove_menu_page( 'edit-comments.php' ); //Comments
remove_menu_page( 'themes.php' ); //Appearance
remove_menu_page( 'plugins.php' ); //Plugins
remove_menu_page( 'users.php' ); //Users
remove_menu_page( 'tools.php' ); //Tools
remove_menu_page( 'options-general.php' ); //Settings
remove_menu_page( 'edit.php?post_type=page' ); //Pages

remove_menu_page('edit.php?post_type=gallery'); // Custom post type 2
remove_menu_page('edit.php?post_type=clients'); // Custom post type 2
remove_menu_page('edit.php?post_type=team'); // Custom post type 2
remove_menu_page('edit.php?post_type=event'); // Event
remove_menu_page('edit.php?post_type=testimonial'); // Testimonial
remove_menu_page('edit.php?post_type=testimonials'); // Testimonials
remove_menu_page('wpcf7'); // Contact form 7
remove_menu_page('vc-welcome'); // Contact form 7
remove_menu_page('admin.php?page=evc-admin-about-page'); // Contact form 7
}
add_action( 'admin_menu', 'remove_menus1' , 100 );


/******************/

function remove_dashboard_widgets() {
    global $wp_meta_boxes;
	
	// get current login user's role
	$roles = wp_get_current_user()->roles;
	 
	// test role
	if( !in_array('campaign_manager',$roles)){
	return;
	}
 
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_drafts']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);
}
 
add_action('wp_dashboard_setup', 'remove_dashboard_widgets' );

/******************/

function remove_comments(){
        global $wp_admin_bar;
		// get current login user's role
			$roles = wp_get_current_user()->roles;
			 
			// test role
			if( !in_array('campaign_manager',$roles)){
			return;
			}
        $wp_admin_bar->remove_menu('comments');
		$wp_admin_bar->remove_menu('new-content');
}
add_action( 'wp_before_admin_bar_render', 'remove_comments' );

/**************/
add_action('admin_head','admin_css'); //using action hook to modify css
function admin_css()
{
	if(current_user_can('campaign_manager')) //check the current user role 
	{
		echo '<style>';
		echo '.notice{display:none}';
		echo '#toplevel_page_charitable .wp-first-item{display:none}';
		echo '#toplevel_page_charitable ul li:last-child{display:none}';
		echo '#toplevel_page_evc-admin-menu-page{display:none}';
		echo '.page-title-action {display:none}';
		echo '.inline-edit-status {display:none}';
		echo '.update-nag {display:none}';
		echo '#favorite-actions, .add-new-h2, .tablenav , .page-title-action { display:none; }';
		echo '.row-actions .inline, .row-actions .trash, .row-actions .duplicate, .row-actions .view { display:none; }';
		echo '#submitdiv{display:none;}';
		echo '</style>';
	}
}

/* add_filter( 'post_row_actions', 'remove_row_actions', 10, 1 );
function remove_row_actions( $actions )
{
    if( get_post_type() === 'post' && )
        unset( $actions['edit'] );
        unset( $actions['view'] );
        unset( $actions['trash'] );
        unset( $actions['duplicate'] );
        unset( $actions['inline hide-if-no-js'] );
    return $actions;
} */
/******************/

function remove_menu_items(){
	// get current login user's role
$roles = wp_get_current_user()->roles;
 
// test role
if( !in_array('campaign_manager',$roles)){
return;
}
   remove_menu_page( 'themes.php' );
   remove_submenu_page( 'charitable','post-new.php?post_type=campaign'); // Custom post type 2' );
   //remove_submenu_page( 'charitable','edit.php?post_type=donation'); // Custom post type 2' );
   remove_submenu_page( 'profile.php','gdpr-profile' );
   remove_submenu_page( 'charitable', 'edit-tags.php?taxonomy=campaign_category&post_type=campaign' );
   remove_submenu_page( 'charitable', 'edit-tags.php?taxonomy=campaign_tag&post_type=campaign' );
}

add_action( 'admin_menu', 'remove_menu_items', 999 );

/* function disable_new_posts() {
    // Hide sidebar link
    global $submenu;
    unset($submenu['post-new.php?post_type=campaign'][10]);

    // Hide link on listing page
    if (isset($_GET['post_type']) && $_GET['post_type'] == 'campaign') {
        echo '<style type="text/css">
        #favorite-actions, .add-new-h2, .tablenav , .page-title-action { display:none; }
        </style>';
    }
}
add_action('admin_menu', 'disable_new_posts'); */
/****************/

function alter_the_edit_screen_query( $wp_query ) {
    if ( strpos( $_SERVER[ 'REQUEST_URI' ], '/wp-admin/edit.php' ) !== false ) {
        if ( !current_user_can( 'activate_plugins' ) )  {
add_action( 'views_edit-post', 'remove_items_from_edit' );
            global $current_user;
            $wp_query->set( 'author', $current_user->id );
        }
    }
}

add_filter('parse_query', 'alter_the_edit_screen_query' );

function remove_items_from_edit( $views ) {
    unset($views['all']);
    unset($views['publish']);
    unset($views['trash']);
    unset($views['draft']);
    unset($views['pending']);
    return $views;
}

function charitable_notify_new_user($user_id, $values) {
	wp_new_user_notification( $user_id, null, 'admin' );
}
add_action('charitable_after_insert_user', 'charitable_notify_new_user', 10, 2);
function ed_charitable_set_user_registration_role( $values ) {
    if ( array_key_exists( 'role', $values ) ) {
        return $values;
    }

    $values['role'] = 'campaign_manager';
    return $values;
}
add_filter( 'charitable_registration_values', 'ed_charitable_set_user_registration_role' );

/* add_action( 'template_redirect', 'redirect_to_home_page' );
function redirect_to_home_page() {
	
    if ( is_page('charity-form-step-3') ) {
		wp_redirect( home_url(), 301 );
		exit;
    }
	if ( is_page('charity-form-step-2') ) {
     wp_redirect( home_url(), 301 );
      exit;
    }
} */

 /* function redirect_to_home() {
  if( is_page('1936')) {
    wp_redirect(home_url());
    exit();
  }
}
add_action('template_redirect', 'redirect_to_home');

function redirect_to_home1() {
  if( is_page('1938')) {
    wp_redirect(home_url());
    exit();
  }
}
add_action('template_redirect', 'redirect_to_home1'); 
 */
add_filter('charitable_user_registration_fields',
	function( $fields ) {
		/* Add a text field. */
		$fields['text_captcha'] = [
			'type'      => 'paragraph',
			'label'     => 'Enter Captcha:',
			'priority'  => 10,
			'required'  => false,
			'content'       => __( '<label><strong>Enter Captcha:</strong></label><br />
								<input id="text-captcha" type="text" name="captcha" required="1"/>
								<p><br />
								<img src="https://www.allphptricks.com/demo/2018/may/create-simple-captcha-script/captcha.php?rand=rand();" id="captcha_image">
								</p>
								<p>Cant read the image?
								<a href="javascript: refreshCaptcha();">click here</a>
								to refresh</p>', 'charitable-ambassadors' ),
		];
		return $fields;
	}
);


/* $fields[ 'captcha' ] = array(
        'type'      => 'paragraph',
        'priority'      => 17,
		'fullwidth'     => true,
        'content'       => __( '<div class="col-md-12"><h4>Resolve the Captcha below :</h4>
								<label id="question"></label>
								<input id="ans" type="text">
								<div id="message">Please verify Captcha</div>
								<div id="success">Validation complete</div>
								<div id="fail">Validation failed</div></div>', 'charitable-ambassadors' )
    ); */
	

// define WC APP Keys.
define( 'WP_CONSUMER_KEY', 'ck_9d2c7a515f1af9ff9a2fe0f58e9509884c9a0961' );
define( 'WP_CONSUMER_SECRET', 'cs_93c59e0b31a815a1dcc3e553a3e89a33ab369c1d' );
 
/**
 * Validate Authorization header for an API calls.
 */
function validate_authorization_header() {
 
    $headers = apache_request_headers();
    if ( isset( $headers['Authorization'] ) ) {
 
        $wc_header = 'Basic ' . base64_encode( WP_CONSUMER_KEY . ':' . WP_CONSUMER_SECRET );
        if ( $headers['Authorization'] == $wc_header ) {
            return true;
        }
    }
    return false;
}

/************************/

add_action( 'admin_menu', 'my_admin_menu' );
function my_admin_menu() {
	add_menu_page( 'Api Documentaion', 'Api Documentaion', 'manage_options', 'api-documentaion', 'api_admin_page', 'dashicons-external', 3  );
}

function api_admin_page() {
	echo '<div class="wrap about-wrap charitable-wrap"><h1 class="wp-heading-inline"><strong>Api Documentation</strong></h1><br>
	<p><a target="_blank" href="https://documenter.getpostman.com/view/8290015/SW14Uc1e?version=latest">Click To View Documentaion of Sadaqat Api.</a></p>
	</div>';
}


/**************************/
class Campaign_React extends WP_REST_Controller {
	private $api_namespace;
	private $base;
	//private $api_version;
	private $required_capability;
	
	public function __construct() {
		$this->api_namespace = 'custom-api';
		$this->base = 'campaign-native';
		//$this->api_version = '1';
		$this->required_capability = 'read';  // Minimum capability to use the endpoint
		
		$this->init();
	}
	
	
	public function register_routes() {
		$namespace = $this->api_namespace;
		
		register_rest_route( $namespace, '/' . $this->base, array(
			array( 'methods' => WP_REST_Server::READABLE, 'callback' => array( $this, 'update_campaign_info2' ), ),
		)  );
	}
	// Register our REST Server
	public function init(){
		add_action( 'rest_api_init', array( $this, 'register_routes' ) );
	}
	
	
	public function update_campaign_info2( WP_REST_Request $request ){
		

		$posts = get_posts( array(
				//'post__not_in' => get_option( 'sticky_posts' ),
				//'post_status' => array( 'pending', 'draft', 'future' ),
				'post_status' => 'any',
				'posts_per_page' => -1,            
				'post_type' => array( 'campaign' ) // This is the line that allows to fetch multiple post types. 
			)
		); 
		$donations = get_posts( array(
				//'post__not_in' => get_option( 'sticky_posts' ),
				'posts_per_page' => -1,            
				'post_type' => array( 'donation' ) // This is the line that allows to fetch multiple post types. 
			)
		); 

		$donations = charitable_get_table( 'campaign_donations' )->get_donations_report( array(
			'campaign_id' => $campaigns->posts,
			'orderby'     => 'date',
			'order'       => 'DESC',
		) );              
							 
		// Loop through the posts and push the desired data to the array we've initialized earlier in the form of an object
		foreach( $posts as $post ) {
			$id = $post->ID; 
			$post_thumbnail = ( has_post_thumbnail( $id ) ) ? get_the_post_thumbnail_url( $id ) : null;
			$term_list = wp_get_post_terms($post->ID, 'campaign_category', array("fields" => "names"));
			$campaign = new Charitable_Campaign( get_the_ID() );
			$my_meta = get_post_meta( $post->ID, '_campaign_campaign_location' );
			$meta = get_post_meta($id);
			$post_author_id = get_post_field( 'post_author', $id ); 
			$display_name = get_the_author_meta( 'display_name' , $post_author_id );
		
			$posts_data[] = (object) array( 
				'id' => $id,
				'campaign_title' => $post->post_title,
				'slug' => $post->post_name, 
				'type' => $post->post_type,
				'campaign_status' => $post->post_status,
				'campaign_country' => $my_meta,
				'authorname' => $display_name,
				'creator_name' => $display_name,
				'campaign_date' => $post->post_date,
				'campaign_goal' => $post->_campaign_goal,
				'campaign_end_date' => $post->_campaign_end_date,
				'campaign_category' => $term_list,
				'location' => 'Nepal',
				'supporters' => '3',
				'campaign_image' => $post_thumbnail,
				'campaign_content' => wp_filter_nohtml_kses($post->post_content),
				'allmeta' => $meta,
			);
		}
		return $posts_data;
		} 
}
 
$lps_rest_server = new Campaign_React();

/**************************/
class Donorlist_React extends WP_REST_Controller {
	private $api_namespace;
	private $base;
	//private $api_version;
	private $required_capability;
	
	public function __construct() {
		$this->api_namespace = 'custom-api';
		$this->base = 'donorlist-native';
		//$this->api_version = '1';
		$this->required_capability = 'read';  // Minimum capability to use the endpoint
		
		$this->init();
	}
	
	
	public function register_routes() {
		$namespace = $this->api_namespace;
		
		register_rest_route( $namespace, '/' . $this->base, array(
			array( 'methods' => WP_REST_Server::READABLE, 'callback' => array( $this, 'update_campaign_info2' ), ),
		)  );
	}
	// Register our REST Server
	public function init(){
		add_action( 'rest_api_init', array( $this, 'register_routes' ) );
	}
	
	
	public function update_campaign_info2( WP_REST_Request $request ){
		
		$donations = get_posts( array(
		'paged' => $paged,
		'post__not_in' => get_option( 'sticky_posts' ),
		'posts_per_page' => -1,            
		'post_type' => array( 'donation' ) // This is the line that allows to fetch multiple post types. 
		)
		); 

		$donations = charitable_get_table( 'campaign_donations' )->get_donations_report( array(
			'campaign_id' => $campaigns->posts,
			'orderby'     => 'date',
			'order'       => 'DESC',
		) );        
							 
		// Loop through the posts and push the desired data to the array we've initialized earlier in the form of an object
		foreach ( $donations as $record ) {
			$donation = charitable_get_donation( $record->donation_id );
			$donor       = $donation->get_donor();

			$posts_data[] = (object) array( 
				'donor_date' => time_elapsed_string($donation->get_date()),
				'donor_name' => $donor->get_name(),
				'donor_campaign' => wp_filter_nohtml_kses($record->campaign_name),
				'donor_amount' => number_format($record->amount),
				'donor_status' => $donation->get_status_label(),
				'donor_location' => $donor->get_location(),
			);
		}   
		return $posts_data;
}
}
$lps_rest_server = new Donorlist_React();

function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}
?>