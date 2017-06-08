<?php
//system("python wp-content/themes/sparkUI/algorithm/ 2>&1", $ret);


//exec("python wp-content/themes/sparkUI/algorithm/sortWikiEntry.py",$output, $ret);
//if ($ret == 0) {
//    deleteRelation();
//    $json_string = $output[0];
//    $json_array = (array)json_decode($json_string);
//    foreach ($json_array as $key => $value) {
//        //key是项目id $value是对应的一组wikiid
//        updateRelation($key, $value);
//        echo $key . "&nbsp&nbsp&nbsp&nbsp";
//        print_r($value);
//        echo "<br>";
//    }
//}

//刷新xml表内容
    //updateContentItem();
    insertContentItem(14);