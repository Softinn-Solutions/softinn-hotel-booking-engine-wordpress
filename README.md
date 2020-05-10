# Softinn BE Wordpress Plugin

Version 1.0 features

* Settings link on the plugin page will direct admin to the plugin admin menu
* Softinn BE admin menu to customize the iframe output (Hotel ID, Theme Color)
* Shortcode that will display the Booking Engine iframe
* The variables are stored using WP Options Api database

Version 2.0.0 features

* Add widget of date range picker to the plugin which allows the user to input the date range then will be directed to the Softinn Booking Engine in a new tab.

## **Installation** 
### **Local Wordpress Environment**
#### Using Local by Flywheel 
* Download Local by Flywheel here [https://localbyflywheel.com/]
* Check this tutorial for installation procedure [https://www.youtube.com/watch?v=8jbQSZq4UYo]
* Pros, can do live search of plugins or themes available online.

#### Using Xampp 
* Download Xampp here [https://www.apachefriends.org/index.html]
* Check this tutorial for installation procedure [https://premium.wpmudev.org/blog/setting-up-xampp/]
* Cons, can't do live search of plugins or themes available online.

### **Installing the plugin**
#### Install via Wordpress.org plugin directory
1. Click add new plugins button.
2. Search for Softinn Booking Engine on the search bar.
3. Install
4. Activate

#### Install manually
1. Download the plugin from the Wordpress.org plugin directory [https://wordpress.org/plugins/softinn-booking-engine/]
2. Copy and paste the file to site-folder/app/public/wp-content/plugins
3. Activate the plugin on the wordpress site -> plugins menu

## **Examples**
### **To set the plugin info**
```php
Plugin Name: Softinn Booking Engine
Plugin URI:  https://wordpress.org/plugins/
Description: Display Softinn Booking Engine iframe using Shortcode. Admin plugin menu setting to set the Hotel Id and Theme Color.
Version:     2.0.0
Author:      Softinn Solutions Sdn Bhd
Author URI:  https://www.mysoftinn.com/
License:     GPL3
```
If the plugin info was setup correctly, it will show up on the plugin menu.

### **Action Hooks**
Basically hooks is used to link the view and the function. The add_action() will hook the admin_menu which is used to add menu page to the admin panel's menu structure. While the add_menu_page() will hook the menu page with the function admin_index().

Example
```php
add_action('admin_menu', 'softinnBE_plugin_menu_setup');

function softinnBE_plugin_menu_setup() 
{
    add_menu_page('Softinn Booking Engine Setting', 'Softinn BE ', 'manage_options', 'softinn_booking_engine', 'admin_index', 'dashicons-admin-multisite');
}

public function admin_index() 
{ 
    /**Some Code**/
}
```
Wordpress documentation:
* [https://codex.wordpress.org/Plugin_API/Action_Reference/admin_menu]
* [https://developer.wordpress.org/reference/functions/add_menu_page/]

Wordpress Hooks Database
* [https://adambrown.info/p/wp_hooks]

### **Enqueue**
All the jquery, javascript or css need to be enqued correctly using the Wordpress method. The enqueue can also be set whether to enqueue the file to front end or back end. It's also important to set the string handle to be unique so there wouldn't be a 

To enqueue css
```php
wp_enqueue_style('softinn_bootstrap');
```

To enqueue javascript or jquery
```php
wp_enqueue_script('softinn_bootstrap');
```

To enqueue at front-end
```php
add_action( 'wp_enqueue_scripts','softinn_enqueue_front' );
```

To enqueue at back-end
```php
add_action( 'admin_enqueue_scripts','softinn_enqueue_back' );
```

Wordpress documentation:
* [https://developer.wordpress.org/reference/functions/wp_enqueue_script/]
* [https://developer.wordpress.org/reference/hooks/wp_enqueue_scripts/]
* [https://codex.wordpress.org/Plugin_API/Action_Reference/wp_enqueue_scripts]
* [https://developer.wordpress.org/reference/hooks/admin_enqueue_scripts/]
* [https://codex.wordpress.org/Plugin_API/Action_Reference/admin_enqueue_scripts]

### **Using wordpress Options api to store value to the database**
|Function       |Usage                        |Example                                                               |
|---------------|-----------------------------|----------------------------------------------------------------------|
|add_option()   |Set the row name             |`add_option( 'softinn_hotel_id');`                                    |
|get_option()   |Retrieve the value on the row|`get_option('softinn_hotel_id');`                                     |
|update_option()|Update the value on the row  |`update_option('softinn_theme_color', $_POST["softinn_theme_color"]);`|
Wordpress documentation: 
* [https://codex.wordpress.org/Options_API]

### **Sanitizing, escaping and validating POST call**
* When you include POST/GET/REQUEST/FILE calls in your plugin, it's important to sanitize, validate, and escape them. The goal here is to prevent a user from accidentally sending trash data through the system, as well as protecting them from potential security issues. 

* SANITIZE: Data that is input (either by a user or automatically) must be sanitized. This lessens the possibility of XSS vulnerabilities and MITM attacks where posted data is subverted.

* VALIDATE: All data should be validated as much as possible. Even when you sanitize, remember that you don’t want someone putting in ‘dog’ when the only valid values are numbers.

* ESCAPE: Data that is output must be escaped properly, so it can't hijack admin screens. There are many esc_*() functions you can use to make sure you don't show people the wrong data. 

Example
```php
sanitize_text_field( $_POST["softinn_hotel_id"] );
sanitize_hex_color( $_POST["softinn_theme_color"] );
```
Wordpress documentation:
* [https://developer.wordpress.org/plugins/security/securing-input/]
* [https://developer.wordpress.org/plugins/security/securing-output/]

### **Using Nonces**
* To prevent unauthorized access. 
* Using wp_create_nonce() to create a unique number. 
* This unique number will be used to check whether the number is correct or not using wp_verify_nonce()

Nonce will be created if the current user is administrator
```php
if(current_user_can('administrator'))
{
    add_action('admin_menu', array( $this, 'softinnBE_plugin_menu_setup')); //admin menu will show-up if the user is admin
    $requestNonce =wp_create_nonce('form-nonce'); //create nonce if the user is admin
    update_option('softinn_admin_nonce',$requestNonce);
} 
```

If Nonce is not correct, it was set to die
```php
if(!wp_verify_nonce( $requestNonce, 'form-nonce' )){

    wp_die("Admin Form Hidden (nonce verification fail)");
}
```

Wordpress documentation:
* [https://developer.wordpress.org/plugins/security/nonces/]
* [https://developer.wordpress.org/plugins/javascript/ajax/#nonce]

## **Submitting to Wordpress Subversion**
To create local directory, adding plugin, editing existing files already covered in the wordpress documentation. 

Wordpress documentation:
* [https://developer.wordpress.org/plugins/wordpress-org/how-to-use-subversion/]

To add new files 
```
C:\my-local-dir> svn add *
C:\my-local-dir> svn add * --force
C:\my-local-dir> svn commit -m "add new files"
C:\my-local-dir> svn log
C:\my-local-dir\assets> svn add *
C:\my-local-dir\assets> svn commit
C:\my-local-dir\assets> svn commit -m "add plugin icon"
```








