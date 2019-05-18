<?php

/**
 * Fired during plugin activation
 *
 * @link       http://www.edisonave.com
 * @since      1.0.0
 *
 * @package    mhu
 * @subpackage mhu/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    mhu
 * @subpackage mhu/includes
 * @author     Tom Printy <tprinty@edisonave.com>
 */
class MHU_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
			wp_schedule_event( time(), 'daily', array( $plugin_admin, 'mhu_send_daily_reminders') );
	}

}
