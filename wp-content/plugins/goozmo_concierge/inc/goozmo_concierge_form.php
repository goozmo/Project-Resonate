<?php
//goozmo_concierge_form.php

class goozmo_concierge_form{
	
	public function __construct($request){
		$this->request=$request;
		if(isset($_POST['goozmo_concierge'])){
			$this->process_form();
		}
		else{
			$this->display_form();
		}
	}
	
	private function display_form(){
?>
<article class="content67">
	<div class="inner">
		<a href="http://www.goozmo.com" title="Goozmo.com"><img src="/wp-content/plugins/goozmo_concierge/img/logo.png" title="Goozmo inc." alt="Goozmo Logo"/></a>
		<p><b>Welcome to Goozmo Concierge!</b> Our team of gurus are ready to assist you with any questions you may have while working with your Wordpress website. We have a few ways you can get in touch with us.</p>
	</div><!--end: inner-->
	<div class="inner info">
		<section>
			<h3>Live Chat:</h3>
			<h4>Click the live chat button in the bottom right corner of your screen.</h4>
		</section>
		
		<section>
			<h3>Phone:</h3>
			<h4>1.800.519.7691</h4>
			<i>or</i>
			<h4>303.938.6821</h4>
		</section>
		
		<section>
			<h3>Email:</h3>
			<h4>support@goozmo.com</h4>
		</section>
		
		<h3>Or Write Us Here:</h3>
		<form name="goozmo_concierge_form" id="goozmo_concierge_form" action="/wp-admin/admin.php?page=goozmo_concierge" method="post">
			<input type="hidden" name="date" value="<?php echo date('Y-m-d H:i:s'); ?>"/>
			<input type="hidden" name="user_id" value="<?php echo $this->request->user_id; ?>"/>
			<input type="hidden" name="username" value="<?php echo $this->request->user_displayname; ?>"/>
			<input type="hidden" name="email" value="<?php echo $this->request->user_email; ?>"/>
			
			<input type="text" name="name" value="<?php $this->autofill('name'); ?>" onfocus="if(this.value=='name'){this.value='';}" onblur="if(this.value==''){this.value='name';}" required="true"/>
			<input type="text" name="email" value="<?php $this->autofill('user_email'); ?>" onfocus="if(this.value=='email'){this.value='';}" onblur="if(this.value==''){this.value='email';}" required="true"/>
			<input type="text" name="website" value="<?php if(isset($this->request->user_url)&&($this->request->user_url!='')){echo $this->request->user_url;} else{echo get_bloginfo();}  ?>" onfocus="if(this.value=='website'){this.value='';}" onblur="if(this.value==''){this.value='website';}" required="true"/>
			<label for="help_for">Need help with:</label><br/>
			<select name="help_for">
				<option value="editing website" <?php $this->autoselect('help_for','editing_website'); ?>>Editing website</option>
				<option value="email" <?php $this->autoselect('help_for','email'); ?>>Email</option>
				<option value="billing" <?php $this->autoselect('help_for','billing'); ?>>Billing</option>
				<option value="services" <?php $this->autoselect('help_for','services'); ?>>Services</option>
				<option value="other" <?php $this->autoselect('help_for','other'); ?>>Other</option>
			</select><br/>
			<label for="message">Message, questions or comments:</label>
			<textarea name="message" required="true"></textarea>
			<input type="submit" name="goozmo_concierge" value="submit"/>
		</form>
	</div><!--end: inner-->
	<div class="clear"></div>
</article><!--end: content67-->

<?php
	}
	
	private function process_form(){
		
		foreach($_POST as $key=>$value){
			if($key!='goozmo_concierge'){
				$this->$key=$_POST[$key];
			}
		}
		
		$request=new goozmo_messanger($this);
		
	}
	
	private function autofill($fieldname){
		if(isset($this->request->$fieldname)&&($this->request->$fieldname!='')){
			echo $this->request->$fieldname;
		}
		elseif(isset($_POST[$fieldname])&&($this->request->$fieldname!='')){
			echo $_POST[$fieldname];
		}
		else{
			echo $fieldname;
		}
	}
	
	private function autoselect($fieldname,$fieldvalue){
		if(isset($_POST[$fieldname])&&($_POST[$fieldname]==$fieldvalue)){
			echo "selected";
		}
	}
	
}

?>