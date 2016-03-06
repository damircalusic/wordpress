<?php
/**
 * Setup theme main supports
 */
if(!function_exists('superkreativ_setup')) :
	function superkreativ_setup(){
		load_theme_textdomain('superkreativ', get_template_directory() . '/languages');
	
		add_theme_support('title-tag');
		add_theme_support('post-thumbnails');
		add_theme_support('html5', array('search-form','gallery','caption',));
		//add_theme_support('woocommerce');
		
		/*add_image_size('leverans-medium', 580, 400, array('center', 'center'));
		add_image_size('leverans-big', 1200, 9999);
		add_image_size('bildspel', 1900, 940, array('center', 'center'));*/
	
		register_nav_menus(array(
			'primary' => __('Huvudmeny', 'superkreativ'),
		));	
	}
endif;

/**
* Change Login Admin Logo
*/
function superkreativ_login_logo(){
    echo '<style type="text/css">.login h1 a{background-image:url('.get_stylesheet_directory_uri().'/img/superkreativ-login.png);-webkit-background-size:300px;background-size:300px;height:45px;width:300px;}</style>';
}

/**
 * Change logo link href
 */
function superkreativ_login_logo_url() {
    return home_url();
}

/**
 * Change logo link title
 */
function superkreativ_login_logo_url_title() {
    return __('Logga in', 'superkreativ');
}

/**
 * Register widgets and sidebars area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function superkreativ_widgets_init() {
	global $wp_widget_factory;
	
	remove_action('wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));

	require(get_template_directory() . '/inc/sidebars.php');
}

/**
 * Enqueue scripts and styles.
 */
function superkreativ_scripts() {
	// Deregister Scripts and Styles
	wp_deregister_script('jquery');
	
	// Register Scripts and Styles
	wp_register_script('jquery', includes_url('/js/jquery/jquery.js'), false, '', true);
	
	// Enqueue Scripts and Styles
	wp_enqueue_style('superkreativ-style', get_stylesheet_uri());
    wp_enqueue_script('jquery');
	wp_enqueue_script('superkreativ-script', get_template_directory_uri() . '/js/superkreativ.js', array(), '', true);
}
/**
 * Remove type='text/javascript' from scripts
 */
function superkreativ_remove_script_tag($tag){
	return str_replace("type='text/javascript' ","",$tag);
}

/**
 * Remove ? query strings after styles and scripts adn ensure that the URL starts with right protocol
 */
function superkreativ_remove_script_version($src){
	$url = "http";
	$url .= (@$_SERVER["HTTPS"] == "on") ? 's://' : '://';
	$base = explode('//', $src);
	$query = explode('?', $base[1]);
	
	return $url.$query[0];
}

/**
* Add widgets on WordPress Panel
*/
function superkreativ_add_dashboard_widgets(){
	// Column 1
	//add_meta_box('superkreativ_ett',__('Ett','superkreativ'),'superkreativ_ett_func','dashboard','normal','high');
	
	// Column 2
	//add_meta_box('superkreativ_tva',__('Två','superkreativ'),'superkreativ_tva_func','dashboard','side','high');
		
	// Column 3
	add_meta_box('superkreativ_support',__('Support','superkreativ'),'superkreativ_support_function','dashboard','column3','high');
	
	// Column 4
	//add_meta_box('suprkreativ_fyra',__('Fyra','superkreativ'),'student_dashboard_widget_annonsmarknad_func','dashboard','column4','high');			
}

/**
* Add support widget on WordPress Panel
*/
function superkreativ_support_function(){
	echo '<img style="display:block;margin:0 auto;" src="https://www.superkreativ.se/apple-touch-icon-60x60.png" width="60" height="60"><p style="margin-bottom:0;text-align:center;"><strong>'.__('Angående form och design.','superkreativ').'</strong></p><p style="margin:0;text-align:center;">'.__('Tel:','superkreativ').' +46 (0) 706 40 18 00</p><p style="margin-top:0;text-align:center;">'.__('E-post:','superkreativ').' <a href="mailto:amelie.malmberg@gmail.com">amelie.malmberg@gmail.com</a></p><p style="margin-bottom:0;text-align:center;"><strong>'.__('Angående text och information.','superkreativ').'</strong></p><p style="margin:0;text-align:center;">'.__('Tel:','superkreativ').' +46 (0) 761 42 00 26</p><p style="margin-top:0;text-align:center;">'.__('E-post:','superkreativ').' <a href="mailto:sarastenberg@live.se">sarastenberg@live.se</a></p><p style="margin-bottom:0;text-align:center;"><strong>'.__('Angående underhåll och support.','superkreativ').'</strong></p><p style="margin:0;text-align:center;">'.__('Tel:','superkreativ').' +46 (0) 768 14 57 37</p><p style="margin:0;text-align:center;">'.__('E-post:','superkreativ').' <a href="mailto:damir@webkreativ.se">damir@webkreativ.se</a></p>';
}

/**
* Move Yoast SEO to bottom at all pages/posts
*/
function superkreativ_yoast_to_bottom(){
	return 'low';
}

/*
* Make Videos fullwidth from start
*/
function superkreativ_modify_embed_defaults() {
    return array(
        'width'  => 950, 
        'height' => 534
    );
}

/*
* Make Videos responsive and remove unwanted attributes
*/
function superkreativ_modify_embed_html( $html ) {
    return '<div class="video-container">'.str_replace(' allowfullscreen','',str_replace(' frameborder="0"','',$html)).'</div>';
}

/**
* Include Post Types
*/
require (get_template_directory() . '/inc/post-types.php');

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';


// Add actions
add_action('login_enqueue_scripts', 'superkreativ_login_logo');
add_action('after_setup_theme', 'superkreativ_setup');
add_action('wp_enqueue_scripts', 'superkreativ_scripts');
add_action('wp_dashboard_setup', 'superkreativ_add_dashboard_widgets');
add_action('widgets_init', 'superkreativ_widgets_init');

// Add filters
add_filter('login_headerurl', 'superkreativ_login_logo_url');
add_filter('login_headertitle', 'superkreativ_login_logo_url_title');
add_filter('wpseo_metabox_prio', 'superkreativ_yoast_to_bottom');
add_filter('script_loader_tag', 'superkreativ_remove_script_tag', 15, 1);
add_filter('script_loader_src', 'superkreativ_remove_script_version', 15, 1);
add_filter('style_loader_src', 'superkreativ_remove_script_version', 15, 1);
add_filter('embed_defaults', 'superkreativ_modify_embed_defaults');
add_filter('embed_oembed_html', 'superkreativ_modify_embed_html', 10, 3);
