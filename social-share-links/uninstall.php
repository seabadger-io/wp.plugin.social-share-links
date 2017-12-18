<?php
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	die;
}

$post_meta_names = array( '_sbmdssl_display_social_share_links' );

foreach ( $post_meta_names as $key ) {
	delete_post_meta_by_key( $key );
}
