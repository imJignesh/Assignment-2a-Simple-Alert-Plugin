<?php
/**
 * The admin-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Simple_Alert
 * @subpackage Simple_Alert/admin
 */

/**
 * The admin-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-facing stylesheet and JavaScript.
 *
 * @package    Simple_Alert
 * @subpackage Simple_Alert/admin
 * @author     Your Name <email@example.com>
 */
class Simple_Alert_Admin {
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
		/**
		 * Constructor.
		 *
		 * @var $plugin_name Description.
		 */
		$this->plugin_name = $plugin_name;
		$this->version     = $version;
		add_action( 'admin_init', array( $this, 'settings_init' ) );
		add_action( 'admin_menu', array( $this, 'options_page' ) );

	}
	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		/**
		 * Added admin css.
		 *
		 * @var $plugin_name Description.
		 */
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/simple-alert-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/simple-alert-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Custom option and settings.
	 */
	public function settings_init() {
		// Register a new setting for "simplealert" page.
		register_setting( 'simplealert', 'sa_settings' );

		add_settings_section(
			'section',
			__( 'Plugin settings', 'simple-alert' ),
			'',
			'simplealert'
		);

		add_settings_field(
			'sa_message',
			__( 'Alert message to be displayed', 'simple-alert' ),
			array( $this, 'sa_render_message' ),
			'simplealert',
			'section'
		);

		add_settings_field(
			'sa_posts',
			__( 'Select Posts', 'simple-alert' ),
			array( $this, 'sa_render_posts' ),
			'simplealert',
			'section'
		);
	}
	/**
	 * Render settings fields posts.
	 */
	public function sa_render_posts() {

		$options = get_option( 'sa_settings' );
		$chklist = get_post_types( array( 'public' => true ), 'objects' );
		foreach ( $chklist as $chk ) {
			$checked     = '';
			$total_posts = [];
			if ( array_key_exists('sa_posts',$options) && is_array( $options['sa_posts'] ) ) {
				if ( in_array( $chk->name, $options['sa_posts'], true ) ) {
					$checked = "checked='checked'";

				}
			}
			echo '<div>';
			echo "<label><input class='sa_check' " . ( $checked ) . " name='sa_settings[sa_posts][]' type='checkbox' value='" . esc_html( $chk->name ) . "' /> " . esc_html( $chk->label ) . '</label><br/>';
			$total_posts               = get_posts(
				array(
					'post_type'        => esc_html($chk->name),
					'posts_per_page'   => 100,
					'suppress_filters' => false,
				)
			);
			//$selected_post_type_values = $options[ $chk->name ];
			if ( $total_posts ) {
				$hidden = "class='sa_select'";
				if ( ! $checked ) {
					$hidden = 'class="sa_select sa_hidden"';
				}
				echo '<select ' . ( $hidden ) . ' name="sa_settings[' . esc_html( $chk->name ) . '][]" multiple>';
				foreach ( $total_posts as $post ) {
					$selected = '';
					if ( in_array( $post->ID, $options[ $chk->name ], false ) ) {
						$selected = "selected='selected'";
					}
					echo '<option ' . ( $selected ) . ' value="' . esc_html( $post->ID ) . '">' . esc_html( $post->post_title ) . '</option>';
				}
				echo '</select>';
			}
			echo "<br class='clear'/>";
			echo '</div>';
		}
	}
	/**
	 * Render settings fields message.
	 */
	public function sa_render_message() {

		$options = get_option( 'sa_settings' );
	?>
		<input type='text' name='sa_settings[sa_message]' value='<?php echo esc_html( $options["sa_message"] ); ?>'>
		<?php
	}
	/**
	 * Admin menu
	 */
	public function options_page() {
		// Add top level menu page.
		add_options_page( 'Simple Alert', 'Simple Alert', 'manage_options', 'simple_alert', array( $this, 'options_page_html' ) );

	}
	/**
	 * Render settings page.
	 */
	public function options_page_html() {
		// Check user capabilities.
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		if ( isset( $_GET['settings-updated'] ) ) {
			add_settings_error( 'simplealert_messages', 'simplealert_message', __( 'Settings Saved', 'simplealert' ), 'updated' );
		}
		// Settings_errors( 'simplealert_messages' );.
		?>
			<div class="wrap">
				<h1>
					<?php echo esc_html( get_admin_page_title() ); ?>
				</h1>
				<form action="options.php" method="post">
					<?php
					settings_fields( 'simplealert' );
					do_settings_sections( 'simplealert' );
					submit_button( 'Save Changes' );
		?>
				</form>
			</div>
			<?php
	}

}
