<?php
	
/**
 * Adds Fundraisers_Widget widget.
 */
class Fundraisers_Widget extends WP_Widget {
	
	/**
	 * a helper function to get fundraisers pages for selection.
	 */
	public function get_wp_virgin_giving_fundraisers_pages() {
		
		$wp_virgin_settings = get_option('wp_virgin_money_giving_options_name');
		
		if ($wp_virgin_settings != '') {
			
			$key = $wp_virgin_settings['fundDevelopersKey'];
			$resourceID = $wp_virgin_settings['fundResourceID'];

			$api = new Virgin_Money_Giving_Fundraisers(array(
			    'fundDevelopersKey' => $key
			));
						
			// Get any existing copy of our transient data
			if ( false === ( $fundraisers_details = get_transient( 'virgin_fundraisers_page_details_' . $virgin_page_id ) ) ) {
				// It wasn't there, so regenerate the data and save the transient
				$fundraisers_details = $api->get_fundraisers_details($resourceID);
				set_transient( 'virgin_fundraisers_page_details_' . $virgin_page_id, $fundraisers_details, 60 * 15 );
			}
			
			
			$pages = $fundraisers_details['pageSummary']['page'];
			
			$array = array();
			foreach ($pages as $page) {
				if (is_array($page)) {
					$exploded = explode('/', $page['pageUrl']);
					$array[end($exploded)] = $page['pageName'];
				} else {
					$exploded = explode('/', $pages['pageUrl']);
					$array[end($exploded)] = $pages['pageName'];
				}
			}
			
			return $array;
			
		} else {
			echo '<p>No API details provided, go to Dashboard > Settings > Virgin Money Giving for more details.</p>';
		}
		
		
	}

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'foo_widget', // Base ID
			__( 'Virgin Giving Fundraisers Page', 'wp_virgin_giving' ), // Name
			array( 'description' => __( 'Show the fundraisers Virgin Giving Page', 'wp_virgin_giving' ), ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
		}
		
		if ( ! empty( $instance['description'] ) ) {
			echo '<p class="vgm-description">' . esc_attr($instance['description']) . '</p>';
		}
		
		$virgin_page_id = $instance['fundraisers_page_select'];
		
		$virgin_page_image = $instance['image'];
		
