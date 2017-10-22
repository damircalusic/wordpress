<?php 
if ( !defined('ABSPATH')){ exit; }

// Customizer Settings Register
function wktheme_customizer($wp_customize){
	// Remove unneccessary sections etc.
	$wp_customize->remove_section('custom_css');
	
	//  =============================
    //  = Title Tagline Section 	=
    //  =============================
	//---  ==============================
    //---  = Logo display              =
    //---  ==============================
	$wp_customize->add_setting('wktheme_theme_logo_display', array('type' => 'option'));
    $wp_customize->add_control(
		'wktheme_theme_logo_display', 
		array(
			'label'    => __('Visa logotyp', 'wktheme'),
			'section'  => 'title_tagline',
			'settings' => 'wktheme_theme_logo_display',
			'priority' => 8,
			'type'     => 'select',
			'choices'  => array(
				'0' => 'Ja',
				'1' => 'Nej',
			),
			'default' => '0',
		)
	);
	
	//  =============================
    //  = Theme Color Section 		=
    //  =============================
	$wp_customize->add_section(
		'wktheme_theme_colors', 
		array(
			'title' => __('F&auml;rgschema', 'wktheme'),
			'priority' => 100,
		) 
	);
	
	//---  ==============================
    //---  = Theme main color			=
    //---  ==============================
	$wp_customize->add_setting('wktheme_theme_main_color',array('default' => '#744696'));	
	$wp_customize->add_control(
		new WP_Customize_Color_Control($wp_customize, 
			'wktheme_theme_main_color', 
			array(
				'label' => __('F&auml;rgschema (global)', 'wktheme'),
				'section' => 'wktheme_theme_colors',
				'settings' => 'wktheme_theme_main_color',
			) 
		) 
	);

	//---  ==============================
    //---  = A menu hover link color 	=
    //---  ==============================
	$wp_customize->add_setting('wktheme_theme_a_menu_link_hover_color',array('default' => '#FFFFFF'));
	$wp_customize->add_control(
		new WP_Customize_Color_Control($wp_customize, 
			'wktheme_theme_a_menu_link_hover_color', 
			array(
				'label' => __('F&auml;rg när man drar musen över länkar (huvudmenyn)', 'wktheme'),
				'section' => 'wktheme_theme_colors',
				'settings' => 'wktheme_theme_a_menu_link_hover_color',
			) 
		) 
	);

	//---  ==============================
    //---  = A theme hover link color 	=
    //---  ==============================
	$wp_customize->add_setting('wktheme_theme_a_link_hover_color', array('default' => '#2d1b32'));
	$wp_customize->add_control(
		new WP_Customize_Color_Control($wp_customize, 
			'wktheme_theme_a_link_hover_color', 
			array(
				'label' => __('F&auml;rg när man drar musen över länkar (övriga sidan)', 'wktheme'),
				'section' => 'wktheme_theme_colors',
				'settings' => 'wktheme_theme_a_link_hover_color',
			) 
		) 
	);

	//---  ==============================
    //---  = A theme puff link color 	=
    //---  ==============================
	$wp_customize->add_setting('wktheme_theme_puff_link_color', array('default' => '#FFFFFF'));
	$wp_customize->add_control(
		new WP_Customize_Color_Control($wp_customize, 
			'wktheme_theme_puff_link_color', 
			array(
				'label' => __('F&auml;rg på puff länkar', 'wktheme'),
				'section' => 'wktheme_theme_colors',
				'settings' => 'wktheme_theme_puff_link_color',
			) 
		) 
	);
	
	//  =====================================
    //  = Theme SEO Panel with sections		=
    //  =====================================
	$wp_customize->add_panel(
		'wktheme_theme_seo', 
		array(
			'title' => __('S&ouml;kmotoroptimering', 'wktheme'),
			'description' => '',
			'priority' => 150,
		) 
	);
	
	$wp_customize->add_section(
		'wktheme_theme_seo_panel_meta_tags', 
		array(
			'title' => __('Meta taggar', 'wktheme'),
			'priority' => 10,
			'panel' => 'wktheme_theme_seo',
		) 
	);
	
	//---  ==============================
    //---  = GEO.Place SEO City			=
    //---  ==============================
    $wp_customize->add_setting('wktheme_theme_geo_city',array('type' => 'option')); 
    $wp_customize->add_control(
		'wktheme_theme_geo_city', 
		array(
			'label' => __('Ange stad', 'wktheme'),
			'section' => 'wktheme_theme_seo_panel_meta_tags',
			'description' => __('Exempel <strong>Stockholm</strong>. Används för <strong>geo.placename</strong> meta taggen för SEO.', 'wktheme'),
			'settings' => 'wktheme_theme_geo_city',
			'priority' => 100,
		)
	);
	
	//---  ==============================
    //---  = GEO.Place SEO Country		=
    //---  ==============================
    $wp_customize->add_setting('wktheme_theme_geo_country',array('type' => 'option'));
    $wp_customize->add_control(
		'wktheme_theme_geo_country', 
		array(
			'label' => __('Ange land', 'wktheme'),
			'section' => 'wktheme_theme_seo_panel_meta_tags',
			'description' => __('Exempel <strong>Sverige</strong>. Används för <strong>DC.coverage</strong> meta taggen för SEO.', 'wktheme'),
			'settings' => 'wktheme_theme_geo_country',
			'priority' => 101,
		)
	);
	
	//---  ==================================
    //---  = GEO.Region SEO Country Code	=
    //---  ==================================
    $wp_customize->add_setting('wktheme_theme_geo_country_code',array('type' => 'option'));
    $wp_customize->add_control(
		'wktheme_theme_geo_country_code', 
		array(
			'label'	=> __('Ange landskod', 'wktheme'),
			'section' => 'wktheme_theme_seo_panel_meta_tags',
			'description' => __('2 bokstäver. Exempel <strong>SE</strong> för Sverige. Kika på <a href="https://countrycode.org/sweden" target="_blank">https://countrycode.org/sweden</a>. Används för <strong>geo.region</strong> meta taggen för SEO.', 'wktheme'),
			'settings' => 'wktheme_theme_geo_country_code',
			'priority' => 102,
		)
	);
	
	//---  ==================================
    //---  = Latitude SEO					=
    //---  ==================================
    $wp_customize->add_setting('wktheme_theme_geo_latitude',array('type' => 'option'));
    $wp_customize->add_control(
		'wktheme_theme_geo_latitude', 
		array(
			'label' => __('Ange latitud', 'wktheme'),
			'section' => 'wktheme_theme_seo_panel_meta_tags',
			'description' => __('Exempel <strong>59.329323</strong>. Kika på <a href="http://www.latlong.net/" target="_blank">http://www.latlong.net/</a>. Används för <strong>ICBM</strong> &amp; <strong>geo.position</strong> meta tags för SEO.', 'wktheme'),
			'settings' => 'wktheme_theme_geo_latitude',
			'priority' => 103,
		)
	);
	
	//---  ==================================
    //---  = Longitude SEO					=
    //---  ==================================
    $wp_customize->add_setting('wktheme_theme_geo_longitude',array('type' => 'option'));
    $wp_customize->add_control(
		'wktheme_theme_geo_longitude', 
		array(
			'label' => __('Ange longitud', 'wktheme'),
			'section' => 'wktheme_theme_seo_panel_meta_tags',
			'description' => __('Exempel <strong>18.068581</strong>. Kika på <a href="http://www.latlong.net/" target="_blank">http://www.latlong.net/</a>. Används för <strong>ICBM</strong> &amp; <strong>geo.position</strong> meta tags för SEO.', 'wktheme'),
			'settings' => 'wktheme_theme_geo_longitude',
			'priority' => 104,
		)
	);
	
	//  =====================================
    //  = Theme JavaScript section			=
    //  =====================================
	$wp_customize->add_section(
		'wktheme_theme_js_section', 
		array(
			'title' => __('Ytterligare JavaScript', 'wktheme'),
			'priority' => 160,
		)
	);
	
	//---  ==============================
    //---  = JavaScript textarea		=
    //---  ==============================
	$wp_customize->add_setting('wktheme_theme_js',array('type' => 'option'));
    $wp_customize->add_control(
		'wktheme_theme_js',
		array(
			'type' => 'textarea',
			'section' => 'wktheme_theme_js_section',
			'input_attrs' => array(
				'class' => 'code',
				'style' => 'border-right:0;border-left: 0;height:-webkit-calc(100vh - 185px);height:calc(100vh - 185px);resize:none;display:block;font-family:Consolas,Monaco,monospace;font-size:12px;padding:6px 8px;-moz-tab-size:4;-o-tab-size:4;tab-size:4;',
				'placeholder' => __('/**
										Du kan lägga till din egen JavaScript här. 
										Testa genom att skriva: alert("hej"); och sedan trycka på spara. 
									**/', 'wktheme'),
  			),
			'priority' => 10,
		)
	);
}

// Theme styles
function wktheme_customizer_head_styles(){
	$theme_color = get_theme_mod('wktheme_theme_main_color');
	$menu_link_hover = get_theme_mod('wktheme_theme_a_menu_link_hover_color');
	$puff_link_color = get_theme_mod('wktheme_theme_puff_link_color');
	$link_hover = get_theme_mod('wktheme_theme_a_link_hover_color');
	?>
<style type="text/css">
#site-navigation,#totop,.puff a,.kampanj a,#colophon,button,input[type=button],input[type=reset],input[type=submit]{background-color: <?php echo $theme_color; ?>;}
a,.puff span,.puff h2,.kampanj h2,.entry-content h1,.entry-content h2,.entry-content h3,.sidebar-widget h3{color: <?php echo $theme_color; ?>;}
.puff a,.kampanj a{color: <?php echo $puff_link_color; ?>;}
a:hover,a:active{color: <?php echo $link_hover; ?>;}
#site-navigation a:hover,#site-navigation li.current-menu-item a{color: <?php echo $menu_link_hover; ?>;}
</style>
	<?php
}

// Theme scripts
function wktheme_customizer_foot_scripts(){
	$theme_scripts = get_option('wktheme_theme_js');
	
	if($theme_scripts !== ''){
	?>
<script>/* <![CDATA[ */"use strict"; jQuery(document).ready(function($){<?php echo $theme_scripts; ?>});/* ]]> */</script>
	<?php
	}
}

// Add icon sizes for the meta icons
function wktheme_custom_site_icon_size($sizes){
	$sizes = '';
	$sizes[] = 512;
	$sizes[] = 384;
	$sizes[] = 256;
	$sizes[] = 194;
	$sizes[] = 192;
	$sizes[] = 180;
	$sizes[] = 152;
	$sizes[] = 144;
	$sizes[] = 120;
	$sizes[] = 114;
	$sizes[] = 96;
	$sizes[] = 76;
	$sizes[] = 72;
	$sizes[] = 60;
	$sizes[] = 57;
	$sizes[] = 48;
	$sizes[] = 36;
	$sizes[] = 32;
	$sizes[] = 16;
	
	return $sizes;
}

// Get the type of the icon
function wktheme_type_of_icon($icon){
	$base = strtolower(substr($icon, -4));
	
	switch($base){
		case '.ico' :
			$type = 'image/x-icon';
		break;
		case '.jpg' :
			$type = 'image/jpeg';
		break;
		case '.jpeg' :    
			$type = 'image/jpeg';
		break;
		case '.png' :    
			$type = 'image/png';
		break;
		default :
			$type = 'image/x-icon';
	}
	
	return $type;
}

// Print out icons in the head 
function wktheme_custom_site_icon_tag($meta_tags){	
	$type = wktheme_type_of_icon(esc_url(get_site_icon_url()));
	$meta_tags = '';
	$meta_tags[] = sprintf('<link rel="apple-touch-icon" href="%s" sizes="180x180" />', esc_url(get_site_icon_url(180)));
	$meta_tags[] = sprintf('<link rel="apple-touch-icon" href="%s" sizes="152x152" />', esc_url(get_site_icon_url(152)));
	$meta_tags[] = sprintf('<link rel="apple-touch-icon" href="%s" sizes="144x144" />', esc_url(get_site_icon_url(144)));
	$meta_tags[] = sprintf('<link rel="apple-touch-icon" href="%s" sizes="120x120" />', esc_url(get_site_icon_url(120)));
	$meta_tags[] = sprintf('<link rel="apple-touch-icon" href="%s" sizes="114x114" />', esc_url(get_site_icon_url(114)));
	$meta_tags[] = sprintf('<link rel="apple-touch-icon" href="%s" sizes="76x76" />', esc_url(get_site_icon_url(76)));
	$meta_tags[] = sprintf('<link rel="apple-touch-icon" href="%s" sizes="72x72" />', esc_url(get_site_icon_url(72)));
	$meta_tags[] = sprintf('<link rel="apple-touch-icon" href="%s" sizes="60x60" />', esc_url(get_site_icon_url(60)));
	$meta_tags[] = sprintf('<link rel="apple-touch-icon" href="%s" sizes="57x57" />', esc_url(get_site_icon_url(57)));
	$meta_tags[] = sprintf('<link rel="icon" type="%s" href="%s" sizes="512x512" />', $type, esc_url(get_site_icon_url(512,512)));
	$meta_tags[] = sprintf('<link rel="icon" type="%s" href="%s" sizes="384x384" />', $type, esc_url(get_site_icon_url(384,384)));
	$meta_tags[] = sprintf('<link rel="icon" type="%s" href="%s" sizes="256x256" />', $type, esc_url(get_site_icon_url(256,256)));
	$meta_tags[] = sprintf('<link rel="icon" type="%s" href="%s" sizes="194x194" />', $type, esc_url(get_site_icon_url(194,194)));
	$meta_tags[] = sprintf('<link rel="icon" type="%s" href="%s" sizes="192x192" />', $type, esc_url(get_site_icon_url(192,192)));
	$meta_tags[] = sprintf('<link rel="icon" type="%s" href="%s" sizes="144x144" />', $type, esc_url(get_site_icon_url(144,144)));
	$meta_tags[] = sprintf('<link rel="icon" type="%s" href="%s" sizes="96x96" />', $type, esc_url(get_site_icon_url(96,96)));
	$meta_tags[] = sprintf('<link rel="icon" type="%s" href="%s" sizes="72x72" />', $type, esc_url(get_site_icon_url(72,72)));
	$meta_tags[] = sprintf('<link rel="icon" type="%s" href="%s" sizes="48x48" />', $type, esc_url(get_site_icon_url(48,48)));
	$meta_tags[] = sprintf('<link rel="icon" type="%s" href="%s" sizes="36x36" />', $type, esc_url(get_site_icon_url(36,36)));
	$meta_tags[] = sprintf('<link rel="icon" type="%s" href="%s" sizes="32x32" />', $type, esc_url(get_site_icon_url(32,32)));
	$meta_tags[] = sprintf('<link rel="icon" type="%s" href="%s" sizes="16x16" />', $type, esc_url(get_site_icon_url(16)));
	$meta_tags[] = sprintf('<link rel="shortcut icon" type="%s" href="%s" />', $type, esc_url(get_site_icon_url(32,32)));
	
	return $meta_tags;
}

// Remove Actions
remove_action('wp_head', 'get_site_icon_url');

// Add Actions
add_action('customize_register', 'wktheme_customizer');
add_action('wp_head', 'wktheme_customizer_head_styles');
add_action('wp_footer', 'wktheme_customizer_foot_scripts',100);

// Add Filters
//add_filter('site_icon_image_sizes', 'wktheme_custom_site_icon_size');
//add_filter('site_icon_meta_tags', 'wktheme_custom_site_icon_tag', 10, 1);
