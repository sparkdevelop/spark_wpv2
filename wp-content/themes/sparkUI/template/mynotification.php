<?php

/**
 * 根据数组中元素个数生成数据库结构语句， 类似（$i,$j）
 * @param $item_array
 * @return string
 */
function generate_sql_structure($item_array) {
    $item_array_str = "";
    if(count($item_array)>0) {
        $item_array_str = "";
        for($i=0;$i<count($item_array);$i++) {
            if($i == 0) {
                $item_array_str = "(".$item_array[$i].",";
                continue;
            }
            if($i == count($item_array)-1){
                $item_array_str = $item_array_str.$item_array[$i].")";
                continue;
            }
            $item_array_str = $item_array_str.$item_array[$i].",";
        }
        if(count($item_array) == 1) {
            $item_array_str = "(".$item_array[0].")";
        }
    }
    return $item_array_str;
}

global $wpdb;
$current_user = wp_get_current_user();
$current_user_id = $current_user->ID;

//获取评论当前用户的数据
//$user_posts = $wpdb->get_results("select * from $wpdb->posts where post_author=".$current_user_id);
$user_posts = $wpdb->get_results("select * from $wpdb->posts where post_author=".$current_user_id);
$user_post_ids = array();
foreach($user_posts as $item) {
    $user_post_ids[] = $item->ID;
}
$comments_user = array();
$comments_posts_ids = generate_sql_structure($user_post_ids);
if($comments_posts_ids != "") {
    $comments_to_current_user_posts = $wpdb->get_results("select * from $wpdb->comments where comment_post_ID in ".$comments_posts_ids." and comment_parent=0");
    foreach($comments_to_current_user_posts as $item) {
        $comments_user[] = $item;
    }
}

//获取回复当前用户的数据
$user_all_comments = $wpdb->get_results("select * from $wpdb->comments where user_id=".$current_user_id);
$user_comments_ids = array();
foreach($user_all_comments as $item) {
    $user_comments_ids[] = $item->comment_ID;
}
$user_comments_ids_str = generate_sql_structure($user_comments_ids);
$user_replys = array();
if($user_comments_ids_str != "") {
    $replys = $wpdb->get_results("select * from $wpdb->comments where comment_parent in ".$user_comments_ids_str);
    foreach($replys as $item) {
        $user_replys[] = $item;
    }
}

//获取问答数据 wiki
$related_qas = array();
$user_post_qa_ids = generate_sql_structure($user_post_ids);
if($user_post_qa_ids != "") {
    //$qas = $wpdb->get_results("select * from wp_relation r left join wp_posts p on r.related_id=p.ID where r.post_id in ".$user_post_qa_ids." and r.post_type=\"yada_wiki\" and r.related_post_type=\"dwqa-question\"");
    $qas = $wpdb->get_results("select * from wp_relation r left join wp_posts p on r.related_id=p.ID where r.post_id in ".$user_post_qa_ids." and r.post_type in (\"yada_wiki\", \"post\") and r.related_post_type=\"dwqa-question\"");
    foreach($qas as $item) {
        $related_qas[] = $item;
    }
}
//echo "one$$$$$$$$$$$$$$$$$$:";
//foreach ($comments_user as $item) {
//    echo $item->comment_content;
//    echo "<br>";
//}
//echo "two$$$$$$$$$$$$$$$$$$:";
//foreach ($user_replys as $item) {
//    echo $item->comment_content;
//    echo "<br>";
//}
//echo "three$$$$$$$$$$$$$$$$$$:";
//foreach ($related_qas as $item) {
//    echo $item->post_title;
//    echo "<br>";
//}


//获取当前用户收到的答案
$user_all_questions = $wpdb->get_results("select * from $wpdb->posts where post_author=".$current_user_id." and post_type = \"dwqa-question\" and post_parent=0");
$user_question_ids = array();
foreach($user_all_questions as $item) {
    $user_question_ids[] = $item->ID;
}
$user_receive_answer = array();
$parent_questions = generate_sql_structure($user_question_ids);
if($parent_questions != "") {
    $user_receive_answer_result = $wpdb->get_results("select * from $wpdb->posts where post_type = \"dwqa-answer\" and post_parent in ".$parent_questions);
    foreach($user_receive_answer_result as $item) {
        $user_receive_answer[] = $item;
    }
}

//获取被采纳的答案
$user_best_answers_result = $wpdb->get_results("select * from $wpdb->posts p left join $wpdb->postmeta pm on pm.meta_value=p.ID where p.post_type=\"dwqa-answer\" and pm.meta_key=\"_dwqa_best_answer\" and p.post_author=".$current_user_id);
$user_best_answer = array();
foreach($user_best_answers_result as $item) {
    $user_best_answer[] = $item;
}

//获取点赞的数据，解析meta中的表达式
$user_answer_favor_result = $wpdb->get_results("select * from $wpdb->posts p left join $wpdb->postmeta pm on p.ID=pm.post_id where p.post_type=\"dwqa-answer\" and pm.meta_key=\"_dwqa_votes_log\" and p.post_author=".$current_user_id);
$user_answer_favors = array();
foreach($user_answer_favor_result as $item) {
    $meta_value = $item->meta_value;
    $meta_value_explode = explode('{', $meta_value);
    $meta_value_explode1 = $meta_value_explode[1];
    $meta_value_explode = explode(';', $meta_value_explode1);
    $favour_users = array();
    for($index=0;$index<count($meta_value_explode);$index++) {
        if($index%2 == 0) {
            $favour_users[] = substr($meta_value_explode[$index], -1);
        }
    }
    $str_index = $item->post_id + '';
    $user_answer_favors[$str_index] = $favour_users;
}

//echo "one$$$$$$$$$$$$$$$$$$:";
//foreach ($comments_user as $item) {
//    echo $item->comment_content;
//    echo "<br>";
//}
//echo "<br>";
//echo "two$$$$$$$$$$$$$$$$$$:";
//foreach ($user_replys as $item) {
//    echo $item->comment_content;
//    echo "<br>";
//}
//echo "<br>";
//echo "three$$$$$$$$$$$$$$$$$$:";
//foreach ($related_qas as $item) {
//    echo $item->post_title;
//    echo "<br>";
//}
//echo "<br>";
//echo "four$$$$$$$$$$$$$$$$$$:";
//foreach ($user_receive_answer as $item) {
//    echo $item->post_content;
//    echo "<br>";
//}
//echo "<br>";
//echo "five$$$$$$$$$$$$$$$$$$:";
//foreach ($user_best_answer as $item) {
//    echo $item->post_id;
//    echo "<br>";
//}
//echo "<br>";
//echo "six$$$$$$$$$$$$$$$$$$:";
//foreach ($user_answer_favors as $key => $value) {
//    echo $key;
//    echo "<br>";
//}
//
//
//echo "<br><hr>";