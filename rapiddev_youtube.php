<?php defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
/*
Plugin Name: Creator Tools for YouTube
Plugin URI: http://wordpress.org/plugins/rapiddev-youtube/
Description: Advanced YouTube features. Add live subscriptions to your website, post livechat from broadcasts, embed videos and more!
Author: RapidDev | Polish technology company
Author URI: https://rapiddev.pl/
License: MIT
License URI: https://opensource.org/licenses/MIT
Version: 1.3.0
Text Domain: rapiddev_youtube
Domain Path: /languages
*/
/**
 * @package WordPress
 * @subpackage Preloader Pro
 *
 * @author Leszek Pomianowski
 * @copyright Copyright (c) 2018, RapidDev
 * @link https://www.rapiddev.pl/rapiddev_youtube
 * @license http://opensource.org/licenses/MIT
 */

/* ====================================================================
 * Constant
 * ==================================================================*/
	define('RAPIDDEV_YOUTUBE_VERSION', '1.3.0');
	define('RAPIDDEV_YOUTUBE_NAME', 'Creator Tools for YouTube');
	define('RAPIDDEV_YOUTUBE_PATH', plugin_dir_path( __FILE__ ));
	define('RAPIDDEV_YOUTUBE_URL', plugin_dir_url(__FILE__));
	define('RAPIDDEV_YOUTUBE_WP_VERSION', '4.5.0');
	define('RAPIDDEV_YOUTUBE_PHP_VERSION', '5.4.0');

/* ====================================================================
 * Define language files
 * ==================================================================*/
	function rapiddev_youtube_languages(){
		load_plugin_textdomain( 'rapiddev_youtube', FALSE, basename(RAPIDDEV_YOUTUBE_PATH) . '/languages/' );
	}
	add_action('plugins_loaded', 'rapiddev_youtube_languages');

/* ====================================================================
 * PHP Version verification
 * ==================================================================*/
	if (version_compare(PHP_VERSION, RAPIDDEV_YOUTUBE_PHP_VERSION, '>=')){

/* ====================================================================
 * WordPress Version check
 * ==================================================================*/
	global $wp_version;
	if (version_compare($wp_version, RAPIDDEV_YOUTUBE_WP_VERSION, '>=')){

/* ====================================================================
 * Settings page
 * ==================================================================*/
	if (is_admin()) {
		if (file_exists(RAPIDDEV_YOUTUBE_PATH.'assets/settings.php')) {
			require RAPIDDEV_YOUTUBE_PATH.'assets/settings.php';
		}
	}

/* ====================================================================
 * Load widgets
 * ==================================================================*/
		if (file_exists(RAPIDDEV_YOUTUBE_PATH.'assets/widgets.php')) {
			require RAPIDDEV_YOUTUBE_PATH.'assets/widgets.php';
		}

/* ====================================================================
 * Admin widget
 * ==================================================================*/
		if (is_admin()) {
			function rapiddev_youtube_admin_widget_header() {
				echo '<h2 id="subscribtions-live" style="text-align: center">'.__('Loading...', 'rapiddev_youtube').'</h2>';
			}
			function rapiddev_youtube_widget_initialize(){
				wp_add_dashboard_widget('rapiddev_youtube_admin_widget_header','<span class="dashicons dashicons-format-video"></span> '.__('YouTube Subscribtions', 'rapiddev_youtube'), 'rapiddev_youtube_admin_widget_header', 'visitor', 'normal', 'high');
			}
			function rapiddev_admin_widget(){
				$conf = get_option( 'rapiddev_youtube_options' );
				if (!isset($conf['api_key'])) {
					$conf['api_key'] = null;
					$conf['channel_id'] = null;
				}
				echo '<script>var CONFIGURATION = {};CONFIGURATION["channel"] = "'.$conf['channel_id'].'";CONFIGURATION["api"] = "'.$conf['api_key'].'";function youtube(){var xmlhttp = new XMLHttpRequest();xmlhttp.onreadystatechange = function(){if (xmlhttp.readyState == XMLHttpRequest.DONE) {var RESPONSE = JSON.parse(xmlhttp.responseText).items[0].statistics.subscriberCount;document.getElementById("subscribtions-live").innerHTML = RESPONSE;}};xmlhttp.open("GET", "https://www.googleapis.com/youtube/v3/channels?part=statistics&id="+CONFIGURATION.channel+"&key="+CONFIGURATION.api, true);xmlhttp.send();setTimeout(youtube, 5500);}youtube();</script>';
			}
			$conf = get_option( 'rapiddev_youtube_options' );
			if (!isset($conf['api_key'])) {
				$conf['enable_widget'] = '0';
			}
			if ($conf['enable_widget'] == '1') {
				add_action('wp_dashboard_setup', 'rapiddev_youtube_widget_initialize');
				add_action( 'admin_print_scripts', 'rapiddev_admin_widget' );
			}
		}

/* ====================================================================
 * WordPress < 4.5.0 error
 * ==================================================================*/
	}else{
		if (!function_exists('rapiddev_youtube_wp_version_error')){
			function rapiddev_youtube_wp_version_error(){
				echo '<div class="notice notice-error"><p><strong>'.__('CRITICAL ERROR', 'rapiddev_youtube').'!</strong><br />'.__('The', 'rapiddev_youtube').' <i>'.RAPIDDEV_YOUTUBE_NAME.'</i> '.__('requires at least', 'rapiddev_youtube').' WordPress '.RAPIDDEV_YOUTUBE_WP_VERSION.'<br />'.__('You need to update your WordPress site', 'rapiddev_youtube').'.<br /><small><i>'.__('ERROR ID', 'rapiddev_youtube').': 1</i></small></p></div>';
			}
			add_action('admin_notices', 'rapiddev_youtube_wp_version_error');
		}
	}

/* ====================================================================
 * PHP < 5.4.0 error
 * ==================================================================*/
	}else{
		if (!function_exists('rapiddev_youtube_php_version_error')){
			function rapiddev_youtube_php_version_error(){
				echo '<div class="notice notice-error"><p><strong>'.__('CRITICAL ERROR', 'rapiddev_youtube').'!</strong><br />'.__('The', 'rapiddev_youtube').' <i>'.RAPIDDEV_YOUTUBE_NAME.'</i> '.__('requires at least', 'rapiddev_youtube').' PHP '.RAPIDDEV_YOUTUBE_PHP_VERSION.'<br />'.__('You need to update your server', 'rapiddev_youtube').'.<br /><small><i>'.__('ERROR ID', 'rapiddev_youtube').': 1</i></small></p></div>';
			}
			add_action('admin_notices', 'rapiddev_youtube_php_version_error');
		}
	}

/* ====================================================================
 * Settings URL
 * ==================================================================*/
	function rapiddev_youtube_settings_url($links) {
		array_push( $links, '<a href="'.admin_url('/options-general.php?page=rapiddev-youtube').'">'.__( 'Settings' ).'</a>');
		return $links;
	}
	add_filter( 'plugin_action_links_'.plugin_basename( __FILE__ ), 'rapiddev_youtube_settings_url');
?>