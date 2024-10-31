<?php defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
/**
 * @package WordPress
 * @subpackage YouTube Pro
 *
 * @author Leszek Pomianowski
 * @copyright Copyright (c) 2018, RapidDev
 * @link https://www.rapiddev.pl/youtube_pro
 * @license http://opensource.org/licenses/MIT
 */

/* ====================================================================
 * Live broadcasts
 * ==================================================================*/
	function rapiddev_youtube_livebroadcasts() {
		register_widget( 'rapiddev_youtube_livebroadcasts' );
	}
	add_action( 'widgets_init', 'rapiddev_youtube_livebroadcasts' );
	class rapiddev_youtube_livebroadcasts extends WP_Widget {
		function __construct() {
			parent::__construct(
			'rapiddev_youtube_livebroadcasts', 
			'YouTube - '.__('Live broadcasts', 'rapiddev_youtube'), 
			array('description' => __( 'Notify the user about your live broadcast', 'rapiddev_youtube' )) 
			);
		}
		public function widget( $args, $instance ) {
			$title = apply_filters( 'widget_title', $instance['title'] );
			echo $args['before_widget'];
			if ( ! empty( $title ) )
			echo $args['before_title'] . $title . $args['after_title'];
			$arrContextOptions=array(
				'ssl'=>array(
					'verify_peer'=>false,
					'verify_peer_name'=>false,
				)
			);
			echo '<div class="youtube-pro-broadcasts" style="max-width:100%;" api-key="'.$instance['api_key'].'" channel="'.$instance['channel_id'].'"></div>';
			echo $args['after_widget'];
		}
		public function form( $instance ) {
			$rapiddev_youtube_options = get_option('rapiddev_youtube_options');
			if(isset($instance['title' ])){$title = $instance[ 'title' ];}else{$title = __( 'Live stream', 'rapiddev_youtube' );}
			if(isset($instance['channel_id'])){$channel_id = $instance[ 'channel_id' ];}else{if (!isset($rapiddev_youtube_options['channel_id'])) {$channel_id = null;}else{$channel_id = $rapiddev_youtube_options['channel_id'];}}
			if(isset($instance['api_key'])){$api_key = $instance[ 'api_key' ];}else{if (!isset($rapiddev_youtube_options['api_key'])) {$api_key = null;}else{$api_key = $rapiddev_youtube_options['api_key'];}}
			?>
			<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></p><p><label for="<?php echo $this->get_field_id('channel_id'); ?>"><?php _e('Channel ID', 'rapiddev_youtube'); ?>:</label> <input class="widefat" id="<?php echo $this->get_field_id( 'channel_id' ); ?>" name="<?php echo $this->get_field_name( 'channel_id' ); ?>" type="text" value="<?php echo esc_attr( $channel_id ); ?>" /></p><p><label for="<?php echo $this->get_field_id('api_key'); ?>"><?php _e('API Key', 'rapiddev_youtube'); ?>:</label> <input class="widefat" id="<?php echo $this->get_field_id( 'api_key' ); ?>" name="<?php echo $this->get_field_name( 'api_key' ); ?>" type="text" value="<?php echo esc_attr( $api_key ); ?>" /></p>
			<?php 
		}
		public function update( $new_instance, $old_instance ) {
			$instance = array();
			$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
			$instance['channel_id'] = ( ! empty( $new_instance['channel_id'] ) ) ? strip_tags( $new_instance['channel_id'] ) : '';
			$instance['api_key'] = ( ! empty( $new_instance['api_key'] ) ) ? strip_tags( $new_instance['api_key'] ) : '';
			return $instance;
		}
	}
	if ( is_active_widget( false, false, 'rapiddev_youtube_livebroadcasts', true ) ) {
		function youtube_pro_broadcastscript(){
			if (!wp_script_is('rapiddev-youtube.js', 'enqueued')) {
				wp_register_script('rapiddev-youtube.js', RAPIDDEV_YOUTUBE_URL.'js/rapiddev-youtube.js');
				wp_enqueue_script('rapiddev-youtube.js');
			}
			wp_add_inline_script( 'rapiddev-youtube.js', 'var youtube_broadcasts = document.getElementsByClassName("youtube-pro-broadcasts"), i, videos_count;for (i = 0, videos_count = youtube_broadcasts.length; i < videos_count; i++) {rapiddev_youtube_broadcasts(youtube_broadcasts[i], "live", "'.__('An error occurred while getting the broadcast', 'rapiddev_youtube').'", "'.__('Watch YouTube broadcast now', 'rapiddev_youtube').'", "'.__('See previous YouTube broadcast', 'rapiddev_youtube').'");}');
		}
		add_action('wp_footer', 'youtube_pro_broadcastscript');
	}

