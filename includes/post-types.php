<?php 
if ( !defined('ABSPATH')){ exit; }

/**
 * Employees CPT
 */
function wktheme_create_personal()
{
	register_post_type('personal',
        array(
        'labels' => array(
            'name' => __('Anställda', 'wktheme'),
            'singular_name' => __('Anställd', 'wktheme'),
            'add_new' => __('Lägg till ny', 'wktheme'),
            'add_new_item' => __('Lägg till ny anställd', 'wktheme'),
            'edit' => __('Redigera', 'wktheme'),
            'edit_item' => __('Redigera anställd', 'wktheme'),
            'new_item' => __('Ny anställd', 'wktheme'),
            'view' => __('Visa', 'wktheme'),
            'view_item' => __('Visa anställd', 'wktheme'),
            'search_items' => __('Sök anställd', 'wktheme'),
            'not_found' => __('Inga anställda', 'wktheme'),
            'not_found_in_trash' => __('Inga anställda in trash', 'wktheme')
        ),
		'menu_position' => 71,
        'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'query_var'	=> true,
		'rewrite' => array('slug' => 'personal'),
        'hierarchical' => true,
        'has_archive' => false,
		'menu_icon' => 'dashicons-businessman',
        'supports' => array(
			'title',
			'editor',
			'thumbnail',
        ),
        'can_export' => true,
    ));
}

/**
 * Retailers CPT
 */
function wktheme_create_aterforsaljare()
{
	register_post_type('aterforsaljare',
        array(
        'labels' => array(
            'name' => __('Återförsäljare', 'wktheme'),
            'singular_name' => __('Återförsäljare', 'wktheme'),
            'add_new' => __('Lägg till ny', 'wktheme'),
            'add_new_item' => __('Lägg till ny återförsäljare', 'wktheme'),
            'edit' => __('Redigera', 'wktheme'),
            'edit_item' => __('Redigera återförsäljare', 'wktheme'),
            'new_item' => __('Ny återförsäljare', 'wktheme'),
            'view' => __('Visa', 'wktheme'),
            'view_item' => __('Visa återförsäljare', 'wktheme'),
            'search_items' => __('Sök återförsäljare', 'wktheme'),
            'not_found' => __('Inga återförsäljare', 'wktheme'),
            'not_found_in_trash' => __('Inga återförsäljare in trash', 'wktheme')
        ),
		'menu_position' => 73,
        'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'query_var'	=> true,
		'rewrite' => array('slug' => 'aterforsaljare'),
        'hierarchical' => true,
        'has_archive' => true,
		'menu_icon' => 'dashicons-groups',
        'supports' => array(
			'title',
			'editor',
			'thumbnail',
        ),
        'can_export' => true,
    ));
}

/**
 * Products CPT
 */
function wktheme_create_produkter()
{
	register_post_type('produkter',
        array(
        'labels' => array(
            'name' => __('Produkter', 'wktheme'),
            'singular_name' => __('Produkt', 'wktheme'),
            'add_new' => __('Lägg till ny', 'wktheme'),
            'add_new_item' => __('Lägg till ny produkt', 'wktheme'),
            'edit' => __('Redigera', 'wktheme'),
            'edit_item' => __('Redigera produkt', 'wktheme'),
            'new_item' => __('Ny produkt', 'wktheme'),
            'view' => __('Visa', 'wktheme'),
            'view_item' => __('Visa produkt', 'wktheme'),
            'search_items' => __('Sök produkt', 'wktheme'),
            'not_found' => __('Inga produkt', 'wktheme'),
            'not_found_in_trash' => __('Inga produkter i papperskorgen', 'wktheme')
        ),
		'menu_position' => 21,
        'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'query_var'	=> true,
		'rewrite' => array('slug' => 'produkter'),
        'hierarchical' => true,
        'has_archive' => true,
		'menu_icon' => 'dashicons-products',
        'supports' => array(
			'title',
			'editor',
			'thumbnail',
        ),
        'can_export' => true,
    ));
}

