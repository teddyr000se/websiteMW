<?php
/*
Plugin Name: Showcase - Visual Composer Addon
Version: 1.0.1
Description: Create a amazing carousel showcase with Ajax presentations with Showcase - Visual Composer Addon you have three different box presentations "Above, Below and Floats" and all control about carousel - <strong>"Important: You must need update the your .htaccess"</strong>.
Author: CHR Designer
Author URI:  http://chrdesigner.com
Text Domain: showcase-vc-addon
Domain Path: /languages/
*/

load_plugin_textdomain( 'showcase-vc-addon', false, plugin_basename( dirname( __FILE__ ) ) . '/languages/' );

/*
 * Function Create Custom Post - showcase_carousel
 */
add_action( 'init', 'create_showcase' );
function create_showcase() {
    register_post_type( 'showcases',
        array(
            'labels' => array(
                'name'                => __( 'Showcases' , 'showcase-vc-addon' ),
                'singular_name'       => __( 'Showcase', 'showcase-vc-addon' ),
                'menu_name'           => __( 'Showcases', 'showcase-vc-addon' ),
                'parent_item_colon'   => __( 'Parent Showcase:', 'showcase-vc-addon' ),
                'all_items'           => __( 'All Showcases', 'showcase-vc-addon' ),
                'view_item'           => __( 'View Showcase', 'showcase-vc-addon' ),
                'add_new_item'        => __( 'Add New Showcase', 'showcase-vc-addon' ),
                'add_new'             => __( 'Add New', 'showcase-vc-addon' ),
                'edit_item'           => __( 'Edit Showcase', 'showcase-vc-addon' ),
                'update_item'         => __( 'Update Showcase', 'showcase-vc-addon' ),
                'search_items'        => __( 'Search Showcase', 'showcase-vc-addon' ),
                'not_found'           => __( 'Not found', 'showcase-vc-addon' ),
                'not_found_in_trash'  => __( 'Not found in Trash', 'showcase-vc-addon' )
            ),
 
            'public' => true,
            'menu_position' => 15,
            'supports' => array( 'title', 'editor', 'thumbnail' ),
            'taxonomies' => array( '' ),
            'menu_icon' => '',
            'register_meta_box_cb' => 'showcase_meta_box',
            'has_archive' => true
        )
    );
}

/*
 * Function for new images sizes - thumb-brand-testimonial | brand-testimonial
 */

add_image_size( 'thumb-brand-testimonial', 220, 220, true );
add_image_size( 'brand-testimonial', 450, 450, array( 'left', 'top' ) );

function chr_script_showcase_vc_addon() {
    wp_register_script( 'owl.carousel.js', plugins_url('/assets/js/owl.carousel.min.js' , __FILE__ ), false, '1.3.2', false );
    wp_enqueue_script( 'owl.carousel.js' );
    wp_register_style( 'owl.carousel.css', plugins_url('/assets/css/owl.carousel.min.css' , __FILE__ ), false, '1.3.2', false );
    wp_enqueue_style( 'owl.carousel.css' );
    wp_register_style( 'sc.vc.addon.style', plugins_url('/assets/css/style.min.css' , __FILE__ ), false, '1.0.0', false );
    wp_enqueue_style( 'sc.vc.addon.style' );
}
add_action( 'wp_enqueue_scripts', 'chr_script_showcase_vc_addon' );

function chr_style_showcase_vc_addon() {
    wp_register_style( 'style.sc.vc.addon.admin', plugins_url('/admin/css/style.sc.vc.addon.admin.css' , __FILE__ ), false, '1.0.0', false );
    wp_enqueue_style( 'style.sc.vc.addon.admin' );
}
add_action( 'admin_enqueue_scripts', 'chr_style_showcase_vc_addon' );

/*
 * Includes
 */
require_once('includes/add-colums-showcase.php');
require_once('includes/shortcode-showcase.php');
require_once('includes/showcase_meta_box.php');
require_once('includes/vc-showcase.php');

/*
 * Add Custom Css Field in Admin Page
 */
add_action('admin_head', 'showcase_admin_css');
function showcase_admin_css() {
    global $post_type;
    if (($_GET['post_type'] == 'showcases') || ($post_type == 'showcases')) :      
        echo "<link type='text/css' rel='stylesheet' href='" . plugins_url('/admin/css/style.min.css', __FILE__) . "' />";
    endif;
}

/*
 * Create and Include custom single page - single-showcases.php
 */

add_filter( 'template_include', 'include_template_showcase', 1 );
function include_template_showcase( $template_path ) {
    if ( get_post_type() == 'showcases' ) {
        if ( is_single() ) {
            if ( $theme_file = locate_template( array ( 'single-showcases.php' ) ) ) {
                $template_path = $theme_file;
            } else {
                $template_path = plugin_dir_path( __FILE__ ) . '/single-showcases.php';
            }
        }
    }
    return $template_path;
}