<?php

// display that map
function get_coordinates () {

    // get coordinates
    $mylatitude = "";
    $mylongitude = "";

    global $wpdb;
    $table_name = $wpdb->prefix . "mylocation";

    // query table row if id is equal to one
    $mycoords = $wpdb->get_results ("SELECT longitude, latitude FROM $table_name WHERE id = 1");

}

get_coordinates();



function display_map () {
    
    // yoh!!
    $frontlat = "";
    $frontlong = "";

    //if id = 1 in the database exist, execute the function baby
    global $wpdb;
    $table_name = $wpdb->prefix . "mylocation";

    $id = $wpdb->get_results ("SELECT id FROM $table_name");
    $coord = $wpdb->get_results ("SELECT longitude, latitude FROM $table_name");

    foreach ($coord as $coordinate){
        $frontlat = $coordinate->latitude;
        $frontlong = $coordinate->longitude;
    }

    if($id = 1){
        $map = "http://maps.googleapis.com/maps/api/staticmap?center=$frontlat,$frontlong&zoom=14&size=400x400&markers=color:red|label:A|$frontlat,$frontlong";
        echo "<div class='front-map'>
            <h3 class='current-loc'>I am currently here...</h3><br />";
        echo "<img src='$map' alt='Current location;' />";
        echo "</div>";
    }
    else{
        echo "<div class='front-map' style='height:18.75em; border:1px solid #dddddd;'>
            <h3 class='current-loc'>Your location is unavailable...</h3>
        </div>";
    }

}

#display_map();     // call to display location