/**
 * Products taxonomies
 */
function wktheme_create_produkter_tax()
{
	register_taxonomy(
		'produkter-kategori', 
		array('produkter'), 
		array(
			'hierarchical' => true,
        	'has_archive' => true,
			'labels' => array(
				'name' => __('Kategorier', 'wktheme'),
				'singular_name' => __('Kategori', 'wktheme'),
				'search_items' => __('Sök kategorier', 'wktheme'),
				'all_items' => __('Alla kategorier', 'wktheme'),
				'parent_item' => __('Kategori', 'wktheme'),
				'parent_item_colon' => __('Kategori:', 'wktheme'),
				'edit_item' => __('Redigera kategori', 'wktheme'),
				'update_item' => __('Uppdatera kategori', 'wktheme'),
				'add_new_item' => __('Skapa ny kategori', 'wktheme'),
				'new_item_name' => __('Nytt kategori namn', 'wktheme'),
				'menu_name' => __('Kategori', 'wktheme'),
			),
			'public' => true,
			'show_ui' => true,
			'show_in_quick_edit' => false,
			'show_admin_column' => true,
			'meta_box_cb' => false,
			'query_var'	=> true,
			'rewrite' => array('slug' => 'produkter/kategori'),
		)
	);
}

/*
* Add possibilty to add CPT title and description
*/
function wktheme_post_types_description(){
    $screen = get_current_screen();
    $screens = array('edit-sposttypename');
	
    if(in_array($screen->id, $screens)){
		$title = get_option('skurs_cpt_title-'.$screen->post_type);
		$description = get_option('skurs_cpt_description-'.$screen->post_type);
		
		echo '<div class="updated">
				<form id="cpt-desc-form" method="post">
					<h2>'.__('Innehåll på sidan','wktheme').'</h2>
					<p><input id="wktheme-cpt-title" name="wktheme-cpt-title" type="text" placeholder="'.__('Lägg till rubrik','wktheme').'" value="'.(empty($title) ? '' : $title).'"></p>
					<p><textarea id="wktheme-cpt-description" name="wktheme-cpt-description" placeholder="'.__('Lägg till besrivning','wktheme').'">'.(empty($description) ? '' : $description).'</textarea></p>
					<p><a id="wktheme-cpt-desc-save" class="button button-primary button-large">'.__('Spara', 'wktheme').'</a></p>
					<input type="hidden" id="wktheme-cpt-desc-id" value="'.$screen->post_type.'">
				</form>
			  </div>';	
	}
}

/*
* Save CPT custom title and description
*/
function wktheme_save_cpt_desc(){
	$id = empty($_POST['id']) ? '' : $_POST['id'];
	$title = empty($_POST['title']) ? '' : $_POST['title'];
	$description = empty($_POST['description']) ? '' : $_POST['description'];
	
	if($id !== '' && $title !== '' && $description !== ''){
		update_option('wktheme_cpt_title-'.$id, $title);
		update_option('wktheme_cpt_description-'.$id, $description);
	}
	
	die();
}

/*
* Display custom post type archive description with Yoast SEO
*/
function wktheme_post_type_archive_seo_description($seo_desc){
	$post_type = get_post_type();
	$post_types = get_post_types(
			array(
				'public' => true,
				'_builtin' => false
			)
		  );
	
	if(in_array($post_type, $post_types)){
		$description = get_option('wktheme_cpt_description-'.$post_type);
		
		if($description){
			$seo_desc = preg_replace('/\r?\n|\r/','',substr(strip_tags($description), 0, 150));
		}
	}
	
	return $seo_desc;
}

/*
* Set posts per page for CPT's
*/
function wktheme_set_posts_per_page_cpts($query){
  if(!is_admin() && $query->is_main_query() && is_post_type_archive('posttypename')){
    $query->set('posts_per_page', '9');
		$query->set('orderby', 'ID');
		$query->set('order', 'DESC');
	}
}

