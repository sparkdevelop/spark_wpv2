<?php

/**
 * 根据数组中元素个数生成数据库结构语句， 类似（$i,$j） 为了sql的in服务
 * @param $item_array
 * @return string
 */
function generate_sql_structure($item_array)
{
    $item_array_str = "";
    if (count($item_array) > 0) {
        $item_array_str = "";
        for ($i = 0; $i < count($item_array); $i++) {
            if ($i == 0) {
                $item_array_str = "(" . $item_array[$i] . ",";
                continue;
            }
            if ($i == count($item_array) - 1) {
                $item_array_str = $item_array_str . $item_array[$i] . ")";
                continue;
            }
            $item_array_str = $item_array_str . $item_array[$i] . ",";
        }
        if (count($item_array) == 1) {
            $item_array_str = "(" . $item_array[0] . ")";
        }
    }
    return $item_array_str;
}



?>
<!--翻页-->
<?php
$type = isset($_GET['type']) ? $_GET['type'] : 'notice';
?>
<ul id="personalTab" class="nav nav-pills">
    <li class="<?php echo $type == 'notice' ? 'active' : ''; ?>">
        <a href="<?php echo esc_url(add_query_arg(array('type' => 'notice'), remove_query_arg(array('paged')))); ?>">通知
            <? if(hasNotice()){?>
                <i id="red-point" style="right: 5px;top: 5px;"></i>
            <? } ?>
        </a>
    </li>
    <li class="<?php echo $type == 'message' ? 'active' : ''; ?>">
        <a href="<?php echo esc_url(add_query_arg(array('type' => 'message'), remove_query_arg(array('paged')))); ?>">私信
            <? if(hasPrivateMessage()){?>
                <i id="red-point" style="right: 5px;top: 5px;"></i>
            <? } ?>
        </a>
    </li>
    <li class="<?php echo $type == 'gpmessage' ? 'active' : ''; ?>">
        <a href="<?php echo esc_url(add_query_arg(array('type' => 'gpmessage'), remove_query_arg(array('paged')))); ?>">群消息
            <? if(hasGPNotice()){?>
                <i id="red-point" style="right: 5px;top: 5px;"></i>
            <? } ?>
        </a>
    </li>
</ul>
<?php
$tab = isset($_GET['type']) && !empty($_GET['type']) ? $_GET['type'] : 'notice';
if ($tab == 'notice') {
    require 'm-notice_tpl.php';
}
elseif($tab == 'message') {
    require 'm-message_tpl.php';
}
else{
    require 'm-gpmessage_tpl.php';
}?>
