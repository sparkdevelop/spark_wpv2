<?php
/**
 * @author        Ramen Dey & Bivash Kanti Pal <contact@blogfordeveloper.com>
 * @package        Search Statistics
 * @version        1.0.0
 * @copyright    20013 -  blogfordeveloper.com
 * @license        GNU GPL
 *
 *    This program is free software; you can redistribute it and/or modify
 *    it under the terms of the GNU General Public License as published by
 *    the Free Software Foundation; either version 2 of the License, or
 *    (at your option) any later version.
 *
 *    This program is distributed in the hope that it will be useful,
 *    but WITHOUT ANY WARRANTY; without even the implied warranty of
 *    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 *    GNU General Public License for more details.
 */


$referer = '';
$search_engine = '';
$repeat_coount = '';

/**
 *  Saves keyword and referer info to db
 *  存储搜索的内容
 *  $keyword: 搜索关键词
 *  $referer: 前一页面地址
 */
function save_keyword($keyword, $referer)
{
    global $wpdb;
    if (!$keyword) return false;//如果没有搜索内容 就不存储
    $date = date('YmdHi');
    $referer_info = parse_url($referer);

    $mySearch =& new WP_Query("s=$keyword & showposts=-1");
    $NumResults = $mySearch->post_count;

    if (is_user_logged_in()) {
        global $current_user;
        get_currentuserinfo();
        $user = $current_user->ID;
    } else {
        $user = 'Non-Registered';
    }

    //---------用户搜索记录存储 开始-------------
    date_default_timezone_set("Asia/Shanghai");
    $dt = new DateTime();
    $wpdb->insert(SEARCHDATAS, array(
        'words' => $keyword,
        'date' => $dt->format('Y-m-d H:i:s'),
        'source' => $referer_info['host'],
        'user_id' => $user,
        'agent' => $_SERVER['HTTP_USER_AGENT']
        ), array(
        '%s', '%s', '%s', '%s', '%s'));
    //---------用户搜索记录存储 结束-------------

    $search_count = search_count($keyword, $user);
    $repeat_coount = repeat_count($keyword, $user);


    if ($repeat_coount != null) {
        if (is_numeric($user))
            $row = $wpdb->get_var("SELECT id FROM " . SS_TABLE . " WHERE keywords = '" . mysql_escape_string($keyword) . "' and user='" . mysql_escape_string($user) . "'");
        else
            $row = $wpdb->get_var("SELECT id FROM " . SS_TABLE . " WHERE keywords = '" . mysql_escape_string($keyword) . "'");

        $wpdb->update(SS_TABLE, array(
            'query_date' => $date,
            'repeat_count' => ++$repeat_coount,
            'search_count' => $NumResults),
            array('id' => $row),
            array(
                '%s', '%s', '%s', '%s', '%s', '%d', '%d'));
    } else {
        $wpdb->insert(SS_TABLE, array(
            'keywords' => $keyword,
            'query_date' => $date,
            'source' => $referer_info['host'],
            'user' => $user,
            'agent' => $_SERVER['HTTP_USER_AGENT'],
            'repeat_count' => 0,
            'search_count' => $NumResults), array(
            '%s', '%s', '%s', '%s', '%s', '%d', '%d'));

    }




}

/**
 * Count repeat if user and keyword matched
 * 查询用户重复搜索次数
 */

function repeat_count($keyword, $user)
{
    global $wpdb;
    if (is_numeric($user))
        $repeat_count = $wpdb->get_var("SELECT repeat_count FROM " . SS_TABLE . " WHERE keywords ='" . mysql_escape_string($keyword) . "' and user='" . mysql_escape_string($user) . "'");
    else {
        //echo "SELECT repeat_count FROM " . SS_TABLE . " WHERE keywords ='" . mysql_escape_string($keyword)."'";
        $repeat_count = $wpdb->get_var("SELECT repeat_count FROM " . SS_TABLE . " WHERE keywords ='" . mysql_escape_string($keyword) . "'");
    }

    return $repeat_count;

}


/**
 * Count repeat if user and keyword matched
 * 查询永福总搜索次数
 */

function search_count($keyword, $user)
{
    global $wpdb;
    if (is_numeric($user))
        $search_count = $wpdb->get_var("SELECT search_count FROM " . SS_TABLE . " WHERE keywords LIKE '" . $keyword . "' and user='" . $user . "'");
    return $search_count;

}

?>