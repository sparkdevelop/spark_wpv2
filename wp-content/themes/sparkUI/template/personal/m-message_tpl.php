<?php
//私信页面模板
$allMsg = get_allPrivateMsg();
$pro_length = count($allMsg);
$perpage = 10;
$total_page = ceil($pro_length / $perpage);

if (!$_GET['paged']) {
    $current_page = 1;
} else {
    $page_num = $_GET['paged'];
    $current_page = $page_num;
}
?>
<script>
    function all_message_read_delete() {
        layer.confirm('确定删除所有已读私信?', {
            icon: 3,
            resize:false,
            move:false,
            title:false,
            btnAlign: 'c',
            btn: ['确认', '取消'],
            btn2: function (index) {   //取消的回调
                layer.close(index);
            },
            btn1: function () {   //确认的回调
                var data = {
                    action: 'all_message_read_delete'
                };
                $.ajax({
                    type: "POST",
                    url: '<?=admin_url('admin-ajax.php')?>',
                    data: data,
                    dataType: "text",
                    success: function () {
                        layer.msg('删除成功!', {time: 2000, icon: 1});
                        location.reload();
                    },
                    error: function () {
                        alert("error");
                    }
                });
            }
        })
    }

    function all_message_set_as_read() {
        var data = {
            action: 'all_message_set_as_read'
        };
        $.ajax({
            //async: false,    //否则永远返回false
            type: "POST",
            url: '<?=admin_url('admin-ajax.php')?>',
            data: data,
            dataType: "text",
            success: function () {
                layer.msg('全部设为已读', {time: 2000, icon: 1});
                location.reload();
            },
            error: function () {
                alert("error");
            }
        });
    }
</script>
<div>
    <div class="badge" id="my_group_badge"
         style="cursor:pointer;float: right;margin-top: -27px;margin-right: 5px"
         onclick="all_message_set_as_read()">
        全部设为已读
    </div>
    <div class="badge" id="my_group_badge"
         style="cursor:pointer;float: right;margin-top: -27px;margin-right: 110px"
         onclick="all_message_read_delete()">
        删除全部已读
    </div>
</div>


<div class="divline" style="margin-top: 0px;margin-bottom: -11px"></div>
<div id="rightTabContent" class="tab-content">
    <ul class="list-group">
        <?php if (count($allMsg) > 0) {
            $min_temp = $pro_length < $perpage * $current_page ? $pro_length : $perpage * $current_page;
            for ($i = $perpage * ($current_page - 1); $i < $min_temp; $i++) {
                if ($allMsg[$i]['message_status'] == 0) { ?>
                    <style>
                        #message-li-<?=$i?> {
                            background-color: #fafbe9;
                            padding-bottom: 0px;
                        }
                        #message-li-0 {    
                            margin-top: 11px;
                        }
                    </style>
                <?php } else { ?>
                    <style>
                        #message-li-<?=$i?> {
                            background-color: transparent;
                            padding-bottom: 0px;
                        }
                        #message-li-0 {    
                            margin-top: 11px;
                        }
                    </style>
                <?php }
                ?>
                <li class="list-group-item" id="message-li-<?= $i ?>">
                    <?php
                    $from_id = $allMsg[$i]['from_id'];   //发信人的id
                    //$joiner为一个字符串,要转化成为数组。
                    //                    $joiner_main = explode(',',$joiner);
                    //                    $joiner_num = sizeof($joiner_main);
                    //                    $joiner_name = get_the_author_meta('user_login', $joiner_main[0]);  ###########
                    $sender_name = get_the_author_meta('user_login', $from_id);
                    $time = $allMsg[$i]['modified_time'];  //操作的时间
                    $message = $allMsg[$i]['content'];
                    $person_url = site_url() . get_page_address('otherpersonal') . '&id=' . $from_id;
                    ?>
                    <div id="notice-ava">
                        <?php echo get_avatar($from_id, 40) ?>
                    </div>
                    <div id="notice-content">
                        <div id="notice-info">
                            <a style="color: #169bd5;cursor: pointer"
                               href="<?php echo site_url() . get_page_address('otherpersonal') . '&id=' . $from_id; ?>">
                                <?= $sender_name ?>
                            </a>
                            <span>给你发了一条消息: </span>
                            <div style="margin-top: 5px"><?= $message ?></div>
                        </div>
                        <div id="notice-time">
                            <div style="text-align: right">
                                <?
                                if (time() - strtotime($time) > 24 * 3600) {
                                    echo date('Y年n月j日', strtotime($time));
                                } else {
                                    echo date('H:i:s', strtotime($time));
                                }
                                ?>
                            </div>
                            <?php
                            $message_url = site_url() . get_page_address("private_message") . "&ruser_id=" . $from_id ."&f=".$allMsg[$i]['ID'];
                            ?>
                            <div class="badge" id="my_group_badge"
                                 style="cursor:pointer;margin-right: 10px;margin-top: 6px;float: initial"
                                 onclick="send_private_message('<?=$message_url?>')">
                                回复
                            </div>
                            <div class="glyphicon glyphicon-envelope"
                                 style="float: right;margin-top: 10px;color: darkgray"></div>
                        </div>
                    </div>
                    <div class="divline"></div>
                </li>
            <?php }
        } else { ?>
            <div class="alert alert-info" style="margin-top: 20px">Oops,还没有收到消息</div>
        <?php } ?>
    </ul>
    <?php if ($total_page > 1) { ?>
        <div id="page_favorite" style="text-align:center;margin-bottom: 20px">
            <!--翻页的超链接-->
            <a href="<?php echo add_query_arg(array('paged' => 1)) ?>">首页</a>
            <?php if ($current_page == 1) { ?>
                <a href="<?php echo add_query_arg(array('paged' => $current_page + 1)) ?>">下一页&nbsp;&raquo;</a>
            <?php } elseif ($current_page == $total_page) { ?>
                <a href="<?php echo add_query_arg(array('paged' => $current_page - 1)) ?>">&laquo;&nbsp;上一页</a>
            <?php } else { ?>
                <a href="<?php echo add_query_arg(array('paged' => $current_page - 1)) ?>">&laquo;&nbsp;上一页&nbsp;</a>
                <a href="<?php echo add_query_arg(array('paged' => $current_page + 1)) ?>">&nbsp;下一页&nbsp;&raquo;</a>
            <?php } ?>
            <a href="<?php echo add_query_arg(array('paged' => $total_page)) ?>">尾页</a>
            共<?= $total_page ?>页
        </div>
    <?php } ?>
</div>