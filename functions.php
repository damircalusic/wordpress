<?php
/**
 * Setup theme main supports
 */
if(!function_exists('wktheme_setup')) :
	function wktheme_setup(){
		load_theme_textdomain('wktheme', get_template_directory() . '/languages');
	
		add_theme_support('title-tag');
		add_theme_support('post-thumbnails');
		add_theme_support('html5', array('search-form','gallery','caption',));
		
		if(in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))){
			add_theme_support('woocommerce');
		}
		
		/*add_image_size('leverans-medium', 580, 400, array('center', 'center'));
		add_image_size('leverans-big', 1200, 9999);
		add_image_size('bildspel', 1900, 940, array('center', 'center'));*/
	
		register_nav_menus(array(
			'primary' => __('Huvudmeny', 'wktheme'),
		));	
	}
endif;

/**
* Change Login Admin Logo
*/
function wktheme_login_logo(){
    echo '<style type="text/css">#login h1 a, .login h1 a{background-image:url('.get_stylesheet_directory_uri().'/img/wktheme-login.png);-webkit-background-size:300px;background-size:300px;height:45px;width:300px;}</style>';
}

/**
 * Change logo link href
 */
function wktheme_login_logo_url() {
    return home_url();
}

/**
 * Change logo link title
 */
function wktheme_login_logo_url_title() {
    return __('Logga in', 'wktheme');
}

/**
 * Register widgets and sidebars area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function wktheme_widgets_init() {
	global $wp_widget_factory;
	
	remove_action('wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
	
	require(get_template_directory().'/inc/widgets.php');
	require(get_template_directory().'/inc/sidebars.php');
}

/**
 * Frontend scripts and styles
 */
function wktheme_scripts() {
	// Deregister Scripts and Styles
	wp_deregister_script('jquery');
	if(!is_admin()){
		wp_deregister_script('wp-embed');
	}
	
	// Register Scripts and Styles
	wp_register_script('jquery', includes_url('/js/jquery/jquery.js'), false, '', true);
	
	// Enqueue Scripts and Styles
	wp_enqueue_style('wktheme-style', get_template_directory_uri().'/stylesheet.css');
    	wp_enqueue_script('jquery');
	wp_enqueue_script('wktheme-script', get_template_directory_uri() . '/js/frontend.js', array(), '', true);
	
	// Dequeue Scripts and Styles
	wp_dequeue_style('validate-engine-css');
	wp_dequeue_style('boxes');
	wp_dequeue_style('yoast-seo-adminbar');
}

/**
 * Backend scripts and styles
 */
function wktheme_backend_scripts() {
	echo "<link type='text/css' rel='stylesheet' href='".get_stylesheet_directory_uri()."/css/backend.css' />\n";
	echo "<script src='".get_stylesheet_directory_uri()."/js/backend.js'></script>\n";
}

/**
 * Remove type='text/javascript' from scripts
 */
function wktheme_remove_script_tag($tag){
	return str_replace("type='text/javascript' ","",$tag);
}

/**
 * Remove ? query strings after styles and scripts adn ensure that the URL starts with right protocol
 */
function wktheme_remove_script_version($src){
	$url = "http";
	$url .= (@$_SERVER["HTTPS"] == "on") ? 's://' : '://';
	$base = explode('//', $src);
	$query = explode('?', $base[1]);
	
	return (!empty($src) && !empty($base)) ? $url.(($query[0] == 'fonts.googleapis.com/css') ? $query[0].'?'.$query[1] : $query[0]) : $src;
}

/**
* Remove menu pages from WP Admin for specific users
*/
function wktheme_remove_menus(){
	global $submenu;
	$user = wp_get_current_user();
	remove_menu_page('edit-comments.php');
	remove_menu_page('link-manager.php');
	
	/*echo "<pre style='margin-left:200px;'>";
	echo get_current_user_id();
	print_r($submenu);
	echo "</pre>";*/
	
	// If not SuperAdmin
	if(get_current_user_id() != '3'){
		remove_menu_page('tools.php');
		remove_menu_page('options-general.php');
		remove_menu_page('edit.php?post_type=acf-field-group'); // ACF Pro
		remove_menu_page('wpseo_dashboard'); // Yoast SEO
		remove_menu_page('itsec'); // Ithemes Security
		remove_menu_page('yst_ga_dashboard'); // Yoast Google Analytics dashboard
		unset($submenu['wysija_campaigns'][3]); // Wysia Premium
		unset($submenu['woocommerce'][6]); // WC Status
		unset($submenu['woocommerce'][7]); // WC Addons
		unset($submenu['loco'][2]); // Plugins
		unset($submenu['loco'][3]); // WordPress
		unset($submenu['loco'][4]); // Settings
	}
}

