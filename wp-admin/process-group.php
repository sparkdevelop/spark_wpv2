<?php
/*        ID int AUTO_INCREMENT PRIMARY KEY,
          group_name text NOT NULL,
          group_author int NOT NULL,
          group_abstract longtext NOT NULL,
          group_status text NOT NULL,
          group_cover text NOT NULL,
          join_permission text NOT NULL,
          task_permission text NOT NULL,
          create_date datetime NOT NULL,
          member_count int NOT NULL
  * */
    global $wpdb;
    require_once(dirname(__FILE__) . '/admin.php');

    //处理一般的数据
    $group_name = isset($_POST["gname"]) ? $_POST["gname"] : '';

    $group_author = isset($_POST["gauthor"]) ? $_POST["gauthor"] : '';

    $group_abstract = isset($_POST["gabstract"]) ? $_POST["gabstract"] : '';

    $group_status = isset($_POST["gstatus"]) ? $_POST["gstatus"] : "publish";

    $join_permission = isset($_POST["gjoin"]) ? $_POST["gjoin"] : "";

    $task_permission = isset($_POST["gstatustask"]) ? $_POST["gstatustask"] : "";

    $create_date = isset($_POST["gcreatedate"]) ? $_POST["gcreatedate"] : "";

    //处理上传的图片
    $upload_path = wp_upload_dir();  //获取wordpress的上传路径。
    if(!empty($_FILES['gava']["name"])){
        $new_upload_path = $upload_path['path'] . "/" . $_FILES['gava']["name"];  //本文件的上传路径,精确到文件名
    }else{
        $new_upload_path = $upload_path['basedir']."/group-avatars/1/default.png";
    }

    if (is_uploaded_file($_FILES['gava']['tmp_name'])) {   //判断文件时候是通过http_post上传的
        move_uploaded_file($_FILES['gava']['tmp_name'], $new_upload_path);
    }else{
        echo "this is not http post";
    }
    //处理加入方式
    //首先获取最后一个group_id;
    $sql_fun = "select ID from wp_gp ORDER BY ID DESC LIMIT 0,1";
    $result = $wpdb->get_results($sql_fun);
    $group_id = $result[0]->ID+1;

    if ($join_permission = "verifyjoin"){
        $verify_content = $_POST['g-ver-info'];
        $verify_content = implode(",",$verify_content);
        $sql_verify = "INSERT INTO wp_gp_verify VALUES ('','$group_id','$verify_content')";
        $wpdb->query($sql_verify);
    }

    $sql = "INSERT INTO wp_gp VALUES ('$group_id','$group_name',$group_author,
                                          '$group_abstract','$group_status',
                                          '$new_upload_path','$join_permission',
                                          '$task_permission','$create_date',1)";
    $wpdb->query($sql);