function wktheme_post_uppdated_messages($messages){
	global $post;
	
	$post_type = get_post_type($post->ID);
	$post_type_object = get_post_type_object($post_type);
	
	// Employees messages
	$messages['personal'] = array(
		0  => '',
		1  => __('Anställd uppdaterad.', 'wktheme'),
		2  => __('Anställd uppdaterad.', 'wktheme'),
		3  => __('Anställd raderad.', 'wktheme'),
		4  => __('Anställd uppdaterad.', 'wktheme'),
		5  => isset($_GET['revision']) ? sprintf(__('Anställd återställd från revision %s', 'wktheme'), wp_post_revision_title((int)$_GET['revision'], false)) : false,
		6  => __('Anställd publicerad.', 'wktheme'),
		7  => __('Anställd sparad.', 'wktheme'),
		8  => __('Anställd inskickad.', 'wktheme'),
		9  => sprintf(__('Anställd tidsinställd för: <strong>%1$s</strong>.', 'wktheme'), date_i18n(__('M j, Y @ G:i', 'wktheme'), strtotime($post->post_date))),
		10 => __('Anställd utkast updaterad.', 'wktheme')
	);
	
	// Retailers messages
	$messages['aterforsaljare'] = array(
		0  => '',
		1  => __('Återförsäljare uppdaterad.', 'wktheme'),
		2  => __('Återförsäljare uppdaterad.', 'wktheme'),
		3  => __('Återförsäljare raderad.', 'wktheme'),
		4  => __('Återförsäljare uppdaterad.', 'wktheme'),
		5  => isset($_GET['revision']) ? sprintf(__('Återförsäljare återställd till revision %s', 'wktheme'), wp_post_revision_title((int)$_GET['revision'], false)) : false,
		6  => __('Återförsäljare publicerad.', 'wktheme'),
		7  => __('Återförsäljare sparad.', 'wktheme'),
		8  => __('Återförsäljare inskickad.', 'wktheme'),
		9  => sprintf(__('Återförsäljare tidsinställd för: <strong>%1$s</strong>.', 'wktheme'), date_i18n(__('M j, Y @ G:i', 'wktheme'), strtotime($post->post_date))),
		10 => __('Återförsäljare utkast uppdaterad.', 'wktheme')
	);
	
	// Products messages
	$messages['produkter'] = array(
		0  => '',
		1  => __('Produkt uppdaterad.', 'wktheme'),
		2  => __('Produkt uppdaterad.', 'wktheme'),
		3  => __('Produkt raderad.', 'wktheme'),
		4  => __('Produkt uppdaterad.', 'wktheme'),
		5  => isset($_GET['revision']) ? sprintf(__('Produkt återställd från revision %s', 'wktheme'), wp_post_revision_title((int)$_GET['revision'], false)) : false,
		6  => __('Produkt publicerad.', 'wktheme'),
		7  => __('Produkt sparad.', 'wktheme'),
		8  => __('Produkt inskickad.', 'wktheme'),
		9  => sprintf(__('Produkt tidsinställd för: <strong>%1$s</strong>.', 'wktheme'), date_i18n(__('M j, Y @ G:i', 'wktheme'), strtotime($post->post_date))),
		10 => __('Produkt utkast updaterad.', 'wktheme')
	);

	return $messages;
}

// Add Actions
add_action('init', 'wktheme_create_personal');
add_action('init', 'wktheme_create_aterforsaljare');
add_action('init', 'wktheme_create_produkter');
add_action('init', 'wktheme_create_produkter_tax');
add_action('pre_get_posts', 'wktheme_set_posts_per_page_cpts');
add_action('admin_notices','wktheme_post_types_description');
add_action('wp_ajax_wktheme_save_cpt_desc', 'wktheme_save_cpt_desc');
add_action('wp_ajax_nopriv_wktheme_save_cpt_desc', 'wktheme_save_cpt_desc');

// Add Filters
add_filter('post_updated_messages', 'wktheme_post_uppdated_messages');
add_filter('wpseo_metadesc', 'wktheme_post_type_archive_seo_description', 10, 1);
