<?php

class Spark_Widgets_Popular_Question extends WP_Widget
{

    /**
     * Constructor
     *
     * @return void
     **/
    function Spark_Widgets_Popular_Question()
    {
        $widget_ops = array( 'description' => 'sparkspace');
        $control_ops = array('width' => 400, 'height' => 300);

        parent::WP_Widget(false,$name='spark popular questions',$widget_ops,$control_ops);
    }


    // 进行更新保存
    function update( $new_instance, $old_instance ) {

        // update logic goes here
        $updated_instance = $new_instance;
        return $updated_instance;
    }
//表单
    function form( $instance ) {
        $instance = wp_parse_args( $instance, array(
            'title' => '',
            'number' => 5,
        ) );
        ?>
        <p><label for="<?php echo $this->get_field_id( 'title' ) ?>"><?php _e( 'Widget title', 'dwqa' ) ?></label>
            <input type="text" name="<?php echo $this->get_field_name( 'title' ) ?>" id="<?php echo $this->get_field_id( 'title' ) ?>" value="<?php echo $instance['title'] ?>" class="widefat">
        </p>
        <p><label for="<?php echo $this->get_field_id( 'number' ) ?>"><?php _e( 'Number of posts', 'dwqa' ) ?></label>
            <input type="text" name="<?php echo $this->get_field_name( 'number' ) ?>" id="<?php echo $this->get_field_id( 'number' ) ?>" value="<?php echo $instance['number'] ?>" class="widefat">
        </p>
        <?php
    }
//热门问题提取
    function widget( $args, $instance ) {
        extract( $args, EXTR_SKIP );
        $instance = wp_parse_args( $instance, array(
            'title' => __( 'Popular Questions', 'dwqa' ),
            'number' => 5,
        ) );
        // echo $before_widget;
        //echo $before_title;
        echo $instance['title'];
        //echo $after_title;

        $args = array(
            'posts_per_page'       => $instance['number'],
            'order'             => 'DESC',
            'orderby'           => 'meta_value_num',
            'meta_key'          => '_dwqa_views',
            'post_type'         => 'dwqa-question',
            'suppress_filters'  => false,
        );
        $questions = new WP_Query( $args );
        if ( $questions->have_posts() ) {
            ?>
            <div class="sidebar_list">
                <div class="sidebar_list_header">
                    <p style="font-size: large;display:inline-block;margin-top: 5%;font-weight: bold">热门问题</p>
                    <a href="#" style="color:gray;float: right;display: inline-block;margin-top: 5%">全部</a>
                </div>
                <!--分割线-->
                <div class="sidebar_divline"></div>
                <!--助教列表-->
                <ul class="list-group">
                    <?php
                    while ($questions->have_posts()) {
                        $questions->the_post();
                        echo '<li class="list-group-item">
                            <a href="' . get_permalink() . '" class="question-title">' . get_the_title() . '</a> ' . __('asked by', 'dwqa') . ' ' . get_the_author_link() . '
                          </li>';
                    }
                    ?>
                </ul>
            </div>

            <?php
        }
        wp_reset_query();
        wp_reset_postdata();
        //echo $after_widget;
    }
}
register_widget('Spark_Widgets_Popular_Question');
?>
