<?php defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
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
 * Settings initialize
 * ==================================================================*/
	function rapiddev_youtube_settings_init() {
		register_setting( 'rapiddev_youtube', 'rapiddev_youtube_options' );
		add_settings_section(
			'rapiddev_youtube_section',
			null,
			'rapiddev_youtube_settings_header',
			'rapiddev_youtube'
		);
		add_settings_field(
			'enable_widget',
			__( 'Admin widget', 'rapiddev_youtube' ),
			'rapiddev_youtube_enable_widget_field',
			'rapiddev_youtube',
			'rapiddev_youtube_section',
			array(
				'label_for' => 'enable_widget',
				'default' => false
			)
		);
		add_settings_field(
			'api_key',
			__( 'API Key', 'rapiddev_youtube' ),
			'rapiddev_youtube_api_key_label',
			'rapiddev_youtube',
			'rapiddev_youtube_section',
			array(
				'label_for' => 'api_key',
				'default' => ''
			)
		);
		add_settings_field(
			'channel_id',
			__( 'Channel ID', 'rapiddev_youtube' ),
			'rapiddev_youtube_channel_id_label',
			'rapiddev_youtube',
			'rapiddev_youtube_section',
			array(
				'label_for' => 'channel_id',
				'default' => ''
			)
		);
	}
	add_action( 'admin_init', 'rapiddev_youtube_settings_init' );
 
/* ====================================================================
 * Header (for debugging)
 * ==================================================================*/
	function rapiddev_youtube_settings_header($args){
		echo '<h1>'.__( 'Settings', 'rapiddev_youtube' ).'</h1><hr>';
		/*
		<?php highlight_string("<?php\nCreator Tools for YouTube\n" . var_export(get_option('rapiddev_youtube_options'), true) . ";\n?>\n"); ?>
		*/
	}

/* ====================================================================
 * Settings fields
 * ==================================================================*/
	function rapiddev_youtube_enable_widget_field($args){
		$options = get_option( 'rapiddev_youtube_options' );
		if (!isset($options[$args['label_for']])) {$options[$args['label_for']] = $args['default'];}
?>
<div class="form-group">
	<select class="form-control" id="<?php echo esc_attr( $args['label_for'] ); ?>" data-custom="<?php echo esc_attr( $args['rapiddev_youtube_custom_data'] ); ?>" name="rapiddev_youtube_options[<?php echo esc_attr( $args['label_for'] ); ?>]">
		<option value="1" <?php echo isset($options[ $args['label_for']])?(selected($options[$args['label_for']],'1',false)):(''); ?>><?php esc_html_e( 'Enabled', 'rapiddev_youtube' ); ?></option>
		<option value="0" <?php echo isset($options[ $args['label_for']])?(selected($options[$args['label_for']],'0',false)):(''); ?>><?php esc_html_e( 'Disabled', 'rapiddev_youtube' ); ?></option>
	</select>
</div>
<?php
	}

	function rapiddev_youtube_api_key_label($args){
		$options = get_option( 'rapiddev_youtube_options' );
		if (!isset($options[$args['label_for']])) {$options[$args['label_for']] = $args['default'];}
?>
<div class="form-group">
	<input class="form-control" type="text" id="<?php echo esc_attr( $args['label_for'] ); ?>" name="rapiddev_youtube_options[<?php echo esc_attr( $args['label_for'] ); ?>]" value="<?php echo $options[$args['label_for']]; ?>" data-custom="<?php echo esc_attr( $args['rapiddev_youtube_custom_data'] ); ?>">
</div>
<?php
	}

	function rapiddev_youtube_channel_id_label($args){
		$options = get_option( 'rapiddev_youtube_options' );
		if (!isset($options[$args['label_for']])) {$options[$args['label_for']] = $args['default'];}
?>
<div class="form-group">
	<input class="form-control" type="text" id="<?php echo esc_attr( $args['label_for'] ); ?>" name="rapiddev_youtube_options[<?php echo esc_attr( $args['label_for'] ); ?>]" value="<?php echo $options[$args['label_for']]; ?>" data-custom="<?php echo esc_attr( $args['rapiddev_youtube_custom_data'] ); ?>">
</div>
<?php
	}
 
/* ====================================================================
 * Add settings submenu page
 * ==================================================================*/
	function rapiddev_youtube_options_page(){
		add_submenu_page(
			'options-general.php',
			'YouTube Tools',
			'YouTube Tools',
			'manage_options',
			'rapiddev-youtube',
			'rapiddev_youtube_options_page_html',
			'dashicons-format-video'
		);
	}
	add_action( 'admin_menu', 'rapiddev_youtube_options_page' );
 
