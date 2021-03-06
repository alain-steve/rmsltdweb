<?php
/*
Plugin Name: Continuous announcement scroller
Plugin URI: http://www.gopiplus.com/work/2010/09/04/continuous-announcement-scroller/
Description: Continuous announcement scroller wordpress plugin create an announcement widget in the website, its not a simply message display instead the message will scroll vertically from bottom to top like roller and many message display at the same time.
Author: Gopi Ramasamy
Version: 13.0
Author URI: http://www.gopiplus.com/work/2010/09/04/continuous-announcement-scroller/
Donate link: http://www.gopiplus.com/work/2010/09/04/continuous-announcement-scroller/
Tags: Continuous, announcement, scroller, message
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Text Domain: continuous-announcement-scroller
Domain Path: /languages
*/

if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); }

global $wpdb, $wp_version, $cas_db_version;
$cas_db_version = "11.4";
define("WP_cas_TABLE", $wpdb->prefix . "cas_plugin");
define('cas_FAV', 'http://www.gopiplus.com/work/2010/09/04/continuous-announcement-scroller/');

if ( ! defined( 'WP_cas_BASENAME' ) )
	define( 'WP_cas_BASENAME', plugin_basename( __FILE__ ) );
	
if ( ! defined( 'WP_cas_PLUGIN_NAME' ) )
	define( 'WP_cas_PLUGIN_NAME', trim( dirname( WP_cas_BASENAME ), '/' ) );
	
if ( ! defined( 'WP_cas_PLUGIN_URL' ) )
	define( 'WP_cas_PLUGIN_URL', plugins_url() . '/' . WP_cas_PLUGIN_NAME );
	
if ( ! defined( 'WP_cas_ADMIN_URL' ) )
	define( 'WP_cas_ADMIN_URL', admin_url() . 'options-general.php?page=continuous-announcement-scroller' );


function cas() 
{
	echo cas_shortcode();
}

