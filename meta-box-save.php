<?php
// Save Meta Box Data
function save_house_meta_boxes($post_id) {
    if (array_key_exists('price', $_POST)) {
        $fields = array(
            'price', 'address', 'house_type', 'land_area',
            'room_count', 'floor_count', 'year_built',
            'furnishing', 'energy_efficiency'
        );

        foreach ($fields as $field) {
            if (isset($_POST[$field])) {
                update_post_meta($post_id, $field, sanitize_text_field($_POST[$field]));
            }
        }
    }

    if (array_key_exists('floors', $_POST)) {
        $floors = array_map(function ($floor) {
            return [
                'name' => sanitize_text_field($floor['name']),
                'images' => array_map('esc_url_raw', $floor['images']),
            ];
        }, $_POST['floors']);

        update_post_meta($post_id, 'floors', $floors);
    }
}
add_action('save_post', 'save_house_meta_boxes');
