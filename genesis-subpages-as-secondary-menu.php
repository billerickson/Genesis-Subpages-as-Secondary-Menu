<?php
/*
Plugin Name: Genesis Subpages as Secondary Menu
Plugin URI: http://www.billerickson.net
Description: Replaces the manually managed Secondary Menu with one that automatically lists the current section's subpages. You must be using the Genesis Framework and have the Secondary Menu enabled (Genesis > Theme Settings > Navigation Settings).
Version: 1.4
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
	
	// Wrap the list items in an unordered list
	$wrapper = apply_filters( 'be_genesis_subpages_wrapper', array( '<ul id="menu-genesis-subpages" class="nav">', '</ul>' ) );
	
	// Output the menu if there is one (from genesis/lib/structure/menu.php)
	if( !empty( $subnav ) )
		$subnav_output = sprintf( '<div id="subnav">%2$s%4$s%1$s%5$s%3$s</div>', $subnav, genesis_structural_wrap( 'subnav', '<div class="wrap">', 0 ), genesis_structural_wrap( 'subnav', '</div><!-- end .wrap -->', 0 ), $wrapper[0], $wrapper[1] );
	else
		$subnav_output = '';
	
	return $subnav_output;
		
}



?>