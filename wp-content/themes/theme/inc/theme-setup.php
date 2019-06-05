<?php
function theme_setup()
{
    // Language loading
    // load_theme_text_domain('Theme Domain', trailingslashit( get_template_directory()).'languages' );

    // HTML5 support; mainly here to get rid of some nasty default styling that WordPress used to inject
    add_theme_support('html5', array('search-form', 'gallery'));

    // Automatic feed links
    add_theme_support('automatic-feed-links');

    /*
    * Let WordPress manage the document title.
    * By adding theme support, we declare that this theme does not use a
    * hard-coded <title> tag in the document head, and expect WordPress to
    * provide it for us.
    */
    add_theme_support('title-tag');

    /*
    * Enable support for Post Thumbnails on posts and pages.
    *
    * See: https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
    */
    add_theme_support('post-thumbnails');

    /*
    * Switch default core markup for search form, comment form, and comments
    * to output valid HTML5.
    */
    add_theme_support('html5', array(
        'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
    ));

    /*
    * Enable support for Post Formats.
    *
    * See: https://codex.wordpress.org/Post_Formats
    */
    add_theme_support('post-formats', array(
        'aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio', 'chat'
    ));

    /*
    * Register Menus
    */
    function register_my_menu()
    {
        register_nav_menu('Menu_Main', __('Menu Main'));
        register_nav_menu('Menu_2', __('Menu 2'));
        register_nav_menu('Menu_3', __('Menu 3'));
    }

    add_action('init', 'register_my_menu');

}

add_action('after_setup_theme', 'theme_setup', 11);

/* REGISTER PLUGINS. */
add_action('tgmpa_register', 'my_theme_register_required_plugins');
function my_theme_register_required_plugins()
{
    $plugins = array(
        array(
            'name' => 'ACF Pro', // The plugin name.
            'slug' => 'acf-pro', // The plugin slug (typically the folder name).
            'source' => 'http://ro-public.s3.amazonaws.com/advanced-custom-fields-pro-RO.zip?AWSAccessKeyId=AKIAIWSC4LNM5ZYR2WFA&Expires=1781924754&Signature=aSMEPQ6kWOvRJ7BswM8zYPY4nuU%3D', // The plugin source.
            'required' => true, // If false, the plugin is only 'recommended' instead of required.
            'external_url' => '', // If set, overrides default API URL and points to an external URL.
        ),
    );
    /*
    * Array of configuration settings. Amend each line as needed.
    *
    * TGMPA will start providing localized text strings soon. If you already have translations of our standard
    * strings available, please help us make TGMPA even better by giving us access to these translations or by
    * sending in a pull-request with .po file(s) with the translations.
    *
    * Only uncomment the strings in the config array if you want to customize the strings.
    */
    $config = array(
        'id' => 'tgmpa',                 // Unique ID for hashing notices for multiple instances of TGMPA.
        'default_path' => '',                      // Default absolute path to bundled plugins.
        'menu' => 'tgmpa-install-plugins', // Menu slug.
        'parent_slug' => 'themes.php',            // Parent menu slug.
        'capability' => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
        'has_notices' => true,                    // Show admin notices or not.
        'dismissable' => true,                    // If false, a user cannot dismiss the nag message.
        'dismiss_msg' => '',                      // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => false,                   // Automatically activate plugins after installation or not.
        'message' => '',                      // Message to output right before the plugins table.
    );

    tgmpa($plugins, $config);
}

/* SET ACTIVE MENU. */
add_filter('nav_menu_css_class', 'special_nav_class', 10, 2);
function special_nav_class($classes, $item)
{
    if (in_array('current-menu-item', $classes)) {
        $classes[] = 'active ';
    }
    return $classes;
}

/* GRAGITY FORM - REGISTER HIDE LABEL. */
add_filter('gform_enable_field_label_visibility_settings', '__return_true');


