<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://www.squareonemd.co.uk
 * @since      1.0.0
 *
 * @package    WP_Virgin_Money_Giving
 * @subpackage WP_Virgin_Money_Giving/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    WP_Virgin_Money_Giving
 * @subpackage WP_Virgin_Money_Giving/public
 * @author     Your Name <email@example.com>
 */
class WP_Virgin_Money_Giving_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $WP_Virgin_Money_Giving    The ID of this plugin.
	 */
	private $WP_Virgin_Money_Giving;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $WP_Virgin_Money_Giving       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $WP_Virgin_Money_Giving, $version ) {

		$this->WP_Virgin_Money_Giving = $WP_Virgin_Money_Giving;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in WP_Virgin_Money_Giving_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The WP_Virgin_Money_Giving_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->WP_Virgin_Money_Giving, plugin_dir_url( __FILE__ ) . 'css/wp-virgin-money-giving-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in WP_Virgin_Money_Giving_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The WP_Virgin_Money_Giving_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->WP_Virgin_Money_Giving, plugin_dir_url( __FILE__ ) . 'js/wp-virgin-money-giving-public.js', array( 'jquery' ), $this->version, false );

	}


	public function test_virgin_api( $template ) {
	
		if ( is_page( 'test-virgin-api' )  ) {
			
			$new_template = plugin_dir_path( __FILE__ ) . 'partials/test-virgin-api.php';;
			if ( '' != $new_template ) {
				return $new_template ;
			}
		}
	
		return $template;
	}

}
