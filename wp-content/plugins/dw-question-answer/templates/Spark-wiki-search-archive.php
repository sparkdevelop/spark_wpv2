<?php
$search_word=$_GET['s'];
?>

<div style="margin-top: 20px;">
    <div style="width: 100%;">
        <div class="project-title">
            <a class="project-title" href="<?php the_permalink(); ?>" style="color: black"><?php echo str_replace($search_word,'<font color=red>'.$search_word.'</font>',get_the_title()); ?></a>
        </div>
        <p style="word-wrap: break-word"><?php echo str_replace($search_word,'<font color=red>'.$search_word.'</font>',get_the_excerpt()); ?><a href="<?php the_permalink(); ?>" class="button right" style="color: #fe642d;">阅读全文</a></p>
    </div>
    <div style="height: 1px;background-color: #dcdcdc;margin-top: 20px"></div>
</div>

