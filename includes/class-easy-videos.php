<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Easy_Videos
 * @subpackage Easy_Videos/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * @since      1.0.0
 * @package    Easy_Videos
 * @subpackage Easy_Videos/includes
 * @author     Your Name <email@example.com>
 */
class Easy_Videos {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Easy_Videos_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $easy_videos    The string used to uniquely identify this plugin.
	 */
	protected $easy_videos;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;
	
	
	/**
	 * The Google APIs key.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      int    $api_keys    The unique Google API keys.
	 
	 */
	 
	 
	protected $api_keys;

	/**
	 * Define the core functionality of the plugin.
	 *  AIzaSyD9Cpf3qomhYfd5oKZ4X4jvNovNfx-byaY
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'EASY_VIDEOS_VERSION' ) ) {
			$this->version = EASY_VIDEOS_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->easy_videos = 'easy-videos';
        $this->api_keys    = 'AIzaSyBevL2P0mBUIaZPjfF9d-cv_u_bDIJle2E';
		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Easy_Videos_Loader. Orchestrates the hooks of the plugin.
	 * - Easy_Videos_i18n. Defines internationalization functionality.
	 * - Easy_Videos_Admin. Defines all hooks for the admin area.
	 * - Easy_Videos_Public. Defines all hooks for the public side of the site.
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
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-easy-videos-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-easy-videos-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-easy-videos-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-easy-videos-public.php';

		$this->loader = new Easy_Videos_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Easy_Videos_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Easy_Videos_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {
         
		$plugin_admin = new Easy_Videos_Admin( $this->get_easy_videos(), $this->get_version(), $this->api_keys );
	
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'easy_videos_import' );
		$this->loader->add_action( 'init', $plugin_admin, 'reg_easy_videos_post' );
		$this->loader->add_action( 'init', $plugin_admin, 'create_youvid_taxonomy' );
		
		
		// Ajax function for submitting videos import request 
		$this->loader->add_action( 'wp_ajax_esay_import', $plugin_admin, 'easy_videos_import_callback' );
		 $this->loader->add_action( 'wp_ajax_nopriv_esay_import', $plugin_admin, 'easy_videos_import_callback' );
		
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		
	

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Easy_Videos_Public( $this->get_easy_videos(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
	

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
	public function get_easy_videos() {
		return $this->easy_videos;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Easy_Videos_Loader    Orchestrates the hooks of the plugin.
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
