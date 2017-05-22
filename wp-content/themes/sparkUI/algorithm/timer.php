<?php
////system("python wp-content/themes/sparkUI/algorithm/sortWikiEntry.py 2>&1", $ret);
////exec("python wp-content/themes/sparkUI/algorithm/main.py 2>&1",$output, $ret);
////echo $ret."<br>" ;
////print_r($output);
////if ($ret == 0) {
//    //$filename = "postIDToSortedWikiEntryIDDict.json";
//    //$filename = "sorted_id.json";
//    $json_string = file_get_contents(get_template_directory_uri()."/algorithm/postIDToSortedWikiEntryIDDict.json");
//    $json_array = (array)json_decode($json_string);
//    print_r($json_array);
//    echo "<hr>";
//    foreach ($json_array as $key => $value) {
////key是项目id $value是对应的一组wikiid
//        echo $key;
//        print_r($value);
//        echo "<br>";
//    }
//    echo "<br>";
////

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
