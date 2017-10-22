<?php 
if ( !defined('ABSPATH')){ exit; }

/**
* Remove metaboxes on add new product in admin
*/
function wktheme_remove_product_metaboxes_admin() {
     remove_meta_box('postexcerpt', 'product', 'normal');
	 remove_meta_box('commentsdiv', 'product', 'normal');
}

/**
 * Manage WooCommerce styles and scripts.
 */
function wktheme_woocommerce_script_cleaner() {
	// Unless we're in the store, remove all the cruft!
	if (!is_woocommerce() && !is_cart() && !is_checkout() && !is_singular('formgivare')){
		wp_dequeue_style('woocommerce_frontend_styles'); // WooCommerce style
		wp_dequeue_style('woocommerce-general'); // WooCommerce style
		wp_dequeue_style('woocommerce-layout'); // WooCommerce style
		wp_dequeue_style('woocommerce-smallscreen'); // WooCommerce style
		wp_dequeue_style('wcqi-css'); // WooCommerce style
		wp_dequeue_script('wc-aelia-eu-vat-assistant-frontend'); // plugins/woocommerce-eu-vat-assistant/src/js/frontend/frontend.js
		wp_dequeue_script('wc-add-payment-method'); // WooCommerce script
		wp_dequeue_script('wc-lost-password'); // WooCommerce script
		wp_dequeue_script('wc_price_slider'); // WooCommerce script
		wp_dequeue_script('wc-single-product'); // WooCommerce script
		wp_dequeue_script('wc-add-to-cart'); // WooCommerce script
		wp_dequeue_script('wc-cart-fragments'); // WooCommerce script
		wp_dequeue_script('wc-credit-card-form'); // WooCommerce script
		wp_dequeue_script('wc-checkout'); // WooCommerce script
		wp_dequeue_script('wc-add-to-cart-variation'); // WooCommerce script
		wp_dequeue_script('wc-cart'); // WooCommerce script
		wp_dequeue_script('wc-address-i18n'); // WooCommerce script
		wp_dequeue_script('wc-country-select'); // WooCommerce script
		wp_dequeue_script('wc-add-extra-charges'); // plugins/woocommerce-extra-charges-to-payment-gateways/assets/app.js
		wp_dequeue_script('wcqi-js'); // WooCommerce script
		wp_dequeue_script('woocommerce'); // WooCommerce script
		wp_dequeue_script('jquery-cookie'); // WooCommerce script
		wp_dequeue_script('jquery-blockui'); // WooCommerce script
		wp_dequeue_script('jquery-placeholder'); // WooCommerce script
		wp_dequeue_script('jquery-payment'); // WooCommerce script
		wp_dequeue_script('fancybox'); // WooCommerce script
		wp_dequeue_script('jqueryui'); // WooCommerce script
		wp_dequeue_script('aws-script'); // plugins/advanced-woo-search/
	}

	wp_dequeue_style('wc-aelia-eu-vat-assistant-frontend'); // plugins/woocommerce-eu-vat-assistant/src/design/css/frontend.css
	wp_dequeue_style('aws-style'); // plugins/advanced-woo-search/
	wp_dequeue_style('select2'); // WooCommerce style
	wp_dequeue_style('woocommerce_fancybox_styles'); // WooCommerce style
	wp_dequeue_style('woocommerce_chosen_styles'); // WooCommerce style
	wp_dequeue_style('woocommerce_prettyPhoto_css'); // WooCommerce style
	wp_dequeue_script('prettyPhoto'); // WooCommerce script
	wp_dequeue_script('prettyPhoto-init'); // WooCommerce script
	wp_dequeue_script('photoswipe'); // WooCommerce script
	wp_dequeue_script('select2'); // WooCommerce script
	wp_dequeue_script('wc-chosen'); // WooCommerce script
}

/**
 * Define image sizes
 */
