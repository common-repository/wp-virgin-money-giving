<?php

/**
 * Fired during plugin activation
 *
 * @link       http://www.squareonemd.co.uk
 * @since      1.0.0
 *
 * @package    WP_Virgin_Money_Giving
 * @subpackage WP_Virgin_Money_Giving/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    WP_Virgin_Money_Giving
 * @subpackage WP_Virgin_Money_Giving/includes
 * @author     Your Name <email@example.com>
 */
class WP_Virgin_Money_Giving_Activator {
		
	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		
		$pages = array(
			'Test Virgin API'
		);

		foreach ($pages as $page) {

			// Initialize the page ID to -1. This indicates no action has been taken.
			$post_id = -1;
		
			// Setup the author, slug, and title for the post
			$author_id = 1;
			$title = $page;
		
			// If the page doesn't already exist, then create it
			if( null == get_page_by_title( $title ) ) {

				// Set the post ID so that we know the post was created successfully
				$post_id = wp_insert_post(
					array(
						'comment_status'	=>	'closed',
						'ping_status'		=>	'closed',
						'post_author'		=>	$author_id,
						'post_title'		=>	$title,
						'post_status'		=>	'publish',
						'post_type'		=>	'page'
					)
				);
		
			// Otherwise, we'll stop
			} else {
	    		// Arbitrarily use -2 to indicate that the page with the title already exists
	    		$post_id = -2;
		
			} 
	
		}

	}
	
}
