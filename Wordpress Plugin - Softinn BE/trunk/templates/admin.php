<!-- html admin form -->

<div class="wrap">
    <h1>Plugin Options</h1>

    <form method="post" action="">
        <table class="form-table">
            <tbody>
                <tr>
                    <th>Hotel ID</th>
                    <td>
                        <fieldset>
                            <input class="regular-text" type="text" name="softinn_hotel_id" pattern="^[0-9]*" value="<?php echo get_option('softinn_hotel_id'); ?>" />
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <th>Theme Color</th>
                    <td>
                        <fieldset>
                            <input type="text" name="softinn_theme_color" class="color-picker" id='color-picker-1' value="<?php echo get_option('softinn_theme_color')? esc_attr( get_option('softinn_theme_color')) : '#8ebc00'; ?>"/>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Booking Engine</th>
                    <td>
                        <p>
                            <span class="dashicons dashicons-desktop" style="color: <?php echo get_option('softinn_theme_color')? : '#8ebc00'; ?>;"></span> Copy this shortcode [softinnBE] and paste it anywhere in the page content, the booking engine will show up. 
                        </p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Calendar Widget</th>
                    <td>
                        <p>
                            <span class="dashicons dashicons-calendar-alt" style="color: <?php echo get_option('softinn_theme_color')? : '#8ebc00'; ?>;"></span> Install calendar widget by navigating to Appearance > Widgets > Softinn Calendar Widget.
                        </p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Manage Bookings</th>
                    <td>
                        <p>
                            <span class="dashicons dashicons-post-status" style="color: <?php echo get_option('softinn_theme_color')? : '#8ebc00'; ?>;"></span> To manage all the bookings received, please visit 
                            <a href='<?php echo esc_url_raw( "https://booking.mysoftinn.com/Booking" ); ?>' target="_blank">Softinn Booking Dashboard →</a>
                        </p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Manage Price</th>
                    <td>
                        <p>
                            <span class="dashicons dashicons-index-card" style="color: <?php echo get_option('softinn_theme_color')? : '#8ebc00'; ?>;"></span> To manage room price and calendar, please visit
                            <a href='<?php echo esc_url_raw( "https://booking.mysoftinn.com/Price" ); ?>' target="_blank">Softinn Room Price →</a>
                        </p>
                    </td>
                </tr>
                <tr>            
                    <th scope="row">Softinn Extranet</th>
                    <td>
                        <p>
                            <span class="dashicons dashicons-star-filled" style="color: <?php echo get_option('softinn_theme_color')? : '#8ebc00'; ?>;"></span> To manage calendar, users, promotions, etc., please visit
                            <a href='<?php echo esc_url_raw( "https://booking.mysoftinn.com" ); ?>' target="_blank">Softinn Extranet →</a>
                        </p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Get Hotel ID</th>
                    <td>
                        <p>
                            <span class="dashicons dashicons-editor-help" style="color: <?php echo get_option('softinn_theme_color')? : '#8ebc00'; ?>;"></span> <a href='<?php echo esc_url_raw( "https://www.mysoftinn.com/Home/Contact" ); ?>' target="_blank">Need help?</a> Don't have a Hotel Id? <a href='<?php echo esc_url_raw( "https://page.mysoftinn.com/softinn-signup-form" ); ?>' target="_blank">Register here</a>
                        </p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">For More Information</th>
                    <td>
                        <p>
                            <span class="dashicons dashicons-editor-help" style="color: <?php echo get_option('softinn_theme_color')? : '#8ebc00'; ?>;"></span> <a href='<?php echo esc_url_raw( "https://www.mysoftinn.com" ); ?>' target="_blank">Visit Official Website</a> or <a href='<?php echo esc_url_raw( "https://www.facebook.com/mySoftinn/" ); ?>' target="_blank">Facebook Fan Page</a>
                            
                        </p>
                    </td>
                </tr>
            </tbody>
        </table>
        <?php 
        if(current_user_can('administrator')){
            submit_button('Save Settings', 'primary'); 
        } 
        ?>
    </form>
</div>