function wktheme_woocommerce_image_dimensions(){
  	$catalog = array('width' => '300', 'height' => '300', 'crop' => array('center', 'top'));
	$single = array('width' => '1335', 'height' => '9999', 'crop' => 0);
	$thumbnail = array('width' 	=> '80', 'height'	=> '80', 'crop' => 1);

	// Image sizes
	update_option('shop_catalog_image_size', $catalog); // Product category thumbs
	update_option('shop_single_image_size', $single); // Single product image
	update_option('shop_thumbnail_image_size', $thumbnail); // Image gallery thumbs
}

/**
* Change currency symbols
*/
function wktheme_currency_symbol($currency_symbol, $currency){
	global $product;
	
	//$wktheme_product_price_or_meter = (get_post_meta($product->get_id(), 'wktheme_product_price_or_meter', true) !== '') ? get_post_meta($product->get_id(), 'wktheme_product_price_or_meter', true) : '';
	
	switch($currency){
		case 'SEK': $currency_symbol = ':-'; //= ((is_admin()) ? ($wktheme_product_price_or_meter == 'yes') ? ' '.__('SEK/meter','wktheme') : ' '.__('SEK/unit','wktheme') : ':-'); 
		break;
	}
	
	return $currency_symbol;
}

/**
* Function to return new placeholder image URL for WooCommerce product
*/
function wktheme_custom_woocommerce_placeholder($image_url){
	return get_template_directory_uri().'/img/product-placeholderimage-300.jpg';
}

/*
* Get the WooCommerce category featured image
*/
function wktheme_woocommerce_category_image($cat_id, $cat_name = ''){
	$size = (empty(get_field('visning_utvald_bild', 'product_cat_'.$cat_id)) ? 'top' : get_field('visning_utvald_bild', 'product_cat_'.$cat_id));
	$image_id = get_woocommerce_term_meta($cat_id, 'thumbnail_id', true);
	$image = wp_get_attachment_image_src($image_id, "cover-{$size}");
	
	if(!empty($image)){ 
		return '<img src="'.$image[0].'" width="'.$image[1].'" height="'.$image[2].'" alt="'.$cat_name.'" />';
	}
	
	return '';
}

