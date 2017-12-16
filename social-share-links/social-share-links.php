<?php
/*
Plugin Name:  SeaBadgerMD Social Share Links
Plugin URI:   https://seabadger.io/
Description:  Add static social share links to posts in SeaBadgerMD theme
Version:      1.0.0
Author:       SeaBadger.io
Author URI:   https://seabadger.io/about
License:      GNU GPLv3 or later
License URI:  https://www.gnu.org/licenses/gpl.txt
Text Domain:  sbmdssl
Domain Path:  /languages

Social Share Links is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
any later version.

Social Share Links is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Title Iconizer. If not, see https://www.gnu.org/licenses/gpl.txt.
*/

register_activation_hook( __FILE__, 'sbmdssl_activate' );

register_deactivation_hook( __FILE__, 'sbmdssl_deactivate' );

function sbmdssl_activate() {
}

function sbmdssl_deactivate() {
	remove_filter( 'the_content', 'sbmdssl_add_links', 20 );
}

function sbmdssl_add_links( $content ) {
	$social_links = '<div class="social-share-links">' .
	'<i class="fa fa-share-alt"></i><span class="sr-only">Share</span>' .
	sbmdssl_twitter_link() .
	sbmdssl_facebook_link() .
	sbmdssl_gplus_link() .
	sbmdssl_linkedin_link() .
	'</div>';
	$content .= $social_links;
	return $content;
}
add_filter( 'the_content', 'sbmdssl_add_links', 20 );

function sbmdssl_enqueue_style() {
	wp_register_style( 'sbmdsslcss', plugins_url( 'style.css', __FILE__ ) );
	wp_enqueue_style( 'sbmdsslcss' );
}
add_action( 'wp_enqueue_scripts', 'sbmdssl_enqueue_style' );


function sbmdssl_gplus_link() {
	$button = '<a target="_blank" href="https://plus.google.com/share?url=' .
	urlencode( get_permalink() ) . '" class="btn btn-sm" title="Share on G+" rel="nofollow">' .
	'<i class="fa fa-google-plus"></i><span class="sr-only">Share on G+</span></a>';
	return $button;
}

function sbmdssl_twitter_link() {
	$button = sprintf( '<a target="_blank" href="https://twitter.com/intent/tweet?url=%s&text=%s&hashtags=%s"' .
		' class="btn btn-sm" title="Tweet" rel="nofollow">' .
		'<i class="fa fa-twitter"></i><span class="sr-only">Tweet</span></a>',
		urlencode( get_permalink() ),
		urlencode( get_the_title() ),
		urlencode( sbmdssl_tags() )
	);
	return $button;
}

function sbmdssl_facebook_link() {
	$button = '<a target="_blank" href="http://www.facebook.com/sharer.php?u=' .
	urlencode( get_permalink() ) . '" class="btn btn-sm" title="Share on Facebook" ' .
	'rel="nofollow"><i class="fa fa-facebook"></i><span class="sr-only">Share on Facebook</span></a>';
	return $button;
}

function sbmdssl_linkedin_link() {
	$button = sprintf( '<a target="_blank" href="https://www.linkedin.com/shareArticle?url=%s&title=%s"' .
		' class="btn btn-sm" title="Share on LinkedIn" rel="nofollow">' .
		'<i class="fa fa-linkedin"></i><span class="sr-only">Share on LinkedIn</span></a>',
		urlencode( get_permalink() ),
		urlencode( get_the_title() )
	);
	return $button;
}

function sbmdssl_tags() {
	$tags = array();
	foreach ( get_the_tags() as $tag ) {
		array_push( $tags, $tag->name );
	}
	return implode( ',', $tags );
}
