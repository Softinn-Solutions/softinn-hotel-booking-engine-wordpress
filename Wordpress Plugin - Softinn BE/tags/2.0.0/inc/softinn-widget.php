<?php
/**
 * @package  SoftinnBE
 */
class Softinn_Widget extends WP_WIDGET
{
	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		$widget_ops = array( 
			'classname' => 'softinn_widget',
			'description' => 'The widget will allow to accept date range and redirect user to the Softinn BE iframe page',
		);
		parent::__construct( 'softinn_widget', 'Softinn Widget', $widget_ops );
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		global $wpdb;
		// outputs the content of the widget
		$hotel_id = $wpdb->get_var("SELECT option_value FROM wp_options WHERE option_name = 'softinn_hotel_id'");

		$bookingpage = 
		'
		<div class="softinn-widget">
			<form target="_blank" method="get" action="https://booking.mysoftinn.com/BookHotelRoom/Web"> 
				<input type="hidden" name="hotelId" value="'.$hotel_id.'">
				<div class="input-group mb-3">
					<div class="input-group-prepend">
						<span class="input-group-text"><i class="dashicons dashicons-calendar-alt"></i></span>
					</div>
					<input class="form-control" type="text" id="from" name="startDate" placeholder="Check-in" readonly>
				</div>
				<div class="input-group mb-3">
					<div class="input-group-prepend">
						<span class="input-group-text"><i class="dashicons dashicons-calendar-alt"></i></span>
					</div>
					<input class="form-control" type="text" id="to" name="endDate" placeholder="Check-out" readonly>
				</div>
				<button class="btn btn-primary btn-block" type="submit">Search</button>
			</form>
		</div>
		';

		echo $before_widget;
		//echo $before_title . $softinn_widget .   $after_title;
		if ( ! empty( $instance['title'] ) ) {echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];}
		echo $bookingpage;
		echo $after_widget;
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {
		// outputs the options form on admin
		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Find A Room', 'text_domain' );
		?>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'text_domain' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			The widget will allow user to input the date range of room reservation. The user will then be redirected to the Softinn Booking Engine page on a new tab.
		</p>
		<?php
	}

	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 *
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		// processes widget options to be saved
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';

		return $instance;
	}
}