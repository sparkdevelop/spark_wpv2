<?php
$user_id = get_current_user_id();
$jsonString_knowledge = readJson("category_knowledge");
$jsonString_grade = readJson("category_grade");
//$jsonString = jsonGenerate();
//$jsonString = jsonGenerate_old($user_id);
?>
<ul id="leftTab" class="nav nav-pills">
    <li class="active"><a href="#knowledge_chart" data-toggle="tab">知识体系</a></li>
    <li><a href="#grade_chart" data-toggle="tab">学习路径</a></li>
</ul>
<div class="divline" style="margin-top: 42px;"></div>
<div id="leftTabContent" class="tab-content">
    <div class="tab-pane fade in active" id="knowledge_chart">
        <div id="chart_knowledge" style="width:855px;height: 700px"></div>
        <script>
            myKnowledgeChart('chart_knowledge','<?=$jsonString_knowledge?>');
        </script>
    </div>
    <div class="tab-pane fade" id="grade_chart">
        <div id="chart_grade" style="width:855px;height: 700px"></div>
        <script>
            myKnowledgeChart('chart_grade','<?=$jsonString_grade?>');
        </script>
    </div>
</div>





