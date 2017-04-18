
<!--page_id后需手动添加My Posts页面ID-->
<div class="sidebar_button" style="margin-top: 20px;margin-right: 15px;margin-left: -2px">
    <a href="?fep_action=edit&fep_id=<?= $post_id; ?><?= (isset($_SERVER['QUERY_STRING']) ? '&' . $_SERVER['QUERY_STRING'] : '') ?>&page_id=30" target="_blank" style="color: white" >编辑项目</a>
</div>
