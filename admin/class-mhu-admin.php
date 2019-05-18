<?php

/**
 * The dashboard-specific functionality of the plugin.
 *
 * @link       http://www.edisonvae.com
 * @since      1.0.0
 *
 * @package    mhu
 * @subpackage mhu/admin
 */

/**
 * The dashboard-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package    mhu
 * @subpackage mhu/admin
 * @author     Tom Printy <tprinty@edisonave.com>
 */
class MHU_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @var      string    $plugin_name       The name of this plugin.
	 * @var      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the Dashboard.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/mhu-admin.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name .'boostrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css');
		wp_enqueue_style( $this->plugin_name .'bootstrap-theme', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css');
		wp_enqueue_style( $this->plugin_name .'datatables' , '//cdn.datatables.net/1.10.4/css/jquery.dataTables.css');
		
	}

	/**
	 * Register the JavaScript for the dashboard.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		 
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/mhu-admin.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name.'datatables', '//cdn.datatables.net/1.10.4/js/jquery.dataTables.min.js', array( 'jquery' ));

	}

	function mhu_admin_menu() {

  		// page title, menu title, permission, menu_slug, callback, image, position
  		add_menu_page("User List", "My Habit Upgrade", 'manage_options', 'mhu_list_users',  array( $this, 'mhu_list_users'), '', 1);
  		add_submenu_page("mhu_list_users", "List Users", "List Users", 'manage_options', "mhu_list_users", array( $this, "mhu_list_users"));
  		add_submenu_page("mhu_list_users", "List Techniques", "List Techniques", 'manage_options', "mhu_list_techniques", array( $this, "mhu_list_techniques"));
		add_submenu_page("mhu_list_users", "Add Technique", "Add Technique", 'manage_options', "mhu_add_techniques", array( $this, "mhu_add_techniques"));
		
		add_submenu_page("mhu_list_users", "List Reminders", "List Reminders", 'manage_options', "mhu_list_reminders", array( $this, "mhu_list_reminders"));
		add_submenu_page("mhu_list_users", "Add Reminders", "Add Reminders", 'manage_options', "mhu_add_reminders", array( $this, "mhu_add_reminders"));
		
		add_submenu_page("mhu_list_users", "List Generic Reminders", "List Generic Reminders", 'manage_options', "mhu_list_generic_reminders", array( $this, "mhu_list_generic_reminders"));
		add_submenu_page("mhu_list_users", "Add Generic Reminders", "Add  GenericReminders", 'manage_options', "mhu_add_generic_reminders", array( $this, "mhu_add_generic_reminders"));
		
		
		add_submenu_page("mhu_list_users", "Shared Journals", "Shared Journals", 'manage_options', "mhu_list_shared_journals", array( $this, "mhu_list_shared_journals"));
		
		//add_submenu_page("mhu_list_users", "New Techniques for Users", "New Techniques for Users", 'manage_options', "mhu_monthly_redo_techniques", array( $this, "mhu_monthly_redo_techniques"));
		add_submenu_page("mhu_list_users", "Extract Questionnaire", "Extract Qustionnaire", 'manage_options', "mhu_extract_questionnaire", array( $this, "mhu_extract_questionnaire"));
		add_submenu_page("mhu_list_users", "Send Reminders", "Send Reminders", 'manage_options', "mhu_send_daily_reminders", array( $this, "mhu_send_daily_reminders"));
		
		
		
		//Actions for the pages above
		$this->mhu_add_admin_page( 'mhu_edit_techniques' );
		$this->mhu_add_admin_page( 'mhu_update_techniques' );
		$this->mhu_add_admin_page( 'mhu_add_techniques' );
		$this->mhu_add_admin_page( 'mhu_process_add_techniques' );
		$this->mhu_add_admin_page( 'mhu_deactive_techniques');
		$this->mhu_add_admin_page( 'mhu_active_techniques');
		
		$this->mhu_add_admin_page( 'mhu_edit_user_techniques' );
		$this->mhu_add_admin_page( 'mhu_delete_user_techniques' );
		$this->mhu_add_admin_page( 'mhu_add_user_techniques' );
		
		
		$this->mhu_add_admin_page( 'mhu_edit_reminders' );
		$this->mhu_add_admin_page( 'mhu_add_reminders' );
		$this->mhu_add_admin_page( 'mhu_process_add_reminders' );
		$this->mhu_add_admin_page( 'mhu_update_reminders' );
		
		$this->mhu_add_admin_page( 'mhu_edit_generic_reminders');
		$this->mhu_add_admin_page( 'mhu_update_generic_reminders' );
		$this->mhu_add_admin_page( 'mhu_process_add_generic_reminders');
		$this->mhu_add_admin_page( 'mhu_delete_generic_reminders');
		
		
		//Front Side form processing
		$this->mhu_add_admin_page( 'mhu_process_questionnaire' );
		$this->mhu_add_admin_page( 'mhu_process_usersettings');
		
		//Action to trigger reminders for testing
		$this->mhu_add_admin_page( 'mhu_send_daily_reminders' );
		
		//Action to View a journal
		$this->mhu_add_admin_page( 'mhu_view_shared_journal' );
		
	}
	
	function mhu_list_users(){
		global $wpdb;
		
		$query_select = "SELECT sa.*, u.user_registered, u.user_email FROM `{$wpdb->prefix}mhu_survey_answer` as sa, `{$wpdb->prefix}users` as u where u.ID = sa.wp_user_id";
		
		
		$mhu_users 	  = $wpdb->get_results($query_select);
		
		
		require 'partials/mhu-admin-list-users.php';
	}

	function mhu_list_techniques($id){
		global $wpdb;
		
		
		$query_select = "SELECT * FROM `{$wpdb->prefix}mhu_techniques` ";
		$techniques = $wpdb->get_results($query_select);
		require 'partials/mhu-admin-list-techniques.php';
		
	}
	
	
	
	function mhu_edit_techniques(){
		global $wpdb;
		
		$id = intval($_GET['id']);
	    $technique = $wpdb->get_row($wpdb->prepare("SELECT * FROM `{$wpdb->prefix}mhu_techniques` WHERE `id` = %d", $id));

	  	require 'partials/mhu-edit-techniques.php';
			
			
	}
	
	/*
	 * Updates the referenced technique with any changes. 
	 * 
	 */
	function mhu_update_techniques() {
	  global $wpdb;
	
	  // our query string placeholder so that we can store bits of it
	  $qs = array();
	  $id = intval($_POST['id']);
	
	  // no deserialization, else our diff checks will fail
	  $past = $wpdb->get_row($wpdb->prepare("SELECT * FROM `{$wpdb->prefix}mhu_techniques` WHERE `id` = %d", $id), ARRAY_A);
	  $fields = array(
	    // by including the ID it is culled from the updates 
	    "id"    => strval($id),
	    "technique_type"   => trim($this->mhu_post('technique_type')),
	    "technique_level"  => trim($this->mhu_post('technique_level')),
	    "technique"        => trim($this->mhu_post('technique')),
	    "how"     		   => $this->mhu_post('how'),
	    'why'      		   => $this->mhu_post('why'),
	    
	  );

	  $updates = $this->mhu_array_diff($past, $fields);
	
	
	  // no quirky empty updates for mySQL
	  if(empty($updates) === false) {
	    $wpdb->update($wpdb->prefix . 'mhu_techniques', $updates, array('id' => $id), null, array("%d"));
	  }
	
	  wp_redirect($this->mhu_admin_link('mhu_edit_techniques', "id={$id}&{$qs}", false), 303);
	  exit;
	}
	
	
	function mhu_add_techniques(){
		global $wpdb;
		
	  	require 'partials/mhu-add-techniques.php';
			
			
	}
	
	
	function mhu_edit_user_techniques(){
		global $wpdb;
		
		$start_date = date('Y-m-01');
		$end_date = date('Y-m-t');
		
		$id = intval($_GET['id']);
		$user_id = $id;
		
		$techniques = $wpdb->get_results($wpdb->prepare("SELECT act.id as actid, act.*, tec.* FROM {$wpdb->prefix}mhu_active_techniques as act, {$wpdb->prefix}mhu_techniques as tec where user_id = $id and tec.id = act.technique_id and start_date >= '$start_date' and end_date <= '$end_date'"));
		
		$query_select = "SELECT * FROM `{$wpdb->prefix}mhu_techniques` ";
		$alltechniques = $wpdb->get_results($query_select);
		
		
	  	require 'partials/mhu-edit-user-techniques.php';
			
			
	}
	
	function mhu_delete_user_techniques(){
		global $wpdb;
		
		
		$id = intval($_GET['id']);
		$start_date = date('Y-m-01');
		$end_date = date('Y-m-t');
		
		$userid = intval($_GET['user_id']);
		
		$fields = array(
			"id" => $id,
		);
		
		//Delete existing teqniques for this user
		$wpdb->delete($wpdb->prefix . 'mhu_active_techniques', $fields );
		
		
		
		$techniques = $wpdb->get_results($wpdb->prepare("SELECT act.id as actid, act.*, tec.* FROM {$wpdb->prefix}mhu_active_techniques as act, {$wpdb->prefix}mhu_techniques as tec where user_id = $userid and tec.id = act.technique_id and start_date >= '$start_date' and end_date <= '$end_date'"));
		
		$query_select = "SELECT * FROM `{$wpdb->prefix}mhu_techniques` ";
		$alltechniques = $wpdb->get_results($query_select);
		
		
	  	require 'partials/mhu-edit-user-techniques.php';
			
			
	}
	
	function mhu_add_user_techniques(){
		global $wpdb;
		
		$id = intval($_POST['tecid']);
		$userid = intval($_POST['user_id']);
		$start_date = date('Y-m-01');
		$end_date = date('Y-m-t');
		
		
		
		$fields = array(
			"user_id" => $userid,
			"technique_id" => $id,
			"start_date" => $start_date,
			"end_date" => $end_date,
		);
		
		//Insert
		$wpdb->insert($wpdb->prefix . 'mhu_active_techniques', $fields) or
    	$wpdb->print_error();
		
		$techniques = $wpdb->get_results($wpdb->prepare("SELECT act.id as actid, act.*, tec.* FROM {$wpdb->prefix}mhu_active_techniques as act, {$wpdb->prefix}mhu_techniques as tec where user_id = $userid and tec.id = act.technique_id and start_date >= '$start_date' and end_date <= '$end_date'"));
		
		$query_select = "SELECT * FROM `{$wpdb->prefix}mhu_techniques` ";
		$alltechniques = $wpdb->get_results($query_select);
		
	  	require 'partials/mhu-edit-user-techniques.php';
			
			
	}
	
	
	function mhu_process_add_techniques(){
		global $wpdb;
		
		// building our new fields.
  		$fields = array(
	    "technique_type"   => trim($this->mhu_post('technique_type')),
	    "technique_level"  => trim($this->mhu_post('technique_level')),
	    "technique"        => trim($this->mhu_post('technique')),
	    "how"     		   => $this->mhu_post('how'),
	    'why'      		   => $this->mhu_post('why'),
	    'active'		   => 1
	  );
		
		$wpdb->insert($wpdb->prefix . 'mhu_techniques', $fields) or
    	$wpdb->print_error();
	  	wp_redirect($this->mhu_admin_link('mhu_edit_techniques', "id={$wpdb->insert_id}", false), 303);
	  	exit;
			
			
	}
	
	
	function mhu_deactive_techniques(){
		global $wpdb;
	
	  	// our query string placeholder so that we can store bits of it
	  	$qs = array();
	  	$id = intval($_GET['id']);
	
	  	// no deserialization, else our diff checks will fail
	  	$past = $wpdb->get_row($wpdb->prepare("SELECT * FROM `{$wpdb->prefix}mhu_techniques` WHERE `id` = %d", $id), ARRAY_A);
		
	  	$fields = array(
	    	// by including the ID it is culled from the updates 
	    	"id"    => strval($id),
	    	"active" => intval("0"),
	  	);

	  	$updates = $this->mhu_array_diff($past, $fields);
		// no quirky empty updates for mySQL
		if(empty($updates) === false) {
		    $wpdb->update($wpdb->prefix . 'mhu_techniques', $updates, array('id' => $id), null, array("%d"));
		}
		
		$query_select = "SELECT * FROM `{$wpdb->prefix}mhu_techniques` ";
		$techniques = $wpdb->get_results($query_select);
		require 'partials/mhu-admin-list-techniques.php';
		exit;
	
	}

	
	function mhu_active_techniques(){
		global $wpdb;
	
	  	// our query string placeholder so that we can store bits of it
	  	$qs = array();
	  	$id = intval($_GET['id']);
	
	  	// no deserialization, else our diff checks will fail
	  	$past = $wpdb->get_row($wpdb->prepare("SELECT * FROM `{$wpdb->prefix}mhu_techniques` WHERE `id` = %d", $id), ARRAY_A);
	  	$fields = array(
	    	// by including the ID it is culled from the updates 
	    	"id"    => strval($id),
	    	"active" => intval("1"),
	  	);

	  	$updates = $this->mhu_array_diff($past, $fields);
		// no quirky empty updates for mySQL
		if(empty($updates) === false) {
		    $wpdb->update($wpdb->prefix . 'mhu_techniques', $updates, array('id' => $id), null, array("%d"));
		}
		
		$query_select = "SELECT * FROM `{$wpdb->prefix}mhu_techniques` ";
		$techniques = $wpdb->get_results($query_select);
		require 'partials/mhu-admin-list-techniques.php';
		exit;
	
	}
	
	
	//Reminders
	function mhu_list_reminders($id){
		global $wpdb;
		$query_select = "SELECT t.technique, r.* FROM `{$wpdb->prefix}mhu_techniques` as t, `{$wpdb->prefix}mhu_reminders` as r where t.id = r.technique_id";
		$reminders = $wpdb->get_results($query_select);
		require 'partials/mhu-admin-list-reminders.php';
		
	}
	
	function mhu_edit_reminders(){
		global $wpdb;
		
		$id = intval($_GET['id']);
		
		$query_select = "SELECT * FROM `{$wpdb->prefix}mhu_techniques` ";
		$techniques = $wpdb->get_results($query_select);
		
	    $reminder = $wpdb->get_row($wpdb->prepare("SELECT * FROM `{$wpdb->prefix}mhu_reminders` WHERE `id` = %d", $id));

	  	require 'partials/mhu-edit-reminders.php';
			
			
	}
	
	function mhu_add_reminders(){
		global $wpdb;
		
		$query_select = "SELECT * FROM `{$wpdb->prefix}mhu_techniques` ";
		$techniques = $wpdb->get_results($query_select);
		
	  	require 'partials/mhu-add-reminder.php';
			
	}

	
	function mhu_process_add_reminders(){
		global $wpdb;
		
		// building our new fields.
  		$fields = array(
	    	"technique_id"   => trim($this->mhu_post('technique_id')),
	    	"message"  => trim($this->mhu_post('message')),
  		);
		
				
		
		$wpdb->insert($wpdb->prefix . 'mhu_reminders', $fields) or
    	$wpdb->print_error();
	  	wp_redirect($this->mhu_admin_link('mhu_edit_reminders', "id={$wpdb->insert_id}", false), 303);
	  	exit;
			
			
	}
	
	
	
	function mhu_update_reminders() {
		global $wpdb;
	
		// our query string placeholder so that we can store bits of it
		$qs = array();
		$id = intval($_POST['id']);
		
		// no deserialization, else our diff checks will fail
		$past = $wpdb->get_row($wpdb->prepare("SELECT * FROM `{$wpdb->prefix}mhu_reminders` WHERE `id` = %d", $id), ARRAY_A);
		$fields = array(
			// by including the ID it is culled from the updates 
		 	"id"    => strval($id),
		 	"technique_id"   => strval($this->mhu_post('technique_id')),
		    "message"  => trim($this->mhu_post('message'))
		  );
	
		$updates = $this->mhu_array_diff($past, $fields);
		
		
		// no quirky empty updates for mySQL
		if(empty($updates) === false) {
			$wpdb->update($wpdb->prefix . 'mhu_reminders', $updates, array('id' => $id), null, array("%d"));
		}
		
		wp_redirect($this->mhu_admin_link('mhu_edit_reminders', "id={$id}&{$qs}", false), 303);
		exit;
	}
	
	
	//Generic Reminders
	function mhu_list_generic_reminders($id){
		global $wpdb;
		$query_select = "SELECT * FROM `{$wpdb->prefix}mhu_default_reminders`";
		$reminders = $wpdb->get_results($query_select);
		require 'partials/mhu-admin-list-generic-reminders.php';
		
	}
	
	function mhu_edit_generic_reminders(){
		global $wpdb;
		
		$id = intval($_GET['id']);
		
	    $reminder = $wpdb->get_row($wpdb->prepare("SELECT * FROM `{$wpdb->prefix}mhu_default_reminders` WHERE `id` = %d", $id));

	  	require 'partials/mhu-edit-generic-reminders.php';
			
			
	}
	
	
	function mhu_add_generic_reminders(){
		global $wpdb;
		
	  	require 'partials/mhu-add-generic-reminder.php';
			
	}

	
	function mhu_process_add_generic_reminders(){
		global $wpdb;
		
		// building our new fields.
  		$fields = array(
	    	"reminder_text"  => trim($this->mhu_post('message')),
  		);
		
				
		
		$wpdb->insert($wpdb->prefix . 'mhu_default_reminders', $fields) or
    	$wpdb->print_error();
	  	wp_redirect($this->mhu_admin_link('mhu_edit_generic_reminders', "id={$wpdb->insert_id}", false), 303); 
	  	exit;
			
			
	}
	
	function mhu_update_generic_reminders() {
		global $wpdb;
	
		// our query string placeholder so that we can store bits of it
		$id = intval($_POST['id']);
		
		// no deserialization, else our diff checks will fail
		$past = $wpdb->get_row($wpdb->prepare("SELECT * FROM `{$wpdb->prefix}mhu_reminders` WHERE `id` = %d", $id), ARRAY_A);
		$fields = array(
			// by including the ID it is culled from the updates 
		 	"id"    => strval($id),
		    "reminder_text"  => trim($this->mhu_post('message'))
		  );
	
		$updates = $this->mhu_array_diff($past, $fields);
		
		
		// no quirky empty updates for mySQL
		if(empty($updates) === false) {
			$wpdb->update($wpdb->prefix . 'mhu_default_reminders', $updates, array('id' => $id), null, array("%d"));
		}
		
		wp_redirect($this->mhu_admin_link('mhu_edit_generic_reminders', "id={$id}", false), 303);
		exit;
	}
	
	
	
	function mhu_delete_generic_reminders(){
		global $wpdb;
				
		$id = intval($_GET['id']);	 
					
		$fields = array(
			"id" => $id
		);
		
		//Delete existing teqniques for this user
		$wpdb->delete($wpdb->prefix . 'mhu_default_reminders', $fields );	 	
			
		
		$query_select = "SELECT * FROM `{$wpdb->prefix}mhu_default_reminders`";
		$reminders = $wpdb->get_results($query_select);
		require 'partials/mhu-admin-list-generic-reminders.php';
	}
	
	
	
	
	
	function mhu_list_shared_journals(){
		global $wpdb;
		$query_select = "SELECT * FROM `{$wpdb->prefix}mhu_user_journal` as j, `{$wpdb->prefix}users` as u where j.share = 1 and j.user_id = u.id";   
		$shares = $wpdb->get_results($query_select);
		require 'partials/mhu-admin-list-shared-journals.php';
		
	}
	
	function mhu_view_shared_journal(){
		global $wpdb;
		$id = intval($_GET['id']);
		$query_select = "SELECT * FROM `{$wpdb->prefix}mhu_user_journal` where id = $id";
		$journal = $wpdb->get_results($query_select);
		
		require 'partials/mhu-admin-show-shared-journals.php';
	}
	
	
	
	function mhu_send_daily_reminders(){
		global $wpdb;
		date_default_timezone_set('America/Chicago');	
		$day = date("D");
		$month_start_date = date('Y-m-01');
		$month_end_date = date('Y-m-t');
		
		
		
		//Twillio stuff
		require('twilio-php/Services/Twilio.php');
		$sid = "AC9fb75f2af562049e2530d7f885f989ed"; // Your Account SID from www.twilio.com/user/account
		$token = "b8ec628e1b282bb6e3decaa04795c942"; // Your Auth Token from www.twilio.com/user/account
		$smsfrom = "17085504040";
		$client = new Services_Twilio($sid, $token);
		
		//Get list of all active users 
		$usersq = $wpdb->get_results("SELECT sa.* FROM `{$wpdb->prefix}mhu_survey_answer` as sa, `{$wpdb->prefix}users` as u where sa.wp_user_id = u.id");
		
		//print "<pre>";
		//print_r($usersq);
		//print "</pre>";
		
		foreach ($usersq as $user){
			$message = "";
			$user_id = $user->wp_user_id;
			
			//Get the techniques for this user
			$query_select = "SELECT * FROM `{$wpdb->prefix}mhu_active_techniques` as at, `{$wpdb->prefix}mhu_techniques` as t 
			                 where user_id = $user_id and start_date >= '$month_start_date' and end_date <= '$month_end_date' 
			                 and at.technique_id = t.id";
							 
			//print "Get Techniques Query: $query_select <br /><br />";				 
			$mhu_techniques = $wpdb->get_results($query_select);
		
		
			
			//Get a random reminder based on users active teqniues
			$rand_query = "SELECT * FROM `{$wpdb->prefix}mhu_active_techniques` as mhuat, `{$wpdb->prefix}mhu_reminders` as mhur
						   where  mhuat.technique_id = mhur.technique_id
						   and mhuat.user_id = $user_id
						   and start_date  >=  '$month_start_date'
						   and end_date  <= '$month_end_date'
                           order by RAND() limit 1";
						   
			//print "Random Reminder: $rand_query <br /><br />";			   
                           
			$rand_tech = $wpdb->get_row($rand_query);
	
			
			//Generic Reminder
			$generic_query = "SELECT * FROM `{$wpdb->prefix}default_reminders order by RAND() limit 1";
			//$gen = $wpdb->get_row($rand_query);
                        $gen = $wpdb->get_row($generic_query);
			
			
			//If Monday reminder about answers for question 15 if nothing specified use technique reminder
			if ($day == "Mon"){
				if (strlen($user->answer_15_1) > 1){
					$message = "Take a step towards \"". strtolower($user->answer_15_1) ."\" by practicing your MHU techniques today!";
				}else{
					$message = $rand_tech->message;
				}
			}
			
			//If Tuesday technique reminder
			if ($day == "Tue"){
				$message = $rand_tech->message;
			}
			
			//If Wed generic reminder
			if ($day == "Wed"){
				$message = $gen->message;
			}
			
			//If Thursday reminder about answers for question 15 if nothing specified use technique reminder
			if ($day == "Thu"){
				if (strlen($user->answer_15_2) > 1){
					
					$message = "Daily MHU improvement actions lead to feeling better and \"". strtolower($user->answer_15_2) ."\" You’re on your way.";
				}else{
					$message = $rand_tech->message;
					
				}
			}
			
			//If Friday technique reminder
			if ($day == "Fri"){
				$message = $rand_tech->message;
			}
			
			//Saturday Generic Reminder
			if ($day == "Sat"){
				$message = $gen->message;
			}
			
			//Sunday technique reminder
			if ($day == "Sun"){
				$message = $rand_tech->message;
			}
			
			
			
			//Fix up the message
			$message = str_replace("<First Name>", $user->first_name, $message, $count);
			//print "User id is: $user_id Message is: $message <br /><br />";
			
			
			//SMS/Text Message
			if (preg_match("/SMS/", $user->answer_14)){
					
				if (strlen($user->cell_number) > 1){	
					
					try{
					
					$message2 = $message ." Login: http://myhabitupgrade.com/dashboard";	
						
					$res = $client->account->messages->sendMessage(
							  $smsfrom, // From a valid Twilio number
							  $user->cell_number, // Text this number
							  $message2
							);

					} catch (Exception $e) {
    					echo 'Caught exception: ',  $e->getMessage(), "\n";
					}					
				}
			}
			
			
			//Email
			if (preg_match("/email/", $user->answer_14)){
				$user_select = "SELECT * FROM `{$wpdb->prefix}users` where ID = $user_id";
			    $wpuserrecord = $wpdb->get_row($user_select);
				
				$email_text = <<<EMAIL
Hi,

$message

Login: http://myhabitupgrade.com/dashboard

Enjoy yourself,

My Habit Upgrade Team
EMAIL;
				
				
				if (strlen($wpuserrecord->user_email) > 1)
					//print "Sending email to user ". $wpuserrecord->user_email . "<br />";
					wp_mail( $wpuserrecord->user_email, 'My Habit Upgrade Reminder', $email_text );
			}
			
			//Push
			if (preg_match("/Push/", $user->answer_14)){
				$url = 'https://api.parse.com/1/push';
				$appId = 'hGxy0MWBOFgYSyR9GsKphNRZlnelfDsjMcW1fePo';
                $restKey = 'r3Kblo1ODsrsGBwE02QmhoehSfqRYmXtTDDkqncs';
				$time = date("c",strtotime("now"));	
				//$message .= "Your Account: http://myhabitupgrade.com/dashboard/";
				$push_payload = json_encode(array(
                	"channel" => "MHU_".$user_id,
                    "data" => array("alert" => $message),
                    "push_time" => $time
                ));
				
				$rest = curl_init();
                curl_setopt($rest,CURLOPT_URL,$url);
                curl_setopt($rest,CURLOPT_PORT,443);
                curl_setopt($rest,CURLOPT_POST,1);
                curl_setopt($rest,CURLOPT_POSTFIELDS,$push_payload);
                curl_setopt($rest,CURLOPT_HTTPHEADER,
                            array("X-Parse-Application-Id: " . $appId,
                            "X-Parse-REST-API-Key: " . $restKey,
                            "Content-Type: application/json"));
				$response = curl_exec($rest);
			}
			
			
			//print "****************************NEXT USER****************************<br />";
		}
		print "<h1>Reminders Sent</h1>";
		
		
	}
	
	/**
	 *  Process the Member Questionaire
	 *
	 * @since    1.0.0
	 */
	public function mhu_process_questionnaire() {
		global $wpdb;
		$userid = trim($this->mhu_post('user_id'));
		
		$fields = array(
			"wp_user_id"	   => $userid,
		    "first_name"       => trim($this->mhu_post('firstname')),
		    "last_name"        => trim($this->mhu_post('lastname')),
		    "cell_number"      => trim($this->mhu_post('cellnumber')),
		   	"country"		   => trim($this->mhu_post('country')),
		    "postal_code"      => trim($this->mhu_post('zipcode')),
		    "birthday"         => trim($this->mhu_post('birthday')),
		    "answer_7"		   => trim($this->mhu_post('question7')),
  			"answer_8"		   => trim($this->mhu_post('question8')),
  			"answer_9"		   => trim($this->mhu_post('question9')),
  			"answer_10"		   => trim($this->mhu_post('question10')),
  			"answer_11"		   => trim($this->mhu_post('question11')),
  			"answer_12"		   => trim($this->mhu_post('question12')),
		);
		
		$answer_7_other   = trim($this->mhu_post('question7other'));
		if(strlen($answer_7_other) > 1){
			$fields["answer_7_other"] = $answer_7_other;
		}
		
		$answer_8_other   = trim($this->mhu_post('question8other'));
		if(strlen($answer_8_other) > 1){
			$fields["answer_8_other"] = $answer_8_other;
		}
	
		$answer_10_other   = trim($this->mhu_post('question10other'));
		if(strlen($answer_10_other) > 1){
			$fields["answer_10_other"] = $answer_10_other;
		}
	
		$answer_15_1 = trim($this->mhu_post('improve1'));
		if(strlen($answer_15_1) > 1){
			$fields["answer_15_1"] = $answer_15_1;
		}
		
		$answer_15_2 = trim($this->mhu_post('improve2'));
		if(strlen($answer_15_2) > 1){
			$fields["answer_15_2"] = $answer_15_2;
		}
		
		$answer_15_3 = trim($this->mhu_post('improve3'));
		if(strlen($answer_15_3) > 1){
			$fields["answer_15_3"] = $answer_15_3;
		}
		
		$answer_13_other   = trim($this->mhu_post('question13other'));
		if(strlen($answer_13_other) > 1){
			$fields["answer_13_other"] = $answer_13_other;
		}
		
		
		
		$answer13 = $_POST['question13'];
		$answer13 = json_encode($answer13);
		$fields["answer_13"] = $answer13;
		
		$answer14 = $_POST['question14'];
		$answer14 = json_encode($answer14);
		$fields["answer_14"] = $answer14;
		
		

		
		
		//We should see if we just need to update the user		
		$past = $wpdb->get_row($wpdb->prepare("SELECT * FROM `{$wpdb->prefix}mhu_survey_answer` WHERE `wp_user_id` = %d", $userid), ARRAY_A);
		if ($past['id']){
			$updates = $this->mhu_array_diff($past, $fields);
			if(empty($updates) === false) {
				$wpdb->update($wpdb->prefix . 'mhu_survey_answer', $updates, array('id' => $id), null, array("%d"));
			}
		}else{
									
			$wpdb->insert($wpdb->prefix . 'mhu_survey_answer', $fields) or
    		$wpdb->print_error();
		}
		
		//Setup techniques for this user
		$this->mhu_process_user($userid);
		
		//Redirect to the dashboard
		wp_redirect("/dashboard/", 303);
		
	}
	
	/**
	 *  Process the Member settings
	 *
	 * @since    1.0.0
	 */
	public function mhu_process_usersettings() {
		global $wpdb;
		$userid = trim($this->mhu_post('user_id'));
		
		//lets see if the passwords are the same
		$password = trim($this->mhu_post('password'));
		$passwordconfirm = trim($this->mhu_post('passwordconfirm'));
		if ($password != $passwordconfirm){
			 wp_redirect("/my-account/?mhu_error=Passwords%20did%20not%20match", 303);
		}else{	
			
			//Let see if we need to update the user wor in wordpress
			if (($password == $passwordconfirm) && (strlen($password)>1)){
				wp_set_password( $password, $userid );
			}
			
			$first_name = trim($this->mhu_post('firstname'));
			$last_name = trim($this->mhu_post('lastname'));
			$cell_number = trim($this->mhu_post('cell_number'));
			$country = trim($this->mhu_post('country'));
			$postal_code = trim($this->mhu_post('$postal_code'));
			$birthday = trim($this->mhu_post('birthday'));
			$email = trim($this->mhu_post('$email'));
			$answer14 = $_POST['question14'];
			$answer14 = json_encode($answer14);
			$answer_15_1 = trim($this->mhu_post('answer_15_1'));
			$answer_15_2 = trim($this->mhu_post('answer_15_2'));
			$answer_15_3 = trim($this->mhu_post('answer_15_3'));
			
			
			$fields = array(
			    // by including the ID it is culled from the updates 
			    "first_name" => $first_name,
			    "last_name" => $last_name,
			    "cell_number"	=> $cell_number,
			    "country" => $country,
			    "postal_code"	=> $postal_code,
			    "birthday" => $birthday,
			    "answer_14" => $answer14,
			    "answer_15_1" => $answer_15_1,
			    "answer_15_2" => $answer_15_2,
			    "answer_15_3" => $answer_15_3,
		  	);
		  
		  
		   $result = $wpdb->update($wpdb->prefix . 'mhu_survey_answer', $fields, array('wp_user_id' => $userid), null, array("%d"));
		   
		   
		   $email_fields = array(
			    // by including the ID it is culled from the updates 
			    "user_email" => trim($this->mhu_post('email'))
		  	);
		   $result = $wpdb->update($wpdb->prefix . 'users', $email_fields, array('ID' => $userid), null, array("%d"));
		   
			
		   wp_redirect("/my-account/", 303);
	
		}
		
		
		
	}
	
	
	
	function mhu_process_user($userid){
		global $wpdb;	
				
		$start_date = date('Y-m-01');
		$end_date = date('Y-m-t');
		
		$fields = array(
			"user_id" => $userid,
			"start_date" => $start_date,
			"end_date" => $end_date,
		);
		
		//Delete existing teqniques for this user
		$wpdb->delete($wpdb->prefix . 'mhu_active_techniques', $fields );
		
		
		$survey = $wpdb->get_row($wpdb->prepare("SELECT * FROM `{$wpdb->prefix}mhu_survey_answer` WHERE `wp_user_id` = %d", $userid), ARRAY_A);
		
		$technique_count = 0;
		
		//V Advanced
		if ($survey['answer_7'] == 'a' && $technique_count < 4){
			$technique = $wpdb->get_row($wpdb->prepare("SELECT * FROM `{$wpdb->prefix}mhu_techniques` WHERE  active = 1 and technique_type = \"V\" and technique_level = \"Advanced\" and id not in (select technique_id from wp_mhu_completed_techniques where user_id = $userid) ORDER BY RAND() limit 1"), ARRAY_A);
			$fields['technique_id'] = intval($technique['id']);
			$wpdb->insert($wpdb->prefix . 'mhu_active_techniques', $fields, array('%d', '%s', '%s', '%d'));
			$technique_count ++;
		}
		
		//V Medium
		if ($survey['answer_7'] == 'b' && $technique_count < 4){
			$technique = $wpdb->get_row($wpdb->prepare("SELECT * FROM `{$wpdb->prefix}mhu_techniques` WHERE  active = 1 and technique_type = \"V\" and technique_level = \"Medium\" and id not in (select technique_id from wp_mhu_completed_techniques where user_id = $userid) ORDER BY RAND() limit 1"), ARRAY_A);
			$fields['technique_id'] = intval($technique['id']);
			$wpdb->insert($wpdb->prefix . 'mhu_active_techniques', $fields, array('%d', '%s', '%s', '%d'));
			$technique_count ++;
		}
		
		//V Basic
		if ($survey['answer_7'] == 'c' && $technique_count < 4){
			$technique = $wpdb->get_row($wpdb->prepare("SELECT * FROM `{$wpdb->prefix}mhu_techniques` WHERE  active = 1 and technique_type = \"V\" and technique_level = \"Basic\" and id not in (select technique_id from wp_mhu_completed_techniques where user_id = $userid) ORDER BY RAND() limit 1"), ARRAY_A);
			$fields['technique_id'] = intval($technique['id']);
			$wpdb->insert($wpdb->prefix . 'mhu_active_techniques', $fields, array('%d', '%s', '%s', '%d'));
			$technique_count ++;
		}
		
		//P Fuel Body
		if ($survey['answer_10'] == 'a' && $technique_count < 4){
			$technique = $wpdb->get_row($wpdb->prepare("SELECT * FROM `{$wpdb->prefix}mhu_techniques` WHERE  active = 1 and technique_type = \"P\" and technique_level = \"Fuel Body\" and id not in (select technique_id from wp_mhu_completed_techniques where user_id = $userid) ORDER BY RAND() limit 1"), ARRAY_A);
			$fields['technique_id'] = intval($technique['id']);
			$wpdb->insert($wpdb->prefix . 'mhu_active_techniques', $fields, array('%d', '%s', '%s', '%d'));
			$technique_count ++;
		}
		
		//P Fuel Mind
		if ($survey['answer_10'] == 'b' && $technique_count < 4){
			$technique = $wpdb->get_row($wpdb->prepare("SELECT * FROM `{$wpdb->prefix}mhu_techniques` WHERE  active = 1 and technique_type = \"P\" and technique_level = \"Fuel Mind\" and id not in (select technique_id from wp_mhu_completed_techniques where user_id = $userid) ORDER BY RAND() limit 1"), ARRAY_A);
			$fields['technique_id'] = intval($technique['id']);
			$wpdb->insert($wpdb->prefix . 'mhu_active_techniques', $fields, array('%d', '%s', '%s', '%d'));
			$technique_count ++;
		}
		
		//P Focus
		if ($survey['answer_10'] == 'c' && $technique_count < 4){
			$technique = $wpdb->get_row($wpdb->prepare("SELECT * FROM `{$wpdb->prefix}mhu_techniques` WHERE  active = 1 and technique_type = \"P\" and technique_level = \"Focus\" and id not in (select technique_id from wp_mhu_completed_techniques where user_id = $userid) ORDER BY RAND() limit 1"), ARRAY_A);
			$fields['technique_id'] = intval($technique['id']);
			$wpdb->insert($wpdb->prefix . 'mhu_active_techniques', $fields, array('%d', '%s', '%s', '%d'));
			$technique_count ++;
		}
		
		//P Function
		if ($survey['answer_10'] == 'd' && $technique_count < 4){
			$technique = $wpdb->get_row($wpdb->prepare("SELECT * FROM `{$wpdb->prefix}mhu_techniques` WHERE  active = 1 and technique_type = \"P\" and technique_level = \"Function\" and id not in (select technique_id from wp_mhu_completed_techniques where user_id = $userid) ORDER BY RAND() limit 1"), ARRAY_A);
			$fields['technique_id'] = intval($technique['id']);
			$wpdb->insert($wpdb->prefix . 'mhu_active_techniques', $fields, array('%d', '%s', '%s', '%d'));
			$technique_count ++;
		}
		
		//I Advanced
		if ($survey['answer_10'] == 'a' && $technique_count < 4){
			$technique = $wpdb->get_row($wpdb->prepare("SELECT * FROM `{$wpdb->prefix}mhu_techniques` WHERE  active = 1 and technique_type = \"I\" and technique_level = \"Advanced\" and id not in (select technique_id from wp_mhu_completed_techniques where user_id = $userid) ORDER BY RAND() limit 1"), ARRAY_A);
			$fields['technique_id'] = intval($technique['id']);
			$wpdb->insert($wpdb->prefix . 'mhu_active_techniques', $fields, array('%d', '%s', '%s', '%d'));
			$technique_count ++;
		}
		
		//I Medium
		if ($survey['answer_10'] == 'b' && $technique_count < 4){
			$technique = $wpdb->get_row($wpdb->prepare("SELECT * FROM `{$wpdb->prefix}mhu_techniques` WHERE  active = 1 and technique_type = \"I\" and technique_level = \"Medium\" and id not in (select technique_id from wp_mhu_completed_techniques where user_id = $userid) ORDER BY RAND() limit 1"), ARRAY_A);
			$fields['technique_id'] = intval($technique['id']);
			$wpdb->insert($wpdb->prefix . 'mhu_active_techniques', $fields, array('%d', '%s', '%s', '%d'));
			$technique_count ++;
		}
		
		//I Basic
		if ($survey['answer_10'] == 'c' && $technique_count < 4){
			$technique = $wpdb->get_row($wpdb->prepare("SELECT * FROM `{$wpdb->prefix}mhu_techniques` WHERE  active = 1 and technique_type = \"I\" and technique_level = \"Basic\" and id not in (select technique_id from wp_mhu_completed_techniques where user_id = $userid) ORDER BY RAND() limit 1"), ARRAY_A);
			$fields['technique_id'] = intval($technique['id']);
			$wpdb->insert($wpdb->prefix . 'mhu_active_techniques', $fields, array('%d', '%s', '%s', '%d'));
			$technique_count ++;
		}
		
	}
	
	
	function mhu_monthly_redo_techniques(){
		global $wpdb;	
		
		
		
		
		
		//Get list of all active users 
		$usersq = $wpdb->get_results("SELECT * FROM `{$wpdb->prefix}mhu_survey_answer` ");
		
		foreach ($usersq as $user){
			$user_id = $user->wp_user_id;
			$this->mhu_process_user($user_id);
		}
		print "Techniques have been reset\n<br />";
		
	}
	
	function mhu_extract_questionnaire(){
		global $wpdb;	
		
		
		//build the header data
		$table_name = $wpdb->prefix . 'mhu_survey_answer';
		$header = "";
		foreach ( $wpdb->get_col( "DESC " . $table_name, 0 ) as $column_name ) {
			$header .=  $column_name . ", ";
		}
		print $header ." <br />";
		
		$usersq = $wpdb->get_results("SELECT * FROM `{$wpdb->prefix}mhu_survey_answer` ");
		
		foreach ($usersq as $user){
			print $user->id .", ".
			      $user->wp_user_id .", ".
			      $user->first_name .", ". 
			      $user->last_name .", ". 
			      $user->email .", ".
			      $user->cell_number .", ".
			      $user->country .", ".
			      $user->postal_code .", ".
			      $user->birthday .", ".
			      $user->answer_7 .", ".
			      $user->answer_7_other .", ".
			      $user->answer_8 .", ".
			      $user->answer_8_other .", ".
			      $user->answer_9 .", ".
			      $user->answer_9_other .", ".
			      $user->answer_10 .", ".
			      $user->answer_11 .", ".
			      $user->answer_12 .", ".	
			      $user->answer_13 .", ".
			      $user->answer_14 .", ".
			      $user->answer_15_1 .", ".
			      $user->answer_15_2 .", ".
			      $user->answer_15_3 .", ".
			      $user->answer_13_other .", <br />";
			      
		}
		
		
		die;  
	}
	
	
	
	//Helpers

	function mhu_admin_link($hook, $query_str=false, $echo=true) {
    $url = admin_url("admin.php?page=${hook}");
    
    if($query_str && !empty($query_str))
      $url .= '&' . (is_string($query_str) ? $query_str : http_build_query($query_str));
        
    if($echo)
      echo $url;
    else
      return $url;
  }

  function mhu_add_admin_page($hook) {
    global $_registered_pages;

    $hookname = get_plugin_page_hookname($hook, 'admin.php');

    if(!empty($hookname)) {
      add_action($hookname, array($this, $hook));
      $_registered_pages[$hookname] = true;
    }
  }
  
  /**
   * A safe alternative to accessing potentially unset $_POST variables.
   *
   * @param string $name 
   * @return mixed
   * @author Robert Kosek, Wood Street Inc.
   */
  function mhu_post($name) {
    // prevents a warning.
    if(array_key_exists($name, $_POST) === false) {
      return null;
    }
    return is_string($_POST[$name]) ? stripslashes($_POST[$name]) : $_POST[$name];
  }
  
  /**
   * Returns only the changed / altered fields, including blanks (unlike array_diff).
   *
   * @param array $old Old values
   * @param array $new New values
   * @return array
   * @author Wood Street
   */
  function mhu_array_diff(Array $old, Array $new) {
    $result = array();
    
    foreach($new as $key => $value) {
      if($old[$key] !== $value)
        $result[$key] = $value;
    }
    
    return $result;
  }
  
  
  
}
