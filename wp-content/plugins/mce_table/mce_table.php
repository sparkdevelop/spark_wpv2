<?php
/*
Plugin Name: TinyMCE Plugins
Plugin URI: http://www.sparkspace.net
Description: Add Plugins to TinyMCE.
Author: zyl
Version: 2.0
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

add_filter('mce_external_plugins', 'mce_code_plugin' );

function mce_code_plugin(  $plugins ) {
    $plugins['code'] = plugin_dir_url( __FILE__ ) .'code/plugin.js';

    return $plugins;
}

add_filter("mce_buttons", "mce_code");
function mce_code($buttons) {
    $buttons[] = 'code';
    return $buttons;
}

add_filter('mce_external_plugins', 'mce_codesample_plugin' );

function mce_codesample_plugin(  $plugins ) {
    $plugins['codesample'] = plugin_dir_url( __FILE__ ) .'codesample/plugin.js';

    return $plugins;
}

add_filter("mce_buttons", "mce_codesample");
function mce_codesample($buttons) {
    $buttons[] = 'codesample';
    return $buttons;
}