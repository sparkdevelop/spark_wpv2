<style type="text/css">
    .row{
        margin-right: 0px;
    }
    .wiki_category_item{
        padding-top:20px;
        padding-bottom: 20px;
        padding-left: 20px;
    }
    .wiki_category_item:hover,.wiki_category_item:focus{
        background: #f5f5f5;
        border-radius: 5px;
    }
    .wiki_category{
        margin-bottom: 30px;
        padding-top: 20px;
    }
    .wiki-index-icon{
        width:50px;
        height:50px;
    }
    .wiki-index-title{
        font-size: 16px;
        font-weight: bold;
        color: #333;
    }
    .wiki-index-title:hover{
        color: #fe642d;
        text-decoration: none;
    }
    .wiki-index-info{
        color: #757576;
        font-size: 12px;
        margin-top: 10px;
    }
</style>
<?php
    global $wpdb;
    $post_ids = "(235, 444, 448, 164, 451, 520, 243, 455, 458, 642, 465, 468, 160, 471)";
    $watchs_result = $wpdb->get_results("select meta_value, meta_id, post_id from $wpdb->postmeta where meta_key=\"count\" and post_id in ".$post_ids);
    $watch_nums = array();
    foreach ($watchs_result as $item) {
        $watch_nums[$item->post_id] = $item->meta_value;
    }
