<?php
/**
 * Plugin Name: Class Schedule List
 * Plugin URI: http://www.thejameswilliam.com
 * Description: List Plugin lists class schedules by day.
 * Version: 0.1.0
 * Author: James W. Johnson
 * Author URI: http://www.thejameswilliam.com
 * License: GPL2
 */
 


/*
|--------------------------------------------------------------------------
| ACTIVATION
|--------------------------------------------------------------------------
*/



register_activation_hook( __FILE__, 'child_plugin_activate' );
function child_plugin_activate(){

    // Require parent plugin
    if ( ! is_plugin_active( 'advanced-custom-fields-pro/acf.php' ) and current_user_can( 'activate_plugins' ) ) {
        // Stop activation redirect and show error
        wp_die('Sorry, but this plugin requires the Advanced Custom Fields Pro plugin to be installed and active. <br><a href="' . admin_url( 'plugins.php' ) . '">&laquo; Return to Plugins</a>');
    }
}




/*
|--------------------------------------------------------------------------
| POST TYPES
|--------------------------------------------------------------------------
*/



add_action( 'init', 'create_jwj_class_post_type' );
// Create 1 Custom Post type for classes, called jwj_class
function create_jwj_class_post_type()
{
   
	register_post_type('jwj_class', // Register Custom Post Type
        array(
        'labels' => array(
            'name' => __('Dance Classes', 'jwj_class'), // Rename these to suit
            'singular_name' => __('Dance Class', 'jwj_class'),
            'add_new' => __('Add New Class', 'jwj_class'),
            'add_new_item' => __('Add New Dance Class', 'jwj_class'),
            'edit' => __('Edit Class', 'jwj_class'),
            'edit_item' => __('Edit Dance Class', 'jwj_class'),
            'new_item' => __('New Dance Class', 'jwj_class'),
            'view' => __('View Dance Classes', 'jwj_class'),
            'view_item' => __('View Dance Classes', 'jwj_class'),
            'search_items' => __('Search Dance Classes', 'jwj_class'),
            'not_found' => __('No Dance Classes found', 'jwj_class'),
            'not_found_in_trash' => __('No Dance Classes found in Trash', 'jwj_class')
        ),
        'public' => true,
        'hierarchical' => true, // Allows your posts to behave like Hierarchy Pages
        'has_archive' => true,
        'supports' => array(
            'title',
            'editor',
            'excerpt',
            'thumbnail'
        ), // Go to Dashboard Custom HTML5 Blank post for supports
        'can_export' => true, // Allows export in Tools > Export
        'taxonomies' => array(
            'location',
            'style',
			'day'
        ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',// Add Category and Post Tags support
    ));
	
}




/*
|--------------------------------------------------------------------------
| TAXONOMIES
|--------------------------------------------------------------------------
*/

// hook into the init action and call create_class_taxonomies when it fires
add_action( 'init', 'create_class_taxonomies', 0 );

// create  taxonomies for the post type jwj_class
function create_class_taxonomies() {
	// Add new taxonomy, styles for dance classes
	$labels = array(
		'name'              => _x( 'Dance Styles', 'taxonomy general name' ),
		'singular_name'     => _x( 'Dance tyle', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Dance Styles' ),
		'all_items'         => __( 'All Styles' ),
		'parent_item'       => __( 'Parent Style' ),
		'parent_item_colon' => __( 'Parent Style:' ),
		'edit_item'         => __( 'Edit Dance Style' ),
		'update_item'       => __( 'Update Dance Style' ),
		'add_new_item'      => __( 'Add New Style' ),
		'new_item_name'     => __( 'New Dance Style' ),
		'menu_name'         => __( 'Dance Styles' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => false,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'jwj_style' ),
	);

	register_taxonomy( 'jwj_style', array( 'jwj_class' ), $args );

	// Add new taxonomy, location for dance classes
	$labels = array(
		'name'                       => _x( 'Locations', 'taxonomy general name' ),
		'singular_name'              => _x( 'Location', 'taxonomy singular name' ),
		'search_items'               => __( 'Search Locations' ),
		'popular_items'              => __( 'Popular Locations' ),
		'all_items'                  => __( 'All Locations' ),
		'parent_item'      			 => __( 'Parent Location' ),
		'parent_item_colon'			 => __( 'Parent Location:' ),
		'edit_item'        			 => __( 'Edit Lcoation' ),
		'update_item'       			 => __( 'Update Location' ),
		'add_new_item'     			 => __( 'Add New Location' ),
		'new_item_name'    			 => __( 'New Location' ),
		'menu_name'        			 => __( 'Locations' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => false,
		'query_var'         => true,
		'rewrite'           => false,
		'public' => true,
		'publicly_queryable' => true,
		'exclude_from_search' => true,
		'query_var' => true
	
	);

	register_taxonomy( 'jwj_location', 'jwj_class', $args );
	
	
	
}




/*
|--------------------------------------------------------------------------
| ASSETS
|--------------------------------------------------------------------------
*/


add_action( 'wp_enqueue_scripts', 'jwj_enqueued_assets' );

function jwj_enqueued_assets() {
	
	
	wp_register_style('jwj-css-styles', plugin_dir_url( __FILE__ ) . '/styles/style.css', array(), '1.0', 'all');
    wp_enqueue_style('jwj-css-styles'); // Enqueue it!
};

add_action('wp_footer', 'jwj_add_fonts');
function jwj_add_fonts() {
	echo '<link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet" type="text/css">';	
};




/*
|--------------------------------------------------------------------------
| SHORTCODES
|--------------------------------------------------------------------------
*/

add_shortcode('class_by_style', 'jwj_list_class_by_style');
function jwj_list_class_by_style( $style_ID ){

echo 'One day this will be completed, and it will be awesome.';
/* include "templates/location.php"; */

}


add_shortcode('class_by_location', 'jwj_list_class_by_location');
function jwj_list_class_by_location(){

echo 'One day this will be completed, and it will be awesome.';
/* include "templates/style.php"; */

}



/*
|--------------------------------------------------------------------------
| CUSTOM FIELDS
|--------------------------------------------------------------------------
*/




if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array (
	'key' => 'group_5661ed97043b4',
	'title' => 'Classes',
	'fields' => array (
		array (
			'key' => 'field_5661ed9c0fc2f',
			'label' => 'Teacher',
			'name' => 'teacher',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
			'readonly' => 0,
			'disabled' => 0,
		),
		array (
			'key' => 'field_5661edbc0fc30',
			'label' => 'Studio',
			'name' => 'studio',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
			'readonly' => 0,
			'disabled' => 0,
		),
		array (
			'key' => 'field_5661edc00fc31',
			'label' => 'Location',
			'name' => 'location',
			'type' => 'taxonomy',
			'instructions' => '',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'taxonomy' => 'location',
			'field_type' => 'radio',
			'allow_null' => 0,
			'add_term' => 1,
			'save_terms' => 1,
			'load_terms' => 1,
			'return_format' => 'id',
			'multiple' => 0,
		),
		array (
			'key' => 'field_5661eddf0fc32',
			'label' => 'Dance Style',
			'name' => 'dance_style',
			'type' => 'taxonomy',
			'instructions' => '',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'taxonomy' => 'style',
			'field_type' => 'checkbox',
			'allow_null' => 0,
			'add_term' => 1,
			'save_terms' => 1,
			'load_terms' => 1,
			'return_format' => 'id',
			'multiple' => 0,
		),
		array (
			'key' => 'field_5661ee31af267',
			'label' => 'Age Range',
			'name' => 'age_range',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
			'readonly' => 0,
			'disabled' => 0,
		),
		array (
			'key' => 'field_5669cdcbd0428',
			'label' => 'Image',
			'name' => 'image',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'id',
			'preview_size' => 'thumbnail',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array (
			'key' => 'field_566a177142b32',
			'label' => 'Class Days',
			'name' => 'class_days',
			'type' => 'checkbox',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array (
				'sunday' => 'Sunday',
				'monday' => 'Monday',
				'tuesday' => 'Tuesday',
				'wednesday' => 'Wednesday',
				'thursday' => 'Thursday',
				'friday' => 'Friday',
				'saturday' => 'Saturday',
			),
			'default_value' => array (
			),
			'layout' => 'vertical',
			'toggle' => 0,
		),
		array (
			'key' => 'field_566a17ef42b33',
			'label' => 'Start Time',
			'name' => 'start_time',
			'type' => 'date_time_picker',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'show_date' => 'false',
			'date_format' => 'm/d/y',
			'time_format' => 'h:mm tt',
			'show_week_number' => 'false',
			'picker' => 'select',
			'save_as_timestamp' => 'true',
			'get_as_timestamp' => 'false',
		),
		array (
			'key' => 'field_566a17fd42b34',
			'label' => 'End Time',
			'name' => 'end_time',
			'type' => 'date_time_picker',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'show_date' => 'false',
			'date_format' => 'm/d/y',
			'time_format' => 'h:mm tt',
			'show_week_number' => 'false',
			'picker' => 'select',
			'save_as_timestamp' => 'true',
			'get_as_timestamp' => 'false',
		),
		array (
			'key' => 'field_56958266db6fb',
			'label' => 'Class Color',
			'name' => 'class_color',
			'type' => 'color_picker',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '#6db33f',
		),
	),
	'location' => array (
		array (
			array (
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'jwj_class',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => 1,
	'description' => '',
));

endif;


