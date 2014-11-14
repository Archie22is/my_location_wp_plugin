<?php

$remove_defaults_widgets = array(
    'dashboard_incoming_links' => array(
        'page'    => 'dashboard',
        'context' => 'normal'
    ),
    'dashboard_right_now' => array(
        'page'    => 'dashboard',
        'context' => 'normal'
    ),
    'dashboard_recent_drafts' => array(
        'page'    => 'dashboard',
        'context' => 'side'
    ),
    'dashboard_quick_press' => array(
        'page'    => 'dashboard',
        'context' => 'side'
    ),
    'dashboard_plugins' => array(
        'page'    => 'dashboard',
        'context' => 'normal'
    ),
    'dashboard_primary' => array(
        'page'    => 'dashboard',
        'context' => 'side'
    ),
    'dashboard_secondary' => array(
        'page'    => 'dashboard',
        'context' => 'side'
    ),
    'dashboard_recent_comments' => array(
        'page'    => 'dashboard',
        'context' => 'normal'
    )
);

$custom_dashboard_widgets = array(
    'my-dashboard-widget' => array(
        'title' => 'Archie\'s Current Location Widget',
        'callback' => 'dashboardWidgetContent'
    )
);

function dashboardWidgetContent()
{
    $user = wp_get_current_user();
    $update_error = "";
    echo 'Hello <strong>' . $user->user_login . '</strong>, this stupid plugin is what you have always dreamt of... I guess you must be retarded to give out your location to the whole world:';

    // construct container
    echo '<br /> <br />';
    echo '<strong>Your current location:  </strong>';
    echo '<div id="map-canvas" class="location-map"></div>';

    ?>

    <!-- Coordinates Input -->
    <script src="http://maps.google.com/maps/api/js?sensor=false"></script>
    <form id="coordform" action="<?php echo $_SERVER['REQUEST_URI'];?>" method="post">

        <!-- Data Attributes -->
        <div class="field-list">
            <label class="red-strong"><strong>Please wait while obtaining your approximate location. <br />Once done, click [Update Location] to update to current location...</strong></label>
        </div>
        <div class="field-listt">
            <label>Current Latitude: </label>
            <input type="text" id="inputLat" name="inputLat">
        </div>
        <div class="field-list">
            <label>Current Longitude: </label>
            <input type="text" id="inputLong" name="inputLong">
        </div>

        <div class="field-list">
            <p class="update-error"><?php echo $update_error; ?></p>
        </div>

        <div class="field-list">
            <input class="sendform" name="submit" type="submit" value="Update Location">
        </div>

    </form>

    <?php
        // ja, and now we update the location
        if(isset($_POST['submit'])) {
            $thelat = $_POST['inputLat'];
            $thelong = $_POST['inputLong'];

            $latitude = filter_var($thelat, FILTER_SANITIZE_STRING);
            $longitude = filter_var($thelong, FILTER_SANITIZE_STRING);

            // validate and manipulate data
            if( (empty($latitude)) && (empty($longitude)) ) {
                $update_error = "Please wait for the geolocation to track your location";
            }
            else{
                // database stuff
                global $wpdb;
                $table_name = $wpdb->prefix . "mylocation";

                // update row if does not exist, else insert (create it)
                $id = '1';
                $current_time = current_time('mysql');
                //$result = $wpdb->get_results ("SELECT id FROM $table_name WHERE id = '".$id."'");
                $result = $wpdb->get_results ("SELECT id FROM $table_name WHERE id = 1");

                if (count ($result) > 0) {
                    //$row = current ($result);
                    $wpdb->update ( $table_name,
                        array(
                            'time'=>$current_time,
                            'latitude'=>$latitude,
                            'longitude'=>$longitude
                        ),
                        array(
                            'id'=>$id       // where to update the table
                        )
                    );
                }
                else {
                    $wpdb->insert ( $table_name,
                        array(
                            'id'=>$id,
                            'time'=>$current_time,
                            'latitude'=>$latitude,
                            'longitude'=>$longitude
                        )
                    );
                }
            }

        }
        else{
            // uhm... can't think of anything to do here
        }

}