<?php
   /*
   Plugin Name: CF7 DatePicker
   Description: An alternative/fix to Contact Forms 7 date selector
   Version: 1.1
   Author: Mark O'Brien
   Author URI: http://minnebyte.com
   License: GPL2
   */


function cf7dp_activation() {

}

register_activation_hook(__FILE__, 'cf7dp_activation');

function cf7dp_deactivation() {

}

register_deactivation_hook(__FILE__, 'cf7dp_deactivation');

add_action('wp_enqueue_scripts', 'cf7dp_scripts');

function cf7dp_scripts() {

    global $post;

    wp_register_script( 'custom_script', plugins_url( '/js/custom-script.js', __FILE__, true ) ); 

    wp_register_style( 'jquery-ui-css', plugins_url( '/css/jquery-ui.css', __FILE__, true ) ); 

    $content = $post->post_content;
    $cf7_shortcode = 'contact-form-7';

      if (strpos($content, $cf7_shortcode) !== false) {

       wp_enqueue_script('jquery');
       wp_enqueue_script('jquery-ui-datepicker');
       wp_enqueue_script('jquery-effects-fade');
       wp_enqueue_script('jquery-effects-slide');
       wp_enqueue_script('jquery-effects-clip');                                          
       wp_enqueue_script('custom_script');
       wp_enqueue_style( 'jquery-ui-css' );

      }

    $effect      = (get_option('cf7dp_effect') == '') ? "slide" : get_option('cf7dp_effect');
    $show_week     = (get_option('cf7dp_show_week') == 'enabled') ? true : false;
    $monyearmenu    = (get_option('cf7dp_monyearmenu') == 'enabled') ? true : false;
        $config_array = array(
            'effect' => $effect,
            'showWeek' => $show_week,
            'monyearmenu' => $monyearmenu,
        );

    wp_localize_script('custom_script', 'setting', $config_array);

}

add_action('admin_enqueue_scripts', 'cf7dp_admin_styles');

function cf7dp_admin_styles() {

    wp_register_style( 'cf7-styles', plugins_url( '/css/cf7-styles.css', __FILE__, true ) ); 
    wp_enqueue_style( 'cf7-styles' );

}

add_action('admin_menu', 'cf7dp_plugin_settings');

function cf7dp_plugin_settings() {
    
    add_submenu_page('options-general.php', 'CF7 DatePicker Settings', 'CF7 DatePicker', 'administrator', 'datepicker_settings', 'datepicker_display_settings');
}

function datepicker_display_settings() {

    $slide_effect = (get_option('cf7dp_effect') == 'slide') ? 'selected' : '';
    $fade_effect = (get_option('cf7dp_effect') == 'fade') ? 'selected' : '';
    $clip_effect = (get_option('cf7dp_effect') == 'clip') ? 'selected' : '';
    $show_week  = (get_option('cf7dp_show_week') == 'enabled') ? 'checked' : '' ;
    $monyearmenu  = (get_option('cf7dp_monyearmenu') == 'enabled') ? 'checked' : '' ;

    $html = '<div class="cf7-wrap">

            <form method="post" name="options" action="options.php">
            <h2>CF7 Datepicker Settings</h2>' . wp_nonce_field('update-options') . '
            <table width="100%" cellpadding="10" class="form-table">
                <tr>
                    <td align="left" scope="row">
                    <label>Animations</label><select name="cf7dp_effect" >
                      <option value="slide" ' . $slide_effect . '>Slide</option>
                      <option value="fade" '.$fade_effect.'>Fade</option>
                      <option value="clip" '.$clip_effect.'>Clip</option>
                    </select>
                    </td> 
                </tr>
                <tr>
                    <td align="left" scope="row">
                    <label>Display Month & year menus</label><input type="checkbox" '.$monyearmenu.' name="cf7dp_monyearmenu" 
                    value="enabled" />
                    </td> 
                </tr>
                <tr>
                    <td align="left" scope="row">
                    <label>Show week of the year</label><input type="checkbox" '.$show_week.' name="cf7dp_show_week" 
                    value="enabled" />
                    </td> 
                </tr>
            </table>
            <p class="submit">
                <input type="hidden" name="action" value="update" />  
                <input type="hidden" name="page_options" value="cf7dp_monyearmenu,cf7dp_effect,cf7dp_show_week" /> 
                <input type="submit" name="Submit" value="Update" />
            </p>
            </form>

        </div>';
    echo $html;    

}
?>