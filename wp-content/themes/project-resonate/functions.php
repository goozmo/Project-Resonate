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
    wp_enqueue_script( 'theme-functions-js', get_stylesheet_directory_uri() . '/js/functions.min.js', array(), '1', false );
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


function _goo_login_button( $atts ){
	
	$url = "";
	$link_text = "";
	
	if( is_user_logged_in() ){
		$url = wp_logout_url();
		$link_text = "Logout";
	}
	else{
		$url = wp_login_url();
		$link_text = "Login";
	}
	
	$output = "";
	$output.= "<a href='";
	$output.= $url;
	$output.= "' class='_goo-login-button' >";
	$output.= $link_text;
	$output.= "</a>";
	
	return $output;
}
add_shortcode( '_goo_login_button', '_goo_login_button' );




















/*
	*	Woocommerce Stuff
	*
*/




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
	// echo "<pre>";
	// print_r( $order );
	// echo "</pre>";
	
	unset( $woocommerce->session->data['transloadit-data'] );
	unset( $woocommerce->session->data['transloadit-file'] );
	unset( $woocommerce->session->data['transloadit-name'] );
	
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
	// $cust_vals = WC()->session->get('transloadit-data');
	// $cust_vals2 = WC()->session->get('transloadit-file');
	// $cust_vals3 = WC()->session->get('transloadit-name');
	
	$cust_vals = $values['transloadit-data'];
	$cust_vals2 = $values['transloadit-file'];
	$cust_vals3 = $values['transloadit-name'];
	
	wc_add_order_item_meta( $item_id, 'waveform-image', $cust_vals );
	wc_add_order_item_meta( $item_id, 'sound-file', $cust_vals2 );
	wc_add_order_item_meta( $item_id, 'your-sound-code', $cust_vals3 );
	
	echo "<pre>";
	print_r( $values );
	echo "</pre>";
	
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

	$errors = array();
	$root = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];
	
	/*
		*
		*	code generation
		*
		*
	*/

	$sound_code = rand( 0, 10000000 );
	
	if( file_exists( $_SERVER['DOCUMENT_ROOT'].'/wp-content/uploads/pres/' ) || is_dir( $_SERVER['DOCUMENT_ROOT'].'/wp-content/uploads/pres/' ) ){
		$pre_array = scandir( $_SERVER['DOCUMENT_ROOT'].'/wp-content/uploads/pres/' );
		foreach( $pre_array as $_file_ ){
			if( $_file_ != "." && $_file_ != ".." ){
				while( preg_match( "/$sound_code/", $_file_ ) == true ){
					$sound_code = rand( 9999999, 10000000 );
				}
			}
		}
		// echo "<pre>";
		// print_r( $pre_array );
		// echo "</pre>";
	}
	
	/*
		*
		*	image saving code
		*
		*
	*/
	
	if( !file_exists( $_SERVER['DOCUMENT_ROOT'].'/wp-content/uploads/pres/' ) || !is_dir( $_SERVER['DOCUMENT_ROOT'].'/wp-content/uploads/pres/' ) ){
		mkdir( $_SERVER['DOCUMENT_ROOT'].'/wp-content/uploads/pres/', 755 );
	}
	
	try{
		$url = $_POST['transloadit-png'];
		$img = $_SERVER['DOCUMENT_ROOT'].'/wp-content/uploads/pres/' . $sound_code . '.png';
		file_put_contents($img, file_get_contents($url));
		if( file_exists( $img ) ){
			chmod( $img, 0644);
		}
		$filepath = $root.'/wp-content/uploads/pres/' . $sound_code . '.png';
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
		$img = $_SERVER['DOCUMENT_ROOT'].'/wp-content/uploads/pres/' . $sound_code . '.wav';
		file_put_contents($img, file_get_contents($url));
		if( file_exists( $img ) ){
			chmod( $img, 0644 );
		}
		
		$filepath2 = $root.'/wp-content/uploads/pres/' . $sound_code . '.wav';		
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
			"fileName" => $sound_code
		),
	);
	
	$cart_item_meta["transloadit-name"] = $sound_code;
	$cart_item_meta["transloadit-data"] = $transloadit[0]['value'];
	$cart_item_meta["transloadit-file"] = $transloadit[0]['file'];
	
	WC()->session->set( "transloadit-name", $sound_code );	
	WC()->session->set( "transloadit-data", $transloadit[0]['value'] );
	WC()->session->set( "transloadit-file", $transloadit[0]['file'] );
	
	return $cart_item_meta;
	
}