?>
<div class="col-md-9 col-sm-9 col-xs-9" id="col9">
    <div class="index_content_show">
        <div class="wiki_category">
            <p style="font-size: 18px"><b>创客教育</b></p>
            <div class="row">
                <div class="col-md-4 wiki_category_item">
                    <div class="row">
                        <div class="col-md-3">
                            <img src="<?php bloginfo("template_url")?>/img/wiki/火花图标设计-02.png" class="wiki-index-icon">
                        </div>
                        <div class="col-md-9">
                            <a class="wiki-index-title" href="http://112.74.62.56/spark_wpv2/?yada_wiki=导论实验课">导论实验课</a>
                            <div class="wiki-index-info">
                                <span>入门</span><span> · </span><span><?php echo $watch_nums[235]; ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 wiki_category_item">
                    <div class="row">
                        <div class="col-md-3">
                            <img src="<?php bloginfo("template_url")?>/img/wiki/火花图标设计-03.png" class="wiki-index-icon">
                        </div>
                        <div class="col-md-9">
                            <a class="wiki-index-title" href="http://112.74.62.56/spark_wpv2/?yada_wiki=中国5g联创进校园">中国5G联创进校园</a>
                            <div class="wiki-index-info">
                                <span>基础</span><span> · </span><span><?php echo $watch_nums[444]; ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 wiki_category_item">
                    <div class="row">
                        <div class="col-md-3">
                            <img src="<?php bloginfo("template_url")?>/img/wiki/火花图标设计-04.png" class="wiki-index-icon">
                        </div>
                        <div class="col-md-9">
                            <a class="wiki-index-title" href="http://112.74.62.56/spark_wpv2/?yada_wiki=开放平台">开放平台</a>
                            <div class="wiki-index-info">
                                <span>API</span><span> · </span><span><?php echo $watch_nums[448]; ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="wiki_category">
            <p style="font-size: 18px"><b>自学资源</b></p>
            <div class="row">
                <div class="col-md-4 wiki_category_item">
                    <div class="row">
                        <div class="col-md-3">
                            <img src="<?php bloginfo("template_url")?>/img/wiki/火花图标设计-05.png" class="wiki-index-icon">
                        </div>
                        <div class="col-md-9">
                            <a class="wiki-index-title" href="http://112.74.62.56/spark_wpv2/?yada_wiki=优秀学习网站">优秀学习网站</a>
                            <div class="wiki-index-info">
                                <span>推荐</span><span> · </span><span><?php echo $watch_nums[164]; ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 wiki_category_item">
                    <div class="row">
                        <div class="col-md-3">
                            <img src="<?php bloginfo("template_url")?>/img/wiki/火花图标设计-06.png" class="wiki-index-icon">
                        </div>
                        <div class="col-md-9">
                            <a class="wiki-index-title" href="http://112.74.62.56/spark_wpv2/?yada_wiki=arduino语法">Arduino语法</a>
                            <div class="wiki-index-info">
                                <span>基础</span><span> · </span><span><?php echo $watch_nums[451]; ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 wiki_category_item">
                    <div class="row">
                        <div class="col-md-3">
                            <img src="<?php bloginfo("template_url")?>/img/wiki/火花图标设计-07.png" class="wiki-index-icon">
                        </div>
                        <div class="col-md-9">
                            <a class="wiki-index-title" href="http://112.74.62.56/spark_wpv2/?yada_wiki=web学习">Web学习</a>
                            <div class="wiki-index-info">
                                <span>入门</span><span> · </span><span><?php echo $watch_nums[520]; ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="wiki_category">
            <p style="font-size: 18px"><b>创新创业</b></p>
            <div class="row">
                <div class="col-md-4 wiki_category_item">
                    <div class="row">
                        <div class="col-md-3">
                            <img src="<?php bloginfo("template_url")?>/img/wiki/火花图标设计-08.png" class="wiki-index-icon">
                        </div>
                        <div class="col-md-9">
                            <a class="wiki-index-title" href="http://112.74.62.56/spark_wpv2/?yada_wiki=互联网创业课-2">互联网创业课</a>
                            <div class="wiki-index-info">
                                <span>创业</span><span> · </span><span><?php echo $watch_nums[243]; ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 wiki_category_item">
                    <div class="row">
                        <div class="col-md-3">
                            <img src="<?php bloginfo("template_url")?>/img/wiki/火花图标设计-09.png" class="wiki-index-icon">
                        </div>
                        <div class="col-md-9">
                            <a class="wiki-index-title" href="http://112.74.62.56/spark_wpv2/?yada_wiki=创新方法">创新方法</a>
                            <div class="wiki-index-info">
                                <span>创新</span><span> · </span><span><?php echo $watch_nums[455]; ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 wiki_category_item">
                    <div class="row">
                        <div class="col-md-3">
                            <img src="<?php bloginfo("template_url")?>/img/wiki/火花图标设计-10.png" class="wiki-index-icon">
                        </div>
                        <div class="col-md-9">
                            <a class="wiki-index-title" href="http://112.74.62.56/spark_wpv2/?yada_wiki=设计思维">设计思维</a>
                            <div class="wiki-index-info">
                                <span>设计</span><span> · </span><span><?php echo $watch_nums[458]; ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="wiki_category">
            <p style="font-size: 18px"><b>北邮资源</b></p>
            <div class="row">
                <div class="col-md-4 wiki_category_item">
                    <div class="row">
                        <div class="col-md-3">
                            <img src="<?php bloginfo("template_url")?>/img/wiki/火花图标设计-11.png" class="wiki-index-icon">
                        </div>
                        <div class="col-md-9">
                            <a class="wiki-index-title" href="http://112.74.62.56/spark_wpv2/?yada_wiki=cc程序设计">C/C++程序设计</a>
                            <div class="wiki-index-info">
                                <span>课程</span><span> · </span><span><?php echo $watch_nums[642]; ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 wiki_category_item">
                    <div class="row">
                        <div class="col-md-3">
                            <img src="<?php bloginfo("template_url")?>/img/wiki/火花图标设计-12.png" class="wiki-index-icon"">
                        </div>
                        <div class="col-md-9">
                            <a class="wiki-index-title" href="http://112.74.62.56/spark_wpv2/?yada_wiki=计算机基础原理">计算机基础原理</a>
                            <div class="wiki-index-info">
                                <span>课程</span><span> · </span><span><?php echo $watch_nums[465]; ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 wiki_category_item">
                    <div class="row">
                        <div class="col-md-3">
                            <img src="<?php bloginfo("template_url")?>/img/wiki/火花图标设计-13.png" class="wiki-index-icon">
                        </div>
                        <div class="col-md-9">
                            <a class="wiki-index-title" href="http://112.74.62.56/spark_wpv2/?yada_wiki=电子电路基础课">电子电路基础课</a>
                            <div class="wiki-index-info">
                                <span>课程</span><span> · </span><span><?php echo $watch_nums[468]; ?></span>
                            </div>
                        </div>
                    </div>
                </div><br><br>
                <div class="col-md-4 wiki_category_item">
                    <div class="row">
                        <div class="col-md-3">
                            <img src="<?php bloginfo("template_url")?>/img/wiki/火花图标设计-14.png" class="wiki-index-icon">
                        </div>
                        <div class="col-md-9">
                            <a class="wiki-index-title" href="http://112.74.62.56/spark_wpv2/?yada_wiki=数字信号处理">数字信号处理</a>
                            <div class="wiki-index-info">
                                <span>课程</span><span> · </span><span><?php echo $watch_nums[160]; ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 wiki_category_item">
                    <div class="row">
                        <div class="col-md-3">
                            <img src="<?php bloginfo("template_url")?>/img/wiki/火花图标设计-15.png" class="wiki-index-icon">
                        </div>
                        <div class="col-md-9">
                            <a class="wiki-index-title" href="http://112.74.62.56/spark_wpv2/?yada_wiki=信息论课  ">信息论课</a>
                            <div class="wiki-index-info">
                                <span>课程</span><span> · </span><span><?php echo $watch_nums[471]; ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