/**
* Add widgets on WordPress Panel
*/
function wktheme_add_dashboard_widgets(){
	// Column 1
	//add_meta_box('wktheme_ett',__('Ett','wktheme'),'wktheme_ett_func','dashboard','normal','high');
	
	// Column 2
	add_meta_box('wktheme_to_do',__('Anteckningar','wktheme'),'wktheme_to_do_function','dashboard','side','high');
		
	// Column 3
	add_meta_box('wktheme_support',__('Support','wktheme'),'wktheme_support_function','dashboard','column3','high');
	
	// Column 4
	//add_meta_box('wktheme_fyra',__('Fyra','wktheme'),'wktheme_fyra_func','dashboard','column4','high');			
}

/**
* Add To Do widget on WordPress Panel
*/
function wktheme_to_do_function(){
	// Get Free space on DISK
	$disk_free_space_bytes = disk_free_space(".");
	$disk_total_space_bytes = disk_total_space("."); 
    	$symbols = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
	$base = 1024;
    	$class_disk_free_space = min((int)log($disk_free_space_bytes, $base), count($symbols) - 1);
	$class_disk_total_space = min((int)log($disk_total_space_bytes, $base), count($symbols) - 1);
	$free_space = sprintf('%1.2f' , $disk_free_space_bytes / pow($base,$class_disk_free_space)).' '.$symbols[$class_disk_free_space];
	$total_space = sprintf('%1.2f' , $disk_total_space_bytes / pow($base,$class_disk_total_space)).' '.$symbols[$class_disk_total_space];
	
	echo '<p><strong>'.__('Ledigt utrymme på servern', 'wktheme').':</strong> '.$free_space.'<br><strong>'.__('Använt utrymme på servern', 'wktheme').':</strong> '.($total_space - $free_space).' / '.$total_space.'</p>';
  
	// Get Optimized Images
	$imgargs = array(
					'post_type' => 'attachment',
					'post_mime_type' => array('image/jpeg', 'image/jpg', 'image/png', 'image/gif'),
					'posts_per_page' => -1, 
					'orderby' => 'ID',
					'order' => 'DESC', 
				);

	$images = get_posts($imgargs);
	
	if($images){
		$imgcounter = 0;
		$imgtotals = get_object_vars(wp_count_attachments(array('image')));
		$gif = isset($imgtotals['image/gif']) ? $imgtotals['image/gif'] : 0;
		$jpg = isset($imgtotals['image/jpg']) ? $imgtotals['image/jpg'] : 0;
		$jpeg = isset($imgtotals['image/jpeg']) ? $imgtotals['image/jpeg'] : 0;
		$png = isset($imgtotals['image/png']) ? $imgtotals['image/png'] : 0;
		$imgtotal = ($gif + $jpg + $jpeg + $png);
		$imgoptimized = '';
	
		foreach($images as $image){
			$id = $image->ID;
			$title = $image->post_title;
			$excerpt = $image->post_excerpt;
			$content = $image->post_content;
			$guid = $image->guid;
			
			if(!empty($title) && !empty($excerpt) && !empty($content)){
				$imgcounter++;		
			}
			else{
				$imgoptimized .= '<tr>
									<td class="date">'.__('ID','wktheme').': <br><a href="/wp-admin/upload.php?item='.$id.'" target="_blank">'.$id.'</a></td>
									<td>'.sprintf(__('Optimera bild: %s','wktheme'), '<a href="/wp-admin/upload.php?item='.$id.'" target="_blank">'.$guid.'</a>').'</td>
								   </tr>';
			}
		}
	
		echo'<hr>
			  <p>
				 <strong>'.__('Antal optimerade bilder', 'wktheme').':</strong> <span>'.$imgcounter.'<span> / <span>'.$imgtotal.'</span><br>'.
				 (empty($imgoptimized) ? __('Allt optimerat','wktheme') : '<strong>'.__('Antal ej optimerade bilder','wktheme').':</strong> '.($imgtotal - $imgcounter)).' 
			  </p>'.
			  (empty($imgoptimized) ? '' : '<table id="imgoptimized" class="wp-list-table widefat fixed striped posts">'.$imgoptimized.'</table><p><a id="displayoptimized" class="button button-primary button-large" href="#" data-id="imgoptimized">'.__('Visa alla','wktheme').'</a></p>');
	}
	?>
	<script>
        jQuery(document).ready(function($){
            $("#displayoptimized").click(function() {
				var id = $(this).data("id");
				
				$("#" + id + " tr").css({'display':'block'});
			});
		});
    </script>
    <?php
}

