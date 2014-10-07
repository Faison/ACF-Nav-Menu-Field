<?php
/*
Plugin Name: Advanced Custom Fields: Nav Menu Field
Plugin URI: http://faisonz.com/wordpress-plugins/advanced-custom-fields-nav-menu-field/
Description: Add-On plugin for Advanced Custom Fields (ACF) that adds a 'Nav Menu' Field type.
Version: 1.1.2
Author: Faison Zutavern
Author URI: http://faisonz.com
License: GPL2 or later
*/


class acf_field_nav_menu_plugin
{
	/*
	*  Construct
	*
	*  @description: 
	*  @since: 3.6
	*  @created: 1/04/13
	*/
	
	function __construct()
	{
		// set text domain
		/*
		$domain = 'acf-nav_menu';
		$mofile = trailingslashit(dirname(__File__)) . 'lang/' . $domain . '-' . get_locale() . '.mo';
		load_textdomain( $domain, $mofile );
		*/
		
		
		// version 4+
		add_action('acf/register_fields', array($this, 'register_fields'));	

	}
	
	/*
	*  register_fields
	*
	*  @description: 
	*  @since: 3.6
	*  @created: 1/04/13
	*/
	
	function register_fields()
	{
		include_once('nav-menu-v4.php');
	}
	
}

new acf_field_nav_menu_plugin();
		
?>
