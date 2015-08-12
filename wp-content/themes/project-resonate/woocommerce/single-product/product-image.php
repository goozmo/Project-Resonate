<?php
/**
 * Single Product Image
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.14
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $woocommerce, $product;

?>
<div class="_goo-images">
	
	<div id="_goo-imageThing">
		
		<img src="/wp-content/themes/project-resonate/images/defaultImage.png" alt="project resonate" id="_goo-imageThing-img" />
		<div id="_goo-imageThing-underlay"></div>
		
	</div>

</div>

<?php
	
if( get_the_ID() === 271 ){
	?>
	<br/><br/>
	<h5>Backside graphic</h5>
	<img src="/wp-content/uploads/tshirtback.jpg" alt="back of shirt" />
	<?php
}
	
?>