function cas_shortcode() 
{
	global $wpdb;
	$cas_html = "";
	$cas_x = "";
	$outstr = "";

	//[continuous-announcement-scroller group=""]
	$num_user = get_option('cas_total_rec');
	$dis_num_user = get_option('cas_dis_count');
	$dis_num_height = get_option('cas_rec_height');
	$cas_randomorder = get_option('cas_randomorder');
	
	$cas_speed = get_option('cas_speed');
	if(!is_numeric($cas_speed)) { $cas_speed = 2; }
	$cas_waitseconds = get_option('cas_waitseconds');
	if(!is_numeric($cas_waitseconds)) { $cas_waitseconds = 2; }
	
	if(!is_numeric($num_user))
	{
		$num_user = 5;
	} 
	if(!is_numeric($dis_num_height))
	{
		$dis_num_height = 30;
	}
	if(!is_numeric($dis_num_user))
	{
		$dis_num_user = 5;
	}

	$sSql = "select cas_text,cas_link from ".WP_cas_TABLE." where cas_status='YES'"; 
	$sSql = $sSql . " and (`cas_datestart` <= NOW() or `cas_datestart` = '0000-00-00')";
	$sSql = $sSql . " and (`cas_dateend` >= NOW() or `cas_dateend` = '0000-00-00')";
	if(trim($cas_randomorder) == "YES")
	{
		$sSql = $sSql . " ORDER BY rand()";
	}
	else
	{
		$sSql = $sSql . " ORDER BY cas_order";
	}
	$sSql = $sSql . " limit 0, $num_user";

	$data = $wpdb->get_results($sSql);

	$cas_data = $data;
	
	if ( ! empty($cas_data) ) 
	{
		$cas_count = 0;
		foreach ( $cas_data as $cas_data ) 
		{
			$cas_post_title = $cas_data->cas_text;
			
			$get_permalink = $cas_data->cas_link;
			
			//$cas_post_title = substr($cas_post_title, 0, 50);

			$dis_height = $dis_num_height."px";
			$cas_html = $cas_html . "<div class='cas_div' style='height:$dis_height;padding:2px 0px 2px 0px;'>"; 
			$cas_html = $cas_html . "<a href='$get_permalink'>$cas_post_title</a>";
			$cas_html = $cas_html . "</div>";
			
			$cas_post_title = trim($cas_post_title);
			$get_permalink = $get_permalink;
			$cas_x = $cas_x . "cas_array[$cas_count] = '<div class=\'cas_div\' style=\'height:$dis_height;padding:2px 0px 2px 0px;\'><a href=\'$get_permalink\'>$cas_post_title</a></div>'; ";	
			$cas_count++;
			
		}
		//$dis_num_height = $dis_num_height + 4;
		$dis_num_height = $dis_num_height + 0;
		if($cas_count >= $dis_num_user)
		{
			$cas_count = $dis_num_user;
			$cas_height = ($dis_num_height * $dis_num_user);
		}
		else
		{
			$cas_count = $cas_count;
			$cas_height = ($cas_count*$dis_num_height);
		}
		$cas_height1 = $dis_num_height."px";
		
		$outstr = '<div style="padding-top:8px;padding-bottom:8px;">';
			$outstr .= '<div style="text-align:left;vertical-align:middle;text-decoration: none;overflow: hidden; position: relative; margin-left: 1px; height: '.$cas_height1.';" id="cas_Holder">';
				$outstr .= $cas_html;
			$outstr .= '</div>';
		$outstr .= '</div>';
		
		$outstr .= '<script type="text/javascript">';
		$outstr .= 'var cas_array	= new Array();';
		$outstr .= "var cas_obj	= '';";
		$outstr .= "var cas_scrollPos 	= '';";
		$outstr .= "var cas_numScrolls	= '';";
		$outstr .= "var cas_heightOfElm = '".$dis_num_height."';";
		$outstr .= "var cas_numberOfElm = '".$cas_count."';";
		$outstr .= "var cas_speed 		= '".$cas_speed."';";
        $outstr .= "var cas_waitseconds = '".$cas_waitseconds."';";
		$outstr .= "var cas_scrollOn 	= 'true';";
		$outstr .= 'function cas_createscroll() ';
		$outstr .= '{';
			$outstr .= $cas_x;
			$outstr .= "cas_obj	= document.getElementById('cas_Holder');";
			$outstr .= "cas_obj.style.height = (cas_numberOfElm * cas_heightOfElm) + 'px';";
			$outstr .= "cas_content();";
		$outstr .= '}';
		$outstr .= '</script>';
		$outstr .= '<script type="text/javascript">';
		$outstr .= 'cas_createscroll();';
		$outstr .= '</script>';
		
	}
	else
	{
		$outstr = 'No data available!';
	}
	return $outstr;
}

function cas_install() 
{
	global $wpdb, $cas_db_version;
	
	$cas_pluginversion = "";
	$cas_tableexists = "YES";
	$cas_pluginversion = get_option("cas_pluginversion");
	
	if($wpdb->get_var("show tables like '". WP_cas_TABLE . "'") != WP_cas_TABLE)
	{
		$cas_tableexists = "NO";
	}
	
	if(($cas_tableexists == "NO") || ($cas_pluginversion != $cas_db_version)) 
	{
		$sSql = "CREATE TABLE ". WP_cas_TABLE . " (
			 cas_id mediumint(9) NOT NULL AUTO_INCREMENT,
			 cas_text text NOT NULL,
			 cas_order int(11) NOT NULL default '0',
			 cas_status char(3) NOT NULL default 'YES',
			 cas_date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,	 
			 cas_link VARCHAR(1024) DEFAULT '#' NOT NULL,
			 cas_group VARCHAR(100) DEFAULT 'GROUP1' NOT NULL,
			 cas_dateend datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
			 cas_datestart datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
			 UNIQUE KEY cas_id (cas_id)
		  ) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sSql );
		
		if($cas_pluginversion == "")
		{
			add_option('cas_pluginversion', "11.4");
		}
		else
		{
			update_option( "cas_pluginversion", $cas_db_version );
		}
		
		if($cas_tableexists == "NO")
		{
			$welcome_text = "This is simply dummy announcement text.";	
			$rows_affected = $wpdb->insert( WP_cas_TABLE , array( 'cas_text' => $welcome_text) );
			$rows_affected = $wpdb->insert( WP_cas_TABLE , array( 'cas_text' => $welcome_text) );
			$rows_affected = $wpdb->insert( WP_cas_TABLE , array( 'cas_text' => $welcome_text) );
		}
	}
	
	add_option('cas_title', "Announcement Scroller");
	add_option('cas_total_rec', "10");
	add_option('cas_dis_count', "5");
	add_option('cas_rec_height', "60");
	add_option('cas_randomorder', "YES");
	add_option('cas_speed', "2");
	add_option('cas_waitseconds', "2");
}

