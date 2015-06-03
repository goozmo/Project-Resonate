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
    wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css',array('parent-style'));
    wp_enqueue_style( 'font-awesome', get_stylesheet_directory_uri() . '/font-awesome-4.3.0/css/font-awesome.min.css', array());
    wp_enqueue_script( 'theme-functions-js', get_stylesheet_directory_uri() . '/js/functions.min.js', array(), '1', true );
}

include( 'includes/http-redirect/index.php' );
include( 'includes/auto-menu-sidebar-widget.class.php' );

// custom login

add_action('login_head', 'custom_login_logo');
function custom_login_logo() {
    echo "<style type=\"text/css\">
    	body.login
    	{
			background-size: cover;
			background-position : center center;
			background-color: rgb( 0,0,0 );
        }
    	.login #login
    	{
			max-width: 500px;
			width: 100%;
    	}
        .login #login h1 a
        {
	        background-image:url( /wp-content/uploads/2015/05/logo-pr-w.png );
	        width: 100%;
	        background-size: contain;
        }
        .login #login form
        {
	        padding: 30px 40px 40px;
	        border-radius: 4px;
	        background : rgba( 0,0,0,0.6 );
        }
        .login #login form label
        {
	        color : rgb( 255,255,255 );
        }
        .login #login #nav,
        .login #login #backtoblog
        {
	        text-align: center;
	    }
	    .login #login #nav a,
        .login #login #backtoblog a
        {
	        color: rgb( 255,255,255 );
        }
        
        .login .message
        {
	        border-color: rgb( 239, 122, 32 );
        }
        
        .wp-core-ui .button-primary
        {
	        background-color: rgb( 239, 122, 32 );
	        border-color: rgb( 219, 102, 12 );
        }
        
         .wp-core-ui .button-primary:hover
        {
	        background-color: rgb( 219, 102, 12 );
	        border-color: rgb( 199, 92, 0 );
        }
        
    </style>";
}



add_action( 'init', 'goo_create_post_type' );
function goo_create_post_type() {

	$collect = array(
		
	);
	
	foreach($collect as $value){
	
		$slug = preg_replace( '/\band\b/', '', $value );
		$slug = str_replace(' ', '-', $slug);
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
				'supports'=> array( 
					'title',
					'editor',
					'thumbnail',
					'excerpt',
					'revisions',
				 ),
				'register_meta_box_cb'=>NULL,
				'taxonomies'=>array(),
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


function goo_load_widget() {
	
	$widgets = array(
		'auto_menu_sidebar_widget',
	);
	
	foreach($widgets as $key => $value){
		register_widget($value);
	}

}
add_action( 'widgets_init', 'goo_load_widget' );

remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10);

?>