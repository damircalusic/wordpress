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


function superkreativ_post_uppdated_messages($messages){
	global $post;
	
	$post_type = get_post_type($post->ID);
	$post_type_object = get_post_type_object($post_type);
	
	// Anställd messages
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
	
	// Återförsäljares messages
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

	return $messages;
}

// Add Actions
add_action('init', 'superkreativ_create_personal');
add_action('init', 'superkreativ_create_aterforsaljare');

// Add Filters
add_filter('post_updated_messages', 'superkreativ_post_uppdated_messages');
