<?php
/*
Plugin Name: WP House Listing
Description: Pridejimui namus
Version: 1.0
Author: Daumantas
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}



// Register the Custom Post Type for Houses
function register_house_post_type() {
    $labels = array(
        'name' => 'Houses',
        'singular_name' => 'House',
        'menu_name' => 'Houses',
        'name_admin_bar' => 'House',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New House',
        'new_item' => 'New House',
        'edit_item' => 'Edit House',
        'view_item' => 'View House',
        'all_items' => 'All Houses',
        'search_items' => 'Search Houses',
        'not_found' => 'No houses found.',
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail'),
        'menu_icon' => 'dashicons-admin-home',
        'rewrite' => array('slug' => 'houses'), 
    );

    register_post_type('house', $args);
}
add_action('init', 'register_house_post_type');


// Add Meta Boxes for House Details
function add_house_meta_boxes() {
    add_meta_box('house_details', 'House Details', 'render_house_meta_box', 'house', 'normal', 'high');
    add_meta_box('floor_details', 'Floor Details', 'render_floor_meta_box', 'house', 'normal', 'high');
}
add_action('add_meta_boxes', 'add_house_meta_boxes');

// Include the file for rendering the meta boxes
require_once plugin_dir_path(__FILE__) . 'meta-box-rendering.php';

// Include the file for saving meta box data
require_once plugin_dir_path(__FILE__) . 'meta-box-save.php';

// Enqueue the external CSS and JS files
function enqueue_house_details_assets() {
    // Corrected handle and path
    wp_enqueue_style('dizainas-css', plugin_dir_url(__FILE__) . 'Dizainas.css'); 
    wp_enqueue_script('house-details-js', plugin_dir_url(__FILE__) . 'house-details.js', array(), null, true);
}
add_action('wp_enqueue_scripts', 'enqueue_house_details_assets');




//Display the house floors and and rooms
include_once plugin_dir_path(__FILE__) . 'display-house-details.php';