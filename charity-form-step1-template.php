<?php
/**
 * Template Name: Charity Form Step 1
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

	.charitable-submit-field .button{
		
	}

	.button:hover:enabled{
		
	}

	.charitable-submit-field .button:disabled{
		opacity: .5;
		cursor: default;
	} 
	.login-submit .button:disabled{
		opacity: 1;
		cursor: pointer;
	} 
</style>

<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600&display=swap" rel="stylesheet">
<div id="main-container">
  	<div class="content">
   		<div class="container">
       		<div class="row">
            	<div id="content-col">
						<div class="col-md-2"></div>
						<div class="col-md-8">
							<?php echo do_shortcode("[charitable_submit_campaign]"); ?>
						</div>
						<div class="col-md-2"></div>
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
<script type="text/javascript">
    $(function() {
        $("input[type=submit]").val("Submit");
    });
</script>
<script>
$(document).ready(function(){
    $("#charitable_field_goal").addClass("col-md-6");
	$("#charitable_field_post_title").addClass("col-md-6");
	$("#charitable_field_description").addClass("col-md-12");
	$("#charitable_field_image").addClass("col-md-12");
	$("#charitable_field_campaign_category").addClass("col-md-6");
	$("#charitable_field_campaign_location").addClass("col-md-6");
	$("#charitable_field_campaign_country").addClass("col-md-6");
	$("#charitable_field_campaign_state").addClass("col-md-12");
	$("#charitable_field_campaign_city").addClass("col-md-6");
	$("#charitable_field_post_content").addClass("col-md-12");
	//$(".charitable-form-content").addClass("row");
	
	$("#charitable_field_team-name1").addClass("col-md-6");
	$("#charitable_field_team-email1").addClass("col-md-6");
	$("#charitable_field_team-name2").addClass("col-md-6");
	$("#charitable_field_team-email2").addClass("col-md-6");
	$("#charitable_field_team-name3").addClass("col-md-6");
	$("#charitable_field_team-email3").addClass("col-md-6");
	
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
<script>
// Note: This example requires that you consent to location sharing when
      // prompted by your browser. If you see the error "The Geolocation service
      // failed.", it means you probably did not give permission for the browser to
      // locate you.

      function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: -34.397, lng: 150.644},
          zoom: 6,
		  mapTypeId: google.maps.MapTypeId.ROADMAP
        });
        var infoWindow = new google.maps.InfoWindow({map: map});

        // Try HTML5 geolocation.
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var pos = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };

            infoWindow.setPosition(pos);
            infoWindow.setContent('Location found.');
            map.setCenter(pos);
          }, function() {
            handleLocationError(true, infoWindow, map.getCenter());
          });
        } else {
          // Browser doesn't support Geolocation
          handleLocationError(false, infoWindow, map.getCenter());
        }
		
		// Create the search box and link it to the UI element.
  var input = document.getElementById('pac-input');
  var searchBox = new google.maps.places.SearchBox(input);
  map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

  // Bias the SearchBox results towards current map's viewport.
  map.addListener('bounds_changed', function() {
    searchBox.setBounds(map.getBounds());
  });

  var markers = [];
  // Listen for the event fired when the user selects a prediction and retrieve
  // more details for that place.
  searchBox.addListener('places_changed', function() {
    var places = searchBox.getPlaces();

    if (places.length == 0) {
      return;
    }

    // Clear out the old markers.
    markers.forEach(function(marker) {
      marker.setMap(null);
    });
    markers = [];

    // For each place, get the icon, name and location.
    var bounds = new google.maps.LatLngBounds();
    places.forEach(function(place) {
      var icon = {
        url: place.icon,
        size: new google.maps.Size(71, 71),
        origin: new google.maps.Point(0, 0),
        anchor: new google.maps.Point(17, 34),
        scaledSize: new google.maps.Size(25, 25)
      };

      // Create a marker for each place.
      markers.push(new google.maps.Marker({
        map: map,
        icon: icon,
        title: place.name,
        position: place.geometry.location
      }));

      if (place.geometry.viewport) {
        // Only geocodes have viewport.
        bounds.union(place.geometry.viewport);
      } else {
        bounds.extend(place.geometry.location);
      }
    });
    map.fitBounds(bounds);
  });
      }

      function handleLocationError(browserHasGeolocation, infoWindow, pos) {
        infoWindow.setPosition(pos);
        infoWindow.setContent(browserHasGeolocation ?
                              'Error: The Geolocation service failed.' :
                              'Error: Your browser doesn\'t support geolocation.');
      }
</script>
<?php get_footer(); ?>