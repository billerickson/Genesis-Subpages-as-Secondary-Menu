<?php
/**
 * Plugin Name: Genesis Subpages as Secondary Menu
 * Plugin URI: https://github.com/billerickson/Genesis-Subpages-as-Secondary-Menu
 * Description: Replaces the Genesis Secondary Menu with a dynamic listing of the current section's subpages. You must be using the Genesis Theme.
 * Version: 2.0
 * Author: Bill Erickson
 * Author URI: http://www.billerickson.net
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU 
 * General Public License version 2, as published by the Free Software Foundation.  You may NOT assume 
 * that you can use any other version of the GPL.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without 
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 */

class BE_Genesis_Subpages_Menu {

	var $instance;
	
	/**
	 * Construct
	 *
	 * Registers our activation hook and init hook
	 *
	 * @since 2.0
	 * @author Bill Erickson
	 */
	function __construct() {
		$this->instance =& $this;
		register_activation_hook( __FILE__, array( $this, 'activation_hook' ) );
		add_action( 'init', array( $this, 'init' ) );	
	}
	
	/**
	 * Activation Hook
	 *
	 * Confirm site is using Genesis
	 *
	 * @since 2.0
	 * @author Bill Erickson
	 */
	function activation_hook() {
		if ( 'genesis' != basename( TEMPLATEPATH ) ) {
			deactivate_plugins( plugin_basename( __FILE__ ) );
			wp_die( sprintf( __( 'Sorry, you cannot activate unless you have installed <a href="%s">Genesis</a>', 'genesis-grid'), 'http://www.billerickson.net/go/genesis' ) );
		}
	}

	/**
	 * Init
	 *
	 * Register all our functions to the appropriate hook
	 *
	 * @since 2.0
	 * @author Bill Erickson
	 */
	function init() {

		// Indicate the Secondary Menu location is in use
		add_filter( 'theme_mod_nav_menu_locations', array( $this, 'subnav_menu_location' ) );
		
		// Build the Dynamic Menu Object
		add_filter( 'wp_get_nav_menu_object', array( $this, 'subnav_menu_object' ), 10, 2 );

		// Mark the Secondary Menu location as having a menu
		add_filter( 'has_nav_menu', array( $this, 'subnav_menu_has_menu' ), 10, 2 );

		// Short circuit wp_nav_menu() for Secondary Menu
		add_filter( 'pre_wp_nav_menu', array( $this, 'be_pre_subnav' ), 10, 2 );
		
		// Add menu-item class 
		add_filter( 'page_css_class', array( $this, 'subnav_item_classes' ) );

		// Output Secondary Menu
		add_filter('genesis_do_subnav', array( $this, 'subnav_output' ) );

	}
	
	/**
	 * Indicate the Secondary Menu location is in use
	 *
	 * @param array $locations, menu locations and the menu ID assigned to that location
	 * @return array $locations
	 *
	 * @since 2.0
	 * @author Bill Erickson
	 */
	function subnav_menu_location( $locations ) {

		$locations['secondary'] = 1;
		return $locations;
	
	}
	
	/**
	 * Dynamic Menu Object
	 *
	 * @param object $menu_object
	 * @param int $menu_id
	 * @return object $menu_object
	 *
	 * @since 2.0
	 * @author Bill Erickson
	 */
	function subnav_menu_object( $menu_object, $menu_id ) {

		if( 1 === $menu_id ) {
			$menu_object = new stdClass();
			$menu_object->name = 'Genesis Subpages';
			$menu_object->term_id = 1;
			$menu_object->slug = 'genesis-subpages-as-secondary-menu';	
		}
	
		return $menu_object;

	}
	
	/**
	 * Mark Secondary Menu location as having a menu
	 *
	 * @param bool $has_nav_menu
	 * @param string $location
	 * @return bool $has_nav_menu
	 *
	 * @since 2.0
	 * @author Bill Erickson
	 */
	function subnav_menu_has_menu( $has_nav_menu, $location ) {

		if( 'secondary' == $location )
			$has_nav_menu = true;
		return $has_nav_menu;
	
	}
	
	/**
	 * Short Circuit wp_nav_menu() for secondary menu
	 *
	 * @param string $output, output of wp_nav_menu (I'm overriding this later)
	 * @param object $args, wp_nav_menu arguments
	 * @return string $output
	 *
	 * @since 2.0
	 * @author Bill Erickson
	 */
	function be_pre_subnav( $output, $args ) {

		if( 'secondary' == $args->theme_location )
			$output = 1;
		return $output;
	
	}
	
	/**
	 * Add menu-item class
	 *
	 * @param array $classes
	 * @return array $classes
	 *
	 * @since 2.0
	 * @author Bill Erickson
	 */
	function subnav_item_classes( $classes ) {
		$classes[] = 'menu-item';
		return $classes;
	}

	/**
	 * Display Secondary Nav with Subpages
	 *
	 * @param string $output, output of genesis_do_subnav()
	 * @return string $output
	 *
	 * @since 2.0
	 * @author Bill Erickson
	 */
	function subnav_output( $output ) {
	
		// Only run on pages
		if( ! is_page() )
			return;
			
		// Find top level parent
		$parents = array_reverse( get_ancestors( get_the_ID(), 'page' ) );
		$parents[] = get_the_ID();
		
		// Build a menu listing top level parent's children
		$args = array(
			'child_of' => $parents[0],
			'title_li' => '',
			'echo'     => false,
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
	
		$output = $subnav_markup_open . $subnav . $subnav_markup_close;
		return $output; 

	}

}

new BE_Genesis_Subpages_Menu;