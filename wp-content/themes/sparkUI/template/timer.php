<?php
/**
 * Created by PhpStorm.
 * User: zhangxue
 * Date: 17/5/19
 * Time: 上午9:21
 */
    
    system("python ".get_stylesheet_directory_uri()."/algorithm/sortWikiEntry.py",$ret);
    deleteRelation();
    $json_string = file_get_contents(get_stylesheet_directory_uri()."/algorithm/postIDToSortedWikiEntryIDDict.json");
    $json_array = (array)json_decode($json_string);
    foreach($json_array as $key =>$value) {
        //key是项目id $value是对应的一组wikiid
        updateRelation($key,$value);
        echo $key."&nbsp&nbsp&nbsp&nbsp";
        print_r($value);
        echo "<br>";
    }
