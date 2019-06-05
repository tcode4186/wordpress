<?php
/**
 * Plugin Name: Tcode Menu Mobile
 */


define('TCODE_PLUGIN_URI' , plugin_dir_path(__FILE__) . '/views/');


/*
 * Add css + js
 */
add_action( 'wp_enqueue_scripts','pluginCss' , 100);
function pluginCss() {
    $fileFolderCss = glob(plugin_dir_path(__FILE__) . '/css/*.css');
    $script_handle = 'plugin-style';
    foreach ($fileFolderCss as $file) {
        $handle = $script_handle. '-' .basename($file, '.css');
        wp_register_style($handle, plugin_dir_url(__FILE__) .'css/'. basename($file));
        wp_enqueue_style($handle);
    }
    // Initialize variables
    $script_handle = 'plugin-script';
    // Register project js files
    $js_files = glob(plugin_dir_path(__FILE__) . 'js/*.js');
    foreach ( $js_files as $fileJs ) {
        $handle = $script_handle. '-' .basename($fileJs, '.js');
        wp_register_script($handle, plugin_dir_url(__FILE__) .'js/'. basename($fileJs), array('jquery'), false, true);
        wp_enqueue_script($handle);
    }
}

/*
 * Tạo menu trong admin
 */

add_action('admin_menu', 'Setting_Menu_Mobile');
function Setting_Menu_Mobile(){
    add_menu_page( 'Menu Mobile', 'Menu Mobile', 'manage_options','menu-mobile', 'Sql_Tcode_Menu_Mobile','', 100 );
}

function  Sql_Tcode_Menu_Mobile()
{
    echo '<h2>Menu Mobile</h2>';
}


add_action('wp_footer', 'Tcode_menu_mobile');
function Tcode_menu_mobile(){
    require TCODE_PLUGIN_URI . 'menu-mobile.php';
}