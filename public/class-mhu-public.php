<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://www.edisonave.com
 * @since      1.0.0
 *
 * @package    mhu
 * @subpackage mhu/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package    mhu
 * @subpackage mhu/public
 * @author     Tom Printy <tprinty@edisonave.com>
 */
class MHU_Public {

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
	 * @var      string    $plugin_name       The name of the plugin.
	 * @var      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/mhu-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/mhu-public.js', array( 'jquery' ), $this->version, false );

	}
	
	/**
	 *  Show the Questionaire
	 *
	 * @since    1.0.0
	 * 
	 * The processing of the form takes place in the admin side of the plugin
	 */
	public function mhu_show_usersettings() {
		global $wpdb;
		$user = wp_get_current_user();
		$userid = $user->ID;
			
		
		$survey_row = $wpdb->get_row($wpdb->prepare("SELECT * FROM `{$wpdb->prefix}mhu_survey_answer` WHERE `wp_user_id` = %d", $userid), ARRAY_A);
		$user_row = $wpdb->get_row($wpdb->prepare("SELECT * FROM `{$wpdb->prefix}users` WHERE `ID` = %d", $userid), ARRAY_A);
		$user_info = get_userdata($userid);
		
		require 'partials/mhu-public-display-usersettings.php';
	}
	
	
	

	/**
	 *  Show the Questionaire
	 *
	 * @since    1.0.0
	 * 
	 * The processing of the form takes place in the admin side of the plugin
	 */
	public function mhu_show_questionnaire() {
		global $wpdb;
		
		
		require 'partials/mhu-public-display-questionnaire.php';
	}
	
	
	/**
	 *  Show the Dashbaord
	 *
	 * @since    1.0.0
	 * 
	 * The processing of the forms takes place in the admin side of the plugin
	 */
	public function mhu_show_dashboard() {
		global $wpdb;
		date_default_timezone_set('America/Chicago');
		$start_date = date('Y-m-01');
		$end_date = date('Y-m-t');
		
		$user = wp_get_current_user();
		$userid = $user->ID;
		$query_select = "SELECT * FROM `{$wpdb->prefix}mhu_active_techniques` as at, `{$wpdb->prefix}mhu_techniques` as t where user_id = $userid and start_date >=  '$start_date' and end_date <= '$end_date' and at.technique_id = t.id";
		$mhu_techniques = $wpdb->get_results($query_select);
		
		
		require 'partials/mhu-public-display-dashboard.php';
	}
	
	
	/**
	 *  Retrieve the Dashbaord
	 *
	 * @since    1.0.0
	 * 
	 * The processing of the forms takes place in the admin side of the plugin
	 */
	public function mhu_get_dashboard( $atts ) {
		global $wpdb;
		date_default_timezone_set('America/Chicago');
	
		if ($atts['offset'] > 0){
			$date_offet = $atts['offset'];
			$start_date = date('Y-m-01', strtotime($date_offet." days ago"));
			$end_date = date('Y-m-t', strtotime($date_offet." days ago"));
			$starttime = date("Y-m-d 00:00:00", strtotime($date_offet." days ago"));
			$endtime = date("Y-m-d 23:59:59", strtotime($date_offet." days ago"));
		}else{	
			$start_date = date('Y-m-01');
			$end_date = date('Y-m-t');
			$starttime = date("Y-m-d 00:00:00");
			$endtime = date("Y-m-d 23:59:59");
		}
		
		$user = wp_get_current_user();
		$userid = $user->ID;
		$query_select = "SELECT at.id as aid, at.*, t.* FROM `{$wpdb->prefix}mhu_active_techniques` as at, `{$wpdb->prefix}mhu_techniques` as t where user_id = $userid and start_date >=  '$start_date' and end_date <= '$end_date' and at.technique_id = t.id";
		
		$mhu_techniques = $wpdb->get_results($query_select);
		
		
		//Now we have to figure out what the initial buttons are
		foreach ($mhu_techniques as &$tech){
				
			//print "SELECT count(*) as total FROM `{$wpdb->prefix}mhu_completed_techniques` WHERE `active_technique_id` = ".$tech->aid ." and user_id = $userid  and completed_date >= '$starttime' and completed_date <= '$endtime' ";
				
			$count = $wpdb->get_row("SELECT count(*) as total FROM `{$wpdb->prefix}mhu_completed_techniques` WHERE `active_technique_id` = ".$tech->aid ." and user_id = $userid  and completed_date >= '$starttime' and completed_date <= '$endtime' ");
			$count = $count->total;
			//print "Count is $count <br />";
			
			
			$badgecount = $wpdb->get_row("SELECT count(*) as total FROM `{$wpdb->prefix}mhu_completed_techniques` WHERE `active_technique_id` = ".$tech->technique_id ." and user_id = $userid  and completed_date >= '$start_date' and completed_date <= 'end_date' ");
			$badgecount = $badgecount->total;
			
			$dfd = ($count>=1);
			$tech->done_for_day = $dfd;
			
			$type = strtoupper(trim($tech->technique_type));
			
			$prefix = "";
			if ($type == "V"){
				$prefix = "feel";
			} else if ($type == "P"){
				$prefix = "function";
			} else if ($type == "I"){
				$prefix = "fulfill";
			}
			
			$suffixStart = "";
			$suffixClick = "";
			if ($badgecount < 3) {
				$suffixStart = ($dfd) ? "badgeon" : "badgeoff";
				$suffixClick = "badgeon";
			} else if ($badgecount == 3) {
				$suffixStart =  ($dfd) ? "badgeon" : "badgeoff";
				$suffixClick = 4;
			} else if ($badgecount >= 4 && $badgecount < 6){
				$suffixStart = ($dfd) ? 4 : "badgeoff";
				$suffixClick = 4;
			} else if ($badgecount == 6) {
				$suffixStart =  ($dfd) ? 4 : "badgeoff";
				$suffixClick = 7;
			}else if ($badgecount >= 7 && $badgecount < 13){
				$suffixStart = ($dfd) ? 7 : "badgeoff";
				$suffixClick = 7;
			}else if ($badgecount == 13){
				$suffixStart = ($dfd) ? 7 : "badgeoff";
				$suffixClick = 14;
			}else if ($badgecount >= 14 && $badgecount < 20){
				$suffixStart = ($dfd) ? 14 : "badgeoff";
				$suffixClick = 14;
			}else if ($badgecount == 20){
				$suffixStart = ($dfd) ? 14 : "badgeoff";
				$suffixClick = 21;
			}else if ($badgecount >= 20 && $badgecount < 29){
				$suffixStart = ($dfd) ? 21 : "badgeoff";
				$suffixClick = 21;
			} else if ($badgecount == 29) {
				$suffixStart = ($dfd) ? 21 : "badgeoff";
				$suffixClick = 30;
			} else if ($badgecount >= 30){
				$suffixStart = ($dfd) ? 30 : "badgeoff";
				$suffixClick = 30;
			}
			
			$tech->badge_start = $prefix.$suffixStart.".png";
			$tech->badge_click = $prefix.$suffixClick.".png";
					
		}

		$questions_1_array = array(
				"1" => "How do you feel after doing these techniques?",
				"2" => "How does doing these techniques make you feel?",
				"3" => "During and after doing these techniques, I feel:"
			);

		$questions_2_array = array(
				"1" => "Since I have been doing my techniques, here is what I am noticing:", 
				"2" => "In doing these techniques, here is what I am noticing:",
				"3" => "These are some things I am noticing since I have been doing my techniques:"
		 	);

		//Lets see if the user has already answered stuff for today
		$random = strval(mt_rand(1, 3));
		$answers_select = $wpdb->get_row("SELECT * FROM `{$wpdb->prefix}mhu_user_journal` WHERE user_id = $userid  and entry_date >= '$starttime' and entry_date <= '$endtime' ");
		$question1 = new stdClass;
		$question2 = new stdClass;
		$questions = array($question1, $question2);
		
		if (strlen($answers_select->question_1_text) > 1){
			$question1->text = $answers_select->question_1_text;
			$question1->answer = $answers_select->question_1_answer;
		}else{
			$question1->text = $questions_1_array[$random];
			$question1->answer = "";
		}
		if (strlen($answers_select->question_2_text) > 1){
			$question2->text = $answers_select->question_2_text;
			$question2->answer = $answers_select->question_2_answer;
		}else{
			$question2->text = $questions_2_array[$random];
			$question2->answer = "";
		}
		
		
		//Get the last entry date for the user
		$lastentry_select = $wpdb->get_row("SELECT * FROM `{$wpdb->prefix}mhu_user_journal` WHERE user_id = $userid order by id desc limit 1 ");
		
		if (strlen($lastentry_select->entry_date) >1){
			//$last_date = $lastentry_select->entry_date;
			$date = new DateTime($lastentry_select->entry_date, new DateTimeZone('America/Chicago'));
			$date->setTimezone(new DateTimeZone('UTC'));
			$last_date = $date->format('Y-m-d H:i:s');
			
		}else{
			$last_date = "Never";	
		}	
		
		
		//Custom Technique
		$custom_select = "SELECT * FROM `{$wpdb->prefix}mhu_user_technique`  where user_id = $userid and end_date is NULL";
		$custom_techniques = $wpdb->get_results($custom_select );
		
		$cust_id = $custom_techniques[0]->id;
		
		$custom_badgecount = $wpdb->get_row("SELECT count(*) as total FROM `{$wpdb->prefix}mhu_completed_custom_techniques` WHERE `custom_technique_id` = ".$cust_id ." and user_id = $userid  and completed_date >= '$start_date' and completed_date <= 'end_date' ");
		$custom_badgecount = $custom_badgecount->total;
		
		$dfd = ($custom_badgecount>=1);
	
		
		
		$prefix = "custom";
		$suffixStart = "";
		$suffixClick = "";
		if ($badgecount < 3) {
			$suffixStart = ($dfd) ? "badgeon" : "badgeoff";
			$suffixClick = "badgeon";
		} else if ($badgecount == 3) {
			$suffixStart =  ($dfd) ? "badgeon" : "badgeoff";
			$suffixClick = 4;
		} else if ($badgecount >= 4 && $badgecount < 6){
			$suffixStart = ($dfd) ? 4 : "badgeoff";
			$suffixClick = 4;
		} else if ($badgecount == 6) {
			$suffixStart =  ($dfd) ? 4 : "badgeoff";
			$suffixClick = 7;
		}else if ($badgecount >= 7 && $badgecount < 13){
			$suffixStart = ($dfd) ? 7 : "badgeoff";
			$suffixClick = 7;
		}else if ($badgecount == 13){
			$suffixStart = ($dfd) ? 7 : "badgeoff";
			$suffixClick = 14;
		}else if ($badgecount >= 14 && $badgecount < 20){
			$suffixStart = ($dfd) ? 14 : "badgeoff";
			$suffixClick = 14;
		}else if ($badgecount == 20){
			$suffixStart = ($dfd) ? 14 : "badgeoff";
			$suffixClick = 21;
		}else if ($badgecount >= 20 && $badgecount < 29){
			$suffixStart = ($dfd) ? 21 : "badgeoff";
			$suffixClick = 21;
		} else if ($badgecount == 29) {
			$suffixStart = ($dfd) ? 21 : "badgeoff";
			$suffixClick = 30;
		} else if ($badgecount >= 30){
			$suffixStart = ($dfd) ? 30 : "badgeoff";
			$suffixClick = 30;
		}
		
		$custom_technique = new stdClass;
		$custom_technique->id = "custom_".$cust_id;
		$custom_technique->name = $custom_techniques[0]->name;
		$custom_technique->description = $custom_techniques[0]->description;
		$custom_technique->badge_start = $prefix.$suffixStart.".png";
		$custom_technique->badge_click = $prefix.$suffixClick.".png";
		$custom_technique->done_for_day = $dfd;
		$custom_technique->user_id = $userid;
		
		$return = new stdClass;
		$return->questions = $questions;
		$return->techniques = $mhu_techniques;
		$return->intialbadges = $initialbadges;
		$return->lastentry = $last_date;
		$return->share = $answers_select->share;
		$return->custom = $custom_technique;
		
		return json_encode($return);
	}
	
	
	/**
	 *  Retrieve the Dashbaord
	 *
	 * @since    1.0.0
	 * 
	 * The processing of the forms takes place in the admin side of the plugin
	 */
	public function mhu_get_archive( $atts ) {
		global $wpdb;
		date_default_timezone_set('America/Chicago');
		$start_date = date('Y-m-01');
		$end_date = date('Y-m-t');
		$starttime = date("Y-m-d 00:00:00");
		$endtime = date("Y-m-d 23:59:59");
		
		
		$user = wp_get_current_user();
		$userid = $user->ID;
		
		$query_select = "SELECT t.id as id, ct.user_id , ct.technique_id, count(ct.technique_id), YEAR(ct.completed_date) as year, MONTH(ct.completed_date) as month, t.technique_type, t.technique_level, t.technique FROM myhabitupgrade.wp_mhu_completed_techniques as ct, myhabitupgrade.wp_mhu_techniques as t where user_id = $userid and ct.technique_id = t.id GROUP BY user_id, technique_id, YEAR(completed_date), MONTH(completed_date) ORDER BY YEAR(completed_date) desc, MONTH(completed_date) desc";
		
		$mhu_techniques = $wpdb->get_results($query_select);
		
		foreach ($mhu_techniques as &$tech){
			$type = strtoupper(trim($tech->technique_type));
			
			$prefix = "";
			if ($type == "V"){
				$prefix = "feel";
			} else if ($type == "P"){
				$prefix = "function";
			} else if ($type == "I"){
				$prefix = "fulfill";
			}	
			
			$suffix = "";
			if ($badgecount < 3) {
				$suffix = "badgeon";
			} else if ($badgecount == 3) {
				$suffix = 4;
			} else if ($badgecount >= 4 && $badgecount < 6){
				$suffix = 4;
			} else if ($badgecount == 6) {
				$suffix = 7;
			}else if ($badgecount >= 7 && $badgecount < 13){
				$suffix = 7;
			}else if ($badgecount == 13){
				$suffix = 14;
			}else if ($badgecount >= 14 && $badgecount < 20){
				$suffix = 14;
			}else if ($badgecount == 20){
				$suffix = 21;
			}else if ($badgecount >= 20 && $badgecount < 29){
				$suffix = 21;
			} else if ($badgecount == 29) {
				$suffix = 30;
			} else if ($badgecount >= 30){
				$suffix = 30;
			}			
			$tech->badge = $prefix.$suffix.".png";
			
		}
		
		$query_select = "SELECT at.id as aid, at.*, t.* FROM `{$wpdb->prefix}mhu_active_techniques` as at, `{$wpdb->prefix}mhu_techniques` as t where user_id = $userid and start_date >=  '$start_date' and end_date <= '$end_date' and at.technique_id = t.id";
		$mhu_active_techniques = $wpdb->get_results($query_select);
		
		$active_technique_ids = array();
		foreach ($mhu_active_techniques as $t){
			$active_technique_ids[] = $t->technique_id;
		}
		
		//old journals
		$journal_select = "SELECT * FROM `{$wpdb->prefix}mhu_user_journal` where user_id = $userid order by entry_date desc";
		$journals = $wpdb->get_results($journal_select);
		
		//Custom techniques
		$custom_select = "SELECT * FROM `{$wpdb->prefix}mhu_user_technique` where user_id = $userid and end_date is NULL";
		//print $custom_select;
		$custom = $wpdb->get_results($custom_select);
		
		$return = new stdClass;
		$return->techniques = $mhu_techniques;
		$return->active_techniques = $mhu_active_techniques;
		$return->active_technique_ids = $active_technique_ids;
		$return->journals = $journals;
		$return->custom = $custom[0];
		
		return json_encode($return);
		
	}
	
	
	
	public function ajax_record_technique_complete()
	{
		global $wpdb;
		
		$dateoffset = $_GET['dateOffset'];
		
		date_default_timezone_set('America/Chicago');
		
		if (($dateoffset < 0)&&($dateoffset > -3)){
			
			$starttime = date("Y-m-d 00:00:00");
			$starttime = date('Y-m-d 00:00:00', strtotime($dateoffset ." days", strtotime($starttime)));
			
			$endtime = date("Y-m-d 23:59:59");
			$endtime = date('Y-m-d 00:00:00', strtotime($dateoffset ." days", strtotime($endtime)));
			
			$completedDate = date('Y-m-d H:i:s', strtotime($dateoffset ." days", time()));
			
			$month_start_date = date('Y-m-01 00:00:00');
			$month_end_date = date('Y-m-t 23:59:59');
		}else{
			$starttime = date("Y-m-d 00:00:00");
			$endtime = date("Y-m-d 23:59:59");
			$month_start_date = date('Y-m-01 00:00:00');
			$month_end_date = date('Y-m-t 23:59:59');
			$completedDate = date('Y-m-d H:i:s');
		}
		
		//We need the user ID and the Technique ID
		$userID = $_GET['userid'];
		$techniqueID = $_GET['techniqueID'];
		$activeTechniqueID = $_GET['activetechniqueID'];
		
		
		if ( preg_match("/custom_/", $techniqueID)){
				$techniqueID = str_replace("custom_", "", $techniqueID);
				$past = $wpdb->get_row("SELECT * FROM `{$wpdb->prefix}mhu_completed_custom_techniques` WHERE `custom_technique_id` = $activeTechniqueID and user_id = $userID  and completed_date >= '$starttime' and completed_date <= '$endtime' ");
			
				if (!$past){
				
					$fields = array(
						"user_id" => $userID,
						"custom_technique_id" => $techniqueID,
						"completed_date" => $completedDate
					);
					$wpdb->insert($wpdb->prefix . 'mhu_completed_custom_techniques', $fields, array('%d', '%d', '%s', '%d'));	
				}
				
				//Get the numnber of times the user has completed this technique this month
				$count = $wpdb->get_row("SELECT count(*) as total FROM `{$wpdb->prefix}mhu_completed_custom_techniques` WHERE `custom_technique_id` = $activeTechniqueID and user_id = $userID  and completed_date >= '$month_start_date' and completed_date <= '$month_end_date' ");
				$count = $count->total;
				
				$prefix = "custom";
				$suffix = "badgeon";
				if ($count >= 4){
					$suffix = '4';
				}else if ($count >= 7){
					$suffix = '7';
				}else if ($count >= 14){
					$suffix = '14';
				}else if ($count == 21){
					$suffix = '21';
				}else if ($count >= 30){
					$suffix = '30';
				}
				
				$result["badge"] = $prefix.$suffix.".png";
				header('Content-Type: application/json'); 
				print json_encode($result);
				die;
			
		}else{
		
			//First lets see if they have already recorded this complete for the day
			$past = $wpdb->get_row("SELECT * FROM `{$wpdb->prefix}mhu_completed_techniques` WHERE `active_technique_id` = $activeTechniqueID and user_id = $userID  and completed_date >= '$starttime' and completed_date <= '$endtime' ");
			
			if (!$past){
				
				$fields = array(
					"user_id" => $userID,
					"technique_id" => $techniqueID,
					"completed_date" => $completedDate,
					"active_technique_id" => $activeTechniqueID,
				);
				$wpdb->insert($wpdb->prefix . 'mhu_completed_techniques', $fields, array('%d', '%d', '%s', '%d'));	
			}
			
			//Get the numnber of times the user has completed this technique this month
			$count = $wpdb->get_row("SELECT count(*) as total FROM `{$wpdb->prefix}mhu_completed_techniques` WHERE `active_technique_id` = $activeTechniqueID and user_id = $userID  and completed_date >= '$month_start_date' and completed_date <= '$month_end_date' ");
			$count = $count->total;
			
			//Now we need to figure out what to retun for this 
		    //Get technique based on ID
		    $technique = $wpdb->get_row("SELECT * FROM `{$wpdb->prefix}mhu_techniques` WHERE `id` = $techniqueID");
			
			$result = array();
			
			$type = strtoupper(trim($technique->technique_type));
			
			$prefix = "";
			if ($type == "V"){
				$prefix = "feel";
			} else if ($type == "P"){
				$prefix = "function";
			} else if ($type == "I"){
				$prefix = "fulfill";
			}
			
			$suffix = "badgeon";
			if ($count >= 4){
				$suffix = '4';
			}else if ($count >= 7){
				$suffix = '7';
			}else if ($count >= 14){
				$suffix = '14';
			}else if ($count == 21){
				$suffix = '21';
			}else if ($count >= 30){
				$suffix = '30';
			}
			
			$result["badge"] = $prefix.$suffix.".png";
			header('Content-Type: application/json'); 
			print json_encode($result);
			die;
		}
	}
	function ajax_record_journal_entry(){
		global $wpdb;		
		date_default_timezone_set('America/Chicago');	
		$starttime = date("Y-m-d 00:00:00");
		$endtime = date("Y-m-d 23:59:59");	
		
		$date = new DateTime(date("Y-m-d H:i:s"), new DateTimeZone('America/Chicago'));
		$date->setTimezone(new DateTimeZone('UTC'));
		$now = $date->format('Y-m-d H:i:s');
		
		//First we need to see if we are updating entry or making a new one
		$userID = $_POST['userid'];
		$questions = wp_unslash($_POST['questions']);
		$share = $_POST['share'];
		
		if ($share == 'true'){
			$share = 1;
		}else{
			$share = 0;
		}
		
		$answers_select = $wpdb->get_row("SELECT * FROM `{$wpdb->prefix}mhu_user_journal` WHERE user_id = $userID  and entry_date >= '$starttime' and entry_date <= '$endtime' ");

		if($answers_select->id){
			//update
			$fields = array(
		    // by including the ID it is culled from the updates 
		    "user_id" => $userID,
		    "entry_date" => $now,
		    "question_1_text"	=> $answers_select->question_1_text,
		    "question_1_answer" => trim($questions[0]["answer"]),
		    "question_2_text"	=> $answers_select->question_2_text,
		    "question_2_answer" => trim($questions[1]["answer"]),
		    "share" => $share
		  );
	      $result = $wpdb->update(
		      	$wpdb->prefix . 'mhu_user_journal',
		      	$fields,
		      	array("id" => $answers_select->id),
		      	array('%d', '%s', '%s', '%s', '%s', '%s')
			);
		}else{
			//insert
			$fields = array(
		    "entry_date" => $now,
		    "user_id" => $userID,
		    "question_1_text"   => trim($questions[0]["question"]),
		    "question_1_answer" => trim($questions[0]["answer"]),
		    "question_2_text" 	=> trim($questions[1]["question"]),
		    "question_2_answer" => trim($questions[1]["answer"]),
		    "share" => $share
		  );
			$result = $wpdb->insert($wpdb->prefix . 'mhu_user_journal', $fields);
		}
		
		header('Content-Type: application/json'); 
		print json_encode(array(
			"questions" => $questions,
			"updated" => $now,
			"result" => $result
		));	
		die; //we need this so WP dosen't return 0
	}

	public function ajax_custom_technique() 
	{
		global $wpdb;
		$start_date = date('Y-m-d');
		$today = date('Y-m-d');
		
		//We need the user ID a
		$userID = $_GET['userid'];
		$name = $_GET['name'];
		$description = $_GET['description'];
		
		
		
		//find the old custom one and mark it inactive
		$old_custom = $wpdb->get_row("SELECT * FROM `{$wpdb->prefix}mhu_user_technique` WHERE user_id = $userID  and end_date is NULL ");

		if($old_custom->id){
			//update
			$fields = array(
		    // by including the ID it is culled from the updates 
		    	"end_date" => $today
		  	); 
	      $result = $wpdb->update(
		      	$wpdb->prefix . 'mhu_user_technique',
		      	$fields,
		      	array("id" => $old_custom->id),
		      	array('%s')
			);
		}
		//insert the new one
		$fields = array(
				"user_id" => $userID,
				"name" => $name,
				"description" => $description,
				"start_date" => $today,
			);
		$wpdb->insert($wpdb->prefix . 'mhu_user_technique', $fields, array('%d', '%s', '%s', '%s'));	
		
		
		
		header('Content-Type: application/json'); 
		print json_encode("ok");
		die;
	}

	public function ajax_reactivate_technique()
	{
		global $wpdb;
		date_default_timezone_set('America/Chicago');
		$starttime = date("Y-m-d 00:00:00");
		$endtime = date("Y-m-d 23:59:59");
		$month_start_date = date('Y-m-01');
		$month_end_date = date('Y-m-t');
		
		
		//We need the user ID and the Technique ID
		$userID = $_GET['userid'];
		$techniqueID = $_GET['techniqueID'];
		
		//First lets see if they have already have this technique this month		
		$count = $wpdb->get_row("SELECT count(*) as total FROM `{$wpdb->prefix}mhu_active_techniques` WHERE  `user_id` = $userID and technique_id = $techniqueID and start_date = '$month_start_date' and end_date = '$month_end_date' ");
		$count = $count->total;
		
		if ($count < 1){
			$fields = array(
				"user_id" => $userID,
				"technique_id" => $techniqueID,
				"start_date" => $month_start_date,
				"end_date" => $month_end_date,
			);
			$wpdb->insert($wpdb->prefix . 'mhu_active_techniques', $fields, array('%d', '%d', '%s', '%s'));	
		}
		
		
		
		header('Content-Type: application/json'); 
		print json_encode("ok");
		die;
	}

	public function ajax_deactivate_technique()
	{
		global $wpdb;
		date_default_timezone_set('America/Chicago');
		$starttime = date("Y-m-d 00:00:00");
		$endtime = date("Y-m-d 23:59:59");
		$month_start_date = date('Y-m-01');
		$month_end_date = date('Y-m-t');
		
		
		//We need the user ID and the Technique ID
		$userID = $_GET['userid'];
		$techniqueID = $_GET['techniqueID'];
		
		//First lets see if they have already have this technique this month		
		$count = $wpdb->get_row("SELECT count(*) as total FROM `{$wpdb->prefix}mhu_active_techniques` WHERE  `user_id` = $userID and technique_id = $techniqueID and start_date = '$month_start_date' and end_date = '$month_end_date' ");
		$count = $count->total;
		
		if ($count >= 1){
			$fields = array(
				"user_id" => $userID,
				"technique_id" => $techniqueID,
				"start_date" => $month_start_date,
				"end_date" => $month_end_date,
			);
			$wpdb->delete($wpdb->prefix . 'mhu_active_techniques', $fields, array('%d', '%d', '%s', '%s'));	
		}
		
		
		
		header('Content-Type: application/json'); 
		print json_encode("ok");
		die;
	}

	
	/*
	 * helper function
	 */
	function mhu_admin_link($hook, $query_str=false, $echo=true) {
	    $url = admin_url("admin.php?page=${hook}");
	    
	    if($query_str && !empty($query_str))
	      $url .= '&' . (is_string($query_str) ? $query_str : http_build_query($query_str));
	        
	    if($echo)
	      echo $url;
	    else
	      return $url;
  	}

	function ajax_app_login(){
		global $wpdb;	
	
		$username = $_GET['username'];
		$password =  $_GET['password'];
		
		$user = get_user_by( 'login', $username );
		
		if ( $user && wp_check_password( $password, $user->data->user_pass, $user->ID) ){
			header('Content-Type: application/json'); 	
			print json_encode(array(
			'result' => 'SUCCESS',
			"user_id" => $user->ID,
			"user_name" => $user->user_login,
			"user_nicename" => $user->user_nicename
		));	
		
			
		}else{
			header('Content-Type: application/json'); 
			print json_encode(array(
			'result' => 'FAILED',
			"user_id" => '',
			"user_name" => '',
			"user_nicename" => ''
		));	
		}
		die;
	}
	
	function ajax_app_get_todays_techniques(){
		global $wpdb;	
		date_default_timezone_set('America/Chicago');
		$userid= $_GET['userid'];
		
		$start_date = date('Y-m-01');
		$end_date = date('Y-m-t');
		$starttime = date("Y-m-d 00:00:00");
		$endtime = date("Y-m-d 23:59:59");
		
		
		$query_select = "SELECT at.id as activetechniqueID, at.*, t.*  FROM `{$wpdb->prefix}mhu_active_techniques` as at, `{$wpdb->prefix}mhu_techniques` as t where user_id = $userid and start_date >= '$start_date' and end_date <= '$end_date' and at.technique_id = t.id";
		$mhu_techniques = $wpdb->get_results($query_select);
		
		
		//Now we have to figure out what the initial buttons are
		foreach ($mhu_techniques as &$tech){
				
			$count = $wpdb->get_row("SELECT count(*) as total FROM `{$wpdb->prefix}mhu_completed_techniques` WHERE `active_technique_id` = ".$tech->activetechniqueID ." and user_id = $userid  and completed_date >= '$starttime' and completed_date <= '$endtime' ");
			$count = $count->total;
			
			$badgecount = $wpdb->get_row("SELECT count(*) as total FROM `{$wpdb->prefix}mhu_completed_techniques` WHERE `active_technique_id` = ".$tech->activetechniqueID ." and user_id = $userid  and completed_date >= '$start_date' and completed_date <= 'end_date' ");
			$badgecount = $badgecount->total;
			
			$dfd = ($count>=1);
			$tech->done_for_day = $dfd;
			
			$type = strtoupper(trim($tech->technique_type));
			
			$prefix = "";
			if ($type == "V"){
				$prefix = "feel";
			} else if ($type == "P"){
				$prefix = "function";
			} else if ($type == "I"){
				$prefix = "fulfill";
			}
			
			$suffixStart = "";
			$suffixClick = "";
			if ($badgecount < 3) {
				$suffixStart = ($dfd) ? "badgeon" : "badgeoff";
				$suffixClick = "badgeon";
			} else if ($badgecount == 3) {
				$suffixStart =  ($dfd) ? "badgeon" : "badgeoff";
				$suffixClick = 4;
			} else if ($badgecount >= 4 && $badgecount < 6){
				$suffixStart = ($dfd) ? 4 : "badgeoff";
				$suffixClick = 4;
			} else if ($badgecount == 6) {
				$suffixStart =  ($dfd) ? 4 : "badgeoff";
				$suffixClick = 7;
			}else if ($badgecount >= 7 && $badgecount < 13){
				$suffixStart = ($dfd) ? 7 : "badgeoff";
				$suffixClick = 7;
			}else if ($badgecount == 13){
				$suffixStart = ($dfd) ? 7 : "badgeoff";
				$suffixClick = 14;
			}else if ($badgecount >= 14 && $badgecount < 20){
				$suffixStart = ($dfd) ? 14 : "badgeoff";
				$suffixClick = 14;
			}else if ($badgecount == 20){
				$suffixStart = ($dfd) ? 14 : "badgeoff";
				$suffixClick = 21;
			}else if ($badgecount >= 20 && $badgecount < 29){
				$suffixStart = ($dfd) ? 21 : "badgeoff";
				$suffixClick = 21;
			} else if ($badgecount == 29) {
				$suffixStart = ($dfd) ? 21 : "badgeoff";
				$suffixClick = 30;
			} else if ($badgecount >= 30){
				$suffixStart = ($dfd) ? 30 : "badgeoff";
				$suffixClick = 30;
			}
			
			$tech->badge_start = $prefix.$suffixStart.".png";
			$tech->badge_click = $prefix.$suffixClick.".png";
					
		}

		//Custom Technique
		$custom_select = "SELECT * FROM `{$wpdb->prefix}mhu_user_technique`  where user_id = $userid and end_date is NULL";
		$custom_techniques = $wpdb->get_results($custom_select );
		
		$cust_id = $custom_techniques[0]->id;
		
		$custom_badgecount = $wpdb->get_row("SELECT count(*) as total FROM `{$wpdb->prefix}mhu_completed_custom_techniques` WHERE `custom_technique_id` = ".$cust_id ." and user_id = $userid  and completed_date >= '$start_date' and completed_date <= 'end_date' ");
		$custom_badgecount = $custom_badgecount->total;
		
		$dfd = ($custom_badgecount>=1);
	
		$prefix = "custom";
		$suffixStart = "";
		$suffixClick = "";
		if ($badgecount < 3) {
			$suffixStart = ($dfd) ? "badgeon" : "badgeoff";
			$suffixClick = "badgeon";
		} else if ($badgecount == 3) {
			$suffixStart =  ($dfd) ? "badgeon" : "badgeoff";
			$suffixClick = 4;
		} else if ($badgecount >= 4 && $badgecount < 6){
			$suffixStart = ($dfd) ? 4 : "badgeoff";
			$suffixClick = 4;
		} else if ($badgecount == 6) {
			$suffixStart =  ($dfd) ? 4 : "badgeoff";
			$suffixClick = 7;
		}else if ($badgecount >= 7 && $badgecount < 13){
			$suffixStart = ($dfd) ? 7 : "badgeoff";
			$suffixClick = 7;
		}else if ($badgecount == 13){
			$suffixStart = ($dfd) ? 7 : "badgeoff";
			$suffixClick = 14;
		}else if ($badgecount >= 14 && $badgecount < 20){
			$suffixStart = ($dfd) ? 14 : "badgeoff";
			$suffixClick = 14;
		}else if ($badgecount == 20){
			$suffixStart = ($dfd) ? 14 : "badgeoff";
			$suffixClick = 21;
		}else if ($badgecount >= 20 && $badgecount < 29){
			$suffixStart = ($dfd) ? 21 : "badgeoff";
			$suffixClick = 21;
		} else if ($badgecount == 29) {
			$suffixStart = ($dfd) ? 21 : "badgeoff";
			$suffixClick = 30;
		} else if ($badgecount >= 30){
			$suffixStart = ($dfd) ? 30 : "badgeoff";
			$suffixClick = 30;
		}
		
		$custom_technique = new stdClass;
		$custom_technique->activetechniqueID = "custom_".$cust_id;
		$custom_technique->id = "custom_".$cust_id;
		$custom_technique->user_id = $userid;
		$custom_technique->start_date = $custom_techniques[0]->start_date;
		$custom_technique->end_date = $custom_techniques[0]->end_date;
		$custom_technique->technique_type = "C";
		$custom_technique->technique_level = "Custom";
		$custom_technique->technique = $custom_techniques[0]->name;
		$custom_technique->how = $custom_techniques[0]->description;
		$custom_technique->why = $custom_techniques[0]->description;
		$custom_technique->done_for_day = $dfd;
		$custom_technique->badge_start = $prefix.$suffixStart.".png";
		$custom_technique->badge_click = $prefix.$suffixClick.".png";

		//Add custom technique to the array
		$mhu_techniques[] = $custom_technique;

	
		$return = new stdClass;
		$return->techniques = $mhu_techniques;
		$return->result = "SUCCESS";
		header('Content-Type: application/json'); 
		echo json_encode($return);

		die;
	}

	public function ajax_app_record_technique_complete()
	{
		global $wpdb;
		date_default_timezone_set('America/Chicago');
		$starttime = date("Y-m-d 00:00:00");
		$endtime = date("Y-m-d 23:59:59");
		$month_start_date = date('Y-m-01 00:00:00');
		$month_end_date = date('Y-m-t 23:59:59');
		
		
		//We need the user ID and the Technique ID
		$userID = $_GET['userid'];
		$techniqueID = $_GET['techniqueID'];
		$activeTechniqueID = $_GET['activetechniqueID'];
		
		
		if ( preg_match("/custom/", $activeTechniqueID)){
			
				$techniqueID = str_replace("custom_", "", $activetechniqueID);
				$past = $wpdb->get_row("SELECT * FROM `{$wpdb->prefix}mhu_completed_custom_techniques` WHERE `custom_technique_id` = $activeTechniqueID and user_id = $userID  and completed_date >= '$starttime' and completed_date <= '$endtime' ");
			
				if (!$past){
				
					$fields = array(
						"user_id" => $userID,
						"custom_technique_id" => $techniqueID,
						"completed_date" => $completedDate
					);
					$wpdb->insert($wpdb->prefix . 'mhu_completed_custom_techniques', $fields, array('%d', '%d', '%s', '%d'));	
				}
				
				//Get the numnber of times the user has completed this technique this month
				$count = $wpdb->get_row("SELECT count(*) as total FROM `{$wpdb->prefix}mhu_completed_custom_techniques` WHERE `custom_technique_id` = $activeTechniqueID and user_id = $userID  and completed_date >= '$month_start_date' and completed_date <= '$month_end_date' ");
				$count = $count->total;
				
				$prefix = "custom";
				$suffix = "badgeon";
				if ($count >= 4){
					$suffix = '4';
				}else if ($count >= 7){
					$suffix = '7';
				}else if ($count >= 14){
					$suffix = '14';
				}else if ($count == 21){
					$suffix = '21';
				}else if ($count >= 30){
					$suffix = '30';
				}
				
				$result["badge"] = $prefix.$suffix.".png";
				$result["result"] = "SUCCESS";
				header('Content-Type: application/json'); 
				print json_encode($result);
				die;
			
		}else{
		
			//First lets see if they have already recorded this complete for the day
			$past = $wpdb->get_row("SELECT * FROM `{$wpdb->prefix}mhu_completed_techniques` WHERE `active_technique_id` = $activeTechniqueID and user_id = $userID  and completed_date >= '$starttime' and completed_date <= '$endtime' ");
			
			
			if (!$past){
				$completedDate = date('Y-m-d H:i:s');
				$fields = array(
					"user_id" => $userID,
					"technique_id" => $techniqueID,
					"completed_date" => $completedDate,
					"active_technique_id" => $activeTechniqueID,
				);
				$wpdb->insert($wpdb->prefix . 'mhu_completed_techniques', $fields, array('%d', '%d', '%s', '%d'));	
			}
			
			//Get the numnber of times the user has completed this technique this month
			$count = $wpdb->get_row("SELECT count(*) as total FROM `{$wpdb->prefix}mhu_completed_techniques` WHERE `active_technique_id` = $activeTechniqueID and user_id = $userID  and completed_date >= '$month_start_date' and completed_date <= '$month_end_date' ");
			$count = $count->total;
			
			//Now we need to figure out what to retun for this 
		    //Get technique based on ID
		    $technique = $wpdb->get_row("SELECT * FROM `{$wpdb->prefix}mhu_techniques` WHERE `id` = $techniqueID");
			
			$result = array();
			
			$type = strtoupper(trim($technique->technique_type));
			
			$prefix = "";
			if ($type == "V"){
				$prefix = "feel";
			} else if ($type == "P"){
				$prefix = "function";
			} else if ($type == "I"){
				$prefix = "fulfill";
			}
			
			$suffix = "badgeon";
			if ($count >= 4){
				$suffix = '4';
			}else if ($count >= 7){
				$suffix = '7';
			}else if ($count >= 14){
				$suffix = '14';
			}else if ($count == 21){
				$suffix = '21';
			}else if ($count >= 30){
				$suffix = '30';
			}
			
			$result["badge"] = $prefix.$suffix.".png";
			$result["result"] = "SUCCESS";
			header('Content-Type: application/json'); 
			print json_encode($result);
			die;
		}
    }
  	function ajax_app_get_journal(){
  		global $wpdb;	
		date_default_timezone_set('America/Chicago');
		$userid= $_GET['userid'];
		
		$start_date = date('Y-m-01');
		$end_date = date('Y-m-t');
		$starttime = date("Y-m-d 00:00:00");
		$endtime = date("Y-m-d 23:59:59");	
  				
  		$questions_1_array = array(
				"1" => "How do you feel after doing these techniques?",
				"2" => "How does doing these techniques make you feel?",
				"3" => "During and after doing these techniques, I feel:"
			);

		$questions_2_array = array(
				"1" => "Since I have been doing my techniques, here is what I am noticing:",
				"2" => "In doing these techniques, here is what I am noticing:",
				"3" => "These are some things I am noticing since I have been doing my techniques:"
		 	);

		//Lets see if the user has already answered stuff for today
		$random = strval(mt_rand(1, 3));
		$answers_select = $wpdb->get_row("SELECT * FROM `{$wpdb->prefix}mhu_user_journal` WHERE user_id = $userid  and entry_date >= '$starttime' and entry_date <= '$endtime' ");
		$question1 = new stdClass;
		$question2 = new stdClass;
		$questions = array($question1, $question2);
		
		if (strlen($answers_select->question_1_text) > 1){
			$question1->text = $answers_select->question_1_text;
			$question1->answer = $answers_select->question_1_answer;
		}else{
			$question1->text = $questions_1_array[$random];
			$question1->answer = "";
		}
		if (strlen($answers_select->question_2_text) > 1){
			$question2->text = $answers_select->question_2_text;
			$question2->answer = $answers_select->question_2_answer;
		}else{
			$question2->text = $questions_2_array[$random];
			$question2->answer = "";
		}		
  		
  		//Get the last entry date for the user
		$lastentry_select = $wpdb->get_row("SELECT * FROM `{$wpdb->prefix}mhu_user_journal` WHERE user_id = $userid order by id desc limit 1 ");
		
		if (strlen($lastentry_select->entry_date) >1){
			$last_date = $lastentry_select->entry_date;
		}else{
			$last_date = "Never";	
		}	
		
		
  		$return = new stdClass;
  		$return->result = "SUCCESS";
		$return->questions = $questions;
		$return->lastentry = $last_date;
		$return->share = $answers_select->share;
		
		header('Content-Type: application/json'); 
		print json_encode($return);
		die;
  		
  	}

    function ajax_app_record_journal_entry()
	{
		global $wpdb;		
		date_default_timezone_set('America/Chicago');	
		$starttime = date("Y-m-d 00:00:00");
		$endtime = date("Y-m-d 23:59:59");	
		$now = date("Y-m-d H:i:s");
		
		//First we need to see if we are updating entry or making a new one
		$userID = $_GET['userid'];
		$questions[0]["question"] =  mb_convert_encoding($_GET['questions1'], "HTML-ENTITIES", 'UTF-8'); 
		$questions[0]["answer"] = 	mb_convert_encoding($_GET['answer1'], "HTML-ENTITIES", 'UTF-8'); 
		$questions[1]["question"] = mb_convert_encoding($_GET['questions2'], "HTML-ENTITIES", 'UTF-8'); 
		$questions[1]["answer"]  = mb_convert_encoding($_GET['answer2'], "HTML-ENTITIES", 'UTF-8'); 
		$share = $_GET['shared'];
		
		if ($share == 'true'){
			$share = 1;
		}
		
		if ($share == 'false'){
			$share = 0;
		}
				
		$answers_select = $wpdb->get_row("SELECT * FROM `{$wpdb->prefix}mhu_user_journal` WHERE user_id = $userID  and entry_date >= '$starttime' and entry_date <= '$endtime' ");
	

		if($answers_select->id){
			//update
			$fields = array(
		    // by including the ID it is culled from the updates 
		    "user_id" => $userID,
		    "entry_date" => $now,
		    "question_1_text"	=> $answers_select->question_1_text,
		    "question_1_answer" => trim($questions[0]["answer"]),
		    "question_2_text"	=> $answers_select->question_2_text,
		    "question_2_answer" => trim($questions[1]["answer"]),
		    "share" => $share
		  );
		  
		  
	      $result = $wpdb->update(
		      	$wpdb->prefix . 'mhu_user_journal',
		      	$fields,
		      	array("id" => $answers_select->id),
		      	array('%d', '%s', '%s', '%s', '%s', '%s', '%d')
			);
		}else{
			//insert
			$fields = array(
		    "entry_date" => $now,
		    "user_id" => $userID,
		    "question_1_text"   => trim($questions[0]["question"]),
		    "question_1_answer" => trim($questions[0]["answer"]),
		    "question_2_text" 	=> trim($questions[1]["question"]),
		    "question_2_answer" => trim($questions[1]["answer"]),
		    "share" => $share
		  );
			$result = $wpdb->insert($wpdb->prefix . 'mhu_user_journal', $fields);
		}
		
		if ($result == 1){
			$result ="SUCCESS";
		}else{
			$result ="FAIL";
		}
		
		header('Content-Type: application/json'); 
		print json_encode(array(
			"questions" => $questions,
			"shared" => $share,
			"updated" => $now,
			"result" => $result
		));	
		die; //we need this so WP dosen't return 0
		
	}

		


}
