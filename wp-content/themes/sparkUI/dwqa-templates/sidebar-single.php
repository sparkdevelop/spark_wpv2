<?php
/**
 * Created by PhpStorm.
 * User: zhangxue
 * Date: 17/3/30
 * Time: 下午2:41
 */
//为相似标签做准备

//$tags = get_terms( 'dwqa-question_tag', array_merge( array( 'orderby' => 'count', 'order' => 'DESC' ) ) ); // Always query top tags
//
//foreach ( $tags as $key => $tag ) {
//           // get_term_link( intval($tag->term_id), $tag->taxonomy );
//    $link = get_edit_term_link( $tag->term_id, $tag->taxonomy, 'dwqa-question' );
//    if ( is_wp_error( $link ) )
//        echo "error";
//    $tags[ $key ]->link = $link;
//    $tags[ $key ]->id = $tag->term_id;
//}
//print_r($link);

//为全部标签做准备。
global $wpdb;
$tag_id = array();
$tag_name = array();//存储每个链接的名字;
$link = array(); // 存储每个标签的链接;
$tag_count = array();
//==============获取所有tag的id信息===============
$tags = get_terms( 'dwqa-question_tag', array_merge( array( 'orderby' => 'count', 'order' => 'DESC' )));
//=============================
foreach($tags as $key => $temp){
    $tag_id[]=$temp->term_id;
    $tag_name[]=$temp->name;
    $tag_count[]=$temp->count;
    array_push($link,get_term_link(intval($tag_id[$key]), 'dwqa-question_tag'));
}

//为相似问题做准备
function Spark_related_question( $question_id = false, $number = 5, $echo = true ) {
    if ( ! $question_id ) {
        $question_id = get_the_ID();
    }
    $tag_in = $cat_in = array();
    $tags = wp_get_post_terms( $question_id, 'dwqa-question_tag' );
    if ( ! empty($tags) ) {
        foreach ( $tags as $tag ) {
            $tag_in[] = $tag->term_id;
        }
    }

    $category = wp_get_post_terms( $question_id, 'dwqa-question_category' );
    if ( ! empty($category) ) {
        foreach ( $category as $cat ) {
            $cat_in[] = $cat->term_id;
        }
    }
    $args = array(
        'orderby'       => 'rand',
        'post__not_in'  => array($question_id),
        'showposts'     => $number,
        'ignore_sticky_posts' => 1,
        'post_type'     => 'dwqa-question',
    );

    $args['tax_query']['relation'] = 'OR';
    if ( ! empty( $cat_in ) ) {
        $args['tax_query'][] = array(
            'taxonomy'  => 'dwqa-question_category',
            'field'     => 'id',
            'terms'     => $cat_in,
            'operator'  => 'IN',
        );
    }
    if ( ! empty( $tag_in ) ) {
        $args['tax_query'][] = array(
            'taxonomy'  => 'dwqa-question_tag',
            'field'     => 'id',
            'terms'     => $tag_in,
            'operator'  => 'IN',
        );
    }
    $related_questions = new WP_Query( $args );

    if ( $related_questions->have_posts() ) {
        if ( $echo ) {?>
            <ul class="list-group">
                <?php
                while ( $related_questions->have_posts() ) {
                    $related_questions->the_post();?>
                    <li class="list-group-item">
                        <a href="<?php echo get_permalink()?>" class="question-title">
                            <?php echo get_the_title();?>
                        </a>
<!--                        <span style="float:right">--><?php //the_author_posts_link()?><!--</span>-->
                    </li>
                <?php }?>
            </ul>
        <?php }
    }
    wp_reset_postdata();
}
?>
<?php
//埋数据点
session_start();
$_SESSION['post_id'] = get_the_ID();
$_SESSION['post_type'] =get_post_type(get_the_ID());
$_SESSION['user_id'] = get_current_user_id();
$_SESSION['timestamp'] = date("Y-m-d H:i:s",time() + 8*3600);
writeUserTrack();
?>
<!--全部标签-->
<script>
    flag=false;
    function show_all_tags() {
        var $all_tags=document.getElementById('all_tags');
        var $hot_tags = document.getElementById('hot_tags');
        if(flag){
            $all_tags.style.display ="block";
            $hot_tags.style.display="none";
        }else{
            $all_tags.style.display="none";
            $hot_tags.style.display="block";
        }
        flag=!flag;
    }
