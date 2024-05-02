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
                    <th scope="row">Softinn Extranet</th>
                    <td>
                        <p>
                            <span class="dashicons dashicons-admin-tools" style="color: #46b450;"></span> Manage your calendar, bookings, payment & more 
                            <a href='<?php echo esc_url_raw( "https://booking.mysoftinn.com" ); ?>' target="_blank">here →</a>
                        </p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Plugin Function</th>
                    <td>
                        <p>
                            <span class="dashicons dashicons-desktop" style="color: #46b450;"></span> Just copy this shortcode [softinnBE] and paste it anywhere in the page to display the Softinn Booking Engine Iframe. 
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