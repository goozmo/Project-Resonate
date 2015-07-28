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

<form class="variations_form cart" method="post" enctype='multipart/form-data' data-product_id="<?php echo $post->ID; ?>" data-product_variations="<?php echo esc_attr( json_encode( $available_variations ) ) ?>">
	<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>
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
			
			<input id="_goo-valid" type="hidden" required="true" value=""/>
			
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

<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>


<?php
	
echo get_the_title();
// Bracelet
// Necklace
// T-Shirts
	
?>


<script>
if( document.getElementsByClassName('single-product').length > 0 ){
	
	var doppleganger = document.getElementsByClassName( 'variations' );
	for( var i=0, n=doppleganger.length; i<n; i++ ){
		doppleganger[i].addEventListener( 'change', function(){
			candyShopInst.clickFunc();
		});
	}
	
	var _cjTransitionProp = candyjar.api.evCSSanimationProperty( [ 'transition', 'webkitTransition', 'otransition' ] ),
	_cjTransitionEndProp = candyjar.api.evCSSanimationProperty( ['transitionend', 'webkitTransitionEnd', 'otransitionend', 'transitionend'] ),
	_cjTransformProp = candyjar.api.evCSSanimationProperty( ['transform', 'msTransform', 'webkitTransform', 'mozTransform', 'oTranform'] ), 
	requestAnimationFrame = window.requestAnimationFrame || window.mozRequestAnimationFrame || window.webkitRequestAnimationFrame || window.msRequestAnimationFrame;
	
	candyShopInst = {
		
		_preloaded : false,
		thisProduct : <?php echo the_ID(); ?>,
		thisImg : "",
		thisBand : false,
		thisBead : false,
		thisShirtColor : false,
		beadImg : {
			"black-rubber-orange-opaque" 			: "/wp-content/uploads/2015/06/BlackOrange-450x350.png",
			"black-rubber-black-opaque" 			: "/wp-content/uploads/2015/06/blackblack-450x300.png",
			"black-rubber-white-opaque" 			: "/wp-content/uploads/2015/06/blackwhite-450x300.png",
			"black-rubber-pink-translucent" 		: "/wp-content/uploads/2015/06/blackpink-450x300.png",
			"black-rubber-green-translucent" 		: "/wp-content/uploads/2015/06/blackgreen-450x300.png",
			"black-rubber-blue-translucent" 		: "/wp-content/uploads/2015/06/Blackblue-450x300.png",
			
			"white-rubber-orange-opaque" 			: "/wp-content/uploads/2015/06/whiteorange-450x300.png",
			"white-rubber-black-opaque" 			: "/wp-content/uploads/blackbracelet-450x350.png",
			"white-rubber-white-opaque" 			: "/wp-content/uploads/2015/06/whitewhite-450x344.png",
			"white-rubber-pink-translucent" 		: "/wp-content/uploads/2015/06/whitepink-450x300.png",
			"white-rubber-green-translucent" 		: "/wp-content/uploads/2015/06/whitegreen-450x300.png",
			"white-rubber-blue-translucent" 		: "/wp-content/uploads/2015/06/whiteblue-450x300.png",
			
			"silver-chain-orange-opaque" 			: "/wp-content/uploads/2015/06/chainorange-450x300.png",
			"silver-chain-black-opaque" 			: "/wp-content/uploads/2015/06/chainblack-450x300.png",
			"silver-chain-white-opaque" 			: "/wp-content/uploads/2015/06/chainwhite-450x300.png",
			"silver-chain-pink-translucent" 		: "/wp-content/uploads/2015/06/chainpink-450x330.png",
			"silver-chain-green-translucent" 		: "/wp-content/uploads/2015/06/chaingreen-450x300.png",
			"silver-chain-blue-translucent" 		: "/wp-content/uploads/2015/06/chainblue-450x300.png",
		},
		
		shirtImg : {
			"blackorange" 							: "/wp-content/uploads/black-orange.jpg",
			"blackblack" 							: "/wp-content/uploads/black-black.jpg",
			"blackblue" 							: "/wp-content/uploads/black-blue.jpg",
			"blackcamo" 							: "/wp-content/uploads/black-camo.jpg",
			"blackgreen" 							: "/wp-content/uploads/black-green.jpg",
			"blackpink" 							: "/wp-content/uploads/black-pink.jpg",
			"blackpurple"							: "/wp-content/uploads/black-purple.jpg",
			"blackwhite"							: "/wp-content/uploads/black-white.jpg",
			"whiteblack"							: "/wp-content/uploads/white-black.jpg",
			"whiteblue"								: "/wp-content/uploads/white-blue.jpg",
			"whitecamo"								: "/wp-content/uploads/white-camo.jpg",
			"whitegreen"							: "/wp-content/uploads/white-green.jpg",
			"whiteorange"							: "/wp-content/uploads/white-orange.jpg",
			"whitepink"								: "/wp-content/uploads/white-pink.jpg",
			"whitepurple"							: "/wp-content/uploads/white-purple.jpg",
		},
		
		imgSet : {
			
		},
		
		init : function(){
			this.thisImg = document.getElementById( '_goo-imageThing-img' );
			this.thisBand = document.getElementsByName( 'attribute_band-color' );
			this.thisBead = document.getElementsByName( 'attribute_bead-color' );
			this.thisShirtColor = document.getElementsByName( 'attribute_shirt-color' );
			
			var img_preloader = document.createElement( 'img' );
			
			if( this.thisProduct === 17 || this.thisProduct === 20 ){
				this.imgSet = this.beadImg;
			}
			else if( this.thisProduct === 271 ){
				this.imgSet = this.shirtImg;
			}
			
			this.getImage();
			
			//console.log( this.thisBand.length + " " + this.thisBead );
		},
		
		clickFunc : function(){
			
			this.getImage();
	
		},
		
		getVals : function(){
			
			// console.log( this.thisShirtColor.length );
			var currentBand = false, currentBead = false, currentShirtColor = false;
			
			for( var i=0, n=this.thisBand.length; i<n; i++ ){
				if( this.thisBand[i].checked ){
					var currentBand = this.thisBand[i].value;
					break;
				}
			}
			for( var i=0, n=this.thisBead.length; i<n; i++ ){
				if( this.thisBead[i].checked ){
					var currentBead = this.thisBead[i].value;
					break;
				}
			}
			for( var i=0, n=this.thisShirtColor.length; i<n; i++ ){
				if( this.thisShirtColor[i].checked ){
					var currentShirtColor = this.thisShirtColor[i].value;
					break;
				}
			}
			
			console.log( currentBand + " " + currentBead + " " + currentShirtColor );
			
			return {
				'band' : currentBand,
				'bead' : currentBead,
				'shirtColor' : currentShirtColor
			}	
		},
		
		getImage : function(){
			
			var vals = this.getVals();
			
			if( vals.band && vals.bead ){
				var val = vals.band + "-" + vals.bead;
			}
			else if( vals.shirtColor ){
				var val = vals.shirtColor;
			}
			
			console.log( val );
			
			if( this.imgSet[val] ){
				var updateIMG = this.imgSet[val];
				// console.log( updateIMG );
			}
			
			if( updateIMG ){
				// console.log( _cjTransitionProp );
				var _processing = false;
				this.thisImg.style[_cjTransitionProp] = "opacity 0.2s ease-in-out";
				if( this._preloaded ){
					if( _processing === false ){
						this.thisImg.style.opacity = 0;
						this.thisImg.addEventListener( _cjTransitionEndProp, function(){
						
							candyShopInst.thisImg.src = updateIMG;
							// console.log( document.getElementById( '_goo-imageThing-img' ).src );
							//console.log( typeof shoeshiner );
							if( typeof shoeshiner !== 'undefined' ){
								clearInterval( shoeshiner );
							}
							shoeshiner = setInterval(function(){
								_processing = true;
								if( document.getElementById( '_goo-imageThing-img' ).src == "http://resonate.lsp.goozmo.com" + updateIMG ){
									candyShopInst.thisImg.style.opacity = 1;
									clearInterval( shoeshiner );
									// console.log( 'got' );
									_processing = false;
								}
							}, 200)
							// console.log( 'monkey' );
						}, false );
					}
				}
				else{
					this.thisImg.src = updateIMG;
					this._preloaded = true;
					// console.log( 'poop' );
				}
			}
			
		}
		
	}
	
	candyShopInst.init();
}
</script>

