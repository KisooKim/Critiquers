<?
session_start();
require("/var/www/html/include_connect.php");

$date_int=$_GET['dateint'];
if($date_int==''){
	$date_int = date("Y-m-d");
}

$today_time = strtotime($date_int);
$yesterday = date("Y-m-d", $today_time-1*24*60*60);

$t=$_GET['category'];
$periodno=$_GET['periodno'];
$date_timestamp = strtotime($date_int);
$date_to_show = date("n월 j일", $date_timestamp);
$yoil = array("일","월","화","수","목","금","토");
$period_name = array("실시간","1일간","3일간","7일간","한달간","반년간","일년간");
$yoil_to_show = $yoil[date('w',strtotime($date_int))];
$user_id = $_SESSION['user_id'];
$time = strtotime($date_int);
?>

<!-- 메인뉴스 리스트 -->
<div id="newslist" style="min-height:100%;margin-bottom:55px;">
<div style="width:100%;text-align:center;background-color:#fcfcfc;color:#2a2a2a;padding:16px;font-weight:bold;font-size:18px;"><?=$date_int;?> (<?=$yoil[date('w',strtotime($date_int))];?>)</div>
<?
$k=0;
include("./include_main_news_list_cluster.php");
$date_int=$yesterday;
?>
<div style="width:100%;background-color:#f3f3f3;border-top:0px solid #e2e2e2;height:24px;"></div>
<div style="width:100%;text-align:center;background-color:#fcfcfc;color:#2a2a2a;padding:16px;font-weight:bold;font-size:18px;"><?=$date_int;?> (<?=$yoil[date('w',strtotime($date_int))];?>)</div>
<?
$k=1;
include("./include_main_news_list_cluster.php");
?>
</div>
<!-- 메인뉴스 리스트 끝-->
<div style="width:100%;height:60px;"></div>