/* ====================================================================
 * Newest video
 * ==================================================================*/
	function rapiddev_youtube_newvideo() {
		register_widget( 'rapiddev_youtube_newvideo' );
	}
	add_action( 'widgets_init', 'rapiddev_youtube_newvideo' );
	class rapiddev_youtube_newvideo extends WP_Widget {
		function __construct() {
			parent::__construct(
			'rapiddev_youtube_newvideo', 
			'YouTube - '.__('Latest movies', 'rapiddev_youtube'), 
			array('description' => __( 'Show information about the latest movie', 'rapiddev_youtube' )) 
			);
		}
		public function widget( $args, $instance ) {
			$title = apply_filters( 'widget_title', $instance['title'] );
			echo $args['before_widget'];
			if ( ! empty( $title ) )
			echo $args['before_title'] . $title . $args['after_title'];
			echo '<div class="youtube-pro-latestvideo" style="max-width:100%;" api-key="'.$instance['api_key'].'" channel="'.$instance['channel_id'].'"></div>';
			echo $args['after_widget'];
		}
		public function form( $instance ) {
			$rapiddev_youtube_options = get_option('rapiddev_youtube_options');
			if(isset($instance['title' ])){$title = $instance[ 'title' ];}else{$title = __( 'Latest video', 'rapiddev_youtube' );}
			if(isset($instance['channel_id'])){$channel_id = $instance[ 'channel_id' ];}else{if (!isset($rapiddev_youtube_options['channel_id'])) {$channel_id = null;}else{$channel_id = $rapiddev_youtube_options['channel_id'];}}
			if(isset($instance['api_key'])){$api_key = $instance[ 'api_key' ];}else{if (!isset($rapiddev_youtube_options['api_key'])) {$api_key = null;}else{$api_key = $rapiddev_youtube_options['api_key'];}}
			?>
			<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></p><p><label for="<?php echo $this->get_field_id('channel_id'); ?>"><?php _e('Channel ID', 'rapiddev_youtube'); ?>:</label> <input class="widefat" id="<?php echo $this->get_field_id( 'channel_id' ); ?>" name="<?php echo $this->get_field_name( 'channel_id' ); ?>" type="text" value="<?php echo esc_attr( $channel_id ); ?>" /></p><p><label for="<?php echo $this->get_field_id('api_key'); ?>"><?php _e('API Key', 'rapiddev_youtube'); ?>:</label> <input class="widefat" id="<?php echo $this->get_field_id( 'api_key' ); ?>" name="<?php echo $this->get_field_name( 'api_key' ); ?>" type="text" value="<?php echo esc_attr( $api_key ); ?>" /></p>
			<?php 
		}
		public function update( $new_instance, $old_instance ) {
			$instance = array();
			$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
			$instance['channel_id'] = ( ! empty( $new_instance['channel_id'] ) ) ? strip_tags( $new_instance['channel_id'] ) : '';
			$instance['api_key'] = ( ! empty( $new_instance['api_key'] ) ) ? strip_tags( $new_instance['api_key'] ) : '';
			return $instance;
		}
	}
	if ( is_active_widget( false, false, 'rapiddev_youtube_newvideo', true ) ) {
		function rapiddev_youtube_latestvideoscript(){
			if (!wp_script_is('rapiddev-youtube.js', 'enqueued')) {
				wp_register_script('rapiddev-youtube.js', RAPIDDEV_YOUTUBE_URL.'js/rapiddev-youtube.js');
				wp_enqueue_script('rapiddev-youtube.js');
			}
			wp_add_inline_script( 'rapiddev-youtube.js', 'var youtube_videos = document.getElementsByClassName("youtube-pro-latestvideo"), i, videos_count;for (i = 0, videos_count = youtube_videos.length; i < videos_count; i++) {rapiddev_youtube_latestvideos(youtube_videos[i], "'.__('An error occurred while getting the latest movie', 'rapiddev_youtube').'", "'.__('See the latest YouTube video', 'rapiddev_youtube').'");}');
		}
		add_action('wp_footer', 'rapiddev_youtube_latestvideoscript');
	}

/* ====================================================================
 * Subscribe channel
 * ==================================================================*/
	function rapiddev_youtube_subscribe() {
		register_widget( 'rapiddev_youtube_subscribe' );
	}
	add_action( 'widgets_init', 'rapiddev_youtube_subscribe' );
	class rapiddev_youtube_subscribe extends WP_Widget {
		function __construct() {
			parent::__construct(
			'rapiddev_youtube_subscribe', 
			'YouTube - '.__('Subscribe channel', 'rapiddev_youtube'), 
			array('description' => __('Encourage users to subscribe to your channel', 'rapiddev_youtube' )) 
			);
		}
		public function widget( $args, $instance ) {
			$title = apply_filters( 'widget_title', $instance['title'] );
			echo $args['before_widget'];
			if ( ! empty( $title ) )
			echo $args['before_title'] . $title . $args['after_title'];
			echo '<div id="google-subscribe"><div class="g-ytsubscribe" data-channelid="'.$instance['channel_id'].'" data-layout="full" data-count="default"></div></div>';
			echo $args['after_widget'];
		}
		public function form( $instance ) {
			$rapiddev_youtube_options = get_option('rapiddev_youtube_options');
			if(isset($instance['title' ])){$title = $instance[ 'title' ];}else{$title = __('Subscribe us','rapiddev_youtube' );}
			if(isset($instance['channel_id'])){$channel_id = $instance[ 'channel_id' ];}else{if (!isset($rapiddev_youtube_options['channel_id'])) {$channel_id = null;}else{$channel_id = $rapiddev_youtube_options['channel_id'];}}
			?>
			<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></p><p><label for="<?php echo $this->get_field_id('channel_id'); ?>"><?php _e('Channel ID', 'rapiddev_youtube'); ?>:</label> <input class="widefat" id="<?php echo $this->get_field_id( 'channel_id' ); ?>" name="<?php echo $this->get_field_name( 'channel_id' ); ?>" type="text" value="<?php echo esc_attr( $channel_id ); ?>" /></p>
			<?php 
		}
		public function update( $new_instance, $old_instance ) {
			$instance = array();
			$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
			$instance['channel_id'] = ( ! empty( $new_instance['channel_id'] ) ) ? strip_tags( $new_instance['channel_id'] ) : '';
			return $instance;
		}
	}
	if (is_active_widget(false, false, 'rapiddev_youtube_subscribe', true)) {
		function rapiddev_youtube_badge(){
			wp_enqueue_script( 'google-apis-platform', 'https://apis.google.com/js/platform.js', array());
		}
		add_action('wp_footer', 'rapiddev_youtube_badge');
	}
?>