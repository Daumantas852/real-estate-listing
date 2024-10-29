<?php
// Display House Details on the Frontend
function display_house_details($content) {
    if (is_singular('house')) {
        global $post;

        // Retrieve House Meta Information
        $price = get_post_meta($post->ID, 'price', true);
        $address = get_post_meta($post->ID, 'address', true);
        $house_type = get_post_meta($post->ID, 'house_type', true);
        $land_area = get_post_meta($post->ID, 'land_area', true);
        $room_count = get_post_meta($post->ID, 'room_count', true);
        $floor_count = get_post_meta($post->ID, 'floor_count', true);
        $year_built = get_post_meta($post->ID, 'year_built', true);
        $furnishing = get_post_meta($post->ID, 'furnishing', true);
        $energy_efficiency = get_post_meta($post->ID, 'energy_efficiency', true);
        $main_image = get_the_post_thumbnail($post->ID, 'large');

        // Start house details html
        $house_details = '<div class="house-details">';

        // Display information
        $house_details .= "<p class='house-price'><span>" . esc_html($price) . "</span> &#8364;</p>";
        $house_details .= "<p class='house-address'>Adresas: <span id='house-address'>" . esc_html($address) . "</span></p>";
        $house_details .= "<p class='house-type'>Namo Tipas: <span>" . esc_html($house_type) . "</span></p>";
        $house_details .= "<p class='land-area'>Zemes Plotas: <span>" . esc_html($land_area) . "</span></p>";
        $house_details .= "<p class='room-count'>Kambariu skaicius: <span>" . esc_html($room_count) . "</span></p>";
        $house_details .= "<p class='floor-count'>Aukstu skaicius: <span>" . esc_html($floor_count) . "</span></p>";
        $house_details .= "<p class='year-built'>Pastatymo metai: <span>" . esc_html($year_built) . "</span></p>";
        $house_details .= "<p class='furnishing'>Irengimas: <span>" . esc_html($furnishing) . "</span></p>";
        $house_details .= "<p class='energy-efficiency'>Energijos efektyvumas: <span>" . esc_html($energy_efficiency) . "</span></p>";

        // Add a div for the map
        $house_details .= '<div id="map" style="width: 100%; height: 400px; margin-top: 20px;"></div>';

        // Retrieve Floors and display dynamically (similar to the original code)
        $floors = get_post_meta($post->ID, 'floors', true);
        $floors = !empty($floors) ? $floors : [];

        if (count($floors) > 0) {
            $house_details .= '<div class="House1">';
            $house_details .= '<div class="Floors">';
            foreach ($floors as $index => $floor) {
                $floor_number = $index + 1;
                $floor_class = 'Floor-' . $floor_number;
                $house_details .= '<img class="Aukstas ' . esc_attr($floor_class) . '" src="' . plugins_url($floor_number . '_Aukstas_red.png', __FILE__) . '" alt="Aukštas ' . $floor_number . '" data-floor="' . esc_attr($floor_number) . '">';
            }
            $house_details .= '</div>'; // Close Floors

            // Display Rooms dynamically
            $house_details .= '<div class="Apartament">';
            $house_details .= '<img class="RoomWalls" src="' . esc_url(plugins_url('Nuotraukos/RoomWalls.png', __FILE__)) . '" alt="Room Walls">';
            $house_details .= '<div class="Rooms">';
            $house_details .= '<div class="RoomsRow1">';
            $house_details .= '<img class="Room2" src="' . esc_url(plugins_url('Nuotraukos/Room2_Floor.png', __FILE__)) . '" alt="Room2" data-room="2">';
            $house_details .= '<img class="Room3" src="' . esc_url(plugins_url('Nuotraukos/Room3_Floor.png', __FILE__)) . '" alt="Room3" data-room="3">';
            $house_details .= '</div>';
            $house_details .= '<div class="RoomsRow2">';
            $house_details .= '<img class="Room1" src="' . esc_url(plugins_url('Nuotraukos/Room1_Floor.png', __FILE__)) . '" alt="Room1" data-room="1">';
            $house_details .= '<img class="Room4" src="' . esc_url(plugins_url('Nuotraukos/Room4_Floor.png', __FILE__)) . '" alt="Room4" data-room="4">';
            $house_details .= '<img class="Room5" src="' . esc_url(plugins_url('Nuotraukos/Room5_Floor.png', __FILE__)) . '" alt="Room5" data-room="5">';
            $house_details .= '</div>';
            $house_details .= '<img class="Room6" src="' . esc_url(plugins_url('Nuotraukos/Room6_Floor.png', __FILE__)) . '" alt="Room6" data-room="6">';
            $house_details .= '</div>'; // Close Rooms
            $house_details .= '</div>'; // Close Apartament
            $house_details .= '</div>'; // Close House1
        }

        // Floors and Rooms Content
        $house_details .= '<div class="floors-content">';
        foreach ($floors as $index => $floor) {
            $floor_number = $index + 1;
            if (!empty($floor['images'])) {
                foreach ($floor['images'] as $room_index => $image_url) {
                    $house_details .= "<div id='floor-{$floor_number}-room-{$room_index}' class='room-pane' data-floor='{$floor_number}' data-room='{$room_index}' style='display: none;'>";
                    $house_details .= "<img class='imagescss2' src='" . esc_url($image_url) . "' style='width: 800px; height: 800px; margin-right: 5px;' />";
                    $house_details .= '</div>';
                }
            }
        }
        $house_details .= '</div>'; // Close Floors Content

        // End house details HTML
        $house_details .= '</div>'; // Close House Details div

        // Floors and Rooms Content
        $house_details .= '<div class="gallery-grid">'; // Changed class name for the container

        foreach ($floors as $index => $floor) {
            $floor_number = $index + 1;
            if (!empty($floor['images'])) {
                foreach ($floor['images'] as $room_index => $image_url) {
                    $house_details .= "<div class=' grid-item'>";
                    $house_details .= "<img class='imagescss' src='" . esc_url($image_url) . "' />";
                    $house_details .= '</div>';
                }
            }
        }

        $house_details .= '</div>'; // Close gallery grid

        // Java scipt to show address with API
        $house_details .= '
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAAXZqzln3k4VLXlffdEz0cx3HyBzvkvm8"></script>
        <script>
            function initMap() {
                var geocoder = new google.maps.Geocoder();
                var address = "' . esc_js($address) . '"; 

                geocoder.geocode({ "address": address }, function(results, status) {
                    if (status === "OK") {
                        var mapOptions = {
                            zoom: 15,
                            center: results[0].geometry.location
                        };
                        var map = new google.maps.Map(document.getElementById("map"), mapOptions);
                        var marker = new google.maps.Marker({
                            map: map,
                            position: results[0].geometry.location
                        });
                    } else {
                        alert("Geocode was not successful for the following reason: " + status);
                    }
                });
            }
            // Initialize the map once the page is fully loaded
            window.onload = initMap;
        </script>';

        return $content . $house_details;
    }
    return $content;

}
add_filter('the_content', 'display_house_details');



