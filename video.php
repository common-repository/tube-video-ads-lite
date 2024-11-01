<?php

/**
 * Plugin Name: Tube Video Ads Lite
 * Description: Tube Video Ads Lite is a free plugin that lets you embed your affiliate link or your personal ads on every single YouTube Video. Discover how easy is and start monetize YouTube videos within your website. Make it white label and unlock all the features with the pro version at <a href="http://tubevideoads.com/">tubevideoads.com</a>. Your ADS or CALL TO ACTIONS to MONETIZE everi single YouTube Video. With ease!
 * Author: Diego Gualdoni
 * Author URI: http://www.seologico.it
 * Author Website: http://www.seologico.it
 * Version:  1.0.2
 */

 //create new post type
add_action( 'init', 'create_wp_you_link' );
 
function create_wp_you_link() {
	register_post_type( 'wp_you_link',
		array(
			'labels' => array(
				'name' => __( 'Tube Video Ads' ),
				'singular_name' => __( 'Tube Video Ads' ),
				'add_new_item' => __( 'Add New Tube Video Ads' ), 
			),
		'public' => true,
		'has_archive' => true,
		 'supports' => array('title')
		)
	);
}

add_action('add_meta_boxes', 'add_wp_you_link_meta_box');

function add_wp_you_link_meta_box() {
    add_meta_box(
        'wp_you_link_meta_box', // $id
        'Basic Options', // $title
        'show_wp_you_link_meta_box', // $callback
        'wp_you_link', // $page
        'normal', // $context
        'high'); // $priority
		
		remove_meta_box( 'submitdiv', 'wp_you_link', 'side' );
}

function show_wp_you_link_meta_box() {
    global $wpdb, $post;

	if (isset($_GET["post"])) {		
		$post_id = $_GET["post"];	
		$youtube_video = get_post_meta($post_id, 'youtube_video', true);
		$mode = get_post_meta($post_id, 'mode', true);
		$position = get_post_meta($post_id, 'position', true);
		$button_text = get_post_meta($post_id, 'button_text', true);
		$bannerurl = get_post_meta($post_id, 'bannerurl', true);
		$adurl = get_post_meta($post_id, 'adurl', true);
		$delay = (int)get_post_meta($post_id, 'delay', true);
		$hover_title = get_post_meta($post_id, 'hover_title', true);
		$hovertext = get_post_meta($post_id, 'hover_text', true);		
	}else{
		$youtube_video = 'vgdsYAA9IW4';
		$mode = 1;
		$position = 1;
		$button_text = 'Free Ticket';
		$bannerurl = 'http://www.tubevideoads.com/images/free_ticket.png';
		$adurl = 'http://www.fifa.com/worldcup';
		$delay = 0;
		$hover_title = '2014 World Cup';
		$hovertext = 'Fly to Brazil';
	}
	
    include "add_link_html.php";
}

add_action('save_post', 'save_wp_you_link');

function save_wp_you_link($post_id) {
             
    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return $post_id;
		
    // check permissions
    if ('wp_you_link' == $_POST['post_type']) {		
			update_post_meta($post_id, 'youtube_video', $_POST["youtubevideo"]);
			update_post_meta($post_id, 'mode', $_POST["mode"]);
			update_post_meta($post_id, 'position', $_POST["position"]);
			update_post_meta($post_id, 'button_text', $_POST["button_text"]);
			update_post_meta($post_id, 'bannerurl', $_POST["bannerurl"]);
			update_post_meta($post_id, 'adurl', $_POST["adurl"]);
			update_post_meta($post_id, 'delay', (int)$_POST["delay"]);
			update_post_meta($post_id, 'hover_title', $_POST["hovertitle"]);
			update_post_meta($post_id, 'hover_text', $_POST["hovertext"]);			
    }
}

add_filter( 'post_updated_messages', 'wp_you_link_updated_messages' );

