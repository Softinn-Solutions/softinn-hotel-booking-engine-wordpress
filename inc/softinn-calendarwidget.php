<?php
/**
 * @package  SoftinnBE
 */
class Softinn_CalendarWidget extends WP_WIDGET
{
	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		$widget_ops = array( 
			'classname' => 'softinn_calendarwidget',
			'description' => 'Calendar widget that check availability of your hotel rooms.',
		);
		parent::__construct( 'softinn_calendarwidget', 'Softinn Calendar Widget', $widget_ops );
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		global $wpdb;

		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
		$layoutConfig = empty($instance['layoutConfig']) ? 'Vertical' : $instance['layoutConfig'];

		$hotel_id = get_option('softinn_hotel_id');

		$bookingpageVertical = 
		'
		<div class="softinn-calendarwidget">
    		<form target="_blank" method="get" action="https://booking.mysoftinn.com/BookHotelRoom/Web">
        		<input type="hidden" name="hotelId" value="'.$hotel_id.'">
        		<div class="mb-3">
            		<input class="border border-gray-300 rounded-md py-2 px-4" type="text" id="from" name="startDate" placeholder="Check-in" readonly>
        		</div>
        		<div class="mb-3">
            		<input class="border border-gray-300 rounded-md py-2 px-4" type="text" id="to" name="endDate" placeholder="Check-out" readonly>
        		</div>
        		<button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full" type="submit">Search</button>
    		</form>
		</div>
		';

		$bookingpageHorizontal = 
		'
		<div class="softinn-calendarwidget">
    <form target="_blank" method="get" action="https://booking.mysoftinn.com/BookHotelRoom/Web">
        <input type="hidden" name="hotelId" value="'.$hotel_id.'">
        
        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                <div class="relative">
                    <input class="block w-full py-2 pl-3 pr-10 leading-tight border rounded-md" type="text" id="from" name="startDate" placeholder="Check-in" readonly>
                    <div class="absolute inset-y-0 right-0 flex items-center mr-3">
                        <i class="dashicons dashicons-calendar-alt"></i>
                    </div>
                </div>
            </div>
            <div class="w-full md:w-1/2 px-3">
                <div class="relative">
                    <input class="block w-full py-2 pl-3 pr-10 leading-tight border rounded-md" type="text" id="to" name="endDate" placeholder="Check-out" readonly>
                    <div class="absolute inset-y-0 right-0 flex items-center mr-3">
                        <i class="dashicons dashicons-calendar-alt"></i>
                    </div>
                </div>
            </div>
        </div>

        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full w-full md:w-auto" type="submit">Search</button>
    </form>
</div>
		';

		echo $before_widget;
		if (!empty($title))
		{
			echo $before_title . $title . $after_title;;
		}
		if ($layoutConfig == 'Horizontal'){
			echo $bookingpageHorizontal;
		} else {
			echo $bookingpageVertical;
		}
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
		$layoutConfig = ! empty( $instance['layoutConfig'] ) ? $instance['layoutConfig'] : 'Vertical';

		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'text_domain' ); ?></label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
					name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" 
					type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('layoutConfig'); ?>">Layout: 
				<select class='widefat' id="<?php echo $this->get_field_id('layoutConfig'); ?>"
					name="<?php echo $this->get_field_name('layoutConfig'); ?>" type="text">
					<option value='Vertical'<?php echo ($layoutConfig=='Vertical')?'selected':''; ?>>
						Vertical
					</option>
					<option value='Horizontal'<?php echo ($layoutConfig=='Horizontal')?'selected':''; ?>>
						Horizontal
					</option> 
				</select>                
			</label>
		</p>
		<p>
			Display a calendar widget which allows user to check room availability.
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
		$instance['layoutConfig'] = $new_instance['layoutConfig'];
		return $instance;
	}
}