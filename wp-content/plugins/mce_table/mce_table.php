<?php
/*
Plugin Name: TinyMCE Table
Plugin URI: http://www.sparkspace.net
Description: Add Table to TinyMCE.
Author: zyl
Version: 1.0
Author URI: http://www.sparkspace.net
*/

add_filter('mce_external_plugins', 'mce_table_plugin' );

function mce_table_plugin(  $plugins ) {
    $plugins['table'] = plugin_dir_url( __FILE__ ) .'table/plugin.js';

    return $plugins;
}

add_filter("mce_buttons", "mce_table");
function mce_table($buttons) {
    $buttons[] = 'table';
    return $buttons;
}

