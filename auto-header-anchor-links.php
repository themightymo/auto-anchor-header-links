<?php
/*
Plugin Name: Auto Header Anchor Links
Plugin URI: https://www.themightymo.com/
Description: Dynamically adds anchor links when you hover over any header tag (H1, H2, H3, etc.)
Author: themightymo
Author URI: https://www.themightymo.com
Version: 1.2
License: GPLv2 or later
Text Domain: themightymo
GitHub Plugin URI: themightymo/auto-anchor-header-links
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

Copyright 2018 The Mighty Mo! Design Co. LLC
*/
	
/**
	 * Automatically add IDs to headings such as <h2></h2> AND add the little href link icon before each header.
	 * via https://jeroensormani.com/automatically-add-ids-to-your-headings/
*/
function auto_id_headings( $content ) {

	$content = preg_replace_callback( '/(\<h[1-6](.*?))\>(.*)(<\/h[1-6]>)/i', function( $matches ) {
		if ( ! stripos( $matches[0], 'id=' ) ) :
			$heading_link = '<a href="#' . sanitize_title( $matches[3] ) . '" class="heading-link"><i class="fa fa-link"></i></a>';
			$matches[0] = $matches[1] . $matches[2] . ' id="' . sanitize_title( $matches[3] ) . '">' . $heading_link . $matches[3] . $matches[4];
		endif;

		return $matches[0];
	}, $content );

    return $content;

}
add_filter( 'the_content', 'auto_id_headings' );

/* 
	* enqueue the fontawesome styles 
	* via https://alienwp.com/font-awesome-wordpress-guide/#Step_1_Enqueue_Font_Awesome_Stylesheet_in_Your_WordPress_Theme 
*/
function enqueue_fontawesome() {
	wp_enqueue_style( 'load-fontawesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' );
}
add_action( 'wp_enqueue_scripts', 'enqueue_fontawesome' );


/* enqueue custom styles */
function auto_header_anchor_links_custom_css () {
	wp_enqueue_style( 'custom-css', plugin_dir_url( __FILE__ ) . 'auto-header-anchor-links.css' );
}
add_action('wp_enqueue_scripts', 'auto_header_anchor_links_custom_css');