<?php 
/* 
Plugin Name: Elementor Custom Widget
Plugin URI:  
Description: Elementor Custom Widget
Version:     0.1
Author:      Keramot UL Islam
Author URI:  https://abmsourav.com
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: elementorcw
Domain Path: /languages
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/** 
 * Usefull Link: https://developers.elementor.com/creating-an-extension-for-elementor/
 */
final class Elementor_Demo_Extension {

	const VERSION = '0.1';
	const MINIMUM_ELEMENTOR_VERSION = '2.0.0';
	const MINIMUM_PHP_VERSION = '7.0';

	private static $_instance = null;
    public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

    public function __construct() {
        add_action( 'plugins_loaded', [ $this, 'init' ] );
    }
        
	public function init() {
        load_plugin_textdomain( 'elementorcw' );

        // Check if Elementor installed and activated
				if ( ! did_action( 'elementor/loaded' ) ) {
					add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
					return;
				}
        
        // Check for required Elementor version
				if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
					add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
					return;
				}
        
        // Check for required PHP version
				if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
					add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
					return;
				}
        
        // Add Plugin actions
				add_action( 'elementor/widgets/widgets_registered', [ $this, 'init_widgets' ] );
  }

    public function init_widgets() {
				// Include Widget files
				require_once( __DIR__ . '/widgets/demo-widget.php' );

        // Register widget
        // Name Space: \Elementor\Plugin
				\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor_Demo_Widget() );
		}

    // Elementor activation function
    public function admin_notice_missing_main_plugin() {
				if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );
				$message = sprintf(
					/* translators: 1: Plugin name 2: Elementor */
					esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'elementorcw' ),
					'<strong>' . esc_html__( 'Elementor Test Extension', 'elementorcw' ) . '</strong>',
					'<strong>' . esc_html__( 'Elementor', 'elementorcw' ) . '</strong>'
				);
				printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
    }
    
    // Elementor version check
    public function admin_notice_minimum_elementor_version() {
				if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

				$message = sprintf(
					/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
					esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'elementorcw' ),
					'<strong>' . esc_html__( 'Elementor Test Extension', 'elementorcw' ) . '</strong>',
					'<strong>' . esc_html__( 'Elementor', 'elementorcw' ) . '</strong>',
					self::MINIMUM_ELEMENTOR_VERSION
				);
				printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
    }
    
    // PHP version check
    public function admin_notice_minimum_php_version() {
				if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

				$message = sprintf(
					/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
					esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'elementorcw' ),
					'<strong>' . esc_html__( 'Elementor Test Extension', 'elementorcw' ) . '</strong>',
					'<strong>' . esc_html__( 'PHP', 'elementorcw' ) . '</strong>',
					self::MINIMUM_PHP_VERSION
				);
				printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

	public function includes() {}

}
Elementor_Demo_Extension::instance();