/**
* Add support widget on WordPress Panel
*/
function wktheme_support_function(){
	echo '<img style="display:block;margin:0 auto;" src="http://webcopywriting.se/wp-content/uploads/freshframework/ff_fresh_favicon/favicon_60x60--2015_03_24__06_52_05.png" width="60" height="60">
	      <p style="margin-bottom:0;text-align:center;"><strong>'.__('Angående text och information.','wktheme').'</strong></p>
	      <p style="margin:0;text-align:center;">'.__('Telefon:','wktheme').' +46 (0) 737 18 12 62</p>
	      <p style="margin-top:0;text-align:center;">'.__('E-post:','wktheme').' <a href="mailto:jcnwordproduction@gmail.com">jcnwordproduction@gmail.com</a></p>
	      <img style="display:block;margin:0 auto;" src="https://www.webkreativ.se/apple-touch-icon-60x60.png" width="60" height="60">
	      <p style="margin-bottom:0;text-align:center;"><strong>'.__('Angående underhåll och support.','wktheme').'</strong></p>
	      <p style="margin:0;text-align:center;">'.__('Telefon:','wktheme').' +46 (0) 768 14 57 37</p>
	      <p style="margin:0;text-align:center;">'.__('E-post:','wktheme').' <a href="mailto:damir@webkreativ.se">damir@webkreativ.se</a></p>';
}
/**
* Move Yoast SEO to bottom at all pages/posts
*/
function wktheme_yoast_to_bottom(){
	return 'low';
}

/*
* Make Videos fullwidth from start
*/
function wktheme_modify_embed_defaults() {
    return array(
        'width'  => 950, 
        'height' => 534
    );
}

/*
* Make Videos responsive and remove unwanted attributes
*/
function wktheme_modify_embed_html( $html ) {
    return '<div class="video-container">'.str_replace(' allowfullscreen','',str_replace(' frameborder="0"','',$html)).'</div>';
}

/*
* Prepare a metabox in the menues section for Custom Post Types Archives
*/
function wktheme_add_cpt_archives_menu() {
	add_meta_box('wpclean-metabox-nav-menu-posttype', __('CPT Kategorier','wktheme'), 'wktheme_list_cpt_archive_items', 'nav-menus', 'side', 'default');
}

/*
* Get and print out all CPT archives as menu items in menues section
*/
function wktheme_list_cpt_archive_items(){
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
					<input type="submit"'.disabled(1, 0).' class="button-secondary submit-add-to-menu right" value="'.__('Lägg till i meny', 'wktheme').'" name="add-posttype-archive-menu-item" id="submit-posttype-archive" />
					<span class="spinner"></span>
				</span>
			  </p>';

	endif;
}

/*
* Get current Taxonomy ID
*/
function wktheme_get_taxonomi_id(){
	$queried_object = get_queried_object();
	$term_id = (empty($queried_object->term_id) ? '' : $queried_object->term_id);
	
	return $term_id;
}

/*
* Get current Taxonomy Name
*/
function wktheme_get_taxonomi_name(){
	$queried_object = get_queried_object();
	$term_name = (empty($queried_object->name) ? '' : $queried_object->name);
	
	return $term_name;
}
/*
* Get current Taxonomy Label
*/
function wktheme_get_taxonomi_label(){
	$queried_object = get_queried_object();
	$term_label = (empty($queried_object->label) ? '' : $queried_object->label);
    
	return $term_label;
}
/*
* Get current Taxonomy Slug
*/
function wktheme_get_taxonomi_slug(){
	$queried_object = get_queried_object();
	$term_slug = (empty($queried_object->slug) ? '' : $queried_object->slug);
	
	return $term_slug;
}

