<?php
//goozmo_tools.php
include('goozmo_concierge_form.php');
include('goozmo_messanger.php');

class Goozmo_concierge{
	
	public function __construct(){
		$user_id = get_current_user_id();
		$user_data=get_userdata($user_id);
		
		$this->user_id=$user_data->data->ID;
		$this->user_login=$user_data->data->user_login;
		$this->user_displayname=$user_data->data->display_name;
		$this->user_email=$user_data->data->user_email;
		$this->user_url=$user_data->data->user_url;
		$this->user_role=$user_data->roles[0];
		$this->user_status=$user_data->user_status;

?>
<link rel="stylesheet" type="text/css" href="/wp-content/plugins/goozmo_concierge/css/goozmo.style.css"/>
<link href='http://fonts.googleapis.com/css?family=Alegreya+Sans:100,400,700|Alegreya:900' rel='stylesheet' type='text/css'>
<main class="content100" id="goozmo_concierge">
<?php
	
		$new_form=new goozmo_concierge_form($this);
?>
</main><!--end: content100 goozmo_concierge-->
<?php
	}
}
?>