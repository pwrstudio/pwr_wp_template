<?php

/**
 * Enqueue scripts and styles.
 */
function pwrstudio_template_scripts() {
    wp_enqueue_style( 'pwrstudio_bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css');
    wp_enqueue_style( 'pwrstudio_template-style', get_template_directory_uri() . '/style.css');
        
    if (!is_admin()) {
        wp_deregister_script('jquery');
        
        wp_register_script('jquery', '//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js', false, '1', true);
        wp_enqueue_script('jquery');
        
        wp_register_script( 'pwr_scripts', get_template_directory_uri() . '/main.min.js', false, '1', true);
        wp_enqueue_script('pwr_scripts');
      
//        wp_register_script('hdb', '//cdnjs.cloudflare.com/ajax/libs/handlebars.js/3.0.3/handlebars.runtime.min.js', false, '1', true);
//        wp_enqueue_script('hdb');                  
      
//        wp_register_script('templates', get_template_directory_uri() . '/templates.js', false, '1', true);
//        wp_enqueue_script('templates');

    }

}
add_action( 'wp_enqueue_scripts', 'pwrstudio_template_scripts' );


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

function pu_remove_script_version( $src ){
    return remove_query_arg( 'ver', $src );
}

add_filter( 'script_loader_src', 'pu_remove_script_version' );
add_filter( 'style_loader_src', 'pu_remove_script_version' );

// Clean up header
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');

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
    add_image_size( 'pwr-large', 1600 );
}
