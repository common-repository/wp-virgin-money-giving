<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.squareonemd.co.uk
 * @since      1.0.0
 *
 * @package    WP_Virgin_Money_Giving
 * @subpackage WP_Virgin_Money_Giving/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    WP_Virgin_Money_Giving
 * @subpackage WP_Virgin_Money_Giving/admin
 * @author     Your Name <email@example.com>
 */
class WP_Virgin_Money_Giving_Admin {

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
	
	private $option;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $WP_Virgin_Money_Giving       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $WP_Virgin_Money_Giving, $version ) {

		$this->WP_Virgin_Money_Giving = $WP_Virgin_Money_Giving;
		$this->version = $version;
		$this->options = get_option( 'wp_virgin_money_giving_options_name' );

	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->WP_Virgin_Money_Giving, plugin_dir_url( __FILE__ ) . 'css/wp-virgin-money-giving-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script( $this->WP_Virgin_Money_Giving, plugin_dir_url( __FILE__ ) . 'js/wp-virgin-money-giving-admin.js', array( 'jquery' ), $this->version, false );

		wp_localize_script( $this->WP_Virgin_Money_Giving, 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'nonce' => wp_create_nonce('vmg-nonce')) );

	}

	public function wp_virgin_money_giving() {
		add_options_page( 
			'Virgin Money Giving',
			'Virgin Money Giving',
			'manage_options',
			'virgin-money-giving-settings',
			array($this,'wp_virgin_money_giving_settings_page')
		);
	}

	public function wp_virgin_money_giving_settings_page() {
		include plugin_dir_path( __FILE__ ) . 'partials/wp-virgin-money-giving-admin-display.php';
	}
	
	public function wp_virgin_money_giving_settings() {
		register_setting(
			'wp_virgin_money_giving_options_group',
			'wp_virgin_money_giving_options_name',
			array($this, 'sanitize')
		);
		
		add_settings_section(
			'wp_virgin_money_giving_fundraiser_key_id',
			'Fundraiser Developer',
			array($this, 'print_section_info'),
			'virgin-money-giving-settings'
		);
		
		add_settings_field(
            'fundDevelopersKey', // ID
            'Key', // Title 
            array( $this, 'fundDevelopersKey_callback' ), // Callback
            'virgin-money-giving-settings', // Page
            'wp_virgin_money_giving_fundraiser_key_id' // Section           
		);

		add_settings_section(
			'wp_virgin_money_giving_fundraiser_resource_id',
			'Fundraiser API Reference',
			array($this, 'print_section_resource_id_info'),
			'virgin-money-giving-settings'
		);
		
		add_settings_field(
            'fundResourceID', // ID
            'API Reference', // Title 
            array( $this, 'fundResourceID_callback' ), // Callback
            'virgin-money-giving-settings', // Page
            'wp_virgin_money_giving_fundraiser_resource_id' // Section           
		);

	}
	
	public function print_section_info() {
		print 'Input the Fundraisers developer key from your Virgin Money Giving developers account here.';
	}
	
	public function print_section_resource_id_info() {
		print 'Input the Fundraisers API reference from your Virgin Money Giving account here.';
	}
	
    public function fundDevelopersKey_callback()
    {	
        printf(
            '<input class="regular-text" type="text" id="fundDevelopersKey" name="wp_virgin_money_giving_options_name[fundDevelopersKey]" value="%s" /><span class="description"> Provided in your Virgin Money Giving Developers Account</span>',
            isset( $this->options['fundDevelopersKey'] ) ? esc_attr( $this->options['fundDevelopersKey']) : ''
        );
    }
    
    public function fundResourceID_callback()
    {	
        printf(
            '<input class="regular-text" type="text" id="fundResourceID" name="wp_virgin_money_giving_options_name[fundResourceID]" value="%s" /><span class="description"> Provided in your Virgin Money Giving Account</span>',
            isset( $this->options['fundResourceID'] ) ? esc_attr( $this->options['fundResourceID']) : ''
        );
    }
    
    public function sanitize( $input )
    {
        $new_input = array();
        if( isset( $input['fundDevelopersKey'] ) )
            $new_input['fundDevelopersKey'] = strip_tags( $input['fundDevelopersKey'] );

        if( isset( $input['fundResourceID'] ) )
            $new_input['fundResourceID'] = strip_tags( $input['fundResourceID'] );

        return $new_input;
    }
    
    public function vmg_settings_results() {
		$success = array();
		$error = array();
		$vmg_settings = get_option('wp_virgin_money_giving_options_name');
		
		var_dump($vmg_settings);
		
		if (isset($vmg_settings) && !empty($vmg_settings)) {
			
			$success['success'][] = 'API settings are set!';
			
			$api_call = new Virgin_Money_Giving_Fundraisers(array('fundDevelopersKey' => $vmg_settings['fundDevelopersKey']));
			$api_call_response = $api_call->get_fundraisers_details($vmg_settings['fundResourceID']);
			
			if (isset($api_call_response['error']) && !empty($api_call_response['error'])) {
				$error['error'][] = $api_call_response['error'];
			} else {
				$success['fundraiser'][] = $api_call_response;
			}
			
			
		} else {
			$error['error'][] = 'API settings are not set!';
		}
		
		$results = $success + $error;
		return $results;
    }
    
    public function verify_vmg_api() {
	    $nonce = $_POST['nextNonce'];
		if ( ! wp_verify_nonce( $nonce, 'vmg-nonce' ) ) {
		    die( 'Security check busted!' ); 
		} else {
			$results = $this->vmg_settings_results();
		?>
	    	<?php if (isset($results['error']) && !empty($results['error'])) { ?>
				<div class="vmg-response-error notice notice-error">
					<h2 class="red">Error!</h2>
					<ul>
						<?php foreach ($results['error'][0] as $k => $error) { ?>
							<li><?php echo esc_html($k . ' : ' . $error); ?></li>
						<?php } ?>
					</ul>
				</div>
	    	<?php } ?>
			
			<?php if (isset($results['success']) && !empty($results['success'])) { ?>
				<div class="vmg-response-success notice notice-success is-dismissible">
					<ul>
						<?php foreach ($results['success'] as $k => $success) { ?>
							<li><?php echo esc_html($success); ?></li>
						<?php } ?>
						
						<?php foreach ($results['fundraiser'][0] as $k => $success) { ?>
							<?php if (!is_array($success)) { ?>
								<li><?php echo esc_html($k . ' : ' . $success); ?></li>
							<?php } else { ?>
								<li><strong><?php echo esc_html($k); ?></strong></li>
							<?php } ?>
						<?php } ?>

						<?php foreach ($results['fundraiser'][0]['pageSummary'] as $k => $pages) { ?>
							
							<?php if (!is_array($pages)) { ?>
								<li><?php echo esc_html($k . ' : ' . $pages); ?></li>
							<?php } else { ?>
								<li><strong><?php echo esc_html($k); ?></strong></li>
							<?php } ?>

							
							<ul class="sub">
								<?php foreach ($pages as $k => $page) { ?>
									
									<?php if (!is_array($page)) { ?>
										<li><?php echo esc_html($k . ' : ' . $page); ?></li>
									<?php } else { ?>
										<li><strong><?php echo esc_html($k); ?></strong></li>
									<?php } ?>
									
									
									<ul class="sub-sub">
									<?php foreach ($page as $k => $v) { ?>
										<li><?php echo esc_html($k . ' : ' . $v); ?></li>
									<?php } ?>
									</ul>
								<?php } ?>
							</ul>
							
						<?php } ?>
					</ul>
				</div>
			<?php } ?>
	    
	    <?php }
	    
		die(); // this is required to terminate immediately and return a proper response
    }
    
    public function check_vmg_options() { ?>

		<div class="vmg-response">
			
			<div class="vmg-check-api">
				<input class="button-primary verify-vmg" type="submit" name="Example" value="<?php esc_attr_e( 'Verify your Virgin Money Giving settings' ); ?>" />
			</div>

			
			<div class="vmg-response-checking notice notice-info" style="display: none">
				<h2 class="green">Checking your Virgin API settings... <span class="spinner is-active" style="float:none;width:auto;height:auto;padding:10px 0 10px 50px;background-position:20px 0;"></span></h2>
			</div>
			
			
		</div>

    <?php }

}
