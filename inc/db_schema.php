<?php
global $mylocation_db_version;
$mylocation_db_version = "1.0";

function create_my_location_db() {
    global $wpdb;
    global $mylocation_db_version;

    $id = "1";
    $time = "0000-00-00 00:00:00";
    $longitude = "00.000";
    $latitude = "00.000";

    $table_name = $wpdb->prefix . "mylocation";

    $sql = "CREATE TABLE $table_name (
      id int(9) NOT NULL AUTO_INCREMENT,
      time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
      longitude VARCHAR (50) DEFAULT '' NOT NULL,
      latitude VARCHAR (50) DEFAULT '' NOT NULL,
      UNIQUE KEY id (id)
    ); ";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );

    //add_option( "mylocation_db_version", "1.0");
    //add_option( "mylocation_db_version", $mylocation_db_version );
}
add_action('init', 'create_my_location_db', 1);

// register activation hook
register_activation_hook( __FILE__, 'create_my_location_db' );

/*
// populate with some default data || this is the data will be altered through out the map updates
function populate_my_location_db() {
    global $wpdb;
    $id = "1";
    $time = "0000-00-00 00:00:00";
    $longitude = "00.000";
    $latitude = "0.000";

    $table_name = $wpdb->prefix . "mylocation";

    if($wpdb->get_var("SHOW TABLES LIKE '$table_name'  ") != $table_name){
        $rows_affected = $wpdb->insert(
            $table_name, array(
                'id'=> 1,
                'time' => current_time('mysql'),
                'longitude' => $longitude,
                'latitude' => $latitude
            )
        );
    }
}
add_action('init', 'populate_my_location_db');
// register activation hook
//register_activation_hook( __FILE__, 'populate_my_location_db' );
*/