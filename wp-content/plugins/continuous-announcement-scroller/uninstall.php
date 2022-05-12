<?php

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit();
}

delete_option('cas_pluginversion');
delete_option('cas_title');
delete_option('cas_total_rec');
delete_option('cas_dis_count');
delete_option('cas_rec_height');
delete_option('cas_randomorder');
delete_option('cas_speed');
delete_option('cas_waitseconds');
 
// for site options in Multisite
delete_site_option('cas_pluginversion');
delete_site_option('cas_title');
delete_site_option('cas_total_rec');
delete_site_option('cas_dis_count');
delete_site_option('cas_rec_height');
delete_site_option('cas_randomorder');
delete_site_option('cas_speed');
delete_site_option('cas_waitseconds');

global $wpdb;
$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}cas_plugin");