<div style="display:none !important">
	
<img src="/wp-content/uploads/2015/06/BlackOrange-450x350.png" alt=""/>
<img src="/wp-content/uploads/2015/06/blackblack-450x300.png" alt=""/>
<img src="/wp-content/uploads/2015/06/blackwhite-450x300.png" alt=""/>
<img src="/wp-content/uploads/2015/06/blackpink-450x300.png" alt=""/>
<img src="/wp-content/uploads/2015/06/blackgreen-450x300.png" alt=""/>
<img src="/wp-content/uploads/2015/06/Blackblue-450x300.png" alt=""/>

<img src="/wp-content/uploads/2015/06/whiteorange-450x300.png" alt=""/>
<img src="/wp-content/uploads/blackbracelet-450x350.png" alt=""/>
<img src="/wp-content/uploads/2015/06/whitewhite-450x344.png" alt=""/>
<img src="/wp-content/uploads/2015/06/whitepink-450x300.png" alt=""/>
<img src="/wp-content/uploads/2015/06/whitegreen-450x300.png" alt=""/>
<img src="/wp-content/uploads/2015/06/whiteblue-450x300.png" alt=""/>

<img src="/wp-content/uploads/2015/06/chainorange-450x300.png" alt=""/>
<img src="/wp-content/uploads/2015/06/chainblack-450x300.png" alt=""/>
<img src="/wp-content/uploads/2015/06/chainwhite-450x300.png" alt=""/>
<img src="/wp-content/uploads/2015/06/chainpink-450x330.png" alt=""/>
<img src="/wp-content/uploads/2015/06/chaingreen-450x300.png" alt=""/>
<img src="/wp-content/uploads/2015/06/chainblue-450x300.png" alt=""/>


<img src="/wp-content/uploads/black-orange.jpg" alt=""/>
<img src="/wp-content/uploads/black-black.jpg" alt=""/>
<img src="/wp-content/uploads/black-blue.jpg" alt=""/>
<img src="/wp-content/uploads/black-camo.jpg" alt=""/>
<img src="/wp-content/uploads/black-green.jpg" alt=""/>
<img src="/wp-content/uploads/black-pink.jpg" alt=""/>
<img src="/wp-content/uploads/black-purple.jpg" alt=""/>
<img src="/wp-content/uploads/black-white.jpg" alt=""/>
<img src="/wp-content/uploads/white-black.jpg" alt=""/>
<img src="/wp-content/uploads/white-blue.jpg" alt=""/>
<img src="/wp-content/uploads/white-camo.jpg" alt=""/>
<img src="/wp-content/uploads/white-green.jpg" alt=""/>
<img src="/wp-content/uploads/white-orange.jpg" alt=""/>
<img src="/wp-content/uploads/white-pink.jpg" alt=""/>
<img src="/wp-content/uploads/white-purple.jpg" alt=""/>


</div>