		$wp_virgin_settings = get_option('wp_virgin_money_giving_options_name');
		
		
		if ($wp_virgin_settings != '' && $virgin_page_id) {
			
			$key = $wp_virgin_settings['fundDevelopersKey'];
			$resourceID = $wp_virgin_settings['fundResourceID'];

			$api = new Virgin_Money_Giving_Fundraisers(array(
			    'fundDevelopersKey' => $key
			));

			// Get any existing copy of our transient data
			if ( false === ( $fundraisers_page_details = get_transient( 'virgin_fundraisers_page_details_' . $virgin_page_id ) ) ) {
				// It wasn't there, so regenerate the data and save the transient
				$fundraisers_page_details = $api->get_fundraisers_page_details($resourceID, $virgin_page_id);
				set_transient( 'virgin_fundraisers_page_details_' . $virgin_page_id, $fundraisers_page_details, 60 * 15 );
			}
			
			$fundraisers_page_profile_image = $fundraisers_page_details->pageDetails[0]->pageImageLarge;
			$fundraisers_page_details = $fundraisers_page_details->pageDetails[0];
			
			if ($fundraisers_page_details->teamPage == true) {
				$fundraisers_page_url = $fundraisers_page_details->pageUrl . '&isTeam=true';
			} else {
				$fundraisers_page_url = $fundraisers_page_details->pageUrl;
			}
						
			$percentage = ($fundraisers_page_details->donationTotalGross / $fundraisers_page_details->targetAmount) * 100;

			?>
			
			<?php if (!empty($virgin_page_image)) { ?>
				<div id="vgm-image-<?php echo esc_attr($virgin_page_id); ?>" class="vgm-image">
					<img src="<?php echo esc_attr($fundraisers_page_profile_image); ?>" alt="Virgin profile image">
				</div>
			<?php } ?>
			
			<div id="vgm-widget" class="vgm-wrap">
				<div class="vgm-top">
					<p class="target">Target &pound;<?php echo esc_attr($fundraisers_page_details->targetAmount); ?></p>
				</div>
				<div class="meter">
					<span style="height: <?php if ($percentage < 100) { echo esc_attr($percentage); } else { echo '100'; } ?>%;">&pound;<?php echo esc_attr(number_format($fundraisers_page_details->donationTotalGross,2)); ?><br>raised</span>
				</div>
				<div class="vgm-base">
					<ul class="numbers">
						<li class="detail">Running Total: <span class="data">&pound;<?php echo esc_attr(number_format($fundraisers_page_details->donationTotalNet,2)); ?></span></li>
						<li class="detail">Offline Total: <span class="data">&pound;<?php echo esc_attr(number_format($fundraisers_page_details->offlineAmount,2)); ?></span></li>
						<li class="detail">Total Gift Aid: <span class="data">&pound;<?php echo esc_attr(number_format($fundraisers_page_details->totalGiftAid,2)); ?></span></li>
						<li class="detail">Total Donors: <span class="data"><?php echo esc_attr($fundraisers_page_details->numberOfDonations); ?></span></li>
					</ul>
					<a href="<?php echo esc_attr($fundraisers_page_url); ?>" target="_blank">
						<img src="<?php echo plugin_dir_url( dirname( __FILE__ ) )  . 'public/images/virgin-money-giving.png'; ?>" alt="virgin-money-giving" />
						<p>Donate Now >> </p>
					</a>
				</div>
			</div>
			
			<?php
/*
			echo '<pre>';
			print_r($fundraisers_page_details);
			echo '</pre>';
*/
		}

		
		
		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		
		$title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'New title', 'wp_virgin_giving' );

		$description = ! empty( $instance['description'] ) ? $instance['description'] : __( 'Description', 'wp_virgin_giving' );

		$image = ! empty( $instance['image'] ) ? $instance['image'] : __( '1', 'wp_virgin_giving' );

		$selected_page = ! empty( $instance['fundraisers_page_select'] ) ? $instance['fundraisers_page_select'] : __( 'Fund Raisers Page', 'wp_virgin_giving' );

		$array = $this->get_wp_virgin_giving_fundraisers_pages();
		
		//$selected_page = get_option('fundraisers_page_select');
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>

		<p>
		<label for="<?php echo $this->get_field_id( 'description' ); ?>"><?php _e( 'Description:' ); ?></label> 
		<textarea class="widefat" id="<?php echo $this->get_field_id( 'description' ); ?>" name="<?php echo $this->get_field_name( 'description' ); ?>" rows="10"><?php echo esc_attr( $description ); ?></textarea>
		</p>
		
		<p>
		<label for="<?php echo $this->get_field_id( 'image' ); ?>"><?php _e( 'Include Image:' ); ?></label> 
		<input type="checkbox" name="<?php echo $this->get_field_name( 'image' ); ?>" value="<?php echo esc_attr( $image ); ?>" <?php checked( $image, $instance['image'] ); ?> />

		</p>


		<p>
		<label for="<?php echo $this->get_field_id( 'fundraisers_page_select' ); ?>"><?php _e( 'Fundraisers Page:' ); ?></label> 
		<select name="<?php echo $this->get_field_name( 'fundraisers_page_select' ); ?>">
			<option value="">Select Page</option>
			<?php foreach ($array as $key => $value) { ?>
				<option value="<?php echo esc_attr($key); ?>" <?php selected( $selected_page, $key, true);?>><?php echo esc_attr($value);?></option>
			<?php } ?>
		</select>
		</p>

		<?php 
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		var_dump($new_instance);
		
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['description'] = ( ! empty( $new_instance['description'] ) ) ? strip_tags( $new_instance['description'] ) : '';
		$instance['image'] = ( ! empty( $new_instance['image'] ) ) ? strip_tags( $new_instance['image'] ) : '';
		$instance['fundraisers_page_select'] = ( ! empty( $new_instance['fundraisers_page_select'] ) ) ? strip_tags( $new_instance['fundraisers_page_select'] ) : '';

		return $instance;
	}

} // class Fundraisers_Widget

// register Fundraisers_Widget widget
function register_fundraisers_widget() {
    register_widget( 'Fundraisers_Widget' );
}
add_action( 'widgets_init', 'register_fundraisers_widget' );