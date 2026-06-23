<!-- html admin form -->

<div class="wrap">
    <h1>Plugin Options</h1>

    <form method="post" action="">
        <?php wp_nonce_field('softinn_save_settings', 'softinn_nonce'); ?>
        <table class="form-table">
            <tbody>
                <tr>
                    <th>Hotel ID</th>
                    <td>
                        <fieldset>
                            <input class="regular-text" type="text" name="softinn_hotel_id" pattern="^[0-9]*$" value="<?php echo esc_attr(get_option('softinn_hotel_id')); ?>" />
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Theme Customisation</th>
                    <td>
                        <p>
                            <span class="dashicons dashicons-admin-customizer" style="color: #8ebc00;"></span> Customise your booking engine theme, colours, and branding on the Softinn Booking Engine.
                            <a href='<?php echo esc_url("https://be.mysoftinn.com/booking-engine/customize"); ?>' target="_blank" rel="noopener noreferrer">Customise Theme →</a>
                        </p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Booking Engine</th>
                    <td>
                        <p>
                            <span class="dashicons dashicons-desktop" style="color: #8ebc00;"></span> Copy this shortcode [softinnBE] and paste it anywhere in the page content, the booking engine will show up. 
                        </p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Calendar Widget</th>
                    <td>
                        <p>
                            <span class="dashicons dashicons-calendar-alt" style="color: #8ebc00;"></span> Install calendar widget by navigating to Appearance > Widgets > Softinn Calendar Widget.
                        </p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Manage Bookings</th>
                    <td>
                        <p>
                            <span class="dashicons dashicons-post-status" style="color: #8ebc00;"></span> To manage all the bookings received, please visit 
                            <a href='<?php echo esc_url( "https://be.mysoftinn.com/booking" ); ?>' target="_blank" rel="noopener noreferrer">Softinn Booking Dashboard →</a>
                        </p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Manage Price</th>
                    <td>
                        <p>
                            <span class="dashicons dashicons-index-card" style="color: #8ebc00;"></span> To manage room price and calendar, please visit
                            <a href='<?php echo esc_url( "https://be.mysoftinn.com/availability/table-view" ); ?>' target="_blank" rel="noopener noreferrer">Softinn Room Price →</a>
                        </p>
                    </td>
                </tr>
                <tr>            
                    <th scope="row">Softinn Extranet</th>
                    <td>
                        <p>
                            <span class="dashicons dashicons-star-filled" style="color: #8ebc00;"></span> To manage calendar, users, promotions, etc., please visit
                            <a href='<?php echo esc_url( "https://be.mysoftinn.com" ); ?>' target="_blank" rel="noopener noreferrer">Softinn Booking Engine →</a>
                        </p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Get Hotel ID</th>
                    <td>
                        <p>
                            <span class="dashicons dashicons-editor-help" style="color: #8ebc00;"></span> <a href='<?php echo esc_url( "https://www.mysoftinn.com/contact-us" ); ?>' target="_blank" rel="noopener noreferrer">Need help?</a> Don't have a Hotel Id? <a href='<?php echo esc_url( "https://page.mysoftinn.com/softinn-signup-form" ); ?>' target="_blank" rel="noopener noreferrer">Register here</a>
                        </p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">For More Information</th>
                    <td>
                        <p>
                            <span class="dashicons dashicons-editor-help" style="color: #8ebc00;"></span> <a href='<?php echo esc_url( "https://www.mysoftinn.com" ); ?>' target="_blank" rel="noopener noreferrer">Visit Official Website</a> or <a href='<?php echo esc_url( "https://www.facebook.com/mySoftinn/" ); ?>' target="_blank" rel="noopener noreferrer">Facebook Fan Page</a>
                            
                        </p>
                    </td>
                </tr>
            </tbody>
        </table>
        <?php submit_button('Save Settings', 'primary'); ?>
    </form>
</div>