/* ====================================================================
 * Subpage callback functions
 * ==================================================================*/
	function rapiddev_youtube_options_page_html(){
		if (!current_user_can( 'manage_options')){
			return;
		}
		?>
<div class="wrap">
	<section id="rapiddev-youtube">
		<h1 class="wp-heading-inline"></h1>
		<div class="container-fluid">
			<div class="row">
				<div class="col-3">
					<div class="sp_card">
						<div class="sp_card_body">
							<div class="image" style="background: #ED5736">
								<span style="font-size:24px" class="dashicons dashicons-awards"></span>
							</div>
							<div class="description">
								<strong id="subscribtions-live"><?php _e('Check the configuration', 'rapiddev_youtube') ?></strong>
								<br>
								<?php _e('Subscribtions live', 'rapiddev_youtube') ?>
							</div>
						</div>
					</div>
				</div>
				<div class="col-3">
					<div class="sp_card">
						<div class="sp_card_body">
							<div class="image">
								<span class="dashicons dashicons-visibility"></span>
							</div>
							<div class="description">
								<strong id="viewCount"><?php _e('Check the configuration', 'rapiddev_youtube') ?></strong>
								<br>
								<?php _e('Total views', 'rapiddev_youtube') ?>
							</div>
						</div>
					</div>
				</div>
				<div class="col-3">
					<div class="sp_card">
						<div class="sp_card_body">
							<div class="image" style="background:#3C5A9A">
								<span class="dashicons dashicons-video-alt3"></span>
							</div>
							<div class="description">
								<strong id="videoCount"><?php _e('Check the configuration', 'rapiddev_youtube') ?></strong>
								<br>
								<?php _e('Videos', 'rapiddev_youtube') ?>
							</div>
						</div>
					</div>
				</div>
				<div class="col-3">
					<div class="sp_card">
						<div class="sp_card_body">
							<div class="image" style="background: #ED5736">
								<span style="font-size:27px" class="dashicons dashicons-heart"></span>
							</div>
							<div class="description">
								<strong><?php _e('You like our plugins?', 'rapiddev_youtube') ?></strong>
								<br>
								<a href="https://rapiddev.pl/spectrum" target="_blank" rel="noopener"><?php _e('See our framework', 'rapiddev_youtube') ?></a>
							</div>
						</div>
					</div>
				</div>
				<div class="col-6">
					<div class="sp_card">
						<div class="sp_card_body">
							<h1><?php _e('Use functionality', 'rapiddev_youtube') ?></h1>
							<hr>
							<h4 class="yt_h4"><strong><?php _e('Site widgets','rapiddev_youtube') ?></strong></h4>
							<p style="margin-top: 0;"><?php _e('Use one of the few widgets available for your website', 'rapiddev_youtube') ?>
							<ul>
								<li>1. <?php _e('Latest movies', 'rapiddev_youtube') ?></li>
								<li>2. <?php _e('Live broadcasts', 'rapiddev_youtube') ?></li>
								<li>3. <?php _e('Subscribe channel', 'rapiddev_youtube') ?></li>
							</ul>
								<a href="<?php echo admin_url('/widgets.php'); ?>"><?php _e('Go to the widgets now', 'rapiddev_youtube') ?></a></p>
							<h4 class="yt_h4"><strong><?php _e('Admin widget','rapiddev_youtube') ?></strong></h4>
							<p style="margin-top: 0;"><?php _e('If you check the \'Admin Widget\' option, a widget with the current number of subscribers will be displayed on the main page of your cockpit every 5 seconds', 'rapiddev_youtube') ?></p>
							<h4 class="yt_h4"><strong>Google API's</strong></h4>
							<p style="margin-top: 0;"><?php _e('To get your own API key, go to the Google developer site.', 'rapiddev_youtube') ?> <?php _e('Generate your API key, then paste it in the settings next to it', 'rapiddev_youtube') ?><br /><a href="https://console.developers.google.com/apis/credentials" target="_blank" rel="noopener">Google API's</a></p>
						</div>
					</div>
				</div>
				<div class="col-6">
					<div class="sp_card">
						<div class="sp_card_body">
							<form action="options.php" method="post">
								<?php
									settings_fields( 'rapiddev_youtube' );
									do_settings_sections( 'rapiddev_youtube' );
								?>
								<div class="form-group">
									<input type="submit" name="submit" id="submit" class="btn btn-primary btn-block" value="<?php _e('Save settings', 'rapiddev_youtube') ?>">
								</div>
							</form>
						</div>
					</div>
				</div>
				<div class="col-12">
					<small><i><?php _e('This plugin is not an official plugin created by YouTube. The YouTube name is owned by Google INC. and is used to facilitate identification', 'rapiddev_youtube') ?>.</i></small>
				</div>
			</div>
		</div>
	</section>
</div>
		<?php
	}

