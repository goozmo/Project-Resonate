		<?php
		global $avia_config;
		$blank = isset($avia_config['template']) ? $avia_config['template'] : "";

		//reset wordpress query in case we modified it
		wp_reset_query();


		//get footer display settings
		$the_id 				= avia_get_the_id(); //use avia get the id instead of default get id. prevents notice on 404 pages
		$footer 				= get_post_meta($the_id, 'footer', true);
		$footer_widget_setting 	= !empty($footer) ? $footer : avia_get_option('display_widgets_socket');


		//check if we should display a footer
		if(!$blank && $footer_widget_setting != 'nofooterarea' )
		{
			if( $footer_widget_setting != 'nofooterwidgets' )
			{
				//get columns
				$columns = avia_get_option('footer_columns');
		?>
				<div class='container_wrap footer_color' id='footer'>

					<div class='container'>

						<?php
						do_action('avia_before_footer_columns');

						//create the footer columns by iterating

						
				        switch($columns)
				        {
				        	case 1: $class = ''; break;
				        	case 2: $class = 'av_one_half'; break;
				        	case 3: $class = 'av_one_third'; break;
				        	case 4: $class = 'av_one_fourth'; break;
				        	case 5: $class = 'av_one_fifth'; break;
				        	case 6: $class = 'av_one_sixth'; break;
				        }
				        
				        $firstCol = "first el_before_{$class}";

						//display the footer widget that was defined at appearenace->widgets in the wordpress backend
						//if no widget is defined display a dummy widget, located at the bottom of includes/register-widget-area.php
						for ($i = 1; $i <= $columns; $i++)
						{
							$class2 = ""; // initialized to avoid php notices
							if($i != 1) $class2 = " el_after_{$class}  el_before_{$class}";
							echo "<div class='flex_column {$class} {$class2} {$firstCol}'>";
							if (function_exists('dynamic_sidebar') && dynamic_sidebar('Footer - column'.$i) ) : else : avia_dummy_widget($i); endif;
							echo "</div>";
							$firstCol = "";
						}

						do_action('avia_after_footer_columns');

						?>


					</div>


				<!-- ####### END FOOTER CONTAINER ####### -->
				</div>

	<?php   } //endif nofooterwidgets ?>



			

			<?php

			//copyright
			// $copyright = do_shortcode( avia_get_option('copyright', "&copy; ".__('Copyright','avia_framework')."  - <a href='".home_url('/')."'>".get_bloginfo('name')."</a>") );
			$copyright = "&copy; Copyright " . date( 'Y' ) . " " . get_bloginfo( 'name' ) . ". All rights reserved. ";

			// you can filter and remove the backlink with an add_filter function
			// from your themes (or child themes) functions.php file if you dont want to edit this file
			// you can also just keep that link. I really do appreciate it ;)
			// $kriesi_at_backlink = kriesi_backlink(get_option(THEMENAMECLEAN."_initial_version"));
			$kriesi_at_backlink = " Powered by <a href='http://goozmo.com'>Goozmo.</a> Printed on recycled data.";

			//you can also remove the kriesi.at backlink by adding [nolink] to your custom copyright field in the admin area
			if($copyright && strpos($copyright, '[nolink]') !== false)
			{
				$kriesi_at_backlink = "";
				$copyright = str_replace("[nolink]","",$copyright);
			}

			if( $footer_widget_setting != 'nosocket' )
			{

			?>

				<footer class='container_wrap socket_color' id='socket' <?php avia_markup_helper(array('context' => 'footer')); ?>>
                    <div class='container'>

                        <span class='copyright'><?php echo $copyright . $kriesi_at_backlink; ?></span>

                        <?php
                        	if(avia_get_option('footer_social', 'disabled') != "disabled")
                            {
                            	$social_args 	= array('outside'=>'ul', 'inside'=>'li', 'append' => '');
								echo avia_social_media_icons($social_args, false);
                            }
                        
                            echo "<nav class='sub_menu_socket' ".avia_markup_helper(array('context' => 'nav', 'echo' => false)).">";
                                $avia_theme_location = 'avia3';
                                $avia_menu_class = $avia_theme_location . '-menu';

                                $args = array(
                                    'theme_location'=>$avia_theme_location,
                                    'menu_id' =>$avia_menu_class,
                                    'container_class' =>$avia_menu_class,
                                    'fallback_cb' => '',
                                    'depth'=>1
                                );

                                wp_nav_menu($args);
                            echo "</nav>";
                        ?>

                    </div>

	            <!-- ####### END SOCKET CONTAINER ####### -->
				</footer>


			<?php
			} //end nosocket check


		
		
		} //end blank & nofooterarea check
		?>
		<!-- end main -->
		</div>
		
		<?php
		//display link to previeous and next portfolio entry
		echo avia_post_nav();

		echo "<!-- end wrap_all --></div>";


		if(isset($avia_config['fullscreen_image']))
		{ ?>
			<!--[if lte IE 8]>
			<style type="text/css">
			.bg_container {
			-ms-filter:"progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?php echo $avia_config['fullscreen_image']; ?>', sizingMethod='scale')";
			filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?php echo $avia_config['fullscreen_image']; ?>', sizingMethod='scale');
			}
			</style>
			<![endif]-->
		<?php
			echo "<div class='bg_container' style='background-image:url(".$avia_config['fullscreen_image'].");'></div>";
		}
	?>


<?php




	/* Always have wp_footer() just before the closing </body>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to reference JavaScript files.
	 */


	wp_footer();


?>
<a href='#top' title='<?php _e('Scroll to top','avia_framework'); ?>' id='scroll-top-link' <?php echo av_icon_string( 'scrolltop' ); ?>><span class="avia_hidden_link_text"><?php _e('Scroll to top','avia_framework'); ?></span></a>

<div id="fb-root"></div>


<?php

// global $woocommerce;
// echo "<pre>";
// print_r( $woocommerce );
// echo "</pre>";

	
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
		thisImg : "",
		thisBand : "",
		thisBead : "",
		theseImg : {
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
		
		init : function(){
			this.thisImg = document.getElementById( '_goo-imageThing-img' );
			this.thisBand = document.getElementsByName( 'attribute_band-color' );
			this.thisBead = document.getElementsByName( 'attribute_bead-color' );
			this.getImage();
			
			var img_preloader = document.createElement( 'img' );
			var mcgoober = this.theseImg;
			
			for( var i=0, n=this.theseImg.length; i<n; i++ ){
				console.log( i );
			}
			
		},
		
		clickFunc : function(){
			
			this.getImage();
	
		},
		
		getVals : function(){
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
			
			return {
				'band' : currentBand,
				'bead' : currentBead
			}	
		},
		
		getImage : function(){
			
			var vals = this.getVals();
			
			var val = vals.band + "-" + vals.bead;
			
			if( this.theseImg[val] ){
				var updateIMG = this.theseImg[val];
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
	
</div>

</body>
</html>
