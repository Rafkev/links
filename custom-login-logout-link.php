<?php
/*
Plugin Name: Custom Login/Logout Link
Description: Add login/logout link to primary menu with customizable text and font attributes. 
Version: 1.0
Author: Oluwasanmi Raphael
*/

// Add settings page to WordPress admin menu
function custom_login_logout_settings_menu() {
    add_options_page('Custom Login/Logout Settings', 'Custom Login/Logout', 'manage_options', 'custom_login_logout_settings', 'custom_login_logout_settings_page');
}
add_action('admin_menu', 'custom_login_logout_settings_menu');

// Register plugin settings
function custom_login_logout_register_settings() { 
    add_option('custom_login_text', 'Login');
    add_option('custom_logout_text', 'Logout');
    add_option('custom_font_family', 'Arial');
    add_option('custom_font_size', '14px');
    register_setting('custom_login_logout_settings_group', 'custom_login_text');
    register_setting('custom_login_logout_settings_group', 'custom_logout_text');
    register_setting('custom_login_logout_settings_group', 'custom_font_family');
    register_setting('custom_login_logout_settings_group', 'custom_font_size'); 
}
add_action('admin_init', 'custom_login_logout_register_settings');

// Function to render settings page
function custom_login_logout_settings_page() {
?>
    <div class="wrap">
        <h2>Custom Login/Logout Settings</h2>
        <form method="post" action="options.php">
            <?php settings_fields('custom_login_logout_settings_group'); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Login Text:</th>
                    <td><input type="text" name="custom_login_text" value="<?php echo get_option('custom_login_text'); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Logout Text:</th>
                    <td><input type="text" name="custom_logout_text" value="<?php echo get_option('custom_logout_text'); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Font Family:</th>
                    <td><input type="text" name="custom_font_family" value="<?php echo get_option('custom_font_family'); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Font Size:</th>
                    <td><input type="text" name="custom_font_size" value="<?php echo get_option('custom_font_size'); ?>" /></td>
                </tr>
            </table>
            <?php submit_button(); ?> 
        </form>
    </div>
<?php
}

// Function to add login/logout link to primary menu
function custom_login_logout_menu_link($items, $args) {
    if ($args->theme_location == 'primary') {
        $login_text = get_option('custom_login_text');
        $logout_text = get_option('custom_logout_text');
        $font_family = get_option('custom_font_family');
        $font_size = get_option('custom_font_size');
        
        $login_link = is_user_logged_in() ? wp_logout_url() : wp_login_url();
        $login_link_text = is_user_logged_in() ? $logout_text : $login_text;

        $items .= '<li><a style="font-family: ' . $font_family . '; font-size: ' . $font_size . ';" href="' . $login_link . '">' . $login_link_text . '</a></li>';
    }
    return $items;
}
add_filter('wp_nav_menu_items', 'custom_login_logout_menu_link', 10, 2);
