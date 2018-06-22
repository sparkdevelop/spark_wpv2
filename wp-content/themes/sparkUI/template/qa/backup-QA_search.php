<?php
$search_word=$_GET['s'];
$post_status=$_GET['post_status'];
$post_type= isset($_GET['post_type'])&&!empty($_GET['post_type'])?sanitize_text_field($_GET['post_type']): "post";
$posts_per_page= isset($_GET['posts_per_page'])&&!empty($_GET['posts_per_page']) ? $_GET['posts_per_page']: 10;
$current_url= curPageURL();//设当前页面为archive页面

//翻页所需参数
$page_text = dwqa_is_front_page() ? 'page' : 'paged';
$page = get_query_var( $page_text ) ? get_query_var( $page_text ) : 1;

    if($post_type=='yada_wiki'){    //根据自身情况更改
     $query_string = $query_string.'&posts_per_page=5'.'&post_type=yada_wiki';
     $posts=query_posts($query_string);
    }
    elseif($post_type=='dwqa-question'){  //根据自身情况更改
        $query_string= $query_string.'&posts_per_page=-1'.'&post_type=dwqa-question';
        $posts=query_posts($query_string);
    }
    else{
        $query_string= $query_string.'&posts_per_page=7'.'&post_type='.$post_type;
        $posts=query_posts($query_string);
    }
$args = array(
    'base' => add_query_arg($page_text, '%#%', $current_url),
    'format' => '',
    'current' => $page,
    'show_all' => True,
);
$paginate = paginate_links($args);

?>

<ul id="searchTab" class="nav nav-pills">
    <?php
    $url_array=parse_url($current_url);
    $query_parse=explode("&",$url_array['query']);
    if(array_search("post_type=yada_wiki",$query_parse)){?>
        <li class="active"><a href="<?php echo esc_url(add_query_arg( array('post_type'=>'yada_wiki' ) ) )?>">wiki</a></li>
        <li><a href="<?php echo remove_query_arg( array('post_type') )?>">问答</a></li>
        <li><a href="<?php echo esc_url(add_query_arg( array('post_type'=>'post'  ) ) )?>">项目</a></li>
    <?php }
    elseif(array_search("post_type=post",$query_parse)){?>
        <li><a href="<?php echo esc_url(add_query_arg( array('post_type'=>'yada_wiki' ) ) )?>">wiki</a></li>
        <li><a href="<?php echo remove_query_arg( array('post_type') )?>">问答</a></li>
        <li class="active"><a href="<?php echo esc_url(add_query_arg( array('post_type'=>'post'  ) ) )?>">项目</a></li>
    <?php }
    else{ ?>
        <li><a href="<?php echo esc_url(add_query_arg( array('post_type'=>'yada_wiki' ) ) )?>">wiki</a></li>
        <li  class="active"><a href="<?php echo remove_query_arg( array('post_type') )?>">问答</a></li>
        <li><a href="<?php echo esc_url(add_query_arg( array('post_type'=>'post'  ) ) )?>">项目</a></li>
    <?php } ?>
</ul>
<div class="dwqa-questions-list">
    <?php if ( have_posts() ) : ?>
        <?php while (have_posts()):the_post();?>
            <?php if ( get_post_status() == 'publish' || ( get_post_status() == 'private' && dwqa_current_user_can( 'edit_question', get_the_ID() ) ) ) : ?>
                <?php if ($post_type=='yada_wiki'){?>
                    <?php dwqa_load_template( 'Spark-wiki-search', 'archive' ) ?>
                <?php }elseif($post_type=='post'){ ?>
                    <?php dwqa_load_template( 'Spark-project-search', 'archive' ) ?>
                <?php } else{ ?>
                    <?php dwqa_load_template( 'Spark-qa-search', 'archive' ) ?>
                <?php } ?>

            <?php endif; ?>
        <?php endwhile; ?>
    <?php else : ?>
        <?php dwqa_load_template( 'Spark-content', 'none' ) ?>
    <?php endif; ?>
</div>
<div class="dwqa-questions-footer"  style="text-align: center;margin-bottom: 20px;margin-top: 10px">
    <div class="dwqa-pagination">
        <?php echo $paginate;?>
    </div>
</div>
<?php
wp_reset_query();
wp_reset_postdata();
?>