function wp_you_link_updated_messages( $messages ) {
	global $post;
	
	$post             = get_post();
	$post_type        = get_post_type( $post );
	$post_type_object = get_post_type_object( $post_type );
	
	$post_id = $post->ID;
		
	$embedded_code = get_wp_you_link_embedded_code($post_id);
	
	$message = "<h3>The shortcode is: </h3>";
	$message .= "[video_link id=$post_id]";
	
	$message .= "<h3>Embeded code</h3>";
	$message .= "<xmp><script src='".admin_url("admin-ajax.php",__FILE__)."?action=tva_embed&id=".$post_id."' ></script></xmp>";
	
	$messages['wp_you_link'] = array(
    0 => '', // Unused. Messages start at index 1.
    1 => $message,
    2 => $message,
    3 => __('Custom field deleted.'),
    4 => $message,
    /* translators: %s: date and time of the revision */
    5 => isset($_GET['revision']) ? sprintf( __('Wp You link restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
    6 => $message,
    7 => $message,
    9 => $message,
    8 => $message,
    10 => $message,
  );

  return $messages;
	
}

function get_wp_you_link_embedded_code($post_id)
{
    $id = "tva-".$post_id;
	$youtube_video = get_post_meta($post_id, 'youtube_video', true);
	$mode = get_post_meta($post_id, 'mode', true);
	$button_text = get_post_meta($post_id, 'button_text', true);
	$bannerurl = get_post_meta($post_id, 'bannerurl', true);
	$adurl = get_post_meta($post_id, 'adurl', true);
				
	ob_start();
	        
	include 'preview_video_html.php';
	
	$message = ob_get_contents ();

	ob_end_clean();
	
	return $message;
}

add_filter('manage_edit-wp_you_link_columns', 'add_new_wp_you_link_columns');

function add_new_wp_you_link_columns($columns)
{
	$new_columns['cb'] = '<input type="checkbox" />';     
    
    $new_columns['title'] = _x('Title', 'column name');
    $new_columns['shortcode'] = __('Shortcode');
 //   $new_columns['embedded'] = __('Embedded Code');
 
    $new_columns['date'] = _x('Created', 'column name');
 
    return $new_columns;
}

add_action('manage_wp_you_link_posts_custom_column', 'manage_wp_you_link_columns', 10, 2);
 
function manage_wp_you_link_columns($column_name, $id) {
    global $wpdb;
    switch ($column_name) {
    case 'shortcode':
        echo "[video_link id=$id]";
            break;
 
    //case 'embedded':       
     //   echo "<a id='copy-video-link' href='admin.php?page=embededcode_wpyoulink&post_id=$id'>Get Embedded Code</a>";
    //    break;
    default:
        break;
    } // end switch
}

add_action('admin_menu', 'register_menu_page');

function register_menu_page() {
    
    add_submenu_page('edit.php?post_type=wp_you_link', 'How to use', 'How to use', 'activate_plugins', 'use_wpyoulink', 'use_wpyoulink');    
    add_submenu_page('edit.php?post_type=wp_you_link', 'Go Pro', 'Go Pro', 'activate_plugins', 'gopro_wpyoulink', 'gopro_wpyoulink');
	add_submenu_page(NULL , 'Embeded Code', 'Embeded Code', 'activate_plugins', 'embededcode_wpyoulink', 'embededcode_wpyoulink');
}

function embededcode_wpyoulink()
{
	if(!empty($_GET) && isset($_GET['post_id']))
	{
		$post_id = $_GET['post_id'];
	
		echo "<h3>Embeded code</h3>";
		echo "<xmp><script src='".admin_url("admin-ajax.php",__FILE__)."?action=tva_embed&id=".$_GET["post_id"]."' ></script></xmp>";
	}
}

function use_wpyoulink() {
    include('use_wp_you_link.php');
}

function gopro_wpyoulink() {
    echo "<h1>Go Pro</h1> 
    <p><img src='http://www.tubevideoads.com/images/youtube_video_ads.jpg'></p>
    <h3>Discover how you can put ads or call to action to monetize Youtube Videos</h3>
    To Unlock all the features visit <a href='http://www.tubevideoads.com/'>http://www.tubevideoads.com/</a>";
}

add_action('wp_ajax_preview_video', 'preview_video');

function preview_video() {
    global $wpdb;

    if (!empty($_POST)) {
    	$id = "tva-".time();
        $youtube_video = $_POST["youtubevideo"];
        $mode = $_POST['mode'];
        $button_text = $_POST["button_text"];
        $adurl = $_POST["adurl"];
        $bannerurl = $_POST["bannerurl"];
		
        include 'preview_video_html.php';
    }

    exit;
}

add_shortcode('video_link', 'show_video_link');

function show_video_link($atts) {
    global $wpdb;
    $a = shortcode_atts(array(
        'id' => 1,
    ), $atts);
				
	return get_wp_you_link_embedded_code( $a["id"]);
}

add_action("wp_ajax_tva_embed","tva_embed");
add_action("wp_ajax_nopriv_tva_embed","tva_embed");

function tva_embed(){
	header("Content-type:text/javascript");

	$post = get_post($_GET["id"]);
    
    $id = "tva-".time();
	$youtube_video = get_post_meta($post->ID, 'youtube_video', true);
	$mode = get_post_meta($post->ID, 'mode', true);
	$button_text = get_post_meta($post->ID, 'button_text', true);
	$bannerurl = get_post_meta($post->ID, 'bannerurl', true);
	$adurl = get_post_meta($post->ID, 'adurl', true);
	$style_url = plugins_url("/tva.css",__FILE__);

	include "script.php";
	exit;
}

add_action("admin_print_styles","tva_admin_css");
add_action("wp_print_styles","tva_admin_css");

function tva_admin_css(){
	wp_enqueue_style("tva",plugins_url("/tva.css",__FILE__));
}
