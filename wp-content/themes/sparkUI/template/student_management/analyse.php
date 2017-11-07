<?php
    $type = isset($_GET['type']) ? $_GET['type'] : 'fre';
?>
<div>
    <div style="height: 1px;background-color: lightgray"></div>
    <ul id="groupAnalyseTab" class="nav nav-tabs">
        <li class="<?php echo $type == 'fre' ? 'active' : ''; ?>">
            <a href="<?php echo esc_url(add_query_arg(array('type' => 'fre'), remove_query_arg(array('start', 'end', 'words', 'tags')))); ?>">词条频度</a>
        </li>
        <li class="<?php echo $type == 'tra' ? 'active' : ''; ?>">
            <a href="<?php echo esc_url(add_query_arg(array('type' => 'tra'), remove_query_arg(array('start', 'end', 'words', 'tags')))); ?>">行为轨迹</a>
        </li>
        <li class="<?php echo $type == 'int' ? 'active' : ''; ?>">
            <a href="<?php echo esc_url(add_query_arg(array('type' => 'int'), remove_query_arg(array('start', 'end', 'words', 'tags')))); ?>">兴趣分布</a>
        </li>
    </ul>
    <?php
    $tab = isset($_GET['type']) && !empty($_GET['type']) ? $_GET['type'] : 'fre';
    if($tab=='int'){
        require 'interest_distribution.php';
    }elseif ($tab=='tra'){
        require 'member_behavior.php';
    }else{
        require 'wiki_frequency.php';
    }
    ?>
</div>