function cas_control() 
{
	_e('Continuous announcement scroller', 'continuous-announcement-scroller');
}

function cas_widget($args) 
{
	extract($args);
	echo $before_widget . $before_title;
	echo get_option('cas_title');
	echo $after_title;
	echo cas_shortcode();
	echo $after_widget;
}

function cas_admin_options() 
{
	global $wpdb;
	$current_page = isset($_GET['ac']) ? $_GET['ac'] : '';
	switch($current_page)
	{
		case 'edit':
			include('pages/content-management-edit.php');
			break;
		case 'add':
			include('pages/content-management-add.php');
			break;
		case 'set':
			include('pages/content-setting.php');
			break;
		default:
			include('pages/content-management-show.php');
			break;
	}
}

function cas_add_to_menu() 
{
	add_options_page(__('Continuous announcement scroller', 'continuous-announcement-scroller'), 
				__('Continuous announcement scroller', 'continuous-announcement-scroller'), 'manage_options', 'continuous-announcement-scroller', 'cas_admin_options' );
}

if (is_admin()) 
{
	add_action('admin_menu', 'cas_add_to_menu');
}

function cas_init()
{
	if(function_exists('wp_register_sidebar_widget')) 
	{
		wp_register_sidebar_widget('continuous-announcement-scroller', 
					__('Continuous announcement scroller', 'continuous-announcement-scroller'), 'cas_widget');
	}
	
	if(function_exists('wp_register_widget_control')) 
	{
		wp_register_widget_control('continuous-announcement-scroller', 
					array( __('Continuous announcement scroller', 'continuous-announcement-scroller'), 'widgets'), 'cas_control');
	} 
}

function cas_deactivation() 
{
	delete_option('cas_title');
	delete_option('cas_dis_count');
	delete_option('cas_total_rec');
	delete_option('cas_rec_height');
	
	delete_option('cas_speed');
	delete_option('cas_waitseconds');
}

function cas_add_javascript_files() 
{
	if (!is_admin())
	{
		wp_enqueue_script( 'continuous-announcement-scroller', WP_cas_PLUGIN_URL.'/continuous-announcement-scroller.js');
	}	
}

function cas_textdomain() 
{
	  load_plugin_textdomain( 'continuous-announcement-scroller', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}

function cas_adminscripts() 
{
	if( !empty( $_GET['page'] ) ) 
	{
		switch ( $_GET['page'] ) 
		{
			case 'continuous-announcement-scroller':
				wp_register_script( 'cas-adminscripts', plugins_url( 'pages/setting.js', __FILE__ ), '', '', true );
				wp_enqueue_script( 'cas-adminscripts' );
				$cas_select_params = array(
					'cas_text'   	=> __( 'Please enter the announcement.', 'cas-select', 'continuous-announcement-scroller' ),
					'cas_link'   	=> __( 'Please enter the link.', 'cas-select', 'continuous-announcement-scroller' ),
					'cas_status' 	=> __( 'Please select the display status.', 'cas-select', 'continuous-announcement-scroller' ),
					'cas_order'  	=> __( 'Please enter the display order, only number.', 'cas-select', 'continuous-announcement-scroller' ),
					'cas_delete'	=> __( 'Do you want to delete this record?', 'cas-select', 'continuous-announcement-scroller' ),
				);
				wp_localize_script( 'cas-adminscripts', 'cas_adminscripts', $cas_select_params );
				break;
		}
	}
}

add_shortcode('continuous-announcement-scroller', 'cas_shortcode');
add_action('plugins_loaded', 'cas_textdomain');
add_action('init', 'cas_add_javascript_files');
add_action("plugins_loaded", "cas_init");
register_activation_hook(__FILE__, 'cas_install');
register_deactivation_hook(__FILE__, 'cas_deactivation');
add_action( 'admin_enqueue_scripts', 'cas_adminscripts' );
?>