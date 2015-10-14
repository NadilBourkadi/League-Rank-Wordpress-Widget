<?php
/*
Plugin Name: Riot API Test
Plugin URI: nadil.co.uk
Description: Testing the Riot API
Version: 1.0
Author: Nadil Bourkadi
Author URI: nadil.co.uk
License: GPL2
*/
// Creating the widget 
include("riot-api-key.php");


function summoner_name($summoner, $server) {

global $riot_api_key;
$summoner_encoded = rawurlencode($summoner);
$summoner_lower = strtolower($summoner_enc);
$curl = curl_init('https://' . $server . '.api.pvp.net/api/lol/' . $server . '/v1.4/summoner/by-name/' . $summoner . '?api_key=' . $riot_api_key);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$result = curl_exec($curl);
curl_close($curl);
return $result;
}



class riot_api_test_widget extends WP_Widget {

function __construct() {
parent::__construct(
// Base ID of your widget
'riot_api_test_widget', 

// Widget name will appear in UI
__('Riot API Test', 'riot_api_test_widget_domain'), 

// Widget description
array( 'description' => __( 'Testing Riot API Key', 'riot_api_test_widget_domain' ), ) 
);
}

// Creating widget front-end
// This is where the action happens
public function widget( $args, $instance ) {
$title = apply_filters( 'widget_title', $instance['title'] );
// before and after widget arguments are defined by themes
echo $args['before_widget'];
if ( ! empty( $title ) )
echo $args['before_title'] . $title . $args['after_title'];




// This is where you run the code and display the output
echo __( 'Hello, World!', 'riot_api_test_widget_domain' );
$summoner_info = summoner_name($summoner, $server);
$summoner_info_array = json_decode($summoner_info, true);

$summoner = 'Vadilli';
$server = 'euw';

print_r(summoner_name($summoner, $server));

echo $riot_api_key;



echo $args['after_widget'];
}
		
// Widget Backend 
public function form( $instance ) {
if ( isset( $instance[ 'title' ] ) ) {
$title = $instance[ 'title' ];
}
else {
$title = __( 'New title', 'riot_api_test_widget_domain' );
}


// Widget admin form
?>
<p>
<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
</p>
<?php 
}
	
// Updating widget replacing old instances with new
public function update( $new_instance, $old_instance ) {
$instance = array();
$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
return $instance;
}








} // Class riot_api_test_widget ends here


// Register and load the widget
function riot_api_test_load_widget() {
	register_widget( 'riot_api_test_widget' );
}
add_action( 'widgets_init', 'riot_api_test_load_widget' );