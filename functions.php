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
    echo '<style type="text/css">.login h1 a{background-image:url('.get_stylesheet_directory_uri().'/img/superkreativ-login.png) !important;-webkit-background-size:300px !important;background-size:300px !important;height:45px !important;width:300px !important;}</style>';
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
	
	require(get_template_directory().'/includes/widgets.php');
	require(get_template_directory().'/includes/sidebars.php');
}

/**
 * Frontend scripts and styles
 */
function superkreativ_scripts() {
	// Deregister Scripts and Styles
	wp_deregister_script('jquery');
	
	// Register Scripts and Styles
	wp_register_script('jquery', includes_url('/js/jquery/jquery.js'), false, '', true);
	
	// Enqueue Scripts and Styles
	wp_enqueue_style('kroauth-style', get_stylesheet_uri());
    	wp_enqueue_script('jquery');
	wp_enqueue_script('superkreativ-script', get_template_directory_uri() . '/js/superkreativ.js', array(), '', true);
	
	// Dequeue Scripts and Styles
	wp_dequeue_style('validate-engine-css');
	wp_dequeue_style('boxes');
	wp_dequeue_style('yoast-seo-adminbar');
}

/**
 * Backend scripts and styles
 */
function superkreativ_backend_scripts() {
	echo "<link type='text/css' rel='stylesheet' href='".get_stylesheet_directory_uri()."/css/backend.css' />\n";
	echo "<script src='".get_stylesheet_directory_uri()."/js/backend.js'></script>\n";
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
	
	return (!empty($src) && !empty($base)) ? $url.(($query[0] == 'fonts.googleapis.com/css') ? $query[0].'?'.$query[1] : $query[0]) : $src;
}

