<?php
/**
 * Variable product add to cart
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce, $product, $post;
?>

<script type="text/javascript">
    var product_variations_<?php echo $post->ID; ?> = <?php echo json_encode( $available_variations ) ?>;
</script>

<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>
<form class="variations_form cart" method="post" enctype='multipart/form-data' data-product_id="<?php echo $post->ID; ?>" data-product_variations="<?php echo esc_attr( json_encode( $available_variations ) ) ?>">
	<?php if ( ! empty( $available_variations ) ) : ?>
		<table class="variations" cellspacing="0">
			<tbody>
				<?php $loop = 0; foreach ( $attributes as $name => $options ) : $loop++; ?>
					<tr>
						<td class="label"><label for="<?php echo sanitize_title($name); ?>"><?php echo wc_attribute_label( $name ); ?></label></td>
						<td class="value"><fieldset>
                        <strong>Choose An Option...</strong><br />
                        <?php
                            if ( is_array( $options ) ) {
 
                                if ( empty( $_POST ) )
                                    $selected_value = ( isset( $selected_attributes[ sanitize_title( $name ) ] ) ) ? $selected_attributes[ sanitize_title( $name ) ] : '';
                                else
                                    $selected_value = isset( $_POST[ 'attribute_' . sanitize_title( $name ) ] ) ? $_POST[ 'attribute_' . sanitize_title( $name ) ] : '';
								//echo   $selected_value;
                                // Get terms if this is a taxonomy - ordered
                                if ( taxonomy_exists( sanitize_title( $name ) ) ) {
 
                                    $terms = get_terms( sanitize_title($name), array('menu_order' => 'ASC') );
									
                                    foreach ( $terms as $term ) {
                                        if ( ! in_array( $term->slug, $options ) ) continue;
                                        echo '<input type="radio" value="' . strtolower($term->slug) . '" ' . checked( strtolower ($selected_value), strtolower ($term->slug), false ) . ' id="'. esc_attr( sanitize_title($name) ) .'" name="attribute_'. sanitize_title($name).'">' . apply_filters( 'woocommerce_variation_option_name', $term->name ).'<br />';
                                    }
                                } else {
                                    foreach ( $options as $option )
                                        echo '<input type="radio" value="' .esc_attr( sanitize_title( $option ) ) . '" ' . checked( sanitize_title( $selected_value ), sanitize_title( $option ), false ) . ' id="'. esc_attr( sanitize_title($name) ) .'" name="attribute_'. sanitize_title($name).'">' . apply_filters( 'woocommerce_variation_option_name', $option ) . '<br />';
                                }
                            }
                        ?>
                    </fieldset> <?php
							if ( sizeof($attributes) == $loop )
								//echo '<a class="reset_variations" href="#reset">' . __( 'Clear selection', 'woocommerce' ) . '</a>';
						?></td>
					</tr>
		        <?php endforeach;?>
			</tbody>
		</table>
		<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

		<div class="single_variation_wrap" style="display:none;">
			<?php do_action( 'woocommerce_before_single_variation' ); ?>

			<div class="single_variation"></div>

			<div class="variations_button">
				<?php woocommerce_quantity_input(); ?>
				<button type="submit" class="single_add_to_cart_button button alt"><?php echo $product->single_add_to_cart_text(); ?></button>
			</div>

			<input type="hidden" name="add-to-cart" value="<?php echo $product->id; ?>" />
			<input type="hidden" name="product_id" value="<?php echo esc_attr( $post->ID ); ?>" />
			<input type="hidden" name="variation_id" value="" />

			<?php do_action( 'woocommerce_after_single_variation' ); ?>
		</div>

		<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>

	<?php else : ?>

		<p class="stock out-of-stock"><?php _e( 'This product is currently out of stock and unavailable.', 'woocommerce' ); ?></p>
	<?php endif; ?>

</form>

<script src="//assets.transloadit.com/js/jquery.transloadit2-v2-latest.js"></script>
<form id="transloadit-form" name="fuckkkkkk" enctype="multipart/form-data" method="post">
		<input type="file" name="transloadit"/>
		<input type="submit" />
</form>
	<script>
		//console.log( '<?php echo $audioFile; ?>' );



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
							
							var transField = document.createElement( 'input' );
							transField.type = 'hidden';
							transField.name = 'transloadit-file';
							transField.value = upload.url;
							woocomm.appendChild( transField );
							
							var transName = document.createElement( 'input' );
							transName.type = 'hidden';
							transName.name = 'transloadit-name';
							transName.value = upload.name;
							woocomm.appendChild( transName );
							
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
							woocomm.appendChild( transField );
							
						}
						
/*
						var oData = new FormData( document.getElementById( 'transloadit-form' ) );
						var oReq = new XMLHttpRequest();
						oReq.open( 'POST', '/wp-content/themes/project-resonate/woocommerce/transloadit-form.php', true );
						
						oReq.onreadystatechange = function(){
							if( oReq.readyState == 4 ){
								if( oReq.status >= 200 && oReq.status < 300 || oReq.status == 304 ){
									console.log( oReq.response );
								}
								else if( oReq.status > 400 ){
									
								}
							}
						}
						oReq.send( oData );
*/
							
						
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
	-moz-appearance:	none;
	appearance:			none;
	opacity: 0.4;
	height: 24px;
	width: 32px;
	background-repeat: no-repeat;
	background-position: center center;
	background-color: transparent !important;
	
	-webkit-transition: opacity 0.2s ease-in-out;
	transition: opacity 0.2s ease-in-out;
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
</style>



<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>
