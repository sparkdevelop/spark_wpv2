<?php
//system("python wp-content/themes/sparkUI/algorithm/sortWikiEntry.py 2>&1", $ret);

//更新相关wiki与项目相关度
//exec("python wp-content/themes/sparkUI/algorithm/sortWikiEntry.py",$output, $ret);
//if ($ret == 0) {
    $file_url = "wp-content/themes/sparkUI/algorithm/postIDToSortedWikiEntryIDDict.json";
    $jsonString = file_get_contents($file_url);
    $json_array = (array)json_decode($jsonString);
    //print_r($json_array);
    deleteRelation();
//    $json_string = $output[0];
//    $json_array = (array)json_decode($json_string);
    foreach ($json_array as $key => $value) {
        updateRelation($key, $value);
    }
    echo "success";
//}
//else{
//    echo "error";
//}

//刷新xml表内容
//    updateContentItem('yada_wiki');
//    updateContentItem('post');

//插入实体表内容
    //updateInsertEntity();

//print_r(get_verify_type(3));
