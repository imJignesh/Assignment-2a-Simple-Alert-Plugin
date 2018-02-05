<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Simple_Alert
 * @subpackage Simple_Alert/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Simple_Alert
 * @subpackage Simple_Alert/public
 * @author     Your Name <email@example.com>
 */
class Simple_Alert_Public {

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
	 * @param      string $plugin_name       The name of the plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;
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
		 * defined in Simple_Alert_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Simple_Alert_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/simple-alert-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Simple_Alert_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Simple_Alert_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		global $post;
		$message = '';
		$status  = '';

		$sa_options = get_option( 'sa_settings' );
		$message    = $sa_options['sa_message'];
		// check if current post is enabled.
		if ( in_array( $post->post_type, $sa_options['sa_posts'], true ) ) {
			$post_loop = $sa_options[ $post->post_type ];
			if ( in_array( $post->ID, $post_loop ) ) {
				$status = 'on';
			}
		}
		$script = "
			<script>
				var sa_status  = '$status';
				var sa_message = '$message';
			</script>";
		echo $script;
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/simple-alert-public.js', array( 'jquery' ), $this->version, false );

	}

}
