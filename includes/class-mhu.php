<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the dashboard.
 *
 * @link       http://www.edisonave.com
 * @since      1.0.0
 *
 * @package    mhu
 * @subpackage mhu/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, dashboard-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Plugin_Name
 * @subpackage Plugin_Name/includes
 * @author     Your Name <email@example.com>
 */
class MHU {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Plugin_Name_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the Dashboard and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->plugin_name = 'mhu';
		$this->version = '1.0.0';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}


	/**
		Send an error message	
	
	**/
	function mhu_error_notification($label, $message) {
  		$email  = "Label: {$label}\n";
  		$email .= 'Date:  ' . date('r') . "\n\n";
  		$email .= $message;

  		wp_mail('info@edisonave.com', "[error][mhu] {$label}", $email);
	}


	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Plugin_Name_Loader. Orchestrates the hooks of the plugin.
	 * - Plugin_Name_i18n. Defines internationalization functionality.
	 * - Plugin_Name_Admin. Defines all hooks for the dashboard.
	 * - Plugin_Name_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-mhu-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-mhu-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the Dashboard.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-mhu-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-mhu-public.php';

		$this->loader = new MHU_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Plugin_Name_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new MHU_i18n();
		$plugin_i18n->set_domain( $this->get_plugin_name() );

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the dashboard functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new MHU_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
      	$this->loader->add_action( 'admin_menu', $plugin_admin, 'mhu_admin_menu');
			
		//Ajax functions
		add_action( 'wp_ajax_nopriv_mhu_send_daily_reminders', array($plugin_admin, 'mhu_send_daily_reminders') );	
		add_action( 'wp_ajax_nopriv_mhu_redo_techniques', array($plugin_admin, 'mhu_monthly_redo_techniques') );				
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new MHU_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		
			
		//Ajax called things
		add_action( 'wp_ajax_record_technique_complete', array($plugin_public, 'ajax_record_technique_complete') );	
		add_action( 'wp_ajax_record_journal_entry', array($plugin_public, 'ajax_record_journal_entry') );		
		add_action( 'wp_ajax_reactivate_technique', array($plugin_public, 'ajax_reactivate_technique') );
		add_action( 'wp_ajax_deactivate_technique', array($plugin_public, 'ajax_deactivate_technique') );
		add_action( 'wp_ajax_custom_technique', array($plugin_public, 'ajax_custom_technique') );
		
		//JSON functions for the app
		add_action( 'wp_ajax_nopriv_app_login', array($plugin_public, 'ajax_app_login') );	
		add_action( 'wp_ajax_nopriv_app_gtt', array($plugin_public, 'ajax_app_get_todays_techniques') ); 
		add_action( 'wp_ajax_nopriv_app_record_technique_complete', array($plugin_public, 'ajax_app_record_technique_complete') ); 
		
		add_action( 'wp_ajax_nopriv_app_get_journal', array($plugin_public, 'ajax_app_get_journal') ); 
		add_action( 'wp_ajax_nopriv_app_record_journal_entry', array($plugin_public, 'ajax_app_record_journal_entry') ); 
		
		
	
		//Shortcodes
		add_shortcode( 'mhu_show_questionnaire', array( $plugin_public, 'mhu_show_questionnaire') );
		add_shortcode( 'mhu_show_usersettings', array( $plugin_public, 'mhu_show_usersettings') );
		
		add_shortcode( 'mhu_show_dashboard', array( $plugin_public, 'mhu_show_dashboard') );
		add_shortcode( 'mhu_get_dashboard', array( $plugin_public, 'mhu_get_dashboard') );
		add_shortcode( 'mhu_get_archive', array( $plugin_public, 'mhu_get_archive') );
		
		//Cron activities
		//$this->loader->add_action( 'wp', $plugin_public, 'setup_reminder_schedule' ); 
		add_action('init','add_my_error');
		function add_my_error() { 
		    global $wp; 
		    $wp->add_query_var('mhu_error'); 
		}
		
		
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    MHU_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
