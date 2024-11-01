<?php

/**
 * Fired during plugin deactivation
 *
 * @link       http://www.squareonemd.co.uk
 * @since      1.0.0
 *
 * @package    WP_Virgin_Money_Giving
 * @subpackage WP_Virgin_Money_Giving/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    WP_Virgin_Money_Giving
 * @subpackage WP_Virgin_Money_Giving/includes
 * @author     Your Name <email@example.com>
 */
class WP_Virgin_Money_Giving_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		
		delete_transient( 'virgin_fundraisers_page_details' );
		delete_transient( 'virgin_fundraisers_page_details_1' );
		delete_transient( 'virgin_fundraisers_page_details_3' );
		delete_transient( 'virgin_fundraisers_page_details_4' );

	}

}
