<?php
/*
Plugin Name: Genesis Subpages as Secondary Menu
Plugin URI: http://www.billerickson.net
Description: Replaces the manually managed Secondary Menu with one that automatically lists the current section's subpages. You must be using the Genesis Framework and have the Secondary Menu enabled (Genesis > Theme Settings > Navigation Settings).
Version: 1.8
Author: Bill Erickson
Author URI: http://www.billerickson.net
License: GPLv2 
*/

// Make sure we're using Genesis
register_activation_hook( __FILE__, 'be_subnav_activation' );
function be_subnav_activation() {
	if ( 'genesis' != basename( TEMPLATEPATH ) ) {
		deactivate_plugins( plugin_basename( __FILE__ ) );
		wp_die( sprintf( 'Sorry, you can&rsquo;t activate unless you are using the <a href="%s">Genesis</a> theme.', 'http://www.billerickson.net/get-genesis' ) );
	}
}
	
// Add Subpages to Subnav
add_filter('genesis_do_subnav', 'be_subnav');
function be_subnav( $subnav_output ){

	// Only run on pages
	if ( !is_page() )
		return;
		
	// Find top level parent
	global $post;
	$parent = $post;
	while( $parent->post_parent ) $parent = get_post( $parent->post_parent );
		
	// Build a menu listing top level parent's children
	$args = array(
		'child_of' => $parent->ID,
		'title_li' => '',
		'echo' => false,
	);
	$subnav = wp_list_pages( apply_filters( 'be_genesis_subpages_args', $args ) );
	if( empty( $subnav ) )
		return;
	
	// Wrap the list items in an unordered list
	$wrapper = apply_filters( 'be_genesis_subpages_wrapper', array( '<ul id="menu-genesis-subpages" class="nav genesis-nav-menu menu-secondary">', '</ul>' ) );
	$subnav = $wrapper[0] . $subnav . $wrapper[1];

	$subnav_markup_open = genesis_markup( array(
		'html5'   => '<nav %s>',
		'xhtml'   => '<div id="subnav">',
		'context' => 'nav-secondary',
		'echo'    => false,
	) );
	$subnav_markup_open .= genesis_structural_wrap( 'menu-secondary', 'open', 0 );

	$subnav_markup_close  = genesis_structural_wrap( 'menu-secondary', 'close', 0 );
	$subnav_markup_close .= genesis_html5() ? '</nav>' : '</div>';

	$subnav_output = $subnav_markup_open . $subnav . $subnav_markup_close;
	return $subnav_output; 
		
}

// Let Genesis know there's a subnav menu
add_filter( 'theme_mod_nav_menu_locations', 'be_subpages_for_secondary' );
function be_subpages_for_secondary( $locations ) {
	if( ! isset( $locations['secondary'] ) )
		$locations['secondary'] = 1;
		
	return $locations;
}

// Add menu-item class 
add_filter( 'page_css_class', 'be_subnav_classes' );
function be_subnav_classes( $classes ) {
	$classes[] = 'menu-item';
	return $classes;
}

// Give the dynamic submenu a name 
add_filter( 'wp_get_nav_menu_object', 'be_subpages_secondary_menu_object', 10, 2 );
function be_subpages_secondary_menu_object( $menu_object, $menu_id ) {

	if( 1 === $menu_id ) {
		$menu_object = new stdClass();
		$menu_object->name = 'Genesis Subpages';
		$menu_object->term_id = 1;
		$menu_object->slug = 'genesis-subpages-as-secondary-menu';	
	}

	return $menu_object;
}

// Mark Secondary Menu as having a menu 
add_filter( 'has_nav_menu', 'be_secondary_menu_has_menu', 10, 2 );
function be_secondary_menu_has_menu ( $has_nav_menu, $location ) {
	if( 'secondary' == $location )
		$has_nav_menu = true;
	return $has_nav_menu;
}

// Short Circuit wp_nav_menu() for secondary menu
add_filter( 'pre_wp_nav_menu', 'be_secondary_menu_pre_output', 10, 2 );
function be_secondary_menu_pre_output( $output, $args ) {
	if( 'secondary' == $args->theme_location )
		$output = 1;
	return $output;
}