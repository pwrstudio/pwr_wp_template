<?php

/**
 * Enqueue scripts and styles.
 */
function pwrstudio_template_scripts() {

    // Enque font style file
    //    wp_enqueue_style( 'univers_light', get_template_directory_uri() . '/fonts/UniversLTCYR-45Light.css');
    wp_enqueue_style( 'pwrstudio_template-style', get_template_directory_uri() . '/style.css');

    if (!is_admin()) {

        wp_deregister_script('jquery');

        wp_register_script( 'pwr_scripts', get_template_directory_uri() . '/app.min.js', false, '1', true);
        wp_enqueue_script('pwr_scripts');

    }

}
add_action( 'wp_enqueue_scripts', 'pwrstudio_template_scripts' );

// Function to output what template file is used to show a particular page

//add_filter( 'template_include', 'var_template_include', 1000 );
//function var_template_include( $t ){
//    $GLOBALS['current_theme_template'] = basename($t);
//    return $t;
//}
//
//function get_current_template( $echo = false ) {
//    if( !isset( $GLOBALS['current_theme_template'] ) )
//        return false;
//    if( $echo )
//        echo $GLOBALS['current_theme_template'];
//    else
//        return $GLOBALS['current_theme_template'];
//}

// DISABLE STUFF

//Disable RSS Feeds functions
add_action('do_feed', array( $this, 'disabler_kill_rss' ), 1);
add_action('do_feed_rdf', array( $this, 'disabler_kill_rss' ), 1);
add_action('do_feed_rss', array( $this, 'disabler_kill_rss' ), 1);
add_action('do_feed_rss2', array( $this, 'disabler_kill_rss' ), 1);
add_action('do_feed_atom', array( $this, 'disabler_kill_rss' ), 1);
if(function_exists('disabler_kill_rss')) {
	function disabler_kill_rss(){
		wp_die( _e("No feeds available.", 'ippy_dis') );
	}
}

//Remove feed link from header
remove_action( 'wp_head', 'feed_links_extra', 3 ); //Extra feeds such as category feeds
remove_action( 'wp_head', 'feed_links', 2 ); // General feeds: Post and Comment Feed

// Disable json api
add_filter('rest_jsonp_enabled', '_return_false');
remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
remove_action( 'wp_head', 'wp_oembed_add_discovery_links', 10 );

// Remove the Link header for the WP REST API
// [link] => <http://www.example.com/wp-json/>; rel="https://api.w.org/"
remove_action( 'template_redirect', 'rest_output_link_header', 11, 0 );

// Remove script and style versions
function pu_remove_script_version( $src ){
    return remove_query_arg( 'ver', $src );
}
add_filter( 'script_loader_src', 'pu_remove_script_version' );
add_filter( 'style_loader_src', 'pu_remove_script_version' );

// Clean up header
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');

// Disable emojis
function disable_wp_emojicons() {

  // all actions related to emojis
  remove_action( 'admin_print_styles', 'print_emoji_styles' );
  remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
  remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
  remove_action( 'wp_print_styles', 'print_emoji_styles' );
  remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
  remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
  remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );

}
add_action( 'init', 'disable_wp_emojicons' );

// Remove admin bar
add_filter('show_admin_bar', '__return_false');

// Remove generator tag
remove_action('wp_head', 'wp_generator');

add_filter( 'query_vars', function( $vars ){
    $vars[] = 'post_parent';
    return $vars;
});

// CUSTOM IMAGE SIZES
add_action( 'after_setup_theme', 'image_size_setup' );
function image_size_setup() {
    add_image_size( 'pwr-small', 500 );
    add_image_size( 'pwr-medium', 800 );
    add_image_size( 'pwr-large', 1400 );
}

// Allow svg in upload
function cc_mime_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');

// Add support for featured images
add_theme_support( 'post-thumbnails' );

// Add categories as classes on single pages
add_filter('body_class','add_category_to_single');
function add_category_to_single($classes, $class) {
	if (is_single() ) {
		global $post;
		foreach((get_the_category($post->ID)) as $category) {
			// add category slug to the $classes array
			$classes[] = $category->category_nicename;
		}
	}
	// return the $classes array
	return $classes;
}

//Page Slug Body Class
function add_slug_body_class( $classes ) {
global $post;
if ( isset( $post ) ) {
  $classes[] = $post->post_type . '-' . $post->post_name;
}
  return $classes;
}
add_filter( 'body_class', 'add_slug_body_class' );

/*-------------------------------------------------------------------------------
	Custom Columns
-------------------------------------------------------------------------------*/
function my_page_columns($columns)
{
	$columns = array(
		'cb'	 	=> '<input type="checkbox" />',
		'thumbnail'	=>	'Image',
		'title' 	=> 'Title',
		'categories'	=>	'Categories',
	);
	return $columns;
}
function my_custom_columns($column)
{
	global $post;
	if($column == 'thumbnail')
	{
        $image = get_field('image', $post->ID);
		echo '<img src="' . $image[sizes][thumbnail] . '">';
	}
}
add_action("manage_posts_custom_column", "my_custom_columns");
add_filter("manage_edit-post_columns", "my_page_columns");

// Strip tags from ACF-content
// function so_26068464( $content )
// {
//   return strip_tags( $content, '<img><p><strong><i><em><a>' );
// }
// add_filter( 'acf_the_content', 'so_26068464' );

function filter_ptags_on_images($content)
{
  return preg_replace('/<p>(\s*)(<img .* \/>)(\s*)<\/p>/iU', '\2', $content);
}

add_filter('acf_the_content', 'filter_ptags_on_images');
