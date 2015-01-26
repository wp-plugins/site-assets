<?php
/*
Plugin Name: Site Assets
Plugin URI: http://www.monatanb.com
Description: Site Assets is a tool to easily share website assets on a per page basis. This is most helpful on site with multiple contributors and developers.
Version: 1.1
Contributors: montanab, abda53
Author: Montana Banana
Author URI: http://www.monatanb.com

Copyright (c) 2014 a 53 minute production

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.

*/ 



//////////////////////////////////////////////////////
//admin menu

require_once ABSPATH . WPINC . '/pluggable.php';
require_once 'inc/site_assets_functions.php';


/// can the user edit?
$get_site_assets_manage =  @array_map('strtolower', json_decode(get_option('site_assets_manage')));
$user = new WP_User(get_current_user_id());
$user_roles = $user->roles;
$site_assets_manage =  @array_map('strtolower', json_decode(get_option('site_assets_manage')));
$can_manage = @array_intersect($site_assets_manage, $user_roles);
if(count($can_manage)>0){require_once 'inc/site_assets_meta.php';}
/// end can the user edit?


/// can the user view?
$get_site_assets_manage =  @array_map('strtolower', json_decode(get_option('site_assets_manage')));
$user = new WP_User(get_current_user_id());
$user_roles = $user->roles;
$site_assets_manage =  @array_map('strtolower', json_decode(get_option('site_assets_manage')));
$can_manage = @array_intersect($site_assets_manage, $user_roles);
if(count($can_manage)>0){require_once 'inc/site_assets_view.php';}
/// end can the user edit?


//admin menu
function site_assets_menu() {
	global $user_ID;

    if($user_ID && $user_ID>0){
    	if(current_user_can('level_10')==1){
			add_options_page( 'Site Assets', 'Site Assets', 'manage_options', 'site-assets', 'site_assets_admmin' );
		}
	}
}
add_action( 'admin_menu', 'site_assets_menu' );

if(is_admin()){
    wp_enqueue_script('site_assets', plugins_url('assets/js/jquery.autosize.min.js', __FILE__), array('jquery'));
    
}

function site_assets_admmin() {
	require_once 'inc/site_assets_admin.php';
}


function load_site_assets_admin_files() {
    wp_register_style( 'site_assets_admin_styles', plugins_url('assets/css/site_assets_admin.css', __FILE__), false, '1.0.0.'.time() );
    wp_enqueue_style( 'site_assets_admin_styles' );
}
add_action( 'admin_enqueue_scripts', 'load_site_assets_admin_files' );

function load_site_assets_files() {
    wp_register_style( 'site_assets_styles', plugins_url('assets/css/site_assets_frontend.css', __FILE__), false, '1.0.0.'.time() );
    wp_enqueue_style( 'site_assets_styles' );
}
add_action( 'wp_enqueue_scripts', 'load_site_assets_files' );
    


//deactivating? :(
if ( function_exists('register_uninstall_hook') ){    
    function deactivate_site_assets(){
        delete_option('site_assets_manage');
        delete_option('site_assets_view');
    }
    register_uninstall_hook( __FILE__, 'deactivate_site_assets' );    
}
