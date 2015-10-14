<?php
/*
Plugin Name: League of Legends Ranked League Widget
Plugin URI: nadil.co.uk
Description: Displays League of Legends ranked league given a Summoner Name and Server
Version: 1.0
Author: Nadil Bourkadi
Author URI: nadil.co.uk
License: GPL2
*/

// file only contains riot api key in $riot_api_key variable
include("riot-api-key.php");
include("api-functions.php");


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

//grabbing instance variables entered in backend
$title = apply_filters( 'widget_title', $instance['title'] );
$summonername = $instance['summonername'];
$server = $instance['server'];

echo $args['before_widget'];
if ( ! empty( $title ) )
echo $args['before_title'] . $title . $args['after_title'];

// summoner_id_from_name uses the provided summoner name and server to make request and grab ID
// summoner_by_id_array makes a request using this ID and saves it to the $league variable for display
$summoner_id = summoner_id_from_name($summonername, $server);
$league = summoner_by_id_array($summoner_id, $server);

// print_r($league[$summoner_id][0]);
echo('<p>');
echo('<strong>Summoner Name:</strong> ' . $league[$summoner_id][0][entries][0][playerOrTeamName] . '<br>');
echo('<strong>League:</strong> ' . $league[$summoner_id][0][tier] . ' ' . $league[$summoner_id][0][entries][0][division] . '<br>');
echo('<strong>Points:</strong> ' . $league[$summoner_id][0][entries][0][leaguePoints] . ' </br>');
echo('<strong>Win/Loss:</strong> ' . $league[$summoner_id][0][entries][0][wins] . ' / ' . $league[$summoner_id][0][entries][0][losses]);
echo('</p>');

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

if ( isset( $instance[ 'summonername' ] ) ) {
$summonername = $instance[ 'summonername' ];
}
else {
$summonername = __( 'New summonername', 'riot_api_test_widget_domain' );
}

if ( isset( $instance[ 'server' ] ) ) {
$server = $instance[ 'server' ];
}
else {
$server = __( 'New server', 'riot_api_test_widget_domain' );
}

// Widget admin form
?>
<p>
<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />

<label for="<?php echo $this->get_field_id( 'summonername' ); ?>"><?php _e( 'Summoner Name:' ); ?></label> 
<input class="widefat" id="<?php echo $this->get_field_id( 'summonername' ); ?>" name="<?php echo $this->get_field_name( 'summonername' ); ?>" type="text" value="<?php echo esc_attr( $summonername ); ?>" />

<label for="<?php echo $this->get_field_id( 'server' ); ?>"><?php _e( 'Server:' ); ?></label> 
<select id="<?php echo $this->get_field_id('server'); ?>" name="<?php echo $this->get_field_name('server'); ?>" class="widefat" style="width:100%;">
    <option <?php selected( $instance['server'], 'euw'); ?> value="euw">EUW</option>
    <option <?php selected( $instance['server'], 'na'); ?> value="na">NA</option>   
</select>

<?php 
}
	
// Updating widget replacing old instances with new
public function update( $new_instance, $old_instance ) {
$instance = array();
$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
$instance['summonername'] = ( ! empty( $new_instance['summonername'] ) ) ? strip_tags( $new_instance['summonername'] ) : '';
$instance['server'] = ( ! empty( $new_instance['server'] ) ) ? strip_tags( $new_instance['server'] ) : '';
return $instance;
}


} // Class riot_api_test_widget ends here


// Register and load the widget
function riot_api_test_load_widget() {
	register_widget( 'riot_api_test_widget' );
}
add_action( 'widgets_init', 'riot_api_test_load_widget' );