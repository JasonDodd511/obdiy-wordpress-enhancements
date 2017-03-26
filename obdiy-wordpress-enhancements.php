<?php

/*
Plugin Name: OBDIY Wordpress Enhancements
Plugin URI: https://github.com/JasonDodd511/obdiy-wordpress-enhancements.git
Description: Plugin to house Wordpress snippets.
Version: 1.0
Author: Jason Dodd
Author URI: https://cambent.com
License: GPL2
GitHub Plugin URI: https://github.com/JasonDodd511/obdiy-wordpress-enhancements
GitHub Branch:     master
GitHub Languages:
*/

/**
 * Display information for logged in user
 *
 * Use these shortcodes to customize messages and links that are built using the front end editor.
 */
function obdiy_user_shortcode($atts, $content){

	if (!is_user_logged_in()) return '';

	$current_user = wp_get_current_user();
	return $current_user->user_login;
}
add_shortcode ('currentuser_username' , 'obdiy_user_shortcode');

function obdiy_email_shortcode ($atts, $content){

	if (!is_user_logged_in()) return '';

	$current_user = wp_get_current_user();
	return $current_user->user_email;
}
add_shortcode ('currentuser_email' , 'obdiy_email_shortcode');

function obdiy_firstname_shortcode ($atts, $content){

	if (!is_user_logged_in()) return '';

	$current_user = wp_get_current_user();
	return $current_user->user_firstname;
}
add_shortcode ('currentuser_firstname' , 'obdiy_firstname_shortcode');

function obdiy_lastname_shortcode ($atts, $content){

	if (!is_user_logged_in()) return '';

	$current_user = wp_get_current_user();
	return $current_user->user_lastname;
}
add_shortcode ('currentuser_lastname' , 'obdiy_lastname_shortcode');

function obdiy_displayname_shortcode ($atts, $content){

	if (!is_user_logged_in()) return '';

	$current_user = wp_get_current_user();
	return $current_user->display_name;
}
add_shortcode ('currentuser_displayname' , 'obdiy_displayname_shortcode');

function obdiy_id_shortcode ($atts, $content){

	if (!is_user_logged_in()) return '';

	$current_user = wp_get_current_user();
	return $current_user->ID;
}
add_shortcode ('currentuser_id' , 'obdiy_id_shortcode');

/**
 * Display get variables using shortcode
 *
 * Use these shortcodes to customize messages and links that are built using the front end editor.
 */
function obdiy_get_ep_id_shortcode ($atts, $content){
	$ep_id = $_GET['ep_id'];

	if($ep_id) {
		return '#' . $ep_id;
	}
	else {
		return '#';
	}
}
add_shortcode ('ep_id' , 'obdiy_get_ep_id_shortcode');

function obdiy_get_ep_name_shortcode ($atts, $content){
	$ep_name = $_GET['ep_name'];

	if($ep_name) {
		return urldecode($ep_name);
	}
	else {
		return '';
	}
}
add_shortcode ('ep_name' , 'obdiy_get_ep_name_shortcode');

/**
 * Automatically log in user when registering
 *
 */
function obdiy_auto_login_new_user( $user_id ) {
	wp_set_current_user( $user_id );
	wp_set_auth_cookie( $user_id, false, is_ssl() );
}
add_action( 'user_register', 'obdiy_auto_login_new_user', 10 );

/**
 * Changing the logo, logo link and alt text on the login page
 *
 */
function obdiy_custom_login_logo() {
	echo '<style type="text/css">
        h1 a { background-image:url(/images/logo.png) !important; }
    </style>';
}

add_action('login_head', 'obdiy_custom_login_logo');

// changing the logo link from wordpress.org to obdiy
function obdiy_login_url() { return home_url( '/' ); }

// changing the alt text on the logo to show obdiy
function obdiy_login_title() { return get_option('blogname'); }

// calling it only on the login page
add_filter('login_headerurl', 'obdiy_login_url');
add_filter('login_headertitle', 'obdiy_login_title');


/**
 * Adding Cutom Post Types
 *
 */

/* Adding the Landing Page Custom Post Type*/
function obdiy_create_lp_post_type() {
	register_post_type( 'landing_page',
		array(
			'labels' => array(
				'name' => __( 'Landing Pages' ),
				'singular_name' => __( 'Landing Page' )
			),
			'public' => true,
			'hierarchical' => true, //Behave like a page
			'query_var' => true,
			'supports' => array( 'title', 'editor', 'revisions', 'custom-fields', 'thumbnail', 'page-attributes' ),
			'rewrite' => array( 'slug' => 'valuable-stuff', 'with_front' => false ),
			'permalink_epmask' => EP_PERMALINK,
			'menu_icon' => 'dashicons-tag',
		)
	);
}

add_action( 'init', 'obdiy_create_lp_post_type' );

/* Adding the Execution Plan Custom Post Type*/
function obdiy_create_ep_post_type() {
	register_post_type( 'execution_plan',
		array(
			'labels' => array(
				'name' => __( 'Execution Plans' ),
				'singular_name' => __( 'Execution Plan' )
			),
			'public' => true,
			'hierarchical' => true, //Behave like a page
			'query_var' => true,
			'supports' => array( 'title', 'editor', 'revisions', 'custom-fields', 'thumbnail', 'page-attributes', 'comments' ),
			'rewrite' => array( 'slug' => 'resources', 'with_front' => false ),
			'permalink_epmask' => EP_PERMALINK,
			'menu_icon' => 'dashicons-welcome-learn-more',
		)
	);
}

add_action( 'init', 'obdiy_create_ep_post_type' );