//*
//* Thêm màu trạng thái bài viết
//*
add_action('admin_footer','posts_status_color');
function posts_status_color(){
    ?>
    <style>
        .status-draft{background: #FCE3F2 !important;}
        .status-pending{background: #87C5D6 !important;}
        .status-publish{/* no background keep wp alternating colors */}
        .status-future{background: #C6EBF5 !important;}
        .status-private{background:#F2D46F;}
    </style>
    <?php
}



//*
//* Tự động xóa revision của bài viết
//*
$wpdb->query( "DELETE FROM $wpdb->posts WHERE post_type = 'revision'" );

//*
//* Chặn các truy vấn nguy hiểm
//*
global $user_ID; if($user_ID) {
    if(!current_user_can('administrator')) {
        if (strlen($_SERVER['REQUEST_URI']) > 255 ||
            stripos($_SERVER['REQUEST_URI'], "eval(") ||
            stripos($_SERVER['REQUEST_URI'], "CONCAT") ||
            stripos($_SERVER['REQUEST_URI'], "UNION+SELECT") ||
            stripos($_SERVER['REQUEST_URI'], "base64")) {
            @header("HTTP/1.1 414 Request-URI Too Long");
            @header("Status: 414 Request-URI Too Long");
            @header("Connection: Close");
            @exit;
        }
    }
}


function ilc_mce_buttons($buttons){
    array_push($buttons,
        "fontselect"
    );
    return $buttons;
}
add_filter("mce_buttons_2", "ilc_mce_buttons");


function wpb_imagelink_setup() {
    $image_set = get_option( 'image_default_link_type' );

    if ($image_set !== 'none') {
        update_option('image_default_link_type', 'none');
    }
}
add_action('admin_init', 'wpb_imagelink_setup', 10);

//*
//* Phân quyền category cho user
//*
add_action('show_user_profile', 'restrict_user_form');
add_action('edit_user_profile', 'restrict_user_form');

function restrict_user_form($user)
{
    $args = array(
        'show_option_all' => '',
        'show_option_none' => '',
        'orderby' => 'ID',
        'order' => 'ASC',
        'show_count' => 0,
        'hide_empty' => 0,
        'child_of' => 0,
        'exclude' => '',
        'echo' => 1,
        'selected' => get_user_meta($user->ID, '_access', true),
        'hierarchical' => 0,
        'name' => 'allow',
        'id' => '',
        'class' => 'postform',
        'depth' => 0,
        'tab_index' => 0,
        'taxonomy' => 'category',
        'hide_if_empty' => false,
        'walker' => ''
    );
    ?>

    <h3>Phân quyền category cho user</h3>

    <table>
        <tr>
            <td>
                <?php wp_dropdown_categories($args); ?>
                <br />
                <span>Sử dụng để hạn chế tác giả đăng lên chỉ một danh mục.</span>
            </td>
        </tr>
    </table>
<?php }

function is_restrict()
{
    if (get_user_meta(get_current_user_id(), '_access', true) != '')
        return true;
    else
        return false;
}


add_action('edit_form_after_title', 'restrict_warning');
function restrict_warning($post_data = false)
{
    if (is_restrict()) {
        $c    = get_user_meta(get_current_user_id(), '_access', true);
        $data = get_category($c);
        echo 'Bạn chỉ được đăng bài viết vào chuyên mục: <strong>' . $data->name . '</strong><br /><br />';
    }
}

function restrict_remove_meta_boxes()
{
    if (is_restrict())
        remove_meta_box('categorydiv', 'post', 'normal');
}
add_action('admin_menu', 'restrict_remove_meta_boxes');

add_action('save_post', 'save_restrict_post');
function save_restrict_post($post_id)
{
    if (!wp_is_post_revision($post_id) && is_restrict()) {
        remove_action('save_post', 'save_restrict_post');
        wp_set_post_categories($post_id, get_user_meta(get_current_user_id(), '_access', true));
        add_action('save_post', 'save_restrict_post');
    }
}


//*
//* Cho phép author chỉ xem được comment của bài họ viết
//*
function get_comment_list_by_user($clauses)
{
    if (is_admin()) {
        global $user_ID, $wpdb;
        $clauses['join'] = ", wp_posts";
        $clauses['where'] .= " AND wp_posts.post_author = " . $user_ID . " AND wp_comments.comment_post_ID = wp_posts.ID";
    }
    ;
    return $clauses;
}
;
if (!current_user_can('edit_others_posts')) {
    add_filter('comments_clauses', 'get_comment_list_by_user');
}

//*
//* Cho phép viết PHP vào Text Widget
//*
function php_text($text)
{
    if (strpos($text, '<' . '?') !== false) {
        ob_start();
        eval('?' . '>' . $text);
        $text = ob_get_contents();
        ob_end_clean();
    }
    return $text;
}
add_filter('widget_text', 'php_text', 99);



// Functions chỉ hiển thị cho Author các Post của của mình
function epal_posts_useronly( $wp_query ) {
    if ( strpos( $_SERVER[ 'REQUEST_URI' ], '/wp-admin/edit.php' ) !== false ) {
        if ( !current_user_can( 'level_10' ) ) {
            global $current_user;
            $wp_query->set( 'author', $current_user->id );
        }
    }
}
add_filter('parse_query', 'epal_posts_useronly' );

// Bỏ Javascript mặc định wordpress tạo ra trên theme
add_action( 'wp_enqueue_scripts', function () {
   wp_deregister_script( 'wp-embed' );
});

// Bỏ các thẻ trên Header website được WordPress tự động sinh ra
add_action( 'init', function () {
 // Bỏ RSD link (Really Simple Discovery)
  remove_action( 'wp_head', 'rsd_link' );
 // Bỏ Wlwmanifest link (Windows Live Writer manifest)
  remove_action( 'wp_head', 'wlwmanifest_link' );
 // Bỏ feeds
  remove_action( 'wp_head', 'feed_links', 2 );
 // Bỏ extra feeds, such as category feeds
  remove_action( 'wp_head','feed_links_extra', 3 );
 // Bỏ displayed XHTML generator
  remove_action( 'wp_head', 'wp_generator' );
 // Bỏ REST API link tag
  remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
  // Bỏ oEmbed discovery links.
  remove_action( 'wp_head', 'wp_oembed_add_discovery_links', 10 );
  // Bỏ rel next/prev links
  remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);
});



//*
//* Loại Bỏ ver
//*
remove_action('wp_head', 'wp_generator');
add_filter('the_generator', '__return_empty_string');

function mmolee_remove_version_scripts_styles($src) {
    if (strpos($src, 'ver=')) {
        $src = remove_query_arg('ver', $src);
    }
    return $src;
}
add_filter('style_loader_src', 'mmolee_remove_version_scripts_styles', 9999);
add_filter('script_loader_src', 'mmolee_remove_version_scripts_styles', 9999);