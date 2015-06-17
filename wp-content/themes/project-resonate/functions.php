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



























/*
	*
	*	insert stuff before the cart button
	*
	*
*/

add_action( 'woocommerce_before_add_to_cart_button', 'add_transloadit_field' );
function add_transloadit_field(){

}


/*
	*
	*	on submit order
	*	
	*
*/
add_action( 'woocommerce_order_details_after_customer_details', 'woo_after_processed' );
function woo_after_processed( $order ){
	// global $woocommerce
	
	//add_post_meta( $order->id, 'oid-'.$order->id, 'with_syrup' );
	echo "<pre>";
	print_r( $order );
	echo "</pre>";
	
	//echo "<script>console.log( 'woocommerce_order_details_after_customer_details' );</script>";
}


/*
	*
	*	on add to cart
	*
	*
*/
add_action('woocommerce_add_order_item_meta','woo_hoo_stick_it_in_there',1, 2);
function woo_hoo_stick_it_in_there( $item_id, $values ){
	
	global $woocommerce;
	
	// $cust_vals = $values['transloadit-data'];
	$cust_vals = WC()->session->get('transloadit-data');
	$cust_vals2 = WC()->session->get('transloadit-file');
	$cust_vals3 = WC()->session->get('transloadit-name');
	wc_add_order_item_meta( $item_id, 'transloadit-png', $cust_vals );
	wc_add_order_item_meta( $item_id, 'transloadit-file', $cust_vals2 );
	wc_add_order_item_meta( $item_id, 'transloadit-name', $cust_vals3 );
	
	//echo "<pre>";
	//print_r( $values );
	//echo "</pre>";

	echo "<script>console.log( 'woocommerce_add_order_item_meta' );</script>";
}




/*
	*
	*	on add to cart
	*
	*
*/
add_filter( 'woocommerce_add_cart_item_data', 'add_cart_item_custom_data_vase', 10, 2 );
function add_cart_item_custom_data_vase( $cart_item_meta, $product_id, $variation_id ) {

	global $woocommerce;
	
	/*
		*
		*	image saving code
		*
		*
	*/
	$errors = array();
	$root = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];
	if( !file_exists( $_SERVER['DOCUMENT_ROOT'].'/wp-content/uploads/pres/' ) || !is_dir( $_SERVER['DOCUMENT_ROOT'].'/wp-content/uploads/pres/' ) ){
		mkdir( $_SERVER['DOCUMENT_ROOT'].'/wp-content/uploads/pres/', 755 );
	}
	
	try{
		$url = $_POST['transloadit-png'];
		$img = $_SERVER['DOCUMENT_ROOT'].'/wp-content/uploads/pres/flower.png';
		file_put_contents($img, file_get_contents($url));
		
		$filepath = $root.'/wp-content/uploads/pres/flower.png';
		
	}
	catch( Exception $e ){
		$filepath = $e;
	}
	
	/*
		*
		*	sound saving code
		*
		*
	*/
		
	try{
		$url = $_POST['transloadit-file'];
		$img = $_SERVER['DOCUMENT_ROOT'].'/wp-content/uploads/flower.wav';
		file_put_contents($img, file_get_contents($url));
		
		$filepath2 = $root.'/wp-content/uploads/pres/flower.wav';		
	}
	catch( Exception $e ){
		$filepath2 = $e;
	}
	
	//	WE NEED TO HOOK INTO https://codex.wordpress.org/Function_Reference/wp_insert_attachment to get it into the media library
	
	$transloadit = array(
		array(
			"name" => "transloadit-png",
			"value" => $filepath,
			"file" => $filepath2,
			"display" => "Toots McScoots",
			"errors" => $errors,
			"fileName" => $_POST['transloadit-name']
		),
	);
	
	$cart_item_meta["transloadit-name"] = $transloadit[0]['fileName'];
	$cart_item_meta["transloadit-data"] = $transloadit[0]['value'];
	$cart_item_meta["transloadit-file"] = $transloadit[0]['file'];
	
	WC()->session->set("transloadit-name", $transloadit[0]['fileName'] );	
	WC()->session->set("transloadit-data", $transloadit[0]['value'] );
	WC()->session->set("transloadit-file", $transloadit[0]['file'] );
	
	return $cart_item_meta; 
}


/*
	*
	* on view cart
	*
	*
*/
//Get it from the session and add it to the cart variable
add_filter( 'woocommerce_get_cart_item_from_session', 'get_cart_items_from_session', 1, 3 );
function get_cart_items_from_session( $item, $values, $key ) {
	
	//echo "<pre>";
	//print_r( $values );
	//echo "</pre>";
	
	if ( array_key_exists( 'transloadit-name', $values ) ){
		$item[ 'transloadit-name' ] = $values['transloadit-name'];
	}
	
    if ( array_key_exists( 'transloadit-data', $values ) ){
		$item[ 'transloadit-data' ] = $values['transloadit-data'];
	}
	
	if ( array_key_exists( 'transloadit-file', $values ) ){
		$item[ 'transloadit-file' ] = $values['transloadit-file'];
	}
	
	// echo "<script>console.log( 'woocommerce_get_cart_item_from_session' );</script>";
	
	return $item;
}

?>