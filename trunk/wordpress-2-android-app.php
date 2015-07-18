<?php
/*
Plugin Name: wordpress2androidapp
Plugin URI: http://freeweb2app.com
Description: Convert your wordpress website into Android App within 5 minutes
Version: 1.0
Author: sangvish
Author URI: http://sangvish.com
Author Email: info@sangvish.com
License:

  Copyright 2011 sangvish (info@sangvish.com)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as 
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
  
*/

class wordpress2androidapp {

	/*--------------------------------------------*
	 * Constants
	 *--------------------------------------------*/
	const name = 'wordpress2androidapp';
	const slug = 'wordpress2androidapp';
	
	/**
	 * Constructor
	 */
	function __construct() {
		//register an activation hook for the plugin
		register_activation_hook( __FILE__, array( &$this, 'install_wordpress2androidapp' ) );

		//Hook up to the init action
		add_action( 'init', array( &$this, 'init_wordpress2androidapp' ) );
	}
  
	/**
	 * Runs when the plugin is activated
	 */  
	function install_wordpress2androidapp() {
		// do not generate any output here
	}
  

	/**
	 * Runs when the plugin is initialized
	 */
	function init_wordpress2androidapp() {
		// Setup localization
		load_plugin_textdomain( self::slug, false, dirname( plugin_basename( __FILE__ ) ) . '/lang' );
		// Load JavaScript and stylesheets
		//$this->register_scripts_and_styles();

		// Register the shortcode [freeweb2app]
		add_shortcode( 'freeweb2app', array( &$this, 'render_shortcode' ) );
	
		if ( is_admin() ) {
			//this will run when in the WordPress admin
					add_action('admin_menu', 'my_menu');
					function my_menu()
					{
					add_menu_page( 'FreeWeb2App', 'FreeWeb2App', 'manage_options', 'web2app', 'web2app');
					}
					function web2app()
					{
					include_once 'web2app.php';
					}

		} else {
			//this will run when on the frontend
			
		}

		/*
		 * TODO: Define custom functionality for your plugin here
		 *
		 * For more information: 
		 * http://codex.wordpress.org/Plugin_API#Hooks.2C_Actions_and_Filters
		 */
		add_action( 'your_action_here', array( &$this, 'action_callback_method_name' ) );
		add_filter( 'your_filter_here', array( &$this, 'filter_callback_method_name' ) );    
	}

	function action_callback_method_name() {
		// TODO define your action method here
	}

	function filter_callback_method_name() {
		// TODO define your filter method here
	}

	function render_shortcode($atts) {
		// Extract the attributes
		extract(shortcode_atts(array(
			'attr1' => 'foo', //foo is a default value
			'attr2' => 'bar'
			), $atts));
		// you can now access the attribute values using $attr1 and $attr2
		
		ob_start();
		return '<iframe src="http://freeweb2app.com/create-android-app/" style="width:100%; min-height:600px;" ></iframe>';
			
	}
  
	/**
	 * Registers and enqueues stylesheets for the administration panel and the
	 * public facing site.
	 */
	/*private function register_scripts_and_styles() {
		if ( is_admin() ) {
			$this->load_file( self::slug . '-admin-script', '/js/admin.js', true );
			$this->load_file( self::slug . '-admin-style', '/css/admin.css' );
		} else {
			$this->load_file( self::slug . '-script', '/js/widget.js', true );
			$this->load_file( self::slug . '-style', '/css/widget.css' );
		} // end if/else
	} // end register_scripts_and_styles*/
	
	/**
	 * Helper function for registering and enqueueing scripts and styles.
	 *
	 * @name	The 	ID to register with WordPress
	 * @file_path		The path to the actual file
	 * @is_script		Optional argument for if the incoming file_path is a JavaScript source file.
	 */
	private function load_file( $name, $file_path, $is_script = false ) {

		$url = plugins_url($file_path, __FILE__);
		$file = plugin_dir_path(__FILE__) . $file_path;

		if( file_exists( $file ) ) {
			if( $is_script ) {
				wp_register_script( $name, $url, array('jquery') ); //depends on jquery
				wp_enqueue_script( $name );
			} else {
				wp_register_style( $name, $url );
				wp_enqueue_style( $name );
			} // end if
		} // end if

	} // end load_file
  
} // end class
new wordpress2androidapp();

?>