/* ====================================================================
 * Admin page styles and scripts
 * ==================================================================*/
	function rapiddev_youtube_admin_styles(){
?>
<style>.yt_h4{font-size: 14px;font-weight: 400;margin: 0;padding: 9px 0 4px;line-height: 29px;}#rapiddev-youtube{display:block}.sp_card{background-color:#fff;box-shadow:2px 5px 10px 1px rgba(0,0,0,.2)}.btn-primary.focus,.btn-primary:focus,.btn-primary:not(:disabled):not(.disabled).active:focus,.btn-primary:not(:disabled):not(.disabled):active:focus,.show>.btn-primary.dropdown-toggle:focus{box-shadow:0 0 0 .2rem rgba(0,123,255,.5)}.sp_card_body{padding:15px}.sp_card_body>.image>span{font-size:25px;height:25px;width:25px}.sp_card_body>.image{float:left;color:#fff;background:#9358AC;padding:8px;border-radius:25px;margin-right:15px}.center,.container{margin-left:auto;margin-right:auto}.sp_card_body>.description>strong{font-size:17px}.btn,.form-control{padding:.375rem .75rem;font-size:1rem;line-height:1.5}.left{text-align:left}.right{text-align:right}.center{text-align:center}.justify{text-align:justify}.container{width:auto}.row{position:relative;width:100%}.row [class^=col]{float:left;margin:.5rem 2%;min-height:.125rem}.col-1,.col-10,.col-11,.col-12,.col-2,.col-3,.col-4,.col-5,.col-6,.col-7,.col-8,.col-9{width:96%}.col-1-sm{width:4.33%}.col-2-sm{width:12.66%}.col-3-sm{width:21%}.col-4-sm{width:29.33%}.col-5-sm{width:37.66%}.col-6-sm{width:46%}.col-7-sm{width:54.33%}.col-8-sm{width:62.66%}.col-9-sm{width:71%}.col-10-sm{width:79.33%}.col-11-sm{width:87.66%}.col-12-sm{width:96%}.row::after{content:"";display:table;clear:both}.hidden-sm{display:none}@media only screen and (min-width:1180px){.col-1{width:4.33%}.col-2{width:12.66%}.col-3{width:21%}.col-4{width:29.33%}.col-5{width:37.66%}.col-6{width:46%}.col-7{width:54.33%}.col-8{width:62.66%}.col-9{width:71%}.col-10{width:79.33%}.col-11{width:87.66%}.col-12{width:96%}.hidden-sm{display:block}}.btn-block{display:block;width:100%}.btn-block+.btn-block{margin-top:.5rem}input[type=submit].btn-block,input[type=reset].btn-block,input[type=button].btn-block{width:100%}.btn-primary{color:#fff;background-color:#007bff;border-color:#007bff}.btn-primary:hover{color:#fff;background-color:#0069d9;border-color:#0062cc}.btn-primary.disabled,.btn-primary:disabled{color:#fff;background-color:#007bff;border-color:#007bff}.btn-primary:not(:disabled):not(.disabled).active,.btn-primary:not(:disabled):not(.disabled):active,.show>.btn-primary.dropdown-toggle{color:#fff;background-color:#0062cc;border-color:#005cbf}.btn{display:inline-block;cursor:pointer;font-weight:400;text-align:center;white-space:nowrap;vertical-align:middle;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none;border:1px solid transparent;border-radius:.25rem;transition:color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out}.form-control{display:block;width:100%;color:#495057;background-color:#fff;background-clip:padding-box;border:1px solid #ced4da;border-radius:.25rem;transition:border-color .15s ease-in-out,box-shadow .15s ease-in-out}@media screen and (prefers-reduced-motion:reduce){.form-control{transition:none}}.form-control::-ms-expand{background-color:transparent;border:0}.form-control:focus{color:#495057;background-color:#fff;border-color:#80bdff;outline:0;box-shadow:0 0 0 .2rem rgba(0,123,255,.25)}.form-control::-webkit-input-placeholder{color:#6c757d;opacity:1}.form-control::-moz-placeholder{color:#6c757d;opacity:1}.form-control:-ms-input-placeholder{color:#6c757d;opacity:1}.form-control::-ms-input-placeholder{color:#6c757d;opacity:1}.form-control::placeholder{color:#6c757d;opacity:1}.form-control:disabled,.form-control[readonly]{background-color:#e9ecef;opacity:1}select.form-control:not([size]):not([multiple]){height:calc(2.25rem + 2px)}select.form-control:focus::-ms-value{color:#495057;background-color:#fff}.form-control-file,.form-control-range{display:block;width:100%}.col-form-label{padding-top:calc(.375rem + 1px);padding-bottom:calc(.375rem + 1px);margin-bottom:0;font-size:inherit;line-height:1.5}.col-form-label-lg{padding-top:calc(.5rem + 1px);padding-bottom:calc(.5rem + 1px);font-size:1.25rem;line-height:1.5}.col-form-label-sm{padding-top:calc(.25rem + 1px);padding-bottom:calc(.25rem + 1px);font-size:.875rem;line-height:1.5}.form-control-plaintext{display:block;width:100%;padding-top:.375rem;padding-bottom:.375rem;margin-bottom:0;line-height:1.5;color:#212529;background-color:transparent;border:solid transparent;border-width:1px 0}.form-control-plaintext.form-control-lg,.form-control-plaintext.form-control-sm,.input-group-lg>.form-control-plaintext.form-control,.input-group-lg>.input-group-append>.form-control-plaintext.btn,.input-group-lg>.input-group-append>.form-control-plaintext.input-group-text,.input-group-lg>.input-group-prepend>.form-control-plaintext.btn,.input-group-lg>.input-group-prepend>.form-control-plaintext.input-group-text,.input-group-sm>.form-control-plaintext.form-control,.input-group-sm>.input-group-append>.form-control-plaintext.btn,.input-group-sm>.input-group-append>.form-control-plaintext.input-group-text,.input-group-sm>.input-group-prepend>.form-control-plaintext.btn,.input-group-sm>.input-group-prepend>.form-control-plaintext.input-group-text{padding-right:0;padding-left:0}.form-control-sm,.input-group-sm>.form-control,.input-group-sm>.input-group-append>.btn,.input-group-sm>.input-group-append>.input-group-text,.input-group-sm>.input-group-prepend>.btn,.input-group-sm>.input-group-prepend>.input-group-text{padding:.25rem .5rem;font-size:.875rem;line-height:1.5;border-radius:.2rem}.input-group-sm>.input-group-append>select.btn:not([size]):not([multiple]),.input-group-sm>.input-group-append>select.input-group-text:not([size]):not([multiple]),.input-group-sm>.input-group-prepend>select.btn:not([size]):not([multiple]),.input-group-sm>.input-group-prepend>select.input-group-text:not([size]):not([multiple]),.input-group-sm>select.form-control:not([size]):not([multiple]),select.form-control-sm:not([size]):not([multiple]){height:calc(1.8125rem + 2px)}.form-control-lg,.input-group-lg>.form-control,.input-group-lg>.input-group-append>.btn,.input-group-lg>.input-group-append>.input-group-text,.input-group-lg>.input-group-prepend>.btn,.input-group-lg>.input-group-prepend>.input-group-text{padding:.5rem 1rem;font-size:1.25rem;line-height:1.5;border-radius:.3rem}.input-group-lg>.input-group-append>select.btn:not([size]):not([multiple]),.input-group-lg>.input-group-append>select.input-group-text:not([size]):not([multiple]),.input-group-lg>.input-group-prepend>select.btn:not([size]):not([multiple]),.input-group-lg>.input-group-prepend>select.input-group-text:not([size]):not([multiple]),.input-group-lg>select.form-control:not([size]):not([multiple]),select.form-control-lg:not([size]):not([multiple]){height:calc(2.875rem + 2px)}.form-group{margin-bottom:1rem}.form-text{display:block;margin-top:.25rem}
<?php
	}
	function rapiddev_youtube_admin_scripts() {
		$conf = get_option( 'rapiddev_youtube_options' );
		if (!isset($conf['api_key'])) {
			$conf['api_key'] = null;
			$conf['channel_id'] = null;
		}
		echo '<script>var CONFIGURATION = {};CONFIGURATION["channel"] = "'.$conf['channel_id'].'";CONFIGURATION["api"] = "'.$conf['api_key'].'";function youtube(){var xmlhttp = new XMLHttpRequest();xmlhttp.onreadystatechange = function(){if (xmlhttp.readyState == XMLHttpRequest.DONE) {var RESPONSE = JSON.parse(xmlhttp.responseText).items[0].statistics;document.getElementById("subscribtions-live").innerHTML = RESPONSE.subscriberCount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");document.getElementById("viewCount").innerHTML = RESPONSE.viewCount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");document.getElementById("videoCount").innerHTML = RESPONSE.videoCount;console.log("Requested URL: https://www.googleapis.com/youtube/v3/channels?part=statistics&id="+CONFIGURATION.channel+"&key="+CONFIGURATION.api);}};xmlhttp.open("GET", "https://www.googleapis.com/youtube/v3/channels?part=statistics&id="+CONFIGURATION.channel+"&key="+CONFIGURATION.api, true);xmlhttp.send();}youtube();</script>';
	}

	global $pagenow;
	if ($pagenow == 'options-general.php') {
		if (@$_GET['page'] == 'rapiddev-youtube') {
			add_action('admin_footer', 'rapiddev_youtube_admin_scripts');
			add_action('admin_head', 'rapiddev_youtube_admin_styles');
		}
	}
	