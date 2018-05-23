<?php
/**
 * The template for displaying question archive pages
 *
 * @package DW Question & Answer
 * @since DW Question & Answer 1.4.3
 */
$tag_id = array();
$tag_name = array();//存储每个链接的名字;
$link = array(); // 存储每个标签的链接;
$tag_count = array();
//==============获取所有tag的id信息===============
$tags = get_terms( 'dwqa-question_tag', array_merge( array( 'orderby' => 'count', 'order' => 'DESC' )));
//=============================
foreach($tags as $key => $temp){
    $tag_id[]=$temp->term_id;
    $tag_count[]=$temp->count;
    $tag_name[]=$temp->name;
    array_push($link,get_term_link(intval($tag_id[$key]), 'dwqa-question_tag'));
}
//=============显示标签名==============
?>
<!--script for show_all_tags函数-->
<script>
    flag=false;
    function show_all_tags() {
        var $all_tags=document.getElementById('all_tags');
        var $related_tags = document.getElementById('hot_tags');
        if(flag){
            $all_tags.style.display ="block";
            $related_tags.style.display="none";
        }else{
            $all_tags.style.display="none";
            $related_tags.style.display="block";
        }
        flag=!flag;
    }
    //	window.onload=function(){
    //		var ul=document.getElementById("rightTab");
    //		var li=ul.getElementsByTagName("li");
    //		for(i=0;i<li.length;i++){
    //			li[i].onclick=function(){
    //				for(j=0;j<li.length;j++){
    //					li[j].className=""
    //				}
    //				this.className="active";
    //			}
    //		}
    //	};
</script>

<div class="col-md-9 col-sm-9 col-xs-9" id="col9">
    <div class="dwqa-questions-archive">
        <div class="archive-nav">
            <?php
            $term = get_query_var( 'dwqa-question_category' ) ?
                get_query_var( 'dwqa-question_category' ) : ( get_query_var( 'dwqa-question_tag' ) ?
                    get_query_var( 'dwqa-question_tag' ) : false );
            $term = get_term_by( 'slug', $term, get_query_var( 'taxonomy' ) );
            if('dwqa-question_tag' == get_query_var( 'taxonomy' )){?>
            <h4>问答标签：
                <span style="color: #fe642d"><?=$term->name?></span>
            </h4>
        <?php }
        elseif('dwqa-question_category' == get_query_var( 'taxonomy' )){
                    if($term->name=="hardware"){?>
                        <style>.archive-nav{margin-bottom:-8px;}</style>
                        <ul id="leftTab" class="nav nav-pills">
                            <li><a href="<?php echo remove_query_arg(array('dwqa-question_category','paged')) ?>">所有问题</a></li>
                            <li class="active"><a href="<?php echo esc_url( add_query_arg( array('dwqa-question_category'=>'hardware','paged'=>'1') ) ) ?>">开源硬件</a></li>
                            <li><a href="<?php echo esc_url( add_query_arg( array('dwqa-question_category'=>'web','paged'=>'1') ) ) ?>">web学习</a></li>
                        </ul>
                    <?php }
                    if($term->name=="web"){?>
                        <style>.archive-nav{margin-bottom:-8px;}</style>
                        <ul id="leftTab" class="nav nav-pills">
                            <li><a href="<?php echo remove_query_arg(array('dwqa-question_category','paged')) ?>">所有问题</a></li>
                            <li><a href="<?php echo esc_url( add_query_arg( array('dwqa-question_category'=>'hardware','paged'=>'1')) ) ?>">开源硬件</a></li>
                            <li  class="active"><a href="<?php echo esc_url( add_query_arg( array('dwqa-question_category'=>'hardware','paged'=>'1')) ) ?>">web学习</a></li>
                        </ul>
                    <?php }?>
        <?php } else{?>
                        <style>.archive-nav{margin-bottom:-8px;}</style>
                        <ul id="leftTab" class="nav nav-pills">
                            <li  class="active"><a href="<?php echo remove_query_arg(array('dwqa-question_category','paged')) ?>" >所有问题</a></li>
                            <li><a href="<?php echo esc_url( add_query_arg( array('dwqa-question_category'=>'hardware','paged'=>'1') ) ) ?>" >开源硬件</a></li>
                            <li><a href="<?php echo esc_url( add_query_arg( array('dwqa-question_category'=>'web','paged'=>'1') ) ) ?>" >web学习</a></li>
                        </ul>
                <?php }?>

        </div>
        <div style="display: inline-block;float: right;height: 42px;">
            <ul id="rightTab" class="nav nav-pills">
                <?php
                $current_url = curPageURL();
                $url_array=parse_url($current_url);
                $query_parse=explode("&",$url_array['query']);
                if(array_search("sort=views",$query_parse)){?>
                    <li  class="active"><a href="<?php echo esc_url(add_query_arg( array( 'sort' => 'views','filter'=>'all','paged'=>'1') ) )?>">热门</a></li>
                    <li><a href="<?php echo remove_query_arg(array('sort','filter','paged')) ?>">最新</a></li>
                    <li><a href="<?php echo esc_url( add_query_arg( array('sort'=>'date','filter' => 'unanswered','paged'=>'1') ) ) ?>" id="m-unresolved">未解决</a></li>
                <?php }elseif (array_search("filter=unanswered",$query_parse)){?>
                    <li><a href="<?php echo esc_url(add_query_arg( array( 'sort' => 'views','filter'=>'all' ,'paged'=>'1') ) )?>">热门</a></li>
                    <li><a href="<?php echo remove_query_arg(array('sort','filter','paged')) ?>">最新</a></li>
                    <li class="active"><a href="<?php echo esc_url( add_query_arg( array( 'sort' => 'date','filter' => 'unanswered','paged'=>'1') ) ) ?>" id="m-unresolved">未解决</a></li>
                <?php } else{ ?>
                    <li><a href="<?php echo esc_url(add_query_arg( array( 'sort' => 'views', 'paged'=>'1') ) )?>">热门</a></li>
                    <li class="active"><a href="<?php echo remove_query_arg(array('sort','filter','paged')) ?>">最新</a></li>
                    <li><a href="<?php echo esc_url( add_query_arg( array( 'sort' => 'date','filter' => 'unanswered','paged'=>'1'))) ?>" id="m-unresolved">未解决</a></li>
                <?php } ?>
            </ul>
        </div>

        <?php //do_action( 'dwqa_before_questions_archive' ) ?>
        <div class="dwqa-questions-list">
            <?php do_action( 'dwqa_before_questions_list' ) ?>
            <?php if ( dwqa_has_question() ) : ?>
                <?php while ( dwqa_has_question() ) : dwqa_the_question(); ?>
                    <?php if ( get_post_status() == 'publish' || ( get_post_status() == 'private' && dwqa_current_user_can( 'edit_question', get_the_ID() ) ) ) : ?>
                        <?php dwqa_load_template( 'Spark-content', 'question' ) ?>
                    <?php endif; ?>
                <?php endwhile; ?>
            <?php else : ?>
                <?php dwqa_load_template( 'content', 'none' ) ?>
            <?php endif; ?>
            <?php do_action( 'dwqa_after_questions_list' ) ?>
        </div>
        <div class="dwqa-questions-footer"  style="text-align: center;margin-bottom: 20px;margin-top: 10px">
            <?php Spark_question_paginate_link() ?>
        </div>

        <?php do_action( 'dwqa_after_questions_archive' ); ?>
    </div>

    <?php
    wp_reset_query();
    wp_reset_postdata();
    ?>
