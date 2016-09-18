<?php 
if ( !defined('ABSPATH')){ exit; }

/**
 * Employees CPT
 */
function superkreativ_create_personal()
{
	register_post_type('personal',
        array(
        'labels' => array(
            'name' => __('Anställda', 'superkreativ'),
            'singular_name' => __('Anställd', 'superkreativ'),
            'add_new' => __('Lägg till ny', 'superkreativ'),
            'add_new_item' => __('Lägg till ny anställd', 'superkreativ'),
            'edit' => __('Redigera', 'superkreativ'),
            'edit_item' => __('Redigera anställd', 'superkreativ'),
            'new_item' => __('Ny anställd', 'superkreativ'),
            'view' => __('Visa', 'superkreativ'),
            'view_item' => __('Visa anställd', 'superkreativ'),
            'search_items' => __('Sök anställd', 'superkreativ'),
            'not_found' => __('Inga anställda', 'superkreativ'),
            'not_found_in_trash' => __('Inga anställda in trash', 'superkreativ')
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
function superkreativ_create_aterforsaljare()
{
	register_post_type('aterforsaljare',
        array(
        'labels' => array(
            'name' => __('Återförsäljare', 'superkreativ'),
            'singular_name' => __('Återförsäljare', 'superkreativ'),
            'add_new' => __('Lägg till ny', 'superkreativ'),
            'add_new_item' => __('Lägg till ny återförsäljare', 'superkreativ'),
            'edit' => __('Redigera', 'superkreativ'),
            'edit_item' => __('Redigera återförsäljare', 'superkreativ'),
            'new_item' => __('Ny återförsäljare', 'superkreativ'),
            'view' => __('Visa', 'superkreativ'),
            'view_item' => __('Visa återförsäljare', 'superkreativ'),
            'search_items' => __('Sök återförsäljare', 'superkreativ'),
            'not_found' => __('Inga återförsäljare', 'superkreativ'),
            'not_found_in_trash' => __('Inga återförsäljare in trash', 'superkreativ')
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
function superkreativ_create_produkter()
{
	register_post_type('produkter',
        array(
        'labels' => array(
            'name' => __('Produkter', 'superkreativ'),
            'singular_name' => __('Produkt', 'superkreativ'),
            'add_new' => __('Lägg till ny', 'superkreativ'),
            'add_new_item' => __('Lägg till ny produkt', 'superkreativ'),
            'edit' => __('Redigera', 'superkreativ'),
            'edit_item' => __('Redigera produkt', 'superkreativ'),
            'new_item' => __('Ny produkt', 'superkreativ'),
            'view' => __('Visa', 'superkreativ'),
            'view_item' => __('Visa produkt', 'superkreativ'),
            'search_items' => __('Sök produkt', 'superkreativ'),
            'not_found' => __('Inga produkt', 'superkreativ'),
            'not_found_in_trash' => __('Inga produkter i papperskorgen', 'superkreativ')
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
function superkreativ_create_produkter_tax()
{
	register_taxonomy(
		'produkter-kategori', 
		array('produkter'), 
		array(
			'hierarchical' => true,
        	'has_archive' => true,
			'labels' => array(
				'name' => __('Kategorier', 'superkreativ'),
				'singular_name' => __('Kategori', 'superkreativ'),
				'search_items' => __('Sök kategorier', 'superkreativ'),
				'all_items' => __('Alla kategorier', 'superkreativ'),
				'parent_item' => __('Kategori', 'superkreativ'),
				'parent_item_colon' => __('Kategori:', 'superkreativ'),
				'edit_item' => __('Redigera kategori', 'superkreativ'),
				'update_item' => __('Uppdatera kategori', 'superkreativ'),
				'add_new_item' => __('Skapa ny kategori', 'superkreativ'),
				'new_item_name' => __('Nytt kategori namn', 'superkreativ'),
				'menu_name' => __('Kategori', 'superkreativ'),
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
function superkreativ_post_types_description(){
    $screen = get_current_screen();
    $screens = array('edit-sposttypename');
	
    if(in_array($screen->id, $screens)){
		$title = get_option('skurs_cpt_title-'.$screen->post_type);
		$description = get_option('skurs_cpt_description-'.$screen->post_type);
		
		echo '<div class="updated">
				<form id="cpt-desc-form" method="post">
					<h2>'.__('Innehåll på sidan','superkreativ').'</h2>
					<p><input id="superkreativ-cpt-title" name="superkreativ-cpt-title" type="text" placeholder="'.__('Lägg till rubrik','superkreativ').'" value="'.(empty($title) ? '' : $title).'"></p>
					<p><textarea id="superkreativ-cpt-description" name="superkreativ-cpt-description" placeholder="'.__('Lägg till besrivning','superkreativ').'">'.(empty($description) ? '' : $description).'</textarea></p>
					<p><a id="superkreativ-cpt-desc-save" class="button button-primary button-large">'.__('Spara', 'superkreativ').'</a></p>
					<input type="hidden" id="superkreativ-cpt-desc-id" value="'.$screen->post_type.'">
				</form>
			  </div>';	
	}
}

/*
* Save CPT custom title and description
*/
function superkreativ_save_cpt_desc(){
	$id = empty($_POST['id']) ? '' : $_POST['id'];
	$title = empty($_POST['title']) ? '' : $_POST['title'];
	$description = empty($_POST['description']) ? '' : $_POST['description'];
	
	if($id !== '' && $title !== '' && $description !== ''){
		update_option('superkreativ_cpt_title-'.$id, $title);
		update_option('superkreativ_cpt_description-'.$id, $description);
	}
	
	die();
}

/*
* Display custom post type archive description with Yoast SEO
*/
function superkreativ_post_type_archive_seo_description($seo_desc){
	$post_type = get_post_type();
	$post_types = get_post_types(
			array(
				'public' => true,
				'_builtin' => false
			)
		  );
	
	if(in_array($post_type, $post_types)){
		$description = get_option('superkreativ_cpt_description-'.$post_type);
		
		if($description){
			$seo_desc = substr($description, 0, 150);
		}
	}
	
	return $seo_desc;
}

/*
* Set posts per page for CPT's
*/
function superkreativ_set_posts_per_page_cpts($query){
  if(!is_admin() && $query->is_main_query() && is_post_type_archive('posttypename')){
    $query->set('posts_per_page', '9');
		$query->set('orderby', 'ID');
		$query->set('order', 'DESC');
	}
}

function superkreativ_post_uppdated_messages($messages){
	global $post;
	
	$post_type = get_post_type($post->ID);
	$post_type_object = get_post_type_object($post_type);
	
	// Employees messages
	$messages['personal'] = array(
		0  => '',
		1  => __('Anställd uppdaterad.', 'superkreativ'),
		2  => __('Anställd uppdaterad.', 'superkreativ'),
		3  => __('Anställd raderad.', 'superkreativ'),
		4  => __('Anställd uppdaterad.', 'superkreativ'),
		5  => isset($_GET['revision']) ? sprintf(__('Anställd återställd från revision %s', 'superkreativ'), wp_post_revision_title((int)$_GET['revision'], false)) : false,
		6  => __('Anställd publicerad.', 'superkreativ'),
		7  => __('Anställd sparad.', 'superkreativ'),
		8  => __('Anställd inskickad.', 'superkreativ'),
		9  => sprintf(__('Anställd tidsinställd för: <strong>%1$s</strong>.', 'superkreativ'), date_i18n(__('M j, Y @ G:i', 'superkreativ'), strtotime($post->post_date))),
		10 => __('Anställd utkast updaterad.', 'superkreativ')
	);
	
	// Retailers messages
	$messages['aterforsaljare'] = array(
		0  => '',
		1  => __('Återförsäljare uppdaterad.', 'superkreativ'),
		2  => __('Återförsäljare uppdaterad.', 'superkreativ'),
		3  => __('Återförsäljare raderad.', 'superkreativ'),
		4  => __('Återförsäljare uppdaterad.', 'superkreativ'),
		5  => isset($_GET['revision']) ? sprintf(__('Återförsäljare återställd till revision %s', 'superkreativ'), wp_post_revision_title((int)$_GET['revision'], false)) : false,
		6  => __('Återförsäljare publicerad.', 'superkreativ'),
		7  => __('Återförsäljare sparad.', 'superkreativ'),
		8  => __('Återförsäljare inskickad.', 'superkreativ'),
		9  => sprintf(__('Återförsäljare tidsinställd för: <strong>%1$s</strong>.', 'superkreativ'), date_i18n(__('M j, Y @ G:i', 'superkreativ'), strtotime($post->post_date))),
		10 => __('Återförsäljare utkast uppdaterad.', 'superkreativ')
	);
	
	// Products messages
	$messages['produkter'] = array(
		0  => '',
		1  => __('Produkt uppdaterad.', 'superkreativ'),
		2  => __('Produkt uppdaterad.', 'superkreativ'),
		3  => __('Produkt raderad.', 'superkreativ'),
		4  => __('Produkt uppdaterad.', 'superkreativ'),
		5  => isset($_GET['revision']) ? sprintf(__('Produkt återställd från revision %s', 'superkreativ'), wp_post_revision_title((int)$_GET['revision'], false)) : false,
		6  => __('Produkt publicerad.', 'superkreativ'),
		7  => __('Produkt sparad.', 'superkreativ'),
		8  => __('Produkt inskickad.', 'superkreativ'),
		9  => sprintf(__('Produkt tidsinställd för: <strong>%1$s</strong>.', 'superkreativ'), date_i18n(__('M j, Y @ G:i', 'superkreativ'), strtotime($post->post_date))),
		10 => __('Produkt utkast updaterad.', 'superkreativ')
	);

	return $messages;
}

// Add Actions
add_action('init', 'superkreativ_create_personal');
add_action('init', 'superkreativ_create_aterforsaljare');
add_action('init', 'superkreativ_create_produkter');
add_action('init', 'superkreativ_create_produkter_tax');
add_action('pre_get_posts', 'superkreativ_set_posts_per_page_cpts');
add_action('admin_notices','superkreativ_post_types_description');
add_action('wp_ajax_superkreativ_save_cpt_desc', 'superkreativ_save_cpt_desc');
add_action('wp_ajax_nopriv_superkreativ_save_cpt_desc', 'superkreativ_save_cpt_desc');

// Add Filters
add_filter('post_updated_messages', 'superkreativ_post_uppdated_messages');
add_filter('wpseo_metadesc', 'superkreativ_post_type_archive_seo_description', 10, 1);
