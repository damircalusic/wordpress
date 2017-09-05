<?php
if ( !defined('ABSPATH')){ exit; }

/**
* Register sidebars
*/
register_sidebar( array(
	'name'          => __('Sidebar 1', 'wktheme'),
	'id'            => 'sidebar-1',
	'description'   => '',
	'before_widget' => '',
	'after_widget'  => '',
	'before_title'  => '',
	'after_title'   => '',
) );
