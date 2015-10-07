<?php


/**
 * Enqueue scripts and styles.
 */
function pwrstudio_template_scripts() {
    wp_enqueue_style( 'pwrstudio_bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css');
    wp_enqueue_style( 'pwrstudio_template-style', get_template_directory_uri() . '/build/style/main.css');
        
    if (!is_admin()) {
        wp_deregister_script('jquery');
        
        wp_register_script('jquery', '//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js', false, '1', true);
        wp_enqueue_script('jquery');
        
        wp_register_script( 'pwr_scripts', get_template_directory_uri() . '/build/js/main.min.js', false, '1', true);
        wp_enqueue_script('pwr_scripts');
      
        wp_register_script('hdb', '//cdnjs.cloudflare.com/ajax/libs/handlebars.js/3.0.3/handlebars.runtime.min.js', false, '1', true);
        wp_enqueue_script('hdb');                  
      
        wp_register_script('templates', get_template_directory_uri() . '/build/js/templates.js', false, '1', true);
        wp_enqueue_script('templates');

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

  // filter to remove TinyMCE emojis
  add_filter( 'tiny_mce_plugins', 'disable_emojicons_tinymce' );
}
add_action( 'init', 'disable_wp_emojicons' );

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

//// CUSTOM TOOL BAR
//add_filter( 'acf/fields/wysiwyg/toolbars' , 'my_toolbars'  );
//function my_toolbars( $toolbars )
//{
//    // Uncomment to view format of $toolbars
//    //	echo '< pre >';
//    //		print_r($toolbars);
//    //	echo '< /pre >';
//    //	die;
//
//    // Add a new toolbar called "Very Simple"
//    // - this toolbar has only 1 row of buttons
//    $toolbars['Very Simple' ] = array();
//    $toolbars['Very Simple' ][1] = array('italic', 'bold', 'underline' , 'link', 'unlink');
//
//    // Edit the "Full" toolbar and remove 'code'
//    // - delet from array code from http://stackoverflow.com/questions/7225070/php-array-delete-by-value-not-key
//    if( ($key = array_search('code' , $toolbars['Full' ][2])) !== false )
//    {
//        unset( $toolbars['Full' ][2][$key] );
//    }
//
//    // remove the 'Basic' toolbar completely
//    unset( $toolbars['Basic' ] );
//
//    // return $toolbars - IMPORTANT!
//    return $toolbars;
//}

//function custom_field_excerpt($title) {
//    global $post;
//    $text = get_field($title);
//    if ( '' != $text ) {
//        $text = strip_shortcodes( $text );
//        $text = apply_filters('the_content', $text);
//        $text = str_replace(']]>', ']]>', $text);
//        $excerpt_length = 80; // 20 words
//        $excerpt_more = apply_filters('excerpt_more', ' ' . '...');
//        $text = wp_trim_words( $text, $excerpt_length, $excerpt_more );
//    }
//    return apply_filters('the_excerpt', $text);
//}
//
//function formatted_date_span() {
//    $out = array();
//
//    $timestamp_start = strtotime(get_field('start_date', $post->ID));
//    $timestamp_end = strtotime(get_field('end_date', $post->ID));
//
//    $startDatum = strftime('%e %B, %Y', $timestamp_start);
//    $slutDatum = strftime('%e %B, %Y', $timestamp_end);
//
//    if(substr($startDatum, -4) == substr($slutDatum, -4)) {
//        $startDatum = substr_replace($startDatum ,"",-6);
//    }
//    $out[] = ucwords($startDatum) . ' – ' . ucwords($slutDatum);
//    return implode('', $out );
//}
//
//function formatted_date_event() {
//    $out = array();
//    $startDatum = strftime('%A  %e %B – %H.00', get_field('start_date', $post->ID));
//    $out[] = ucwords($startDatum);
//    return implode('', $out );
//}


