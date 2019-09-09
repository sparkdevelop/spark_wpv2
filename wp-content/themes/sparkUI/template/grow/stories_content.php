<?php


//var_dump($_GET);

/*if($_GET['param'] > 3){
    echo "Ooops!!页面制作中……";
    return;
}*/

require 'stories/story-'.$_GET['param'].'.php';