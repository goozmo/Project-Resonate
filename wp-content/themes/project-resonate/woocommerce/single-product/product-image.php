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


<style>
._goo-images
{
	background-image: url( '/wp-content/themes/project-resonate/images/defaultImage.png' );
	background-position: center center;
	background-size: contain;
}

	._goo-images #_goo-imageThing
	{
		max-height: 300px;
		max-width: 100%;
		overflow: hidden;
	}
	
		._goo-images #_goo-imageThing img
		{
			height: 300px;
			width: 100%;
		}

</style>