/*
* Get all WooCommerce categories and display them in the header of the shop
*/
function wktheme_get_shop_categories_header(){
	$main_cats = '';
	$sub_cats = '';
	$allowed_cats = array('19','20','21','22');
	
	$mains = get_categories(
				array(
					'taxonomy' => 'product_cat',
					'orderby' => 'name',
					'show_count' => 0,
					'pad_counts' => 0,
					'hierarchical' => 1,
					'title_li' => '',
					'hide_empty' => 0
				)
			);
	
	foreach($mains as $main) {
		if($main->category_parent == 0) {
			if(in_array($main->term_id, $allowed_cats)){
				$main_slug = get_term_link($main->slug, 'product_cat');
				$main_class = (strpos('https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], $main_slug) !== false) ? 'shop-main-cat-active' : '';
				$main_cats .= '<a class="shop-main-cat '.$main_class.'" href="'.$main_slug.'">'.$main->name.'</a>';
			}
			else{
				$sub_slug = get_term_link($main->slug, 'product_cat');
				$sub_class = (strpos('https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], $sub_slug) !== false) ? 'shop-sub-cat-active' : '';
				$sub_cats .= '<a class="shop-sub-cat '.$sub_class.'" href="'.str_replace('/kategori/presentkort/','/produkt/presentkort/',$sub_slug).'">'.$main->name.'</a>';
			}
			
			/*$subs = get_categories(
						array(
							'taxonomy' => 'product_cat',
							'child_of' => 0,
							'parent' => $main->term_id,
							'orderby' => 'name',
							'show_count' => 0,
							'pad_counts' => 0,
							'hierarchical' => 1,
							'title_li' => '',
							'hide_empty' => 0
						)
					);
			
			if($subs) {
				foreach($subs as $sub) {
					$sub_slug = get_term_link($sub->slug, 'product_cat');
					$sub_class = (wktheme_get_current_url() == $sub_slug) ? 'shop-sub-cat-active' : '';
					$sub_cats .= '<a class="shop-sub-cat '.$sub_class.'" href="'.get_term_link($sub->slug, 'product_cat').'">'.$sub->name.'</a>';
				}   
			}*/
		}       
	}
	
	echo '<p>'.$main_cats.'</p><p>'.$sub_cats.'</p>';
}

/*
* Get the main shop categories with related slider
*/
function wktheme_shop_main_categories_and_slider(){
	$main_cats = '';
	
	// Display only IF NOT shop page
	if(!is_shop()){
		$desc = wktheme_current_product_category_desc();
		
		if(!empty($desc)){
			echo '<div class="main-blog"><p>'.$desc.'</p></div>';
		}
		
		$mains = get_categories(
					array(
						'taxonomy' => 'product_cat',
						'orderby' => 'name',
						'show_count' => 0,
						'pad_counts' => 0,
						'hierarchical' => 1,
						'title_li' => '',
						'hide_empty' => 0
					)
				);
		
		$allowed_cats = array('19','20','21','22');
		
		foreach($mains as $main) {
			if($main->category_parent == 0) {
				if(in_array($main->term_id, $allowed_cats)){
					echo '<ul class="products main-cats">
							<li class="product-category">
								<figure>'.
									wktheme_woocommerce_category_image($main->term_id, $main->name).'
									<figcaption>
										<div>
											<h2>'.$main->name.'</h2>
											<a class="shop-cat-link" href="'.get_term_link($main->slug, 'product_cat').'">'.__('View all products', 'wktheme').'</a>
										</div>
									</figcaption>
								</figure>
							</li>
						</ul>';
					
					/*$products = array(
						'post_type' => 'product',
						'posts_per_page' => 4,
						'product_cat' => $main->slug,
					);
					
					$product = new WP_Query($products);
					
					if($product->have_posts()){
						echo '<ul class="productsslider owl-carousel owl-theme">';
						
						while($product->have_posts()) : $product->the_post();
							wc_get_template_part('content', 'product');
						endwhile;
						
						echo '</ul>';
					}
					
					wp_reset_postdata();*/
				}
			}       
		}
	}
}

/*
* Get a specific designers products
*/
function wktheme_get_designers_products($id){
	$id = (int)$id;
	$products = new WP_Query(array('post_type' => 'product', 'post_status' => 'publish', 'posts_per_page' => -1, 'meta_key' => 'produkt_designer', 'meta_value' => '"'.$id.'"', 'meta_compare' => 'LIKE'));
	
	echo '<ul class="products">';
	
	while($products->have_posts()) : $products->the_post();
		wc_get_template_part('content', 'product');
	endwhile;
	
	echo '</ul>';
}

/*
* Add a search products form to the shop
*/
function wktheme_add_woocommerce_product_search() {
	// If it is the main shop page do not display otherwise display
	if(!is_shop()){
		if(is_active_sidebar('produkt-sok')){ 
			dynamic_sidebar('produkt-sok'); 
		}
	}
	
	// If is search page display
	if(is_search()){
		if(is_active_sidebar('produkt-sok')){ 
			dynamic_sidebar('produkt-sok'); 
		}
	}
}

/*
* Add attributes to the product title in Single Product view
*/

function wktheme_single_product_title(){
	$wktheme_product_miljo = get_post_meta(get_the_ID(), 'wktheme_product_miljo', true);
	$miljo = ($wktheme_product_miljo == 'yes') ? '<img id="miljoicon" src="data:image/jpeg;base64,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%3D%3D" width="70" height="81" alt="'.__('Good Environment','wktheme').'">' : '';
		
	echo '<h1 itemprop="name" class="product_title entry-title">'; the_title(); echo $miljo.'</h1>';
}

/*
* Define the woocommerce_product_additional_information_heading callback 
*/
function wktheme_woocommerce_product_additional_information_heading($var){  
    return ''; 
};

/*
* Add text to the product quantity in Single Product view
*/
function wktheme_before_add_to_cart_quantity(){
	echo '<label class="woocommerce_quantity_title">'.__('Quantity','wktheme').'</label>';
}

/*
* Add styled dropdown to the product variations in Single Product view
*/
function wktheme_woocommerce_dropdown_variation_attribute_options_html($html, $args){ 
	return '<div class="styled-dropdown">'.$html.'</div>'; 
}

/**
* Change the product permalink in shop so the user scrolls doen to main product immediately
*/
function wktheme_template_loop_product_link_open(){
	echo '<a href="'.get_the_permalink().'#product-'.get_the_ID().'" class="woocommerce-LoopProduct-link">';
}

/*
* Change number of columns displaying product thumbnails
*/
function wktheme_woocommerce_product_thumbnails_columns() {
	return 15;
}

/*
* Remove overflowed tabs from the shop
*/
function wktheme_remove_tabs_shop($tabs){
    unset($tabs['description']);
	unset($tabs['reviews']);
	unset($tabs['additional_information']);
    
	return $tabs;
}

/*
* Get products main description
*/
function wktheme_woocommerce_product_main_description() {
	the_content();
}

/*
* Get products additional information
*/
function wktheme_woocommerce_product_additional_information() {
	wc_get_template('single-product/tabs/additional-information.php');
}

/**
* Rename all text to fit wktheme for products add_to_cart etc.
*/
function wktheme_woocommerce_product_add_to_cart_text(){
	global $product;
	
	$product_type = $product->get_type();
	
	switch($product_type){
		case 'external': return __('Buy', 'wktheme'); break;
		case 'grouped':return __('View products', 'wktheme'); break;
		case 'simple': return __('Buy', 'wktheme'); break;
		case 'variable': return __('Options', 'wktheme'); break;
		default: return __('Read more', 'wktheme');
	}
	
}

/**
* Add extra buttons to a product in listings
*/
function wktheme_woocommerce_after_shop_loop_item_title(){
	global $product;
	
	echo '<a href="'.get_permalink($product->get_id()).'" class="read_more_product">'.__('Read more', 'wktheme').'</a>';
}

/**
* Change products per page
*/
function wktheme_loop_shop_per_page(){
	return 12;
}

/**
* Get current product category description
*/
function wktheme_current_product_category_desc(){
	$queried_object = get_queried_object();
	
	return $queried_object->description;
}

/**
* Add Proceed to checkout button on cart.php page
*/
function wktheme_woocommerce_cart_actions(){
	do_action('woocommerce_proceed_to_checkout');
}

/**
* Remove cart totals on cart.php page
*/
function wktheme_woocommerce_cart_totals(){
	return '';
}

/** 
* Hide shipping rates when free shipping is available or a weight limit exists 
*/
function wktheme_hide_shipping_methods_on_free_weight($rates){
    foreach($rates as $rate_id => $rate){
        if('free_shipping' === $rate->method_id){
            return array(
                $rate_id => $rate
            );
        }
    }
 
    return $rates;
}

/**
* Change the display of prices of variable products to --> From: 200 instead of 200 - 1500
*/
function wktheme_woocommerce_variable_price_html($price_product_get_price_suffix, $product){
	$prices = preg_match_all("/woocommerce-Price-amount/i", $price_product_get_price_suffix);
	$wktheme_product_price_or_meter = get_post_meta($product->get_id(), 'wktheme_product_price_or_meter', true);
	
	// If is Single product or is in Administration
	//if(is_product() || is_admin()){
		return (($prices >= 2) ? __('From','wktheme').': ' : '').number_format($product->get_price(),0,' ',' ').' '.(($wktheme_product_price_or_meter == 'yes') ? __('SEK/meter','wktheme') : __('SEK/unit','wktheme'));
	//}
	
	//return ($prices >= 2) ? __('From','wktheme').': '.$product->get_price().':-' : $price_product_get_price_suffix;
}

/**
* Display custom product fields in the general tab of a single product in Admin
*/
function wktheme_woocommerce_general_product_data_custom_fields() {
	global $woocommerce, $post;
	
	echo '<div class="options_group">';
	woocommerce_wp_checkbox(
		array(
			'id' => 'wktheme_product_price_or_meter',
			'wrapper_class' => 'checkbox_class',
			'label' => __('Selling per meter', 'wktheme'),
			'description' => __('Check this if it is a product sold per meter.', 'wktheme')
		)
	);
	woocommerce_wp_checkbox(
		array(
			'id' => 'wktheme_product_miljo',
			'wrapper_class' => 'checkbox_class',
			'label' => __('Good environment', 'wktheme'),
			'description' => __('Check this if it is a good environment product.', 'wktheme')
		)
	);
	echo '</div>';
}

/**
* Save all custom products fields in the Dtabase
*/
function wktheme_woocommerce_process_product_meta_fields_save($post_id){
    $wktheme_product_price_or_meter = isset($_POST['wktheme_product_price_or_meter']) ? 'yes' : 'no';
	$wktheme_product_miljo = isset($_POST['wktheme_product_miljo']) ? 'yes' : 'no';
	
	update_post_meta($post_id, 'wktheme_product_price_or_meter', $wktheme_product_price_or_meter);
	update_post_meta($post_id, 'wktheme_product_miljo', $wktheme_product_miljo);
}

/**
* Get the total number of products in the cart and display in menu
*/
function wktheme_cart_total_products($menu_items){
	foreach($menu_items as $menu_item){
		if(strpos($menu_item->post_title, '#wktheme_cart_total_products#') !== false){
			$class = (WC()->cart->get_cart_contents_count() == 0) ? 'red' : '';
			$menu_item->post_title = str_replace('#wktheme_cart_total_products#','<span id="wktheme-cart-total" class="'.$class.'">'.WC()->cart->get_cart_contents_count().'</span>', $menu_item->post_title);
			$menu_item->title = str_replace('#wktheme_cart_total_products#','<span id="wktheme-cart-total" class="'.$class.'">'.WC()->cart->get_cart_contents_count().'</span>', $menu_item->title);
		}
    }

    return $menu_items;
}

/**
* Get product schema category based on the product type
*/
function wktheme_woocommerce_get_product_schema(){
	global $product;
	$schema = "Product";

	if($product->is_downloadable()){
		switch($product->download_type){
		  case 'application' : $schema = "SoftwareApplication"; break;
		  case 'music' : $schema = "MusicAlbum"; break;
		  default : $schema = "Product"; break;
		}
	}
	
	return 'https://schema.org/' . $schema;
}

/**
* Add additional checkouts fields or remove existing checkout fields
*/
function wktheme_woocommerce_checkout_fields($fields){
	 $fields['billing']['billing_pnr'] = array(
		'label' => __('Personal number', 'wktheme'),
		'required' => 1,
		'class' => array('form-row-wide'),
		'autocomplete' => 'personal-number',
		'priority' => 115
     );
	 
     return $fields;
}

/**
* Display additional checkouts fields on the order edit page in admin
*/
function wktheme_woocommerce_admin_order_data_after_billing_address($order){
    echo '<div class="address"><p><strong>'.__('Personal number','wktheme').':</strong> '.get_post_meta($order->get_id(), '_billing_pnr', true).'</p></div>';
}

/**
* Add additional information to emails
*/
function wktheme_woocommerce_email_order_details($order, $sent_to_admin, $plain_text, $email){ 
	if(empty($sent_to_admin)){
		echo '<p>'.__( "Hi, thank you for your order! This is an automated order confirmation, generated when your order is placed in our webshop. You will receive a new order confirmation with a delivery date as soon as any of our employees has time to process your order. Welcome back!", 'wktheme').'</p>';
	}
}; 

/**
* Add additional checkouts fields to emails sent to admin and client
*/
function wktheme_woocommerce_email_order_meta_fields($fields, $sent_to_admin, $order){
	$fields['meta_key'] = array(
		'label' => __('Personal number', 'wktheme'),
		'value' => get_post_meta($order->id, '_billing_pnr', true),
		'priority' => 999 
	);
	
	return $fields;
}


function wktheme_woocommerce_email_customer_details($order, $sent_to_admin, $plain_text, $email){
	return __('Personal number', 'wktheme').': '.get_post_meta($order->id, '_billing_pnr', true);
}

// Remove Actions
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);
remove_action('woocommerce_before_single_product', 'wc_print_notices');
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);

// Add Actions
add_action('add_meta_boxes', 'wktheme_remove_product_metaboxes_admin', 999);
add_action('init', 'wktheme_woocommerce_image_dimensions', 1);
add_action('wp_enqueue_scripts', 'wktheme_woocommerce_script_cleaner', 99);
add_action('woocommerce_after_shop_loop', 'wktheme_shop_main_categories_and_slider');
add_action('woocommerce_after_shop_loop_item','wktheme_woocommerce_after_shop_loop_item_title');
add_action('woocommerce_before_single_product_summary', 'wc_print_notices', 0);
add_action('woocommerce_single_product_summary', 'wktheme_woocommerce_product_additional_information', 45);
add_action('woocommerce_single_product_summary', 'wktheme_woocommerce_product_main_description', 60);
add_action('woocommerce_cart_actions', 'wktheme_woocommerce_cart_actions');
add_action('woocommerce_before_shop_loop', 'wktheme_add_woocommerce_product_search', 40);
add_action('woocommerce_product_options_general_product_data', 'wktheme_woocommerce_general_product_data_custom_fields');
add_action('woocommerce_process_product_meta', 'wktheme_woocommerce_process_product_meta_fields_save');
add_action('woocommerce_single_product_summary', 'wktheme_single_product_title', 5);
add_action('woocommerce_before_add_to_cart_quantity', 'wktheme_before_add_to_cart_quantity');
add_action('woocommerce_before_shop_loop_item','wktheme_template_loop_product_link_open');
add_action('woocommerce_admin_order_data_after_billing_address', 'wktheme_woocommerce_admin_order_data_after_billing_address', 10, 1);
add_action('woocommerce_email_order_details', 'wktheme_woocommerce_email_order_details', 10, 4);
//add_action('woocommerce_email_customer_details', 'wktheme_woocommerce_email_customer_details', 10, 99);

// Add Filters
add_filter('woocommerce_currency_symbol', 'wktheme_currency_symbol', 10, 2);
add_filter('woocommerce_placeholder_img_src', 'wktheme_custom_woocommerce_placeholder', 10);
add_filter('woocommerce_product_tabs', 'wktheme_remove_tabs_shop', 98);
add_filter('woocommerce_product_add_to_cart_text', 'wktheme_woocommerce_product_add_to_cart_text');
add_filter('woocommerce_product_thumbnails_columns', 'wktheme_woocommerce_product_thumbnails_columns');
add_filter('woocommerce_package_rates', 'wktheme_hide_shipping_methods_on_free_weight', 0);
add_filter('woocommerce_product_additional_information_heading', 'wktheme_woocommerce_product_additional_information_heading', 10, 1);
add_filter('loop_shop_per_page', 'wktheme_loop_shop_per_page', 20);
add_filter('woocommerce_cart_totals', 'wktheme_woocommerce_cart_totals', 10, 1);
add_filter('woocommerce_price_trim_zeros', '__return_true');
add_filter('woocommerce_variable_price_html', 'wktheme_woocommerce_variable_price_html', 10, 2);
add_filter('wp_nav_menu_objects', 'wktheme_cart_total_products');
add_filter('woocommerce_checkout_fields', 'wktheme_woocommerce_checkout_fields');
add_filter('woocommerce_dropdown_variation_attribute_options_html', 'wktheme_woocommerce_dropdown_variation_attribute_options_html', 10, 2);
add_filter('woocommerce_email_order_meta_fields', 'wktheme_woocommerce_email_order_meta_fields', 10, 4);
