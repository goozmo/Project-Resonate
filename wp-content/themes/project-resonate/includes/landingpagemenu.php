<?php

class _gooLandingPage{
	
	private $menu_items = array();
	
	public function __construct( $pageID ){
	
		$inst = get_children(array('post_parent'=>$pageID, 'post_type'=>'page','orderby' => 'menu_order','order' => 'ASC','post_status'=>'publish'));
		
		foreach($inst as $key=>$value){
			array_push($this->menu_items, $value);
		}
		
		$this->doMarkup();
		
	}
	
	private function doMarkup(){
		?>
		<div id="_goo-landing-container">
		<?php
		
		foreach($this->menu_items as $key=>$value){
			
			$post_title = isset( $value->post_title ) ? $value->post_title : $value['post_title'];
			
			$guid = isset( $value->guid ) ? $value->guid : $value['guid'];
			if(strstr($value->guid, 'localhost')){
				$guid = str_replace('localhost', "$_SERVER[HTTP_HOST]", $guid);
			}
			
			$post_excerpt = isset( $value->post_excerpt ) ? $value->post_excerpt : $value->post_content;
			$post_excerpt =  strip_tags($post_excerpt );
			if(  strlen( $post_excerpt ) > 150 ){
				$post_excerpt = substr( $post_excerpt, 0, 150 ) . "...";
			}
			
			$thumbnail = get_the_post_thumbnail( $value->ID ) ? get_the_post_thumbnail($value->ID, 'thumbnail') : NULL;
			?>
			
			<div class="landing-menu-inst">			
				<?php if( $thumbnail ){ ?>
				<figure class="menu-thumbnail">
					<a href="<?php echo $guid; ?>">
						<?php echo $thumbnail; ?>
					</a>
				</figure>
				<?php } ?>
				<div class="menu-content">
					<hgroup>
						<h3><a href="<?php echo $guid; ?>"><?php echo $post_title; ?></a></h3>
						<h4><a href="<?php echo $guid; ?>"><?php echo $post_excerpt; ?></a></h4>
					</hgroup>
				
					<a href="<?php echo $guid; ?>" class="button">Read More</a>
				</div>
				<div style="width: 100%; clear: both;"></div>
				
			</div>
								
			<?php		
		}
		
		?></div><?php
		
	}
	
}

?>