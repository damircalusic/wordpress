<?php 
if ( !defined('ABSPATH')){ exit; }

/**
* Remove metaboxes on add new product in admin
*/
function superkreativ_remove_product_metaboxes_admin() {
	remove_meta_box('postexcerpt', 'product', 'normal');
	remove_meta_box('commentsdiv', 'product', 'normal');
}

/**
 * Manage WooCommerce styles and scripts.
 */
function superkreativ_woocommerce_script_cleaner() {
	// Unless we're in the store, remove all the cruft!
	if (!is_woocommerce() && !is_cart() && !is_checkout()){
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
function superkreativ_woocommerce_image_dimensions(){
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
function superkreativ_currency_symbol($currency_symbol, $currency){
	global $product;
	
	$superkreativ_product_price_or_meter = get_post_meta($product->id, 'superkreativ_product_price_or_meter', true);
	
	switch($currency){
		case 'SEK': $currency_symbol = ((is_admin()) ? ($superkreativ_product_price_or_meter == 'yes') ? ' '.__('SEK/meter','superkreativ') : ' '.__('SEK/st','superkreativ') : ':-'); 
		break;
	}
	
	return $currency_symbol;
}

/**
* Function to return new placeholder image URL for WooCommerce product
*/
function superkreativ_custom_woocommerce_placeholder($image_url){
	return get_template_directory_uri().'/img/product-placeholderimage-300.jpg';
}

/*
* Get the WooCommerce category featured image
*/
function superkreativ_woocommerce_category_image($cat_id, $cat_name = ''){
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
function superkreativ_get_shop_categories_header(){
	$main_cats = '';
	$sub_cats = '';
	
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
			if($main->term_id != 17 && $main->term_id != 18){
				$main_slug = get_term_link($main->slug, 'product_cat');
				$main_class = (superkreativ_get_current_url() == $main_slug) ? 'shop-main-cat-active' : '';
				$main_cats .= '<a class="shop-main-cat '.$main_class.'" href="'.$main_slug.'">'.$main->name.'</a>';
			}
			
			$subs = get_categories(
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
					$sub_class = (superkreativ_get_current_url() == $sub_slug) ? 'shop-sub-cat-active' : '';
					$sub_cats .= '<a class="shop-sub-cat '.$sub_class.'" href="'.get_term_link($sub->slug, 'product_cat').'">'.$sub->name.'</a>';
				}   
			}
		}       
	}
	
	echo '<p>'.$main_cats.'</p><p>'.$sub_cats.'</p>';
}

/*
* Get the main shop categories with related slider
*/
function superkreativ_shop_main_categories_and_slider(){
	$main_cats = '';
	
	// Display only IF NOT shop page
	if(!is_shop()){
		$desc = superkreativ_current_product_category_desc();
		
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
		
		foreach($mains as $main) {
			if($main->category_parent == 0) {
				if($main->term_id != 17 && $main->term_id != 18){
					echo '<ul class="products main-cats">
							<li class="product-category">
								<figure>'.
									superkreativ_woocommerce_category_image($main->term_id, $main->name).'
									<figcaption>
										<div>
											<h2>'.$main->name.'</h2>
											<a class="shop-cat-link" href="'.get_term_link($main->slug, 'product_cat').'">'.__('View all products', 'superkreativ').'</a>
										</div>
									</figcaption>
								</figure>
							</li>
						</ul>';
					
					$products = array(
						'post_type' => 'product',
						'posts_per_page' => 8,
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
					
					wp_reset_postdata();
				}
			}       
		}
	}
}

/*
* Add a search products form to the shop
*/
function superkreativ_add_woocommerce_product_search() {
	if(!is_shop()){
		if(is_active_sidebar('produkt-sok')){ 
			dynamic_sidebar('produkt-sok'); 
		}
	}
}

/*
* Get all WooCommerce categories and display them in the shop except main shop page
*/
function superkreativ_get_shop_categories(){
	if(!is_shop()){
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
		
		echo '<div id="choose_category"><div class="styled-dropdown"><select><option>'.__('Välj kategori','superkreativ').'</option>';
		foreach($mains as $main) {
			if($main->category_parent == 0) {
				$main_slug = get_term_link($main->slug, 'product_cat');
				$selected = (strpos('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], $main_slug) !== false) ? 'selected="selected"' : '';
				echo '<option '.$selected.' value="'.$main_slug.'" class="strong">'.$main->name.'</option>';
			} 
			
			$subs = get_categories(
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
			
			foreach($subs as $sub) {
				$sub_slug = get_term_link($sub->slug, 'product_cat');
				$selected_sub = (strpos('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], $sub_slug) !== false) ? 'selected="selected"' : '';
				echo '<option '.$selected_sub.' value="'.$sub_slug.'">- '.$sub->name.'</option>';	
			}
		}
		echo '</select></div></div>';
	}
}

/*
* Change number of columns displaying product thumbnails
*/
function superkreativ_woocommerce_product_thumbnails_columns() {
	return 4;
}

/*
* Remove overflowed tabs from the shop
*/
function superkreativ_remove_tabs_shop($tabs){
    unset($tabs['description']);
	unset($tabs['reviews']);
	unset($tabs['additional_information']);
    
	return $tabs;
}

/*
* Get products main description
*/
function superkreativ_woocommerce_product_main_description() {
	the_content();
}

/*
* Get products additional information
*/
function superkreativ_woocommerce_product_additional_information() {
	woocommerce_get_template('single-product/tabs/additional-information.php');
}

/**
* Rename all text to fit superkreativ for products add_to_cart etc.
*/
function superkreativ_woocommerce_product_add_to_cart_text(){
	global $product;
	
	$product_type = $product->product_type;
	
	switch($product_type){
		case 'external': return __('Buy', 'superkreativ'); break;
		case 'grouped':return __('View products', 'superkreativ'); break;
		case 'simple': return __('Buy', 'superkreativ'); break;
		case 'variable': return __('Options', 'superkreativ'); break;
		default: return __('Read more', 'superkreativ');
	}
	
}

/**
* Add extra buttons to a product in listings
*/
function superkreativ_woocommerce_after_shop_loop_item_title(){
	global $product;
	
	echo '<a href="'.get_permalink($product->ID).'" class="read_more_product">'.__('Read more', 'superkreativ').'</a>';
}

/**
* Change products per page
*/
function superkreativ_loop_shop_per_page(){
	return 12;
}

/**
* Get current product category description
*/
function superkreativ_current_product_category_desc(){
	$queried_object = get_queried_object();
	
	return $queried_object->description;
}

/**
* Add Proceed to checkout button on cart.php page
*/
function superkreativ_woocommerce_cart_actions(){
	do_action('woocommerce_proceed_to_checkout');
}

/** 
* Hide shipping rates when free shipping is available 
*/
function superkreativ_hide_shipping_when_free_is_available($rates){
	$free = array();
	
	foreach($rates as $rate_id => $rate){
		if('free_shipping' === $rate->method_id){
			$free[$rate_id] = $rate;
			break;
		}
	}
	
	return !empty($free) ? $free : $rates;
}

/**
* Change the display of prices of variable products to --> From: 200 instead of 200 - 1500
*/
function superkreativ_woocommerce_variable_price_html($price_product_get_price_suffix, $product){
	$prices = preg_match_all("/woocommerce-Price-amount/i", $price_product_get_price_suffix);
	$superkreativ_product_price_or_meter = get_post_meta($product->id, 'superkreativ_product_price_or_meter', true);
	
	// If is Single product or is in Administration
	//if(is_product() || is_admin()){
		return (($prices >= 2) ? __('Från','superkreativ').': ' : '').number_format($product->price,0,' ',' ').' '.(($superkreativ_product_price_or_meter == 'yes') ? __('SEK/meter','superkreativ') : __('SEK/st','superkreativ'));
	//}
	
	//return ($prices >= 2) ? __('Från','superkreativ').': '.$product->price.':-' : $price_product_get_price_suffix;
}

/**
* Display custom product fields in the general tab of a single product in Admin
*/
function superkreativ_woocommerce_general_product_data_custom_fields() {
	global $woocommerce, $post;
	
	echo '<div class="options_group">';
	woocommerce_wp_checkbox(
		array(
			'id' => 'superkreativ_product_price_or_meter',
			'wrapper_class' => 'checkbox_class',
			'label' => __('Säljes per meter', 'klassbols'),
			'description' => __('Kryssa för om produkten säljs per meter', 'superkreativ')
		)
	);
	echo '</div>';
}

/**
* Save all custom products fields in the Dtabase
*/
function superkreativ_woocommerce_process_product_meta_fields_save($post_id){
	$superkreativ_product_price_or_meter = isset($_POST['superkreativ_product_price_or_meter']) ? 'yes' : 'no';
	update_post_meta($post_id, 'superkreativ_product_price_or_meter', $superkreativ_product_price_or_meter);
}

// Remove Actions
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);
remove_action('woocommerce_before_single_product', 'wc_print_notices');
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);

// Add Actions
add_action('add_meta_boxes', 'superkreativ_remove_product_metaboxes_admin', 999);
add_action('init', 'superkreativ_woocommerce_image_dimensions', 1);
add_action('wp_enqueue_scripts', 'superkreativ_woocommerce_script_cleaner', 99);
add_action('woocommerce_after_shop_loop', 'superkreativ_shop_main_categories_and_slider');
add_action('woocommerce_after_shop_loop_item','superkreativ_woocommerce_after_shop_loop_item_title');
add_action('woocommerce_before_single_product_summary', 'wc_print_notices', 0);
add_action('woocommerce_single_product_summary', 'superkreativ_woocommerce_product_additional_information', 45);
add_action('woocommerce_single_product_summary', 'superkreativ_woocommerce_product_main_description', 60);
add_action('woocommerce_cart_actions', 'superkreativ_woocommerce_cart_actions');
add_action('woocommerce_before_shop_loop', 'superkreativ_add_woocommerce_product_search', 40);
add_action('woocommerce_before_shop_loop', 'superkreativ_get_shop_categories', 40);
add_action('woocommerce_product_options_general_product_data', 'superkreativ_woocommerce_general_product_data_custom_fields');
add_action('woocommerce_process_product_meta', 'superkreativ_woocommerce_process_product_meta_fields_save');

// Add Filters
add_filter('woocommerce_currency_symbol', 'superkreativ_currency_symbol', 10, 2);
add_filter('woocommerce_placeholder_img_src', 'superkreativ_custom_woocommerce_placeholder', 10);
add_filter('woocommerce_product_tabs', 'superkreativ_remove_tabs_shop', 98);
add_filter('woocommerce_product_add_to_cart_text', 'superkreativ_woocommerce_product_add_to_cart_text');
add_filter('woocommerce_product_thumbnails_columns', 'superkreativ_woocommerce_product_thumbnails_columns');
add_filter('woocommerce_package_rates', 'superkreativ_hide_shipping_when_free_is_available', 0);
add_filter('loop_shop_per_page', 'superkreativ_loop_shop_per_page', 20);
add_filter('woocommerce_price_trim_zeros', '__return_true');
add_filter('woocommerce_variable_price_html', 'superkreativ_woocommerce_variable_price_html', 10, 2);
