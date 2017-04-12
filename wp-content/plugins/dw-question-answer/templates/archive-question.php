<?php
/**
 * The template for displaying question archive pages
 *
 * @package DW Question & Answer
 * @since DW Question & Answer 1.4.3
 */

$ask_page_ID=get_ask_page();
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
	$tag_count[]=$temp->count;
	$tag_name[]=$temp->name;
	array_push($link,get_term_link(intval($tag_id[$key]), 'dwqa-question_tag'));
}
//=============显示标签名==============
?>
<!--script for 切换nav-pills active状态和show_all_tags函数-->
<script>
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
</script>

<div class="col-md-9 col-sm-9 col-xs-9" id="col9">
	<div class="dwqa-questions-archive">
		<div style="display:inline-block;margin-bottom: 20px">
			<?php
			$term = get_query_var( 'dwqa-question_category' ) ?
					get_query_var( 'dwqa-question_category' ) : ( get_query_var( 'dwqa-question_tag' ) ?
					 											  get_query_var( 'dwqa-question_tag' ) : false );
			$term = get_term_by( 'slug', $term, get_query_var( 'taxonomy' ) );
			if('dwqa-question_tag' == get_query_var( 'taxonomy' )){?>
			<h4>问答标签:
			<?php }elseif('dwqa-question_category' == get_query_var( 'taxonomy' )){ ?>
			<h4>问答分类:
			<?php } else{?>
			<h4>所有问题
			<?php }?>
				<span style="color: #fe642d"><?=$term->name?></span>
			</h4>
		</div>
		<div style="display: inline-block;float: right;height: 42px;">
			<ul id="rightTab" class="nav nav-pills">
				<?php
				$current_url = home_url(add_query_arg(array()));
				$url_array=parse_url($current_url);
				$query_parse=explode("&",$url_array['query']);
				if(array_search("sort=views",$query_parse)||array_search("filter=all",$query_parse)){?>
					<li  class="active"><a href="<?php echo esc_url(add_query_arg( array( 'sort' => 'views','filter'=>'all' ) ) )?>">热门</a></li>
					<li><a href="<?php echo remove_query_arg(array('sort','filter')) ?>">所有</a></li>
					<li><a href="<?php echo esc_url( add_query_arg( array( 'filter' => 'unanswered','sort'=>'date' ) ) ) ?>">未解决</a></li>
				<?php }elseif (array_search("filter=unanswered",$query_parse)||array_search("sort=date",$query_parse)){?>
					<li><a href="<?php echo esc_url(add_query_arg( array( 'sort' => 'views' ) ) )?>">热门</a></li>
					<li><a href="<?php echo remove_query_arg(array('sort','filter')) ?>">所有</a></li>
					<li class="active"><a href="<?php echo esc_url( add_query_arg( array( 'filter' => 'unanswered' ) ) ) ?>">未解决</a></li>
				<?php } else{ ?>
					<li><a href="<?php echo esc_url(add_query_arg( array( 'sort' => 'views' ) ) )?>">热门</a></li>
					<li class="active"><a href="<?php echo remove_query_arg(array('sort','filter')) ?>">所有</a></li>
					<li><a href="<?php echo esc_url( add_query_arg( array( 'filter' => 'unanswered' ) ) ) ?>">未解决</a></li>
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
		<?php dwqa_question_paginate_link() ?>
	</div>

	<?php do_action( 'dwqa_after_questions_archive' ); ?>
	</div>
</div>
<style>
	.label-default[href]:focus,
	.label-default[href]:hover{background-color: transparent;outline: none;color: #fe642d}
	#buttonForAllTags{  outline: none;border:0px;color:gray;float: right;display: inline-block;margin-top: 20px;padding: 0 12px}
</style>
<div class="col-md-3 col-sm-3 col-xs-3 right" id="col3">
	<div class="sidebar_button">
		<a href="<?php echo site_url().$ask_page_ID;?>" style="color: white">我要提问</a>
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
</div>
