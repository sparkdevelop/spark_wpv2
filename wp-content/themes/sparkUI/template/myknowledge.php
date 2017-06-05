<?php
$user_id = get_current_user_id();
$jsonString = jsonGenerate(1);
//$jsonString = sideJSONGenerte(1,"");
?>
<div id="chart" style="width:800px;height: 700px"></div>
<script>
    myKnowledgeChart('<?=$jsonString?>');
</script>