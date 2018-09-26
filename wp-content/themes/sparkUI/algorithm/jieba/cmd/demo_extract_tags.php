
<?php
/**
 * demo_extract_tags.php
 *
 * PHP version 5
 *
 * @category PHP
 * @package  /src/cmd/
 * @author   Fukuball Lin <fukuball@gmail.com>
 * @license  MIT Licence
 * @version  GIT: <fukuball/jieba-php>
 * @link     https://github.com/fukuball/jieba-php
 */
ini_set('memory_limit', '1024M');

require_once dirname(dirname(__FILE__))."/vendor/multi-array/MultiArray.php";
require_once dirname(dirname(__FILE__))."/vendor/multi-array/Factory/MultiArrayFactory.php";
require_once dirname(dirname(__FILE__))."/class/Jieba.php";
require_once dirname(dirname(__FILE__))."/class/Finalseg.php";
require_once dirname(dirname(__FILE__))."/class/JiebaAnalyse.php";
use Fukuball\Jieba\Jieba;
use Fukuball\Jieba\Finalseg;
use Fukuball\Jieba\JiebaAnalyse;
Jieba::init(array('mode'=>'test','dict'=>'big'));
Finalseg::init();
JiebaAnalyse::init(array('dict'=>'big'));

function get_post_content($min,$max){
    global $wpdb;
    $sql = "SELECT * FROM wp_posts WHERE ID >=$min AND ID <$max AND (post_type ='post' OR post_type ='yada_wiki')";
    $result = $wpdb->get_results($sql);
    return $result;
}

function add_post_keyword($content,$id){
    $top_k = 5;
   // $content = file_get_contents(dirname(dirname(__FILE__))."/dict/lyric.txt", "r");
//$reg = "#<pre[^>]*?class=\"language-markup\"[^>]*>(.*?)</pre>#is";
    $reg = array(
        '/(\s|\&nbsp\;|　|\xc2\xa0)/',
        '#<pre>.*</pre>#is',
        '#<pre[^>]*?class="language-markup"[^>]*>(.*?)</pre>#is',
        '#<pre[^>]*?class="language-javascript"[^>]*>(.*?)</pre>#is',
        '#<pre[^>]*?class="language-css"[^>]*>(.*?)</pre>#is',
        '#<pre[^>]*?class="language-php"[^>]*>(.*?)</pre>#is',
        '#<pre[^>]*?class="language-python"[^>]*>(.*?)</pre>#is',
        '#<pre[^>]*?class="language-java"[^>]*>(.*?)</pre>#is',
        '#<pre[^>]*?class="language-c"[^>]*>(.*?)</pre>#is',
        '#<pre[^>]*?class="language-csharp"[^>]*>(.*?)</pre>#is',
        '#<pre[^>]*?class="language-cpp"[^>]*>(.*?)</pre>#is',
        '#<pre[^>]*?class="language-ruby"[^>]*>(.*?)</pre>#is'
    );
//除去代码
    $replace = array('','','','','','','','','','','','');
    $new = preg_replace($reg,$replace,$content);//正则替换函数
    $reg1 = "/<\/?[^>]+>/i";
//除去标签
    $new1 = preg_replace($reg1,"",$new);//正则替换函数

    JiebaAnalyse::setStopWords(dirname(dirname(__FILE__)).'/dict/stop_words.txt');

    $tags = JiebaAnalyse::extractTags($new1, $top_k);
//var_dump($tags);
    foreach ($tags as $x=>$x_value){
        addPostKeyword($id,$x);
    }
}
$res = get_post_content(1,50000);
foreach ($res as $row){
    $post_id = $row->ID;
    $content = $row->post_content;
    add_post_keyword($content,$post_id);
}


?>