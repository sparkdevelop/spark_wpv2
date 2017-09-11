<?php
/* header&footer为导航和下脚
 * index.php为所有页面通用模板  目前基本没用了,除非是没有设置的默认页面
 * front-page.php为仅仅首页的默认模板  设置了首页以后才有用
 * sidebar.php为右侧页面的默认模板    其中包含各个页面边栏不同的分类
 * page.php也是和sidebar一样是默认模板, 包含各个页面内容不同的分类
 *
 */

//$page_wiki_id = get_page_id('wiki');
//$page_qa_id = get_page_id('qa');
//$page_project_id =get_page_id('project');
//$page_ask_id = get_page_id('ask');
//$page_personal_id = get_page_id('personal');
?>

<?php get_header(); ?>
<div class="container" style="margin-top: 10px;margin-bottom: 30px;">
    <div class="row" style="width: 100%">
           <!--引入动态模板-->
            <?php if ( have_posts() ) : while ( have_posts() ) : the_post();
                ?>
                <?php
                if(is_home() || is_front_page()) { //首页显示“首页内容”
                    the_content();
                }
                elseif (is_page("wiki_index")) {
                    if (!is_user_logged_in()) {
                        wp_redirect( home_url().'/wp-login.php' );
                    }
                    require "template/wiki/wiki_index.php";
                }
                elseif (is_page("编辑wiki")) {
                    if (!is_user_logged_in()) {
                        wp_redirect( home_url().'/wp-login.php' );
                    }
                    require "template/wiki/wiki_edit.php";
                }
                elseif (is_page("创建wiki")) {
                    if (!is_user_logged_in()) {
                        wp_redirect( home_url().'/wp-login.php' );
                    }
                    require "template/wiki/wiki_create.php";
                }
                elseif (is_page("wiki_revisions")) {
                if (!is_user_logged_in()) {
                    wp_redirect( home_url().'/wp-login.php' );
                }
                require "template/wiki/wiki_revisions.php";
            }
                elseif (is_page("qa") ) {//显示问答内容 参数为pageID 如何自动获取??
                    if (!is_user_logged_in()) {
                        wp_redirect( home_url().'/wp-login.php' );
                    }?>
                    <script>
                        location.replace("<?= site_url();?>/?post_type=dwqa-question");
                    </script>
                <?php }
                elseif (is_page('项目')){
                    if (!is_user_logged_in()) {
                        wp_redirect( home_url().'/wp-login.php' );
                    }
                    require "template/project/project_content.php";
                }
                elseif (is_page('group')){
                    if (!is_user_logged_in()) {
                        wp_redirect( home_url().'/wp-login.php' );
                    }
                    require "template/group/index.php";
                }
                elseif (is_page('verify_form')){
                    if (!is_user_logged_in()) {
                        wp_redirect( home_url().'/wp-login.php' );
                    }
                    require "template/group/verify_form.php";
                }
                elseif (is_page('budao_index')){
                    if (!is_user_logged_in()) {
                        wp_redirect( home_url().'/wp-login.php' );
                    }
                    require "template/budao/index.php";
                }
                elseif (is_page("ask")) {
                    if (is_user_logged_in()) {
                        require "template/qa/QA_ask.php";
                    } else {?>
                        <script>location.replace("<?= wp_login_url( get_permalink())?>");</script>
                <?php   }
                }
                elseif (is_page('发布项目')){
                    if (!is_user_logged_in()) {
                        wp_redirect( home_url().'/wp-login.php' );
                    }
                    the_content();
                }
                elseif (is_page('My Posts')){
                    if (!is_user_logged_in()) {
                        wp_redirect( home_url().'/wp-login.php' );
                    }
                    the_content();
                }
                elseif (is_page('ask_tiny')){
                    if (!is_user_logged_in()) {
                        wp_redirect( home_url().'/wp-login.php' );
                    }
                    require "template/qa/QA_ask_tiny.php";
                }
                elseif (is_page('timer')){
                    require "algorithm/timer.php";
                }
                elseif (is_page('changedomain')){
                    require "algorithm/changedomain.php";
                }
                elseif (is_page('autowiki')){
                    require "template/wiki/wiki_uploads/upload.php";
                }
                elseif (is_page('otherpersonal')){
                    if (!is_user_logged_in()) {
                        wp_redirect( home_url().'/wp-login.php' );
                    }
                    require "template/otherpersonal.php";
                }
//                elseif (is_page('student_management')){
//                    if (!is_user_logged_in()) {
//                        wp_redirect( home_url().'/wp-login.php' );
//                    }
//                    require "template/student_management/management.php";
//                }
                elseif (is_page('personal')){
                    if (is_user_logged_in()) {
                        require "template/personal.php";
                    } else { ?>
                        <script>location.href = "<?= wp_login_url( get_permalink())?>";</script>
                <?php  }
                }
                elseif (is_page('creategroup')){
                    if (!is_user_logged_in()) {
                        wp_redirect( home_url().'/wp-login.php' );
                    }
                    require "template/group/create_group.php";
                }
                elseif (is_page('createtask')){
                    if (!is_user_logged_in()) {
                        wp_redirect( home_url().'/wp-login.php' );
                    }
                    require "template/group/create_task.php";
                }
                elseif (is_page('single_group')){
                    if (!is_user_logged_in()) {
                        wp_redirect( home_url().'/wp-login.php' );
                    }
                    require "template/group/single_group.php";
                }
                elseif (is_page('single_task')){
                    if (!is_user_logged_in()) {
                        wp_redirect( home_url().'/wp-login.php' );
                    }
                    require "template/group/single_task.php";
                }
                else{
                    if (!is_user_logged_in()) {
                        wp_redirect( home_url().'/wp-login.php' );
                    }
                    the_content();
                }
                endwhile;
                ?>
            <?php else: ?>
                <p><?php _e('Sorry, this page does not exist.'); ?></p>
            <?php endif; ?>
            <?php get_sidebar(); ?>
    </div>
</div>
<?php get_footer(); ?>
