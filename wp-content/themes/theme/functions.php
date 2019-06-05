<?php
/*
 *  GLOBAL VARIABLES
 */
define('THEME_DIR', get_stylesheet_directory());
define('THEME_URL', get_stylesheet_directory_uri());

/*
 *  INCLUDED FILES
 */

add_editor_style('css/button-web.css');

$file_includes = [
    'inc/theme-assets.php',                 // Style and JS
    'inc/theme-setup.php',                  // General theme setting
    'inc/acf-options.php',                  // ACF Option page
    'inc/theme-shortcode.php',              // Theme Shortcode
    'inc/button-editer.php',                // Button Editer
    'inc/clone-post.php'                    // Clone Post
];

foreach ($file_includes as $file) {
    if (!$filePath = locate_template($file)) {
        trigger_error(sprintf(__('Missing included file'), $file), E_USER_ERROR);
    }

    require_once $filePath;
}

unset($file, $filePath);

//Add SVG Vào WP-admin
function cc_mime_types($mimes)
{
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}

add_filter('upload_mimes', 'cc_mime_types');


//404, phai vao tao 1 trang 404 trong wordpress
add_action('wp', 'redirect_404_to_homepage', 1);
function redirect_404_to_homepage()
{
    global $wp_query;
    if ($wp_query->is_404) {
        wp_redirect(get_bloginfo('url') . '/404', 301);
        exit;
    }
}


add_action('pre_user_query', 'yoursite_pre_user_query');
function yoursite_pre_user_query($user_search)
{
    global $current_user;
    $username = $current_user->user_login;

    if ($username == 'expro') {
        global $wpdb;
        $user_search->query_where = str_replace('WHERE 1=1',
            "WHERE 1=1 AND {$wpdb->users}.user_login != 'expro'", $user_search->query_where);
    }
}


//Thêm Font size vào text Editor
function scanwp_buttons($buttons)
{
    array_unshift($buttons, 'fontsizeselect');
    return $buttons;
}

add_filter('mce_buttons_2', 'scanwp_buttons');
function scanwp_font_size($initArray)
{
    $initArray['fontsize_formats'] = "9px 10px 11px 12px 13px 14px 15px 16px 17px 18px 19px 20px 21px 22px 23px 24px 25px 26px 27px 28px 29px 30px 31px 32px 33px 34px 35px 36px 37px 38px 39px 40px";
    return $initArray;
}

add_filter('tiny_mce_before_init', 'scanwp_font_size');


//Wedget
if (function_exists('register_sidebar')) {
    register_sidebar(array(
        'name' => 'Sidebar',
        'id' => 'sidebar',
    ));
}

// Ẩn Menu Admin
// function chetz_remove_admin_menus(){
// if ( function_exists('remove_menu_page') ) { 

//     remove_menu_page( 'plugins.php' ); 
// }}add_action('admin_menu', 'chetz_remove_admin_menus');