/**
* Remove pages from admin menues
*/
function superkreativ_remove_menus(){
	remove_menu_page('edit-comments.php');
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
	//add_meta_box('superkreativ_fyra',__('Fyra','superkreativ'),'superkreativ_fyra_func','dashboard','column4','high');			
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

/*
* Prepare a metabox in the menues section for Custom Post Types Archives
*/
function superkreativ_add_cpt_archives_menu() {
	add_meta_box('wpclean-metabox-nav-menu-posttype', __('CPT Kategorier','superkreativ'), 'superkreativ_list_cpt_archive_items', 'nav-menus', 'side', 'default');
}

/*
* Get and print out all CPT archives as menu items in menues section
*/
function superkreativ_list_cpt_archive_items(){
	$post_types = get_post_types(array('show_in_nav_menus' => true, 'has_archive' => true), 'object');

	if($post_types) :
		$items = array();
		$loop_index = 999999;
	
		foreach($post_types as $post_type) {
			$item = new stdClass();
			$loop_index++;
	
			$item->object_id = $loop_index;
			$item->db_id = 0;
			$item->object = 'post_type_'.$post_type->query_var;
			$item->menu_item_parent = 0;
			$item->type = 'custom';
			$item->title = $post_type->labels->name;
			$item->url = get_post_type_archive_link($post_type->query_var);
			$item->target = '';
			$item->attr_title = '';
			$item->classes = array();
			$item->xfn = '';
	
			$items[] = $item;
		}

    	$walker = new Walker_Nav_Menu_Checklist(array());

		echo '<div id="posttype-archive" class="posttypediv">
				<div id="tabs-panel-posttype-archive" class="tabs-panel tabs-panel-active">
					<ul id="posttype-archive-checklist" class="categorychecklist form-no-clear">'.
						walk_nav_menu_tree(array_map('wp_setup_nav_menu_item', $items), 0, (object) array('walker' => $walker)).'
					</ul>
				</div>
			  </div>
			  <p class="button-controls">
			  	<span class="add-to-menu">
					<input type="submit"'.disabled(1, 0).' class="button-secondary submit-add-to-menu right" value="'.__('Lägg till i meny', 'superkreativ').'" name="add-posttype-archive-menu-item" id="submit-posttype-archive" />
					<span class="spinner"></span>
				</span>
			  </p>';

	endif;
}

/*
* Get current Taxonomy ID
*/
function superkreativ_get_taxonomi_id(){
	$queried_object = get_queried_object();
	$term_id = (empty($queried_object->term_id) ? '' : $queried_object->term_id);
	
	return $term_id;
}

/*
* Get current Taxonomy Name
*/
function superkreativ_get_taxonomi_name(){
	$queried_object = get_queried_object();
	$term_name = (empty($queried_object->name) ? '' : $queried_object->name);
	
	return $term_name;
}

/*
* Get current Taxonomy Slug
*/
function superkreativ_get_taxonomi_slug(){
	$queried_object = get_queried_object();
	$term_slug = (empty($queried_object->slug) ? '' : $queried_object->slug);
	
	return $term_slug;
}

/*
* Get current Taxonomy Description
*/
function superkreativ_get_taxonomi_desc(){
	$queried_object = get_queried_object();
	$term_desc = (empty($queried_object->description) ? '' : '<p id="tax-description">'.$queried_object->description.'</p>');
	
	return $term_desc;
}

/*
* Make all post types searchable in search.php
*/
function superkreativ_search_filter($query) {
	if(!is_admin() && $query->is_main_query()){
		if($query->is_search) {
			$query->set('post_type', array( 'post' ) );
			//$query->set('posts_per_page', '9999');
			//$query->set('suppress_filters', FALSE);
		}
	}
}

/*
* Make all post types searchable with post_title
*/
function superkreativ_posts_where( $where, &$wp_query ){
	global $wpdb;
	
	if($wp_query->is_search == 1){
		$where .= ' OR '.$wpdb->posts.'.post_title LIKE \'%'.esc_sql($wpdb->esc_like($_GET['s'])).'%\''; 
	}
	
	return $where;
}

/*
* Email spam ready
* Usage --> [email]info@superkreativ.se[/email]
*/ 
function superkreativ_email_spam_ready($atts, $content = "") {
	return '<a href="mailto:'.antispambot($content).'">'.antispambot($content).'</a>';
}

/*
* Phone spam ready
* Usage --> [phone]123-456 789[/phone]
*/ 
function superkreativ_phone_spam_ready($atts, $content = "") {
	return '<a href="tel:'.antispambot($content).'">'.antispambot($content).'</a>';
}

/*
* Allways PLAIN text on ctrl + v in EDITOR
*/
function superkreativ_tinymce_paste_as_text( $init ) {
    $init['paste_as_text'] = true;

    return $init;
}

/*
* Get the latest Facebook post from a user/page
* Get the $page_id from http://findmyfbid.com/
*/
function superkreativ_get_facebook_post(){
	$page_id = ($page_id_faceb == '') ? '******' : $page_id_faceb;
	$access_token = '1695809097367668|05b97bfdcc780ee5fe1af0a5d745889e';
	$api_url = 'https://graph.facebook.com/v2.5/'.$page_id.'/posts';
	$limit = 1;
	$sanitized_blogname = sanitize_title(get_bloginfo('name'));
	$key = $sanitized_blogname.'_facebook_'.md5($sanitized_blogname.'_facebook_key',$limit);
	
	if(false === ($fb_feed = get_transient($key))){
		$response = wp_remote_get( 
						add_query_arg( 
							array(
								'access_token' => esc_html($access_token),
								'limit' => absint($limit),
								'fields' => esc_html('id,caption,description,link,message,object_id,full_picture,type'),
							), 
							$api_url 
						) 
					);
		
		// Is the API up?
		if(!200 == wp_remote_retrieve_response_code($response)){
			return false;
		}
		
		// Parse the API data and place into an array
		$fb_feed = json_decode( wp_remote_retrieve_body( $response ), true );

		// Are the results in an array?
		if(!is_array($fb_feed)){
			return false;
		}
		
		$fb_feed = maybe_unserialize($fb_feed);
		
		// Store Facebook in a transient, and expire every hour
		set_transient($key, $fb_feed, apply_filters($sanitized_blogname.'_facebook_cache_lifetime', 1 * HOUR_IN_SECONDS));
	}
	
	// Check so we get something from facebook!
	if(!empty($fb_feed)){ 
		// Check so DATA exists!
		if(!empty($fb_feed["data"])){
			$data_counter = 0;
			
			foreach($fb_feed["data"] as $data){
				// What type of post is it?
				if($fb_feed["data"][$data_counter]["type"] == 'message' || $fb_feed["data"][$data_counter]["type"] == 'video'){
					$message = (!empty($fb_feed["data"][$data_counter]["message"]) ? '<p>'.mb_substr($fb_feed["data"][0]["message"],0,220,'UTF-8').'<a href="'.$data["link"].'" target="_blank">...</a></p>' : '');
					
					echo '<div id="fb-post" class="fb-post-'.$data_counter.'">'.$message.'</div>';
				}
				elseif($fb_feed["data"][$data_counter]["type"] == 'photo'){
					$message = (!empty($fb_feed["data"][$data_counter]["message"]) ? '<p>'.mb_substr($fb_feed["data"][$data_counter]["message"],0,220,'UTF-8').'<a href="'.$data["link"].'" target="_blank">...</a></p>' : '');
					
					//<img src="'.$fb_feed["data"][0]["full_picture"].'" width="580" height="400" alt="" />
					echo '<div id="fb-post" class="fb-post-'.$data_counter.'"><img src="'.$fb_feed["data"][0]["full_picture"].'" width="580" height="400" alt="" /></div>';
				}
				elseif($fb_feed["data"][$data_counter]["type"] == 'link'){
					$message = (!empty($fb_feed["data"][$data_counter]["message"]) ? '<p>'.mb_substr($fb_feed["data"][$data_counter]["message"],0,220,'UTF-8').'<a href="'.$data["link"].'" target="_blank">...</a></p>' : '');
					$img = (!empty($fb_feed["data"][$data_counter]["full_picture"])) ? '<img src="'.$fb_feed["data"][$data_counter]["full_picture"].'" width="580" height="400" alt="" />' : '';
					
					echo '<div id="fb-post" class="fb-post-'.$data_counter.'">'.$img.$message.'</div>';
				}
				
				$data_counter++;
			}
			
			//echo '<div id="fb-post" class="fb-post-0"><a class="yellowbtn" href="" target="_blank">'.__('Läs mer på Facebook','lvm').'</a></div>';
			
		}
	}
}

/*
* Get the latest Instagram post from a user
* get $user_id from http://jelled.com/instagram/lookup-user-id
*/
function superkreativ_get_instagram_feed(){
	$user_id = '*****';
	$client_id = '3a81a9fa2a064751b8c31385b91cc25c';
	$access_token = '1808017486.3a81a9f.bfd5c0d3fe8c4da2a4dad5c47308da5b';
	$api_url = 'https://api.instagram.com/v1/users/'.$user_id.'/media/recent/';
	$limit = 4;
	$sanitized_blogname = sanitize_title(get_bloginfo('name'));
	$key = $sanitized_blogname.'_instagram_'.md5($sanitized_blogname.'_instagram_key', $limit);
	
	// If no client id, bail
	if(empty($client_id)){
		return false;
	}

	// Check for transient
	if(false === ($instagrams = get_transient($key))){
		$response = wp_remote_get(
						add_query_arg(
							array(
								'client_id' => $client_id,
								'access_token' => esc_html($access_token),
								'count' => absint($limit)
							), 
							$api_url
						)
					);
					
		// Is the API up?
		if(!200 == wp_remote_retrieve_response_code($response)){
			return false;
		}
		
		// Parse the API data and place into an array
		$instagrams = json_decode(wp_remote_retrieve_body($response), true);
		
		// Are the results in an array?
		if(!is_array($instagrams)){
			return false;
		}
		
		$instagrams = maybe_unserialize($instagrams);
		
		// Store Instagrams in a transient, and expire every hour
		set_transient( $key, $instagrams, apply_filters( $sanitized_blogname . '_instagram_cache_lifetime', 1 * HOUR_IN_SECONDS ) );
	}
	
	// Check so we get something from Instagram!
	if(!empty($instagrams)){
		
		// Check so DATA exists!
		if(!empty($instagrams['data'])){
			echo '<ul id="instagram-feed">';
			foreach($instagrams['data'] as $insta){
				echo '<li class="instagram-picture"><a href="'.$insta['link'].'" target="_blank"><img src="'.$insta['images']['low_resolution']['url'].'" width="'.$insta['images']['low_resolution']['width'].'" height="'.$insta['images']['low_resolution']['height'].'" alt="'.$insta['user']['full_name'].'" /></a></li>';
			}
			echo "</ul>";
		}
	}
}

/**
* Include Post Types
*/
require (get_template_directory().'/includes/post-types.php');

/*
* Register WooCommerce Snippets
*/
require (get_template_directory().'/includes/woocommerce-snippets.php');


// Add actions
add_action('login_enqueue_scripts', 'superkreativ_login_logo');
add_action('after_setup_theme', 'superkreativ_setup');
add_action('wp_enqueue_scripts', 'superkreativ_scripts');
add_action('admin_head', 'superkreativ_backend_scripts');
add_action('admin_menu', 'superkreativ_remove_menus');
add_action('wp_dashboard_setup', 'superkreativ_add_dashboard_widgets');
add_action('widgets_init', 'superkreativ_widgets_init');
add_action('admin_head-nav-menus.php', 'superkreativ_add_cpt_archives_menu');
add_action('pre_get_posts','superkreativ_search_filter');

// Add shortcodes
add_shortcode('email', 'superkreativ_email_spam_ready');
add_shortcode('phone', 'superkreativ_phone_spam_ready');

// Add filters
add_filter('login_headerurl', 'superkreativ_login_logo_url');
add_filter('login_headertitle', 'superkreativ_login_logo_url_title');
add_filter('wpseo_metabox_prio', 'superkreativ_yoast_to_bottom');
if(!is_admin()){
	add_filter('script_loader_tag', 'superkreativ_remove_script_tag', 15, 1);
	add_filter('script_loader_src', 'superkreativ_remove_script_version', 15, 1);
	add_filter('style_loader_src', 'superkreativ_remove_script_version', 15, 1);
}
add_filter('embed_defaults', 'superkreativ_modify_embed_defaults');
add_filter('embed_oembed_html', 'superkreativ_modify_embed_html', 10, 3);
add_filter('posts_where', 'superkreativ_posts_where', 11, 2);
add_filter('tiny_mce_before_init', 'superkreativ_tinymce_paste_as_text');
