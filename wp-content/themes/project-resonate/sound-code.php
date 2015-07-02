<?php
/*
	*
	*	template name: sound code
	* 
	*
	*
*/
global $avia_config;

	/*
	 * get_header is a basic wordpress function, used to retrieve the header.php file in your theme directory.
	 */
	 get_header();


 	 if( get_post_meta(get_the_ID(), 'header', true) != 'no') echo avia_title();
	 ?>

		<div class='container_wrap container_wrap_first main_color <?php avia_layout_class( 'main' ); ?>'>

			<div class='container'>

				<main class='template-page content  <?php avia_layout_class( 'content' ); ?> units' <?php avia_markup_helper(array('context' => 'content','post_type'=>'page'));?>>

                    <?php
                    /* Run the loop to output the posts.
                    * If you want to overload this in a child theme then include a file
                    * called loop-page.php and that will be used instead.
                    */

                    $avia_config['size'] = avia_layout_class( 'main' , false) == 'entry_without_sidebar' ? '' : 'entry_with_sidebar';
                    get_template_part( 'includes/loop', 'page' );
                    ?>

				<!--end content-->
				
					<form name="pres-soundcode-form" id="pres-soundcode-form" class="pres-soundcode-forminst1" method="post">
						<input type="text" name="pres-soundcode" id="pres-soundcode" value="" />
						<input type="submit" name="pres-soundcode-submit" value="Hear It!" />
					</form>
					
					<?php
						
						if( isset( $_POST['pres-soundcode'] ) || isset( $_GET['pres-soundcode'] ) ){
							// print_r( $_POST['pres-soundcode'] );
							
							if( isset( $_POST['pres-soundcode'] ) ){
								$_sound_code_ = $_POST['pres-soundcode'];
							}
							elseif( isset( $_GET['pres-soundcode'] ) ){
								$_sound_code_ = $_GET['pres-soundcode'];
							}
							
							$_img_file_ = NULL;
							$_aud_file_ = NULL;
							
							echo $_sound_code_;
							
							if( file_exists( $_SERVER['DOCUMENT_ROOT'].'/wp-content/uploads/pres/' ) && is_dir( $_SERVER['DOCUMENT_ROOT'].'/wp-content/uploads/pres/' ) ){
								$dir_contents = scandir( $_SERVER['DOCUMENT_ROOT'].'/wp-content/uploads/pres/' );
								
								// echo count( $dir_contents );
								
								foreach( $dir_contents as $_file_ ){
									
									if( preg_match( "/^$_sound_code_.png/i", $_file_) ){
										// echo "bingo";
										$_img_file_ = $_file_;
									}
									
									if( preg_match( "/^$_sound_code_.(wav|mp4|mov|m4v)/i", $_file_ ) ){
										// echo "bongo";
										$_aud_file_ = $_file_;
									}
									
								}
								
								// echo "<pre>";
								// print_r( $dir_contents );
								// echo "</pre>";
								
							}
							?>
							
							<?php if( $_img_file_ ) :  ?>
							
							<div class="_goo-transoadit-photo">
								<img src="/wp-content/uploads/pres/<?php echo $_img_file_; ?>" />
							</div>
							<?php endif; ?>
							
							<br/>
							
							<?php if( $_aud_file_ ) :  ?>
							
							<audio controls class="_goo-transloadit-audio">
								<?php
									$_aud_type_ = 'wav';
									if( preg_match('/^.*\.(wav)$/i', $_aud_file_) ){
										$_aud_type_ = 'wav';
									}
									
								?>
								<source src="/wp-content/uploads/pres/<?php echo $_aud_file_; ?>" type="audio/<?php echo $_aud_type_; ?>" />
							</audio>
							<?php endif; ?>							
							
							<?php
								
							if( !$_aud_file_ && !$_img_file_ ){
							?>
							
							<h4>We could not find a file associated with that code. Double check your code and try again. If problems persist, please contact us for help at <a href="mailto:support@projectresonate.com">support@projectresonate.com</a></h4>
							
							<?php		
							}
						}
						
					?>
					
				</main>

				<?php

				//get the sidebar
				$avia_config['currently_viewing'] = 'page';
				get_sidebar();

				?>

			</div><!--end container-->

		</div><!-- close default .container_wrap element -->



<?php get_footer(); ?>