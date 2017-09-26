<?
session_start();
require("/var/www/html/include_connect.php");



$date_int = date("Y-m-d");

$t=$_GET['category'];
$periodno=$_GET['periodno'];
$date_timestamp = strtotime($date_int);
$date_to_show = date("n월 j일", $date_timestamp);
$yoil = array("일","월","화","수","목","금","토");
$period_name = array("실시간","1일간","3일간","7일간","한달간","반년간","일년간");
$yoil_to_show = $yoil[date('w',strtotime($date_int))];
$user_id = $_SESSION['user_id'];
$time = strtotime($date_int);



$articlelist=$_GET['articlelist'];
if($articlelist==''){
	$sql0 = "SELECT articlelist from c_cluster WHERE dateint='$date_int' ORDER BY facebook_total desc limit 0, 1";
	$resultout0 = mysql_query($sql0);
	$print = mysql_fetch_array($resultout0);
	$articlelist = $print[0];
}
$sql = "SELECT * from b_article_all WHERE no IN($articlelist) ORDER by rate_value desc, facebook_no desc";
$count=1;
$resultout = mysql_query($sql);
$numResults = mysql_num_rows($resultout);
if($numResults>10){
	$numResults = 10;
}
while($print = mysql_fetch_array($resultout)){ // 그 클러스터의 기사들을 뿌려준다
$articleno = $print['no'];
$url = urldecode($print['url']);
$article_date_int = $print['date_int'];
$category = $print['category'];
$title = urldecode($print['title']);
$title = str_replace("&lt;br&gt;","&nbsp;",$title);
$title = str_replace("&lt;BR&gt;","&nbsp;",$title);
$title = str_replace("&nbsp;&nbsp;","&nbsp;",$title);
$title = html_entity_decode($title);
$media = urldecode($print['media']);
$media_no = $print['media_no'];
$author = urldecode($print['author']);
$author_no = $print['author_no'];
//$comment_no = $print[6];
//$link_no = $print[7];
$rate_total = $print['rate_total'];
$rated_time = $print['rated_time'];
if($rated_time>0){
	$or = $rate_total/$rated_time;
}else{
	$or = 0;
}
$avg_rate = round($or*100,0)/100;
$rate = round($or*2,0)/2*10;

$facebook_no = $print['facebook_no'];
$twitter_no = $print['twitter_no'];
$repimage = urldecode($print['rep_image']);
if($repimage == 'cqrs_noimage'){
	$repimage = '';
}

//기사 출력부분 호출
?>
<?
include("cluster_news_list_article.php");
?>
<?
//
$count++;
} // 기사 목록을 출력하는 부분 foreach
?>
<div style="width:100%;border-top:0px solid #eaeaea;margin-bottom:55px;"></div>
</div>
</div>
<div style="width:100%;height:60px;"></div>
<?
//include("footer.php");
?>