</div>
<style>
    .label-default[href]:focus,
    .label-default[href]:hover{background-color: transparent;outline: none;color: #fe642d}
    #buttonForAllTags{  outline: none;border:0px;color:gray;float: right;display: inline-block;margin-top: 20px;padding: 0 12px}
</style>
<div class="col-md-3 col-sm-3 col-xs-3 right" id="col3">
    <?php if(is_user_logged_in()){ ?>
        <div class="sidebar_button">
            <a href="<?php echo site_url().get_page_address('ask');?>" style="color: white">我要提问</a>
        </div>
    <?php }else{ ?>
        <div class="sidebar_button">
            <a href="<?php echo wp_login_url( get_permalink() ); ?>" style="color: white">我要提问</a>
        </div>
    <?php } ?>
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

    <!--雷锋榜ok-->
    <div class="sidebar_list">
        <div class="sidebar_list_header">
            <p>雷锋榜</p>
            <!--列表头-->
            <ul id="sidebar_list_choose" class="nav nav-pills">
                <li><a href="#helperday" data-toggle="tab">日</a></li>
                <li class="active"><a href="#helpermonth" data-toggle="tab">周</a></li>
            </ul>
        </div>
        <!--分割线 下面的是列表-->
        <div class="sidebar_divline"></div>
        <!--列表内容 需要填写的都用php提取出来就行-->
        <div id="helperTabContent" class="tab-content">
            <div class="tab-pane fade in active" id="helperday">
                <ul class="list-group">
                    <?php
                    $from_day=strtotime("-1 day")+8*3600;
                    $answer_most =array();
                    $answer_most=dwqa_user_most_answer(10,$from_day);
                    $answer_most_author_id = $answer_most[0]['post_author'];
                    for($i=0;$i<5;$i++){
                        ?>
                        <li class="list-group-item">
                            <img src="<?php bloginfo("template_url")?>/img/n<?php echo $i+1;?>.png" style="display: inline-block;margin-right: 10px;">
                            <?php echo get_avatar($answer_most[$i]['post_author'],20,'');?>
                            <a href="<?php echo site_url().get_page_address('otherpersonal').'&id='.$answer_most[$i]['post_author'];?>" class="author_link"><?php echo get_userdata($answer_most[$i]['post_author'])->display_name;?></a>
                            <p style="display: inline-block;float: right"><?php echo $answer_most[$i]['answer_count'];?> 答</p>
                        </li>
                        <?php
                    }
                    ?>
                </ul>
            </div>
            <div class="tab-pane fade" id="helpermonth">
                <ul class="list-group">
                    <?php
                    $from_week=strtotime("-1 week")+8*3600;
                    $answer_most_this_week = array();
                    $answer_most_this_week = dwqa_user_most_answer(10,$from_week);
                    //$answer_most_this_week_author_id = $answer_most_this_week[0]['post_author'];
                    for($i=0;$i<5;$i++){
                        ?>
                        <li class="list-group-item">
                            <img src="<?php bloginfo("template_url")?>/img/n<?php echo $i+1;?>.png" style="display: inline-block;margin-right: 10px;"/>
                            <?php echo get_avatar($answer_most_this_week[$i]['post_author'],20,'');?>
                            <a href="<?php echo site_url().get_page_address('otherpersonal').'&id='.$answer_most_this_week[$i]['post_author'];?>" class="author_link">
                                <?php echo get_userdata($answer_most_this_week[$i]['post_author'])->display_name;?>
                            </a>
                            <p style="display: inline-block;float: right"><?php echo $answer_most_this_week[$i]['answer_count'];?> 答
                            </p>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div><!--helper-->

    <!--好问榜-->
    <div class="sidebar_list">
        <div class="sidebar_list_header">
            <p>好问榜</p>
            <!--列表头-->
            <ul id="sidebar_list_choose" class="nav nav-pills">
                <li><a href="#askerday" data-toggle="tab">日</a></li>
                <li class="active"><a href="#askermonth" data-toggle="tab">周</a></li>
            </ul>
        </div>
        <!--分割线-->
        <div class="sidebar_divline"></div><!--下面的是列表

        <!--列表内容 需要填写的都用php提取出来就行-->
        <div id="askerTabContent" class="tab-content">
            <div class="tab-pane fade" id="askerday">
                <ul class="list-group">
                    <?php
                    $from_day=strtotime("-1 day")+8*3600;
                    $ask_most =array();
                    $ask_most=dwqa_user_most_ask(10,$from_day);
                    $ask_most_author_id = $ask_most[0]['post_author'];
                    for($i=0;$i<5;$i++){
                        ?>
                        <li class="list-group-item">
                            <img src="<?php bloginfo("template_url")?>/img/n<?php echo $i+1;?>.png" style="display: inline-block;margin-right: 10px;">
                            <?php echo get_avatar($ask_most[$i]['post_author'],20,'');?>
                            <a href="<?php echo site_url().get_page_address('otherpersonal').'&id='.$ask_most[$i]['post_author'];?>" class="author_link"><?php echo get_userdata($answer_most[$i]['post_author'])->display_name;?></a>
                            <p style="display: inline-block;float: right"><?php echo $ask_most[$i]['ask_count'];?> 问</p>
                        </li>
                        <?php
                    }
                    ?>
                </ul>
            </div>
            <div class="tab-pane fade in active" id="askermonth">
                <ul class="list-group">
                    <?php
                    $from_week=strtotime("-1 week")+8*3600;
                    $ask_most_this_week = array();
                    $ask_most_this_week = dwqa_user_most_ask(10,$from_week);
                    //$answer_most_this_week_author_id = $answer_most_this_week[0]['post_author'];
                    for($i=0;$i<5;$i++){
                        ?>
                        <li class="list-group-item">
                            <img src="<?php bloginfo("template_url")?>/img/n<?php echo $i+1;?>.png" style="display: inline-block;margin-right: 10px;"/>
                            <?php echo get_avatar($ask_most_this_week[$i]['post_author'],20,'');?>
                            <a href="<?php echo site_url().get_page_address('otherpersonal').'&id='.$ask_most_this_week[$i]['post_author'];?>" class="author_link">
                                <?php echo get_userdata($ask_most_this_week[$i]['post_author'])->display_name;?>
                            </a>
                            <p style="display: inline-block;float: right"><?php echo $ask_most_this_week[$i]['ask_count'];?> 问
                            </p>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div><!--asker-->

</div>

<?php
function Spark_question_paginate_link(){
    global $wp_query;
    $current_url= curPageURL();//设当前页面为archive页面
    //翻页所需参数
    $page_text = dwqa_is_front_page() ? 'page' : 'paged';
    $page = get_query_var( $page_text ) ? get_query_var( $page_text ) : 1;
    $args = array(
        'base' => add_query_arg($page_text, '%#%', $current_url),
        'format' => '',
        'current' => $page,
        'show_all' => false,
        'total' => $wp_query->dwqa_questions->max_num_pages
    );
    $paginate = paginate_links($args);
    echo '<div class="dwqa-pagination">';
    echo $paginate;
    echo '</div>';





}
?>


<?php if(is_user_logged_in()){ ?>
    <div class="side-tool" id="m-side-tool-project">
        <ul>
            <li><a href="<?php echo site_url().get_page_address('ask');?>"><i class="fa fa-plus" aria-hidden="true"></i></a></li>
        </ul>
    </div>
<?php }else{ ?>
    <div class="side-tool" id="m-side-tool-project">
        <ul>
            <li><a href="<?php echo wp_login_url( get_permalink() ); ?>"><i class="fa fa-plus" aria-hidden="true"></i></a></li>
        </ul>
    </div>
<?php } ?>
