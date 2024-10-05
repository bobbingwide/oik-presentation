<?php 
/*
Plugin Name: oik-presentation
Plugin URI: https://www.oik-plugins.com/oik-presentation
Description: Presentation slides as WordPress custom post type
Version: 2.1.0
Author: bobbingwide
Author URI: https://www.bobbingwide.com/about-bobbing-wide
License: GPL2

    Copyright 2012-2013, 2019, 2023, 2024 Bobbing Wide (email : herb@bobbingwide.com )

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License version 2,
    as published by the Free Software Foundation.

    You may NOT assume that you can use any other version of the GPL.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    The license for this software can likely be found here:
    http://www.gnu.org/licenses/gpl-2.0.html

*/

/**
 * Implement "oik_fields_loaded" for oik-presentation
 */
function oik_presentation_init() {
  oik_presentation_register_oik_presentation();
  oik_presentation_register_shortcodes();
  oik_presentation_register_blocks();
}

/**
 * Register our plugin server as the default oik plugin server
 */
function oik_presentation_admin_menu() {
  oik_register_plugin_server( __FILE__ );
}

/**
 * Register an oik_presentation custom post type
 * 
 * The "oik_presentation" custommpost type is used to create pages/slides in presentation format
 * The pages can be navigated using a supporting theme
 * The Notes field can be displayed either using the [bw_fields] shortcode OR the "oik_presentation_footer" action
 * 
 *
 * supports: 'title', 'editor' (content), 'excerpt', 'thumbnail' (featured image, current theme must also support post-thumbnails),
 * 'page-attributes' (menu order, hierarchical must be true to show Parent option)
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */
function oik_presentation_register_oik_presentation() {
  $post_type = 'oik_presentation';
  $post_type_args = array();
  $post_type_args['hierarchical'] = true;
  $post_type_args['label'] = __('Presentation pages');
  $post_type_args['description'] = __('oik presentation pages');
  
  // We don't need custom-fields if we define our own! 
  $post_type_args['supports'] = array( 'title', 'editor', 'excerpt', 'page-attributes', 'thumbnail', 'author', 'revisions', 'clone' );
  $post_type_args[ 'show_in_rest'] = true;
  // (menu order, hierarchical must be true to show Parent option)
  bw_register_post_type( $post_type, $post_type_args );
  bw_register_field( "_oikp_notes", "textarea", __( "Notes" ) ); 
  bw_register_field_for_object_type( "_oikp_notes", $post_type );
  add_action( "manage_{$post_type}_posts_custom_column", "bw_custom_column_admin", 10, 2 );
  add_filter( "oik_table_titles_{$post_type}", "oik_presentation_columns", 10, 3 ); 
}

/**
 * List the custom columns for "oik_presentation_columns" filter 
 */
function oik_presentation_columns( $columns, $arg2 ) {
  bw_trace2();
  return( $columns ); 
}

/**
 * Display navigation for the oik-presentation
 *
 * @uses oikp_lazy_nav()
 */ 
function oikp_nav() {
  oik_require( "includes/oikp-lazy-nav.inc", "oik-presentation" );
  global $post;
  oikp_lazy_nav( $post );
} 

/**
 * Display the edit custom CSS button
 */
function oikp_editCSS() {
  oik_require( "shortcodes/oik-bob-bing-wide.php" );
  e( bw_editcss());
  bw_flush();
}

/**
 * Implement "admin_notices" for oik-presentation to check plugin dependency
 *
 * Version | Depends
 * ------- | -------------
 * v1.1    | oik 2.1-alpha, oik-fields 1.19.0905
 * v2.0.0  | oik 3.3.7, oik-fields 1.51.0
 */ 
function oik_presentation_activation() {
  static $plugin_basename = null;
  if ( !$plugin_basename ) {
    $plugin_basename = plugin_basename(__FILE__);
    add_action( "after_plugin_row_" . $plugin_basename, __FUNCTION__ );   
    require_once( "admin/oik-activation.php" );
  }  
  $depends = "oik:3.3.7,oik-fields:1.51.0";
  oik_plugin_lazy_activation( __FILE__, $depends, "oik_plugin_plugin_inactive" );
}

/**
 * Implement "oik_presentation_navigation" action for oik-presentation
 */
function oik_presentation_navigation() {
  oikp_nav( true );
  bw_flush();
}

/**
 * Implement "oik_presentation_footer" action for oik-presentation
 * 
 * Display the presentation footer consisting of
 * - An audio commentary on the page
 * - The oik Edit css button
 * - Copyright statement
 * - Optionally, "wtf" output - showing how the page was constructed
 * - Notes:
 */
function oik_presentation_footer() {
  //e( do_shortcode( "[audio]" ));
  //oikp_editCSS();
  //e( bw_follow_me() );
  //e( bw_copyright());
  //oik_require( "shortcodes/oik-wtf.php" );
  //e( bw_wtf());
  oik_require( "shortcodes/oik-fields.php", "oik-fields" );
  e( bw_metadata( array( "fields" => '_oikp_notes')) );   
  bw_flush();
}

function oik_presentation_register_shortcodes() {
	bw_add_shortcode( 'oik_presentation_navigation', 'oik_presentation_navigation_shortcode');
}

function oik_presentation_register_blocks() {
	$library_file = oik_require_lib( 'oik-blocks');
	$args = [ 'render_callback' => 'oik_presentation_navigation_block' ];
	$registered = register_block_type_from_metadata( __DIR__ .'/src/navigation', $args );
	/*
	$args = [ 'render_callback' => 'oik_presentation_footer_block' ];
	$registered = register_block_type_from_metadata( __DIR__ .'/src/footer', $args );
	*/

}

function oik_presentation_navigation_shortcode( $atts, $content, $tag ) {
	oikp_nav();
	$html = bw_ret();
	return $html;

}

function oik_presentation_navigation_block() {
	oikp_nav();
	$html = bw_ret();
	return $html;
}

/**
 * Function to run when the plugin file is loaded 
 */
function oik_presentation_plugin_loaded() {
  add_action( "admin_notices", "oik_presentation_activation" );
  add_action( "oik_fields_loaded", "oik_presentation_init" );
  add_action( "oik_admin_menu", "oik_presentation_admin_menu" );
  add_action( "oik_presentation_footer", "oik_presentation_footer" );
  add_action( "oik_presentation_navigation", "oik_presentation_navigation" );
}

oik_presentation_plugin_loaded();

