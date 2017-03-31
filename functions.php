<?php

define("THEME_DIR", get_template_directory_uri());
remove_action('wp_head', 'wp_generator');
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list'));


/*  Admin 
-----------------------------------*/ 

// Remove Menu Items
function remove_menus(){
  remove_menu_page( 'edit-comments.php' );
  remove_menu_page('link-manager.php');
}
add_action( 'admin_menu', 'remove_menus' );

// Remove Post Date Filter
add_filter('months_dropdown_results', '__return_empty_array');


/*  Body Class
----------------------------------------------------------------------------*/ 

add_filter( 'body_class', 'sp_body_class' );
function sp_body_class( $classes ) {
  if (!is_front_page())
  $classes[] = 'sub';
  return $classes;
}

function add_slug_body_class( $classes ) {
  global $post;
  if (isset($post)) {
    $classes[] =  $post->post_name;
  }
  return $classes;
}
add_filter( 'body_class', 'add_slug_body_class' );


/*  Menus
----------------------------------------------------------------------------*/

function register_my_menus() {
  register_nav_menus(
    array(
      'main-menu' => __( 'Main Menu' ),
      'footer-menu' => __( 'Footer Menu' ),
    )
  );
}
add_action( 'init', 'register_my_menus' );


/*  Images
----------------------------------------------------------------------------*/

add_theme_support( 'post-thumbnails' );
add_image_size( 'cover', 300, 300, true, array( 'left', 'top' ));


/*  Search Query
----------------------------------------------------------------------------*/

function search_filter($query) {
  if ($query->is_search) {
    $query->set('post_type', 'post');
    $query->set('orderby', 'UPPER(title2)');
    $query->set('order', 'ASC');
  }
return $query;
}
add_filter('pre_get_posts','search_filter');

function search_url_rewrite_rule() {
  if ( is_search() && !empty($_GET['s'])) {
    wp_redirect(home_url("/search/") . urlencode(get_query_var('s')));
    exit();
  } 
}
add_action('template_redirect', 'search_url_rewrite_rule');


/*  Search custom fields
----------------------------------------------------------------------------*/

function cf_search_join( $join ) {
  global $wpdb;
  if ( is_search() ) {    
     $join .=' LEFT JOIN '.$wpdb->postmeta. ' ON '. $wpdb->posts . '.ID = ' . $wpdb->postmeta . '.post_id ';
  } 
  return $join;
}
add_filter('posts_join', 'cf_search_join' );

// Modify search query
function cf_search_where( $where ) {
  global $wpdb;
  if (is_search()) {
    $where = preg_replace(
      "/\(\s*".$wpdb->posts.".post_title\s+LIKE\s*(\'[^\']+\')\s*\)/",
      "(".$wpdb->posts.".post_title LIKE $1) OR (".$wpdb->postmeta.".meta_value LIKE $1)", $where );
  }
  return $where;
}
add_filter( 'posts_where', 'cf_search_where' );

// Prevent Duplicates
function cf_search_distinct( $where ) {
  global $wpdb;
  if ( is_search() ) {
    return "DISTINCT";
  }
  return $where;
}
add_filter( 'posts_distinct', 'cf_search_distinct' );


/*  Custom post order - ignoring initial articles
----------------------------------------------------------------------------*/

function wpcf_create_temp_column($fields) {
  global $wpdb;
  $matches = 'A|An|The|La|Les';
  $has_the = " CASE 
      WHEN $wpdb->postmeta.meta_value regexp( '^($matches)[[:space:]]' )
        THEN trim(substr($wpdb->postmeta.meta_value from 4)) 
      ELSE $wpdb->postmeta.meta_value
        END AS title2";
  if ($has_the) {
    $fields .= ( preg_match( '/^(\s+)?,/', $has_the ) ) ? $has_the : ", $has_the";
  }
  return $fields;
}

function wpcf_sort_by_temp_column ($orderby) {
  $custom_orderby = "UPPER(title2) ASC";
  $orderby = $custom_orderby;
  return $orderby;
}



/*  Add post meta
----------------------------------------------------------------------------*/

function artist_name_meta( $post_id ) {
  $post = array();
  $post['ID'] = $post_id;

  $artist = get_field('artist');
  $artist_name  = get_the_title($artist);
  $db_name = esc_attr($artist_name);

  if ( get_post_type() == 'post' ) {
    add_post_meta( $post_id, 'artist_name', $db_name );
  } 
  wp_update_post( $post );
} 
add_action('acf/save_post', 'artist_name_meta', 20);


/*  Custom Post Types
----------------------------------------------------------------------------*/

function cptui_register_my_cpts() {

  $labels = array(
    "name" => __( 'Artists', '' ),
    "singular_name" => __( 'Artist', '' ),
  );

  $args = array(
    "label" => __( 'Artists', '' ),
    "labels" => $labels,
    "description" => "",
    "public" => true,
    "publicly_queryable" => true,
    "show_ui" => true,
    "show_in_rest" => false,
    "rest_base" => "",
    "has_archive" => true,
    "show_in_menu" => true,
    "exclude_from_search" => false,
    "capability_type" => "post",
    "map_meta_cap" => true,
    "hierarchical" => false,
    "rewrite" => array( "slug" => "artist", "with_front" => true ),
    "query_var" => true,
    "menu_position" => 5,
    "supports" => array( "title", "editor", "thumbnail" ),
  );

  register_post_type( "artist", $args );
}

add_action( 'init', 'cptui_register_my_cpts' );


/*  Stylesheets
----------------------------------------------------------------------------*/

function enqueue_styles() {
  
  // Foundation
  wp_register_style( 'foundation', THEME_DIR . '/css/foundation.css', array(), '1', 'all' );
  wp_enqueue_style( 'foundation' );

  // Google Fonts 
  wp_register_style( 'google-fonts', 'https://fonts.googleapis.com/css?family=Roboto:400,700', array(), '1', 'all' );
  wp_enqueue_style( 'google-fonts' );

  // Material Icons
  wp_register_style( 'material-icons', 'https://fonts.googleapis.com/icon?family=Material+Icons', array(), '1', 'all' );
  wp_enqueue_style( 'material-icons' );

  // Main styles
  wp_register_style( 'main', THEME_DIR . '/css/main.css', array(), '1', 'all' );
  wp_enqueue_style( 'main' );

  // Custom styles
  wp_register_style( 'style', THEME_DIR . '/style.css', array(), '1', 'all' );
  wp_enqueue_style( 'style' );

}
add_action( 'wp_enqueue_scripts', 'enqueue_styles' );

     
/*  Scripts
----------------------------------------------------------------------------*/

function enqueue_scripts() {

  // Global
  wp_register_script( 'scripts', THEME_DIR . '/js/scripts.min.js', false, '1', true );
  wp_enqueue_script( 'scripts' );

}
add_action( 'wp_enqueue_scripts', 'enqueue_scripts' );