</script>
<style>
    .label-default[href]:focus,
    .label-default[href]:hover{background-color: transparent;outline: none;color: #fe642d}
    #buttonForAllTags{  outline: none;border:0px;color:gray;float: right;display: inline-block;margin-top: 20px;padding: 0 12px}
</style>

<div class="col-md-3 col-sm-3 col-xs-3 right" id="col3">

    <div class="sidebar_button" style="margin-top: 20px">
        <a href="<?php echo site_url().get_page_address('ask');?>" style="color: white">我要提问</a>
    </div>
<!--热门标签-->
    <div class="sidebar_list">
        <div class="sidebar_list_header">
            <p>热门标签</p>
            <a id="sidebar_list_link" onclick="show_all_tags()">全部标签</a>
        </div>
        <!--                分割线-->
        <div class="sidebar_divline"></div>


        <div id="hot_tags" style="word-wrap: break-word; word-break: keep-all;">
            <h4>
                <?php
                for($i=0;$i<9;$i++){?>
                    <a class="label label-default" href="<?=$link[$i]?>"><?=$tag_name[$i]?><span class="badge">(<?=$tag_count[$i]?>)</span></a>
                <?php  } ?>
            </h4>
        </div>

        <div id="all_tags" style="display: none;word-wrap: break-word; word-break: keep-all;">
            <h4>
                <?php
                foreach ($tag_name as $key =>$i){?>
                    <a class="label label-default" href="<?=$link[$key]?>"><?=$i?><span class="badge">(<?=$tag_count[$key]?>)</span></a>
                <?php }
                ?>
            </h4>
        </div>
    </div>





<!--注释中为相似标签-->
<!--    <div class="related_tags">-->
<!--        <div class="sidebar_list_header">-->
<!--            <p>相似标签</p>-->
<!--            <button id="buttonForAllTags" class="btn btn-default" onclick="show_all_tags()" style="">全部标签</button>-->
<!--        </div>-->
<!--        <!--分割线-->
<!--        <div style="height: 2px;background-color: lightgray"></div>-->
<!--        <div id="related_tags" style="display:block;word-wrap: break-word; word-break: keep-all;">-->
<!--            <h4>-->
<!--                --><?php
//                for($i=0;$i<9;$i++){?>
<!--                    <a class="label label-default">-->
<!--                        舵机<span class="badge">(40)</span>-->
<!--                    </a>-->
<!--                --><?php // } ?>
<!--            </h4>-->
<!--        </div>-->
<!--        <div id="all_tags" style="display: none;word-wrap: break-word; word-break: keep-all;">-->
<!--            <h4>-->
<!--                --><?php
//                foreach ($tag_name as $key =>$i){?>
<!--                    <a class="label label-default" href="--><?//=$link[$key]?><!--">--><?//=$i?><!--<span class="badge">(--><?//=$tag_count[$key]?><!--)</span></a>-->
<!--                --><?php //}
//                ?>
<!--            </h4>-->
<!--        </div>-->
<!--    </div>-->
    <!--    相似问题-->
    <?php
    $instance = wp_parse_args( $instance, array('number' => 3,) );
    $post_type = get_post_type();
    if ( is_single() && ( $post_type == 'dwqa-question' || $post_type == 'dwqa-answer' ) ) {?>
        <div class="related_questions">
            <div class="sidebar_list_header">
                <p>相似问题</p>
            </div>
            <!--分割线-->
            <div style="height: 2px;background-color: lightgray"></div>
            <?php Spark_related_question( false, $instance['number'] ); ?>
        </div>
        <?php
    }
    ?>
</div>

