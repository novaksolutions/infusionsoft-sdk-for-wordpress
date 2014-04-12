<?php

/*
Plugin Name: Infusionsoft SDK
Version: 1.0.8
Description: Integrate with the Infusionsoft API using the Novak Solutions SDK. This plugin is a dependency for other Infusionsoft plugins, like the <a href="http://wordpress.org/plugins/infusionsoft-one-click-upsell/">Infusionsoft One-click Upsell</a> plugin.
Author: Novak Solutions
Author URI: http://novaksolutions.com/
Plugin URI: http://novaksolutions.com/wordpress-plugins/infusionsoft-sdk/
*/

/**
 * Load Infusionsoft SDK if it isn't already loaded
 */
if( !class_exists('Infusionsoft_Classloader') ){
    require_once('Infusionsoft/infusionsoft.php');
}

/**
 * Check if options are set properly, and add credentials to SDK if they are.
 */
if (get_option('infusionsoft_sdk_app_name') && get_option('infusionsoft_sdk_api_key'))
{
    try{
        Infusionsoft_AppPool::addApp(new Infusionsoft_App(get_option('infusionsoft_sdk_app_name') . '.infusionsoft.com', get_option('infusionsoft_sdk_api_key')));
    } catch(Infusionsoft_Exception $e) {
        // SDK didn't load.
    }
}

/**
 * Display error message if app name and API key aren't set.
 */
function infusionsoft_sdk_error() {
    if(get_option('infusionsoft_sdk_app_name') == '' || get_option('infusionsoft_sdk_api_key') == ''){
        echo "<div class=\"error\"><p><strong>Please set your Infusionsoft SDK app name and API key on the <a href=\"" . admin_url( 'options-general.php?page=infusionsoft-sdk/infusionsoft-sdk.php' ) . "\">settings page.</a></strong></p></div>";
    }
}
add_action('admin_notices', 'infusionsoft_sdk_error');

/**
 * Add links to the admin plugin page.
 *
 * @param array $links
 * @param string $file
 * @return array
 */
function infusionsoft_sdk_plugin_action_links( $links, $file ) {
    if ( $file == plugin_basename( dirname(__FILE__).'/infusionsoft-sdk.php' ) ) {
        $links[] = '<a href="' . admin_url( 'options-general.php?page=infusionsoft-sdk/infusionsoft-sdk.php' ) . '">'.__( 'Settings' ).'</a>';
        $links[] = '<a href="http://novaksolutions.com/integrations/wordpress/?utm_source=wordpress&utm_medium=link&utm_content=sdk&utm_campaign=more-plugins">More Plugins by Novak Solutions</a>';
    }

    return $links;
}
add_filter('plugin_action_links', 'infusionsoft_sdk_plugin_action_links', 10, 2);

/**
 * Define the fields used on the settings page.
 */
function infusionsoft_sdk_admin_init(){
    add_settings_section('infusionsoft_sdk_settings',
        'Infusionsoft App',
        null,
        'infusionsoft_sdk_settings');

    add_settings_field('infusionsoft_sdk_app_name',
        'Infusionsoft&reg; App Name',
        'infusionsoft_sdk_callback_function_app_name',
        'infusionsoft_sdk_settings',
        'infusionsoft_sdk_settings');

    add_settings_field('infusionsoft_sdk_api_key',
        'Infusionsoft&reg; API Key',
        'infusionsoft_sdk_callback_function_api_key',
        'infusionsoft_sdk_settings',
        'infusionsoft_sdk_settings');

    register_setting('infusionsoft_sdk_settings', 'infusionsoft_sdk_app_name', 'infusionsoft_sdk_sanitize');
    register_setting('infusionsoft_sdk_settings', 'infusionsoft_sdk_api_key', 'infusionsoft_sdk_sanitize');
}
add_action('admin_init', 'infusionsoft_sdk_admin_init');

/**
 * Remove non-alphanumeric characters.
 *
 * @param string $value
 * @return string
 */
function infusionsoft_sdk_sanitize($value) {
    return preg_replace("/[^a-zA-Z0-9]+/", "", $value);
}

/**
 * Display the app name field.
 */
function infusionsoft_sdk_callback_function_app_name() {
    echo 'https://<input type="text" name="infusionsoft_sdk_app_name" value="' . get_option('infusionsoft_sdk_app_name') . '" size="15" />.infusionsoft.com<br />';
    echo '<span class="description">Your app name is the URL you use to access Infusionsoft.</span>';
}

/**
 * Display the API key field.
 */
function infusionsoft_sdk_callback_function_api_key() {
    echo '<input type="text" name="infusionsoft_sdk_api_key" value="' . get_option('infusionsoft_sdk_api_key') . '" size="45" /><br />';
    echo '<span class="description"><a href="http://ug.infusionsoft.com/article/AA-00442/0/How-do-I-enable-the-Infusionsoft-API-and-generate-an-API-Key.html">Click here</a> for instructions on finding your API key.</span>';
}

/**
 * Add the settings page to the menu.
 */
function infusionsoft_sdk_add_admin_menu(){
    add_options_page(
        'Infusionsoft SDK Settings',    // Title
        'Infusionsoft SDK',             // Sub-menu title
        'install_plugins',              // Security
        __FILE__,                       // File to open
        'infusionsoft_sdk_display_admin_page'    // Function to call
    );
}
add_action('admin_menu', 'infusionsoft_sdk_add_admin_menu');

/**
 * Content for the link back to Novak Solutions and the plugin directory.
 */
function infusionsoft_sdk_display_link_back(){
    echo '<h2>Like this plugin?</h2>';
    echo '<p>If you found this plugin useful, please <a href="http://wordpress.org/support/view/plugin-reviews/infusionsoft-sdk">rate it in the plugin directory</a>.</p>';
    echo '<p>Visit <a href="http://novaksolutions.com/?utm_source=wordpress&amp;utm_medium=link&amp;utm_campaign=sdk">Novak Solutions</a> to find dozens of free tips, tricks, and tools to help you get the most out of Infusionsoft®.</p>';
}

/**
 * Display the settings form and link back.
 */
function infusionsoft_sdk_display_admin_page(){
    echo '<h2>Infusionsoft SDK Settings</h2>';

    echo '<form method="POST" action="options.php">';
    settings_fields('infusionsoft_sdk_settings');   //pass slug name of page
    do_settings_sections('infusionsoft_sdk_settings');    //pass slug name of page
    submit_button();
    echo '</form>';

    infusionsoft_sdk_display_link_back();
}