/*
	*
	* on always
	*
	*
*/
//Get it from the session and add it to the cart variable
add_filter( 'woocommerce_get_cart_item_from_session', 'get_cart_items_from_session', 1, 3 );
function get_cart_items_from_session( $item, $values, $key ) {
	
	// echo "<pre>";
	// print_r( $values );
	// echo "</pre>";
	
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














add_action( 'woocommerce_before_add_to_cart_form', 'do_step1');
function do_step1(){
	?>
	<h4 class="_goo-order-step"><span>Step 1: </span>Choose your product variations: band and bead color.</h4>
	<?php
}



add_action( 'woocommerce_add_to_cart_validation', 'goo_validate', 1, 5 );
function goo_validate(){
	
	if( !isset( $_POST['transloadit-file'] ) || empty( $_POST['transloadit-file'] ) ){
		$product = get_product( $product_id );
		$product_title = $product->post->post_title;
		wc_add_notice( "You need to upload a file... or else!" );
	}
	else{
		return true;
	}
	
}

add_action( 'woocommerce_before_add_to_cart_button', 'goo_price_output' );
function goo_price_output(){
	
	global $product;
	
	?>
	<div class="pres-upload-button" id="pres-upload-button-inst1">
		<h4 class="_goo-order-step"><span>Step 2: </span>Upload a sound file. Click "Choose File," select your file and click "Submit." Visit our Create a Sound File page if you need additional tips.</h4>
		<button class="button">Upload a sound file</button>
		<span class="arrow-thing fa fa-angle-down">&nbsp;Upload an audio or video file in the <a href="#transloadit-form" style="color: rgb( 239, 118, 34 );">form below</a></span>
		<div style="width: 100%; clear: both;"></div>
	</div>
	<br/>
	<h4 class="_goo-order-step"><span>Step 3: </span>After the file has been successfully processed, add the item to your cart and checkout.</h4>
	
	<div class="_goo-cart-price-output">
		<?php echo $product->get_price_html(); ?>
	</div>
	<?php
}


add_action( 'woocommerce_after_add_to_cart_button', 'do_step4' );
function do_step4(){
	?>
	<h4 class="_goo-order-step"><span>Step 4: </span>Check out & take your Sound Code to our Sound Code Page to listen. Your order will be filled with a product, padded box, plus a card with your sound code.</h4>
	<?php
}

add_action( 'woocommerce_after_add_to_cart_form', 'goo_form_output' );
function goo_form_output(){
?>

<script src="//assets.transloadit.com/js/jquery.transloadit2-v2-latest.js"></script>
<form id="transloadit-form" name="transloadit-form" enctype="multipart/form-data" method="post">
	<div class="transloadit-form-container">
		
		<h5>To Upload a file, click "choose file" on the form below, select a file &amp; click open or enter.  For more detailed info on creating an accepted sound file, visit our <a href="/q-a">Q & A page</a></h5><br/>
		<h5>Accepted file types .wav, .ogg, .m4v or .mov file</h5>
		<br/>
		<input type="file" name="transloadit" required="true" pattern="(.wav|.ogg|.m4p|.mov)$"/>
		<input type="submit" />
		<div style="width: 100%; clear: both;"></div>
	</div>
	
</form>
<script>
//console.log( '<?php echo $audioFile; ?>' );

_goo_variation_inst = {
	
	upload_form : "",
	
	_cjTransitionProp : candyjar.api.evCSSanimationProperty( ['transition', 'webkitTransition', 'otransition', 'transition'] ),  
	
	_cjTransitionEndProp : candyjar.api.evCSSanimationProperty( ['transitionend', 'webkitTransitionEnd', 'otransitionend', 'transitionend'] ),
	
	_cjTransformProp : candyjar.api.evCSSanimationProperty( ['transform', 'msTransform', 'webkitTransform', 'mozTransform', 'oTranform'] ), 
	
	requestAnimationFrame : window.requestAnimationFrame || window.mozRequestAnimationFrame || window.webkitRequestAnimationFrame || window.msRequestAnimationFrame,
	
	init : function(){
		
		// console.log( this._cjTransitionProp );
		
		
		this.upload_form = document.getElementById( 'transloadit-form' );
		pre_class = this.upload_form.className;
		this.upload_form.className = pre_class + " _goo-inactive"; 
		
		console.log( this.upload_form.style[ this._cjTransformProp ] );
		
		if( this.upload_form.style[ this._cjTransformProp ] === "" || this.upload_form.style[ this._cjTransformProp ] === "undefined" || this.upload_form.style[ this._cjTransformProp ] === null ){
			this.upload_form.style[ this._cjTransitionProp ] = "max-height 0.2s ease-in-out";
		}
		
		jQuery( '.pres-upload-button' ).on( 'click', 'button', function( event ){
			event.preventDefault();
			_goo_variation_inst.do_clicky();
			
		});
		this.animate( 0 );
		
	},
	
	do_clicky : function(){
		
		if( this.upload_form.className.match(/_goo-active/gi) ){
			
			candyjar.api.declassify( this.upload_form, '_goo-active' );
			candyjar.api.classify( this.upload_form, '_goo-inactive' );
			
			fHeight = 0;
			this.animate( fHeight );			
			// console.log( '1' );
		}
		else{
			candyjar.api.classify( this.upload_form, '_goo-active' );
			candyjar.api.declassify( this.upload_form, '_goo-inactive' );
			// console.log( '2' );
			
			fHeight = 100;
			this.animate( fHeight );
			
		}	
		
		
		// console.log( this.upload_form );
		
	},
	
	animate : function( fHeight ){
		var thingies = document.getElementsByClassName( 'arrow-thing' );
		_animate = function(){
			if( fHeight == 0 ){
				_goo_variation_inst.upload_form.style.maxHeight = "0px";
				
				for( var i=0, n=thingies.length; i<n; i++ ){
					thingies[i].style.opacity = 0;
				}
				//this.requestAnimationFrame( _animate );
			}
			else if( fHeight == 100 ){
				_goo_variation_inst.upload_form.style.maxHeight = "500px";
				for( var i=0, n=thingies.length; i<n; i++ ){
					thingies[i].style.opacity = 1;
				}
				//this.requestAnimationFrame( _animate );
			}
		}
		
		_animate( fHeight );
	}
}

_goo_variation_inst.init();

/*
	jQuery.ajax( '/wp-content/themes/project-resonate/woocommerce/transloadit-form.js', {
		dataType: "script",
		success : function( response ){
			console.log( response );
		},
		error : function(){
			console.log( 'fucked up' );
			
		}
	});	
*/

jQuery(function(){
	jQuery('#transloadit-form').transloadit({
		wait : true,
		triggerUploadOnFileSelection : true,
		params : {
			auth : {
				key: "b15a103003e211e5a7cb1199b0923661"
			},
			steps : {
				mp3: {
					use: ":original",
					robot: "/audio/encode",
					preset: "mp3"
				},
				waveform : {
					robot : "/audio/waveform",
					use : "mp3",
					width : 500,
					height : 200,
					background_color : "000000",
					outer_color : "cccccc",
					center_color : "ffffff"
				}
			},
			notify_url : window.location.href
		},
		autoSubmit : false,
		onUpload : function( upload ){
			// console.log( upload );
			
			var woocomm = document.getElementsByClassName( 'variations_form cart' );
			if( woocomm.length > 0 ){
				
				woocomm = woocomm[0];
				
				if( document.getElementsByName( 'transloadit-file' ).length < 1 ){
					var transField = document.createElement( 'input' );
					transField.type = 'hidden';
					transField.name = 'transloadit-file';
					woocomm.appendChild( transField );
				}
				else{
					var transField = document.getElementsByName( 'transloadit-file' )[0];
				}
				
				transField.value = upload.url;
				console.log( transField.value );
				
				if( document.getElementsByName( 'transloadit-name' ).length < 1 ){
					var transName = document.createElement( 'input' );
					transName.type = 'hidden';
					transName.name = 'transloadit-name';
					woocomm.appendChild( transName );
				}
				else{
					var transName = document.getElementsByName( 'transloadit-name' )[0];
				}
				
				transName.value = upload.name;
				console.log( upload.name );
				
			}
		},
		onResult : function( step, result ){
			// console.log( step );
			// console.log( result );
			
			var woocomm = document.getElementsByClassName( 'variations_form cart' );
			if( woocomm.length > 0 ){
				
				woocomm = woocomm[0];
				
				var transField = document.createElement( 'input' );
				transField.type = 'hidden';
				transField.name = 'transloadit-png';
				transField.value = result.url;
				transField.setAttribute( 'required', 'true' );
				woocomm.appendChild( transField );
				
				var bizzuton = document.getElementById( 'pres-upload-button-inst1' );
				
				if( document.getElementsByClassName( '_goo-uploaded-image-render' ).length < 1 ){
					var sound_wave = document.createElement( 'img' );
					sound_wave.className = "_goo-uploaded-image-render";
					bizzuton.appendChild( sound_wave );
				}
				else{
					var sound_wave = document.getElementsByClassName( '_goo-uploaded-image-render' )[0];
				}
			
				sound_wave.src = result.url;
				
				var good_notice = document.createElement( 'p' );
				good_notice.innerHTML = "File Processed Succesfully";
				bizzuton.appendChild( good_notice );
				
			}						
		},
		onSuccess : function( assembly ){
			// console.log( assembly.results );
			// console.log( assembly );
			
			// document.getElementById('_goo-valid').parentNode.removeChild( document.getElementById('_goo-valid') );
		}
	});
	// console.log( 'true' );
});
		
</script>


	

<style>
.variations input[name="attribute_bead-color"]
{
	margin:0;
	padding:0;
	-webkit-appearance:	none;
	-moz-appearance:	input;
	appearance:			none;
	opacity: 0.4;
	height: 24px;
	width: 32px;
	background-repeat: no-repeat;
	background-position: center center;
	background-color: transparent !important;
	
	-webkit-transition: opacity 0.2s ease-in-out;
	transition: opacity 0.2s ease-in-out;
	
	border: none !important;
	border-width: 0 !important;
}

.variations input[name="attribute_bead-color"]:checked,
.variations input[name="attribute_bead-color"]:hover
{
	opacity: 1;
}

.variations input[value='black-opaque']
{
	background-image:url( '/wp-content/themes/project-resonate/images/pr-blackbutton.png');	
}

.variations input[value='white-opaque']
{
	background-image:url( '/wp-content/themes/project-resonate/images/pr-whitebutton.png');	
}

.variations input[value='orange-opaque']
{
	background-image:url( '/wp-content/themes/project-resonate/images/pr-orangeObutton.png');	
}

.variations input[value='pink-translucent']
{
	background-image:url( '/wp-content/themes/project-resonate/images/pr-pinkbutton.png');	
}

.variations input[value='green-translucent']
{
	background-image:url( '/wp-content/themes/project-resonate/images/pr-greenbutton.png');	
}

.variations input[value='blue-translucent']
{
	background-image:url( '/wp-content/themes/project-resonate/images/pr-bluebutton.png');	
}

._goo-uploaded-image-render
{
	max-width: 350px;
	width: 100%;
	border: 1px solid rgb( 180, 180, 180 );
	background-color: rgb( 255,255,255 );
	margin-top: 30px;
}

.single-product-summary .variations_form.cart .pres-upload-button
{
	padding: 20px 0;
	border-top: 1px solid rgb( 230, 230, 230 );
	border-bottom: 1px solid rgb( 230, 230, 230 );
}
</style>
<?php	
}

?>