/*
* Get current Taxonomy Description
*/
function wktheme_get_taxonomi_desc(){
	$queried_object = get_queried_object();
	$term_desc = (empty($queried_object->description) ? '' : '<p id="tax-first-p">'.preg_replace('/\n/', '<br>', preg_replace('/\n(\s*\n)+/', '</p><p>', $queried_object->description)).'</p>');
	
	return $term_desc;
}

/*
* Make all post types searchable in search.php
*/
function wktheme_search_filter($query) {
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
function wktheme_posts_where( $where, &$wp_query ){
	global $wpdb;
	
	if($wp_query->is_search == 1){
		$where .= ' OR '.$wpdb->posts.'.post_title LIKE \'%'.esc_sql($wpdb->esc_like($_GET['s'])).'%\''; 
	}
	
	return $where;
}

/*
* Email spam ready
* Usage --> [email]info@wktheme.se[/email]
*/ 
function wktheme_email_spam_ready($atts, $content = "") {
	return '<a href="mailto:'.antispambot($content).'">'.antispambot($content).'</a>';
}

/*
* Phone spam ready
* Usage --> [phone]123-456 789[/phone]
*/ 
function wktheme_phone_spam_ready($atts, $content = "") {
	return '<a href="tel:'.antispambot($content).'">'.antispambot($content).'</a>';
}

/*
* Allways PLAIN text on ctrl + v in EDITOR
*/
function wktheme_tinymce_paste_as_text( $init ) {
    $init['paste_as_text'] = true;

    return $init;
}

/**
* Add custom ACF Google Map variables
* Get API key from https://developers.google.com/maps/documentation/javascript/get-api-key
*/
function wktheme_acf_google_map_api($api){
	$api['key'] = 'xxx';
	
	return $api;
}

/**
* Include Customizer
*/
require (get_template_directory().'/inc/customizer.php');

/**
* Include Post Types
*/
require (get_template_directory().'/inc/post-types.php');

/**
* Include Social Media Snippets
*/
require (get_template_directory().'/inc/social-media.php');

/*
* Register WooCommerce Snippets
*/
if(in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))){
	require (get_template_directory().'/inc/woocommerce-snippets.php');
}

// Remove actions
remove_action('wp_head', 'rest_output_link_wp_head');
remove_action('wp_head', 'wp_oembed_add_discovery_links');
remove_action('template_redirect', 'rest_output_link_header', 11, 0);

// Add actions
add_action('login_enqueue_scripts', 'wktheme_login_logo');
add_action('after_setup_theme', 'wktheme_setup');
add_action('wp_enqueue_scripts', 'wktheme_scripts');
add_action('admin_head', 'wktheme_backend_scripts');
add_action('admin_menu', 'wktheme_remove_menus');
add_action('wp_dashboard_setup', 'wktheme_add_dashboard_widgets');
add_action('widgets_init', 'wktheme_widgets_init');
add_action('admin_head-nav-menus.php', 'wktheme_add_cpt_archives_menu');
add_action('pre_get_posts','wktheme_search_filter');

// Add shortcodes
add_shortcode('email', 'wktheme_email_spam_ready');
add_shortcode('phone', 'wktheme_phone_spam_ready');

// Add filters
add_filter('login_headerurl', 'wktheme_login_logo_url');
add_filter('login_headertitle', 'wktheme_login_logo_url_title');
add_filter('wpseo_metabox_prio', 'wktheme_yoast_to_bottom');
if(!is_admin()){
	add_filter('script_loader_tag', 'wktheme_remove_script_tag', 15, 1);
	add_filter('script_loader_src', 'wktheme_remove_script_version', 15, 1);
	add_filter('style_loader_src', 'wktheme_remove_script_version', 15, 1);
}
add_filter('embed_defaults', 'wktheme_modify_embed_defaults');
add_filter('embed_oembed_html', 'wktheme_modify_embed_html', 10, 3);
add_filter('posts_where', 'wktheme_posts_where', 11, 2);
add_filter('tiny_mce_before_init', 'wktheme_tinymce_paste_as_text');
add_filter('acf/fields/google_map/api', 'wktheme_acf_google_map_api');
