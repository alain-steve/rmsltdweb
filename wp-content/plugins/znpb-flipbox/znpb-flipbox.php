<?php if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Plugin Name: ZNPB FlipBox Element
 * Plugin URI: http://hogash.com
 * Description: This plugin will generate an animated flipping box for Kallyas Page builder
 * Version: 1.0.8
 * Author: Balasa Sorin Stefan
 * Author URI: http://themefuzz.com
 * License: GPL2
 */

/**
 * Class ZnPbFlipBoxElement
 *
 * The plugin's base class
 */
class ZnPbFlipBoxElement {

	/**
	 * Holds the plugin current version
	 * @var string
	 */
	var $version = '1.0.8';

	/**
	 * Holds the plugin url
	 * @var string
	 */
	var $url = '';

	/**
	 * Holds the plugin path
	 * @var string
	 */
	var $path = '';


	/**
	 * Holds a refference of the class instance
	 */
	static $instance = null;


	/**
	 * Returns an instance of the classs
	 * @return [type] [description]
	 */
	static public function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}


	/**
	 * Main class constructor
	 */
	function __construct() {
		// Set plugin paths
		$this->url     = plugin_dir_url( __FILE__ );
		$this->path    = plugin_dir_path( __FILE__ );

		add_action( 'after_setup_theme', array( $this, 'init_plugin' ) );
		add_action( 'znb:elements:register_elements', array($this, 'register_element'));
		load_plugin_textdomain('znpb-flipbox-element', false, basename( dirname( __FILE__ ) ) . '/languages' );
	}

	/**
	 * Register the Page Builder element
	 * @param ZionElementsManager $elements_manager
	 */
	function register_element( $elements_manager ) {
		require_once $this->path . 'elements/flipbox/flipbox.php';
		$elements_manager->registerElement( new ZnFlipbox(array(
			'id'           => 'ZnFlipbox',
			'name'         => __('FlipBox Element', 'zion-builder'),
			'description'  => __('This element will generate an animated flipping box.', 'zion-builder'),
			'level'        => 3,
			'category'     => 'content',
			'legacy'       => false,
			'has_multiple' => true,
			'keywords'     => array('3d', 'realistic', 'card', 'image', 'hover'),
		)));
	}


	/**
	 * Fire up the plugin or show a notice in case Kallyas theme is not installed
	 */
	function init_plugin() {
		if ( ! function_exists( 'ZNPB' ) ) {
			add_action( 'admin_notices', array( $this, 'show_admin_notice' ) );
		}
	}


	/**
	 * Shows an admin notice telling you that the Kallyas theme is not installed.
	 */
	function show_admin_notice() {
		$class           = 'notice notice-error is-dismissible';
		$buy_kallyas_url = 'https://themeforest.net/item/kallyas-responsive-multipurpose-wordpress-theme/4091658';
		$buy_link        = sprintf( '<a class="button button button-primary" href="%1$s" target="_blank">%2$s</a>', $buy_kallyas_url, __( 'Get Kallyas theme from here', 'znpb-flipbox-element' ) );
		$message         = __( 'Kallyas theme is not installed! FlipBox Element only works with Kallyas theme.', 'znpb-flipbox-element' );

		printf( '<div class="%1$s"><p>%2$s</p><p>%3$s</p></div>', $class, $message, $buy_link );
	}
}
ZnPbFlipBoxElement::get_instance();
