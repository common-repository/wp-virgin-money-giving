<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://www.squareonemd.co.uk
 * @since      1.0.0
 *
 * @package    WP_Virgin_Money_Giving
 * @subpackage WP_Virgin_Money_Giving/admin/partials
 */
$class = new WP_Virgin_Money_Giving_Admin('WP_Virgin_Money_Giving', '1.0.0');

?>



<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap">
	
	<div id="icon-options-general" class="icon32"></div>
	<h2>Virgin Money Giving Settings</h2>
	
	<?php $class->check_vmg_options();?>
	
	<p>There are two things you'll need to start using the WordPress Virgin Money Giving plug-in, a <strong>fundraisers API key</strong> and a <strong>fundraisers API reference</strong>.

	<p>1. For the <strong>fundraisers API key</strong> sign in or register a developers account at the <a href="https://developer.virginmoneygiving.com/">developers virgin money giving website</a>. With your developers account created use the "get a fundraisers API key" link to create your fundraisers API key. All your API keys will be listed under the "My Account" link.
	<p>2. For the <strong>fundraisers API reference</strong> simply login to your personal Virgin Money Giving account and you'll find your <strong>fundraisers API reference</strong> in your main account page, it's referenced as "My fundraisers API reference:"
		
	<p>Simply copy and paste the <strong>fundraisers API key</strong> and the <strong>fundraisers API reference</strong> below then from within the WordPress dashboard go Dashboard > Appearance > Widgets and add the "Virgin Giving Fundraisers Page" widget to anyone of your sidebars, the widget will have options for you to select in order for the widget to function correctly.</p>

</p>
	
	<hr />	
	
</div> <!-- .wrap -->


<form method="post" action="options.php">
	<?php
		
	    settings_fields( 'wp_virgin_money_giving_options_group' );   
	    do_settings_sections( 'virgin-money-giving-settings' );
	    submit_button(); 
	?>
</form>