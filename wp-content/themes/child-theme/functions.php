<?php
	
/*
	*
	*
	*
	*
	*
	*
	*
	*
*/

add_theme_support( 'html5', array( 'search-form' ) );


add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',get_stylesheet_directory_uri() . '/style.css', array('parent-style'));
}

/*
	*
	*	sidebars
	*
	*
*/

function goo_load_sidebars(){
	$args = array(
		array(
			'name'          => __( 'Quote of the Day', 'dailyquote' ),
			'id'            => 'daily-quote',
			'description'   => 'Daily Quote Rotator',
			'class'         => 'daily-quote',
		),
		array(
			'name'          => __( 'Featured Homepage Business', 'homefeatured' ),
			'id'            => 'home-featured',
			'description'   => 'featured homepage business',
			'class'         => 'home-featured',
		),
		
	);
	
	foreach( $args as $arg ){
		// register_sidebar( $arg );
	}
	
	
}
add_action( 'widgets_init', 'goo_load_sidebars' );

/*
	*
	*	widgets
	*
	*
*/

include( 'includes/auto_menu_sidebar_widget.class.php' );

function goo_load_widget() {
	
	$widgets = array(
		'auto_menu_sidebar_widget',
	);
	
	foreach($widgets as $key => $value){
		// register_widget($value);
	}

}
add_action( 'widgets_init', 'goo_load_widget' );

/*
	*
	*	custom posts
	*
	*
*/

/*
add_action( 'init', 'create_post_type' );
function create_post_type() {

	$collect = array( "My Custom Post Type" );
	
	foreach($collect as $value){
	
		$slug = str_replace(' ', '-', $value);
		$slug = str_replace("'", "", $slug );
		$slug = strtolower($slug);
		
		//echo $slug;
		
		register_post_type( 
			"$value",
			array(
				'labels'=>array(
					'name'=>__( "$value" ),
					'singular_name'=>__( "$value" )
				),
				'public'=>true,
				'exclude_from_search'=>false,
				'publicly_queryable'=>true,
				'show_ui'=>true,
				'show_in_nav_menus'=>false,
				'show_in_menu'=>true,
				'show_in_admin_bar'=>true,
				'menu_position'=>NULL,
				'capability_type'=>'post',
				'capabilities'=>array('edit_posts','read_posts','delete_posts'),
				'map_meta_cap'=>true,
				'hierarchical'=>true,
				'supports'=>NULL,
				'register_meta_box_cb'=>NULL,
				'taxonomies'=>array('category'),
				'has_archive'=>"$slug",
				'permalink_epmask'=>'EP_PERMALINK',
				'rewrite'=>array(
					'slug'=> "$slug",
					'with_front'=>false
				),
				'query_var'=>true,
				'can_export'=>true
			)
		);	
	}	
	
}
*/

?>