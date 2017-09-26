<?
session_start();
require("/var/www/html/include_connect.php");
$user_id = $_SESSION['user_id'];
$date_int = $_GET['dateint'];
$time = strtotime($date_int);
$periodno = $_GET['periodno'];
$period_array = array(
"date_int='".date("Y-m-d", $time)."'",
"date_int<='".date("Y-m-d", $time)."' AND date_int>='".date("Y-m-d", $time-3*24*60*60)."'",
"date_int<='".date("Y-m-d", $time)."' AND date_int>='".date("Y-m-d", $time-7*24*60*60)."'",
"date_int<='".date("Y-m-d", $time)."' AND date_int>='".date("Y-m-d", $time-31*24*60*60)."'",
"date_int<='".date("Y-m-d", $time)."' AND date_int>='".date("Y-m-d", $time-31*6*24*60*60)."'",
"date_int<='".date("Y-m-d", $time)."' AND date_int>='".date("Y-m-d", $time-365*24*60*60)."'"
);
$period_string_array = array('1일 간', '3일 간', '7일 간', '한 달 간', '반 년 간', '일 년 간');
$date_timestamp = strtotime($date_int);
$date_to_show = date("n월 j일", $date_timestamp);
$yoil = array("일","월","화","수","목","금","토");
$period_name = array("실시간","1일간","3일간","7일간","한달간","반년간","일년간");
$yoil_to_show = $yoil[date('w',strtotime($date_int))];

?>
<div id="fb-root"></div>
<div id="body1_m1" style="height:auto;">


<? if($periodno<4){ // 만약 실시간으로 보고 있다면 이걸 보여준다 ?>
<? //오늘의 랭킹뉴스 시작  ?>
<div style="width:94%;margin-left:3%;margin-right:3%;height:40px;margin-top:12px;padding-top:4px;background-color:#fcfcfc;border:1px solid #e2e2e2;border-bottom:0px;border-radius:3px;padding-left:6px;">
		<div style="display:table-cell;height:20px;padding-top:4px;vertical-align:top">
			<div style="display:inline-block;background-color:rgb(245, 199, 150);width:5px;height:9px;margin-left:8px;margin-top:6px"></div><div style="display:inline-block;background-color:rgb(245, 199, 150);width:5px;height:14px;margin-left:1px;margin-top:6px"></div><div style="display:inline-block;background-color:rgb(245, 199, 150);width:5px;height:6px;margin-left:1px;margin-right:3px;margin-top:6px"></div>
		</div>
		<div style="display:table-cell;height:20px;font-weight:bold;padding-top:9px;vertical-align:top">오늘의 순위뉴스</div>
</div>

<?
// 목록출력부
$date_timestamp = strtotime($date_int);
$one_day_ago = date("Y-m-d", $date_timestamp-24*60*60);
$sql = "SELECT textified_list from b_article_textified_1 WHERE date_int='$date_int' AND period_no='4'";
$query = mysql_query($sql);
$result = mysql_fetch_array($query);
$textified_list = $result[0];
$textified_list_array = array();
$textified_list_array = json_decode($textified_list, true);
?>
<div style="min-height:300px">
<?
//여기까지 sql을 하나로 다 모았다 그 sql에는 limit 구문이 없다
//이제 sql에 limit구문을 붙여서 한페이지 분량의 row를 가져온다
if($textified_list == '[]' || $textified_list == '' ){ // 아무것도 없을 경우
?>
<div style="clear:both"?>

<table articleno="<?=$articleno;?>_mark" class="newslist_table">
<tr>
<td style="padding: 30px;">
선택하신 날짜, 기간, 카테고리에 해당하는<br>기사가 없습니다.
</td>
</tr>
</table>
<?
}
else{
$resultout = NULL;
$resultout = mysql_query($sql, $connect) or die(mysql_error());
}
$count=1;
foreach($textified_list_array as $print){
if($count<11){
$t=11;
$articleno = $print['no'];
$url = urldecode($print['url']);
$date_int_now = $print['date_int'];
$category = $print['category'];
$title = urldecode($print['title']);
$title = strip_tags($title);
$title = str_replace(")",")&nbsp;",$title);
$title = str_replace("]","] ",$title);
$title = str_replace("&lt;br&gt;","&nbsp;",$title);
$title = str_replace("&lt;BR&gt;","&nbsp;",$title);
$title = str_replace("…"," … ",$title);
$title = str_replace("/"," / ",$title);
$title = str_replace("···"," ··· ",$title);
$title = str_replace("·"," · ",$title);
$title = str_replace("· · ·","···",$title);
$title = str_replace("  "," ",$title);
$title = str_replace("  "," ",$title);
$title = str_replace("&nbsp;&nbsp;","&nbsp;",$title);
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
?>

<!-- 기사 목록 -->
<a href='<?=$url;?>' class="newslist_a" href='javascript:void()' rel="external" target="_blank" id="newsitem<?=$count?>">
<? if($count < 4){ ?>
<? if($count>1){ ?><div style="width:100%;background-color:#f3f3f3;height:12px"></div> <? }else{ ?>
<div style="width:100%;background-color:#f3f3f3;border-top:0px solid #e2e2e2;height:1px"></div>
<? } ?>
<div <? if($count ==1){ echo "id='article_top_2'";}?> class="article_list article_list_main_1" data-t="<?=$t;?>" data-articleno="<?=$articleno;?>" data-categoryno="<?=$category;?>" data-belong="<?=$media;?>" author="<?=$author;?>" data-mediano="<?=$media_no;?>" data-authorno="<?=$author_no;?>" data-chartid="<?=$articleno."_".$t;?>" data-dateint="<?=$article_date_int;?>" data-targettile="<?=$t;?>_<?=$articleno;?>">
<? }else{ ?>
<div class="article_list_main_1 article_list_hidden" style="display:none;width:100%;background-color:#f3f3f3;border-top:0px solid #e2e2e2;height:12px"></div><div class="article_list article_list_main_1 article_list_hidden" style="display:none" data-t="<?=$t;?>" data-articleno="<?=$articleno;?>" data-categoryno="<?=$category;?>" data-belong="<?=$media;?>" data-author="<?=$author;?>" data-mediano="<?=$media_no;?>" data-authorno="<?=$author_no;?>" data-chartid="<?=$articleno."_".$t;?>" data-dateint="<?=$article_date_int;?>" data-targettile="<?=$t;?>_<?=$articleno;?>">
<? } ?>
<div class="article_count"><?=$count;?></div><div style="display:inline-block;vertical-align:top;width:61%;padding:14px;padding-left:0px;padding-top:23px;margin:0px;">
		<div class="author_div"><?=$media;?></div>
		<div class="title_div <?
		if(strpos($title, " ")==true || strpos($title, "&nbsp")==true){
			echo "title_wordbreak";
		}
		?>" style=""><?=$title;?></div>
		<div style="font-size:11px;padding:7px;padding-left:0px;padding-bottom:3px;padding-top:10px;">
			<div class="newslist_badge" style="display:table-cell;vertical-align:top;height:14px;">
				<div style="display:inline-block;padding-top:0px;border:0px solid blue;height:9px;float:left"><img src="img/ico_fb.png" style="width:9px;height:9px;margin: 0px 2px 0px 0px;"></div>
				<div style="display:inline-block;padding-top:0px;border:0px solid blue;height:9px;float:left"><?=number_format($facebook_no);?></div>
				<? if($comment_no>0){ ?>
				<div style="display:inline-block;padding-top:0px;border:0px solid blue;height:9px;float:left;margin-left:6px;margin-right:1px"><img src="img/comment_icon.png" style="width:9px;height:9px;margin: 0px 2px 0px 0px;"></div>
				<div style="display:inline-block;padding-top:0px;border:0px solid blue;height:9px;float:left"><?=number_format($comment_no);?></div>
				<? } ?>
			</div>
		</div>
		
		<div class="ratingbadge_<?=$articleno;?>" style="<?
		if($rated_time<1){ 
			echo "display:none;";
			} ?>font-size:11px;padding:7px;padding-left:0px;padding-top:0px">
			<div class="newslist_badge" style="display:table-cell;vertical-align:top;height:14px;border:1px solid #dadada;">
				<div style="display:inline-block;padding-top:0px;border:0px solid blue;height:9px;float:left">
					<img src = "img/new_rating_<?
					//dd
					$img_rate = round($rate*2,0)/2;
					if($rated_time==0){
						echo "none";
					}else{
						echo $img_rate;
					} 
					?>.png" class="ratingstar_to_show_<?=$articleno;?> newslist_stars_img ratingstar_to_show" style=";margin-top:-2px;float:none">
				</div>
				<div class="rating_to_show_<?=$articleno;?>" style="display:inline-block;padding-top:0px;border:0px solid blue;height:9px;float:left">
						<?=sprintf("%.2f", $avg_rate); ?>
				 </div><div style="float:left;">&nbsp;(<div class="rated_time rated_time_<?=$articleno;?>" style="display:inline-block;padding-top:0px;border:0px solid blue;height:9px;"><?=number_format($rated_time);?></div>)</div>
			</div>
		</div>
	</div><div style="position:absolute;right:0px;height:100%;display:inline-block;width:29%;padding:14px;padding-left:0px;margin:0px;border:0px solid pink;text-align:right;padding-top:23px;padding-right:8px;">
		<div class="article_bgcontainer">
			<div class="article_background" style="display:inline-block;width:100%;max-width:180px;height:75px;background: url('<?=$repimage;?>') no-repeat center center;background-size:cover;">&nbsp;</div>
		</div><div style="position:absolute;bottom:0px;right:0px;width:100%;height:30px;border:0px solid gold;text-align:right;">
			<div style="height:40px;display:inline-block;"><img class="article_more" id="article_more_<?=$t;?>_<?=$articleno;?>" data-t="<?=$t;?>" data-articleno="<?=$articleno;?>" data-categoryno="<?=$category;?>" data-belong="<?=$media;?>" data-author="<?=$author;?>" data-mediano="<?=$media_no;?>" data-authorno="<?=$author_no;?>" data-chartid="<?=$articleno."_".$t;?>" src = "./img/date_down.png" style="width:16px;height:16px;padding:6px 24px 6px 24px;"></div>
		</div>
</div>
</div>
</a>

<!-- addon -->
<div id="article_addon_<?=$t;?>_<?=$articleno;?>" class="article_addon" style="display:none;width:100%;">
<!-- 통계, 저자 정보, 공유기능 -->
<div class="article_info">
<?
if($_SESSION['user_id'] == 10113){ ?>
	<div style="float:left;"><a onclick="delete_article(<?=$category;?>, <?=$articleno;?>, <?=$media_no;?>)"><img src = "img/delete.png" style="width:12px;height:12px;margin:5px;margin-top:15px"></a></div>

<? } ?>
	<!-- 가운데 -->
	<div class="article_info_1">
		<div class="article_info_3" style="height:94px">
			<div class="article_info_4" style="">
				<div class="article_info_5"><img src ="img/new_rating_none.png" id="ratingstar_to_show_media_<?=$t;?>_<?=$articleno;?>" class="newslist_stars_img"><em id="media_rate_<?=$t;?>_<?=$articleno;?>" class="media_rate">0.00</em></div>
				<div class="article_info_6"><a href="./media.php?media=<?=$media;?>" class="article_info_7" title="<?=$media;?>"><?=$media;?></a></div>
			</div>
			<div class="article_info_8">
				<? if($author){ ?>
						<div class="article_info_5"><img src = "img/new_rating_none.png" id="ratingstar_to_show_author_<?=$t;?>_<?=$articleno;?>" class="newslist_stars_img"><em id="author_rate_<?=$t;?>_<?=$articleno;?>" class="author_rate">0.00</em></div>
						<div class="article_info_6"><a href="./media.php?media=<?=$media;?>&author=<?=$author;?>" class="article_info_7" title="<?=$author;?>"><?=$author;?></a></div>
				<? } ?>
			</div>
		</div><div class="article_info_2">
			<div id="chart_<?=$articleno."_".$t;?>" class="ratingchart"></div>
		</div>
	</div>
	<!-- 가운데 종료 -->
<!-- 평점 별 -->
<div class="addon_function_div">
	<div class="addon_function article_comment" data-targettile="<?=$t;?>_<?=$articleno;?>" data-t="<?=$t;?>" data-articleno="<?=$articleno;?>" data-categoryno="<?=$category;?>" data-belong="<?=$media;?>" data-author="<?=$author;?>" data-mediano="<?=$media_no;?>" data-authorno="<?=$author_no;?>" data-chartid="<?=$articleno."_".$t;?>" data-dateint="<?=$article_date_int;?>">
		<span id="article_rate_<?=$t;?>_<?=$articleno;?>"><img src="./img/star_icon.png" style="width:12px;height:12px;vertical-align:middle;margin-right:3px;margin-top:-3px;">평점</span><span> / 댓글<?
	if($comment_no>0){
		echo "(".$comment_no.")";
	}
		?></span>
	</div><div class="addon_function article_save" id="article_save_<?=$t;?>_<?=$articleno;?>" data-articleno="<?=$articleno;?>" data-targettile="<?=$t;?>_<?=$articleno;?>">
		<img src="./img/love_icon.png" style="vertical-align:middle;width:12px;height:12px;margin-right:3px;margin-top:-3px"><div style="cursor:pointer;display:inline-block;">담아두기</div>
	</div>
</div>
</div>
</div> <!-- addon 종료 -->

<?
}//if $count
$count++;
} // 기사 목록을 출력하는 부분 foreach
?>

<div style="width:100%;height:40px;text-align:right;margin-bottom:10px;">
<div class="drawdown" data-drawnumber='1'><div style="padding-top:10px">펼쳐보기</div></div>
</div>
</div>

<? //오늘의 랭킹뉴스 종료 ?>
<? } // 만약 실시간으로 보고 있다면 이걸 보여준다 종료 ?>




<? //전날의 랭킹뉴스 시작  ?>
<div style="width:94%;margin-left:3%;margin-right:3%;height:40px;margin-top:12px;padding-top:4px;background-color:#fcfcfc;border:1px solid #e2e2e2;border-bottom:0px;border-radius:3px;padding-left:6px;">
		<div style="display:table-cell;height:20px;padding-top:4px;vertical-align:top">
			<div style="display:inline-block;background-color:rgb(245, 199, 150);width:5px;height:9px;margin-left:8px;margin-top:6px"></div><div style="display:inline-block;background-color:rgb(245, 199, 150);width:5px;height:14px;margin-left:1px;margin-top:6px"></div><div style="display:inline-block;background-color:rgb(245, 199, 150);width:5px;height:6px;margin-left:1px;margin-right:3px;margin-top:6px"></div>
		</div>
		<div style="display:table-cell;height:20px;font-weight:bold;padding-top:9px;vertical-align:top">전날의 순위뉴스</div>
</div>

<?
// 목록출력부
$date_timestamp = strtotime($date_int);
$one_day_ago = date("Y-m-d", $date_timestamp-24*60*60);
$sql = "SELECT textified_list from b_article_textified_1 WHERE date_int='$one_day_ago' AND period_no='4'";
$query = mysql_query($sql);
$result = mysql_fetch_array($query);
$textified_list = $result[0];
$textified_list_array = array();
$textified_list_array = json_decode($textified_list, true);
?>
<div style="min-height:300px">
<?
//여기까지 sql을 하나로 다 모았다 그 sql에는 limit 구문이 없다
//이제 sql에 limit구문을 붙여서 한페이지 분량의 row를 가져온다
if($textified_list == '[]' || $textified_list == '' ){ // 아무것도 없을 경우
?>
<div style="clear:both"?>

<table articleno="<?=$articleno;?>_mark" class="newslist_table">
<tr>
<td style="padding: 30px;">
선택하신 날짜, 기간, 카테고리에 해당하는<br>기사가 없습니다.
</td>
</tr>
</table>
<?
}
else{
$resultout = NULL;
$resultout = mysql_query($sql, $connect) or die(mysql_error());
}
$count=1;
foreach($textified_list_array as $print){
if($count<11){
$t=11;
$articleno = $print['no'];
$url = urldecode($print['url']);
$date_int_now = $print['date_int'];
$category = $print['category'];
$title = urldecode($print['title']);
$title = strip_tags($title);
$title = str_replace(")",")&nbsp;",$title);
$title = str_replace("]","] ",$title);
$title = str_replace("&lt;br&gt;","&nbsp;",$title);
$title = str_replace("&lt;BR&gt;","&nbsp;",$title);
$title = str_replace("…"," … ",$title);
$title = str_replace("/"," / ",$title);
$title = str_replace("···"," ··· ",$title);
$title = str_replace("·"," · ",$title);
$title = str_replace("· · ·","···",$title);
$title = str_replace("  "," ",$title);
$title = str_replace("  "," ",$title);
$title = str_replace("&nbsp;&nbsp;","&nbsp;",$title);
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
?>

<!-- 기사 목록 -->
<a href='<?=$url;?>' class="newslist_a" href='javascript:void()' rel="external" target="_blank" id="newsitem<?=$count?>">
<? if($count < 4){ ?>
<? if($count>1){ ?><div style="width:100%;background-color:#f3f3f3;height:12px"></div> <? }else{ ?>
<div style="width:100%;background-color:#f3f3f3;border-top:0px solid #e2e2e2;height:1px"></div>
<? } ?>
<div <? if($count ==1){ echo "id='article_top_2'";}?> class="article_list article_list_main_2" data-t="<?=$t;?>" data-articleno="<?=$articleno;?>" data-categoryno="<?=$category;?>" data-belong="<?=$media;?>" author="<?=$author;?>" data-mediano="<?=$media_no;?>" data-authorno="<?=$author_no;?>" data-chartid="<?=$articleno."_".$t;?>" data-dateint="<?=$article_date_int;?>" data-targettile="<?=$t;?>_<?=$articleno;?>">
<? }else{ ?>
<div class="article_list_main_2 article_list_hidden" style="display:none;width:100%;background-color:#f3f3f3;border-top:0px solid #e2e2e2;height:12px"></div><div class="article_list article_list_main_2 article_list_hidden" style="display:none" data-t="<?=$t;?>" data-articleno="<?=$articleno;?>" data-categoryno="<?=$category;?>" data-belong="<?=$media;?>" data-author="<?=$author;?>" data-mediano="<?=$media_no;?>" data-authorno="<?=$author_no;?>" data-chartid="<?=$articleno."_".$t;?>" data-dateint="<?=$article_date_int;?>" data-targettile="<?=$t;?>_<?=$articleno;?>">
<? } ?>
<div class="article_count"><?=$count;?></div><div style="display:inline-block;vertical-align:top;width:61%;padding:14px;padding-left:0px;padding-top:23px;margin:0px;">
		<div class="author_div"><?=$media;?></div>
		<div class="title_div <?
		if(strpos($title, " ")==true || strpos($title, "&nbsp")==true){
			echo "title_wordbreak";
		}
		?>" style=""><?=$title;?></div>
				<div style="font-size:11px;padding:7px;padding-left:0px;padding-bottom:3px;padding-top:10px;">
			<div class="newslist_badge" style="display:table-cell;vertical-align:top;height:14px;">
				<div style="display:inline-block;padding-top:0px;border:0px solid blue;height:9px;float:left"><img src="img/ico_fb.png" style="width:9px;height:9px;margin: 0px 2px 0px 0px;"></div>
				<div style="display:inline-block;padding-top:0px;border:0px solid blue;height:9px;float:left"><?=number_format($facebook_no);?></div>
				<? if($comment_no>0){ ?>
				<div style="display:inline-block;padding-top:0px;border:0px solid blue;height:9px;float:left;margin-left:6px;margin-right:1px"><img src="img/comment_icon.png" style="width:9px;height:9px;margin: 0px 2px 0px 0px;"></div>
				<div style="display:inline-block;padding-top:0px;border:0px solid blue;height:9px;float:left"><?=number_format($comment_no);?></div>
				<? } ?>
			</div>
		</div>
		
		<div class="ratingbadge_<?=$articleno;?>" style="<?
		if($rated_time<1){ 
			echo "display:none;";
			} ?>font-size:11px;padding:7px;padding-left:0px;padding-top:0px">
			<div class="newslist_badge" style="display:table-cell;vertical-align:top;height:14px;border:1px solid #dadada;">
				<div style="display:inline-block;padding-top:0px;border:0px solid blue;height:9px;float:left">
					<img src = "img/new_rating_<?
					//dd
					$img_rate = round($rate*2,0)/2;
					if($rated_time==0){
						echo "none";
					}else{
						echo $img_rate;
					} 
					?>.png" class="ratingstar_to_show_<?=$articleno;?> newslist_stars_img ratingstar_to_show" style=";margin-top:-2px;float:none">
				</div>
				<div class="rating_to_show_<?=$articleno;?>" style="display:inline-block;padding-top:0px;border:0px solid blue;height:9px;float:left">
						<?=sprintf("%.2f", $avg_rate); ?>
				 </div><div style="float:left;">&nbsp;(<div class="rated_time rated_time_<?=$articleno;?>" style="display:inline-block;padding-top:0px;border:0px solid blue;height:9px;"><?=number_format($rated_time);?></div>)</div>
			</div>
		</div>
	</div><div style="position:absolute;right:0px;height:100%;display:inline-block;width:29%;padding:14px;padding-left:0px;margin:0px;border:0px solid pink;text-align:right;padding-top:23px;padding-right:8px;">
		<div class="article_bgcontainer">
			<div class="article_background" style="display:inline-block;width:100%;max-width:180px;height:75px;background: url('<?=$repimage;?>') no-repeat center center;background-size:cover;">&nbsp;</div>
		</div><div style="position:absolute;bottom:0px;right:0px;width:100%;height:30px;border:0px solid gold;text-align:right;">
			<div style="height:40px;display:inline-block;"><img class="article_more" id="article_more_<?=$t;?>_<?=$articleno;?>" data-t="<?=$t;?>" data-articleno="<?=$articleno;?>" data-categoryno="<?=$category;?>" data-belong="<?=$media;?>" data-author="<?=$author;?>" data-mediano="<?=$media_no;?>" data-authorno="<?=$author_no;?>" data-chartid="<?=$articleno."_".$t;?>" src = "./img/date_down.png" style="width:16px;height:16px;padding:6px 24px 6px 24px;"></div>
		</div>
</div>
</div>
</a>

<!-- addon -->
<div id="article_addon_<?=$t;?>_<?=$articleno;?>" class="article_addon" style="display:none;width:100%;">
<!-- 통계, 저자 정보, 공유기능 -->
<div class="article_info">
<?
if($_SESSION['user_id'] == 10113){ ?>
	<div style="float:left;"><a onclick="delete_article(<?=$category;?>, <?=$articleno;?>, <?=$media_no;?>)"><img src = "img/delete.png" style="width:12px;height:12px;margin:5px;margin-top:15px"></a></div>

<? } ?>
	<!-- 가운데 -->
	<div class="article_info_1">
		<div class="article_info_3" style="height:94px">
			<div class="article_info_4" style="">
				<div class="article_info_5"><img src ="img/new_rating_none.png" id="ratingstar_to_show_media_<?=$t;?>_<?=$articleno;?>" class="newslist_stars_img"><em id="media_rate_<?=$t;?>_<?=$articleno;?>" class="media_rate">0.00</em></div>
				<div class="article_info_6"><a href="./media.php?media=<?=$media;?>" class="article_info_7" title="<?=$media;?>"><?=$media;?></a></div>
			</div>
			<div class="article_info_8">
				<? if($author){ ?>
						<div class="article_info_5"><img src = "img/new_rating_none.png" id="ratingstar_to_show_author_<?=$t;?>_<?=$articleno;?>" class="newslist_stars_img"><em id="author_rate_<?=$t;?>_<?=$articleno;?>" class="author_rate">0.00</em></div>
						<div class="article_info_6"><a href="./media.php?media=<?=$media;?>&author=<?=$author;?>" class="article_info_7" title="<?=$author;?>"><?=$author;?></a></div>
				<? } ?>
			</div>
		</div><div class="article_info_2">
			<div id="chart_<?=$articleno."_".$t;?>" class="ratingchart"></div>
		</div>
	</div>
	<!-- 가운데 종료 -->
<!-- 평점 별 -->
<div class="addon_function_div">
	<div class="addon_function article_comment" data-targettile="<?=$t;?>_<?=$articleno;?>" data-t="<?=$t;?>" data-articleno="<?=$articleno;?>" data-categoryno="<?=$category;?>" data-belong="<?=$media;?>" data-author="<?=$author;?>" data-mediano="<?=$media_no;?>" data-authorno="<?=$author_no;?>" data-chartid="<?=$articleno."_".$t;?>" data-dateint="<?=$article_date_int;?>">
		<span id="article_rate_<?=$t;?>_<?=$articleno;?>"><img src="./img/star_icon.png" style="width:12px;height:12px;vertical-align:middle;margin-right:3px;margin-top:-3px;">평점</span><span> / 댓글<?
	if($comment_no>0){
		echo "(".$comment_no.")";
	}
		?></span>
	</div><div class="addon_function article_save" id="article_save_<?=$t;?>_<?=$articleno;?>" data-articleno="<?=$articleno;?>" data-targettile="<?=$t;?>_<?=$articleno;?>">
		<img src="./img/love_icon.png" style="vertical-align:middle;width:12px;height:12px;margin-right:3px;margin-top:-3px"><div style="cursor:pointer;display:inline-block;">담아두기</div>
	</div>
</div>
</div>
</div> <!-- addon 종료 -->

<?
}//if $count
$count++;
} // 기사 목록을 출력하는 부분 foreach
?>

<div style="width:100%;height:40px;text-align:right">
<div class="drawdown" data-drawnumber='2'><div style="padding-top:10px">펼쳐보기</div></div>
</div>
</div>

<? //전날의 랭킹뉴스 종료 ?>





<? //한달간의 랭킹뉴스 시작  ?>

<? //전날의 랭킹뉴스 시작  ?>
<div style="width:94%;margin-left:3%;margin-right:3%;height:40px;margin-top:12px;padding-top:4px;background-color:#fcfcfc;border:1px solid #e2e2e2;border-bottom:0px;border-radius:3px;padding-left:6px;">
		<div style="display:table-cell;height:20px;padding-top:4px;vertical-align:top">
			<div style="display:inline-block;background-color:rgb(245, 199, 150);width:5px;height:9px;margin-left:8px;margin-top:6px"></div><div style="display:inline-block;background-color:rgb(245, 199, 150);width:5px;height:14px;margin-left:1px;margin-top:6px"></div><div style="display:inline-block;background-color:rgb(245, 199, 150);width:5px;height:6px;margin-left:1px;margin-right:3px;margin-top:6px"></div>
		</div>
		<div style="display:table-cell;height:20px;font-weight:bold;padding-top:9px;vertical-align:top">한 달간의 순위뉴스</div>
</div>
<?
// 목록출력부
$date_int = $_GET['dateint'];
$date_timestamp = strtotime($date_int);
$one_day_ago = date("Y-m-d", $date_timestamp-24*60*60);
$sql = "SELECT textified_list from b_article_textified_1 WHERE date_int='$one_day_ago' AND period_no='7'";
$query = mysql_query($sql);
$result = mysql_fetch_array($query);
$textified_list = $result[0];
$textified_list_array = array();
$textified_list_array = json_decode($textified_list, true);
?>
<div style="min-height:300px">
<?
//여기까지 sql을 하나로 다 모았다 그 sql에는 limit 구문이 없다
//이제 sql에 limit구문을 붙여서 한페이지 분량의 row를 가져온다
if($textified_list == '[]' || $textified_list == '' ){ // 아무것도 없을 경우
?>
<div style="clear:both"?>

<table articleno="<?=$articleno;?>_mark" class="newslist_table">
<tr>
<td style="padding: 30px;">
선택하신 날짜, 기간, 카테고리에 해당하는<br>기사가 없습니다.
</td>
</tr>
</table>
<?
}
else{
$resultout = NULL;
$resultout = mysql_query($sql, $connect) or die(mysql_error());
}
$count=1;
foreach($textified_list_array as $print){
if($count<11){
$t=12;
$articleno = $print['no'];
$url = urldecode($print['url']);
$date_int_now = $print['date_int'];
$category = $print['category'];
$title = urldecode($print['title']);
$title = strip_tags($title);
$title = str_replace(")",")&nbsp;",$title);
$title = str_replace("]","] ",$title);
$title = str_replace("&lt;br&gt;","&nbsp;",$title);
$title = str_replace("&lt;BR&gt;","&nbsp;",$title);
$title = str_replace("…"," … ",$title);
$title = str_replace("/"," / ",$title);
$title = str_replace("···"," ··· ",$title);
$title = str_replace("·"," · ",$title);
$title = str_replace("· · ·","···",$title);
$title = str_replace("  "," ",$title);
$title = str_replace("  "," ",$title);
$title = str_replace("&nbsp;&nbsp;","&nbsp;",$title);
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

<!-- 기사 목록 -->
<a href='<?=$url;?>' class="newslist_a" href='javascript:void()' rel="external" target="_blank" id="newsitem<?=$count?>">
<? if($count < 4){ ?>
<? if($count>1){ ?><div style="width:100%;background-color:#f3f3f3;height:12px"></div> <? }else{ ?>
<div style="width:100%;background-color:#f3f3f3;border-top:0px solid #e2e2e2;height:1px"></div>
<? } ?><div <? if($count ==1){ echo "id='article_top_3'";}?> class="article_list article_list_main_3" data-t="<?=$t;?>" data-articleno="<?=$articleno;?>" data-categoryno="<?=$category;?>" data-belong="<?=$media;?>" data-author="<?=$author;?>" data-mediano="<?=$media_no;?>" data-authorno="<?=$author_no;?>" data-chartid="<?=$articleno."_".$t;?>" data-dateint="<?=$article_date_int;?>" data-targettile="<?=$t;?>_<?=$articleno;?>">
<? }else{ ?>
<div class="article_list_main_3 article_list_hidden" style="display:none;width:100%;background-color:#f3f3f3;border-top:0px solid #e2e2e2;height:12px"></div><div class="article_list article_list_main_3 article_list_hidden" style="display:none" data-t="<?=$t;?>" data-articleno="<?=$articleno;?>" data-categoryno="<?=$category;?>" data-belong="<?=$media;?>" data-author="<?=$author;?>" data-mediano="<?=$media_no;?>" data-authorno="<?=$author_no;?>" data-chartid="<?=$articleno."_".$t;?>" data-dateint="<?=$article_date_int;?>" data-targettile="<?=$t;?>_<?=$articleno;?>">
<? } ?>
<div class="article_count"><?=$count;?></div><div style="display:inline-block;vertical-align:top;width:61%;padding:14px;padding-left:0px;padding-top:23px;margin:0px;">
		<div class="author_div"><?=$media;?></div>
		<div class="title_div <?
		if(strpos($title, " ")==true || strpos($title, "&nbsp")==true){
			echo "title_wordbreak";
		}
		?>" style=""><?=$title;?></div>
				<div style="font-size:11px;padding:7px;padding-left:0px;padding-bottom:3px;padding-top:10px;">
			<div class="newslist_badge" style="display:table-cell;vertical-align:top;height:14px;">
				<div style="display:inline-block;padding-top:0px;border:0px solid blue;height:9px;float:left"><img src="img/ico_fb.png" style="width:9px;height:9px;margin: 0px 2px 0px 0px;"></div>
				<div style="display:inline-block;padding-top:0px;border:0px solid blue;height:9px;float:left"><?=number_format($facebook_no);?></div>
				<? if($comment_no>0){ ?>
				<div style="display:inline-block;padding-top:0px;border:0px solid blue;height:9px;float:left;margin-left:6px;margin-right:1px"><img src="img/comment_icon.png" style="width:9px;height:9px;margin: 0px 2px 0px 0px;"></div>
				<div style="display:inline-block;padding-top:0px;border:0px solid blue;height:9px;float:left"><?=number_format($comment_no);?></div>
				<? } ?>
			</div>
		</div>
		
		<div class="ratingbadge_<?=$articleno;?>" style="<?
		if($rated_time<1){ 
			echo "display:none;";
			} ?>font-size:11px;padding:7px;padding-left:0px;padding-top:0px">
			<div class="newslist_badge" style="display:table-cell;vertical-align:top;height:14px;border:1px solid #dadada;">
				<div style="display:inline-block;padding-top:0px;border:0px solid blue;height:9px;float:left">
					<img src = "img/new_rating_<?
					//dd
					$img_rate = round($rate*2,0)/2;
					if($rated_time==0){
						echo "none";
					}else{
						echo $img_rate;
					} 
					?>.png" class="ratingstar_to_show_<?=$articleno;?> newslist_stars_img ratingstar_to_show" style=";margin-top:-2px;float:none">
				</div>
				<div class="rating_to_show_<?=$articleno;?>" style="display:inline-block;padding-top:0px;border:0px solid blue;height:9px;float:left">
						<?=sprintf("%.2f", $avg_rate); ?>
				 </div><div style="float:left;">&nbsp;(<div class="rated_time rated_time_<?=$articleno;?>" style="display:inline-block;padding-top:0px;border:0px solid blue;height:9px;"><?=number_format($rated_time);?></div>)</div>
			</div>
		</div>
	</div><div style="position:absolute;right:0px;height:100%;display:inline-block;width:29%;padding:14px;padding-left:0px;margin:0px;border:0px solid pink;text-align:right;padding-top:23px;padding-right:8px;">
		<div class="article_bgcontainer">
			<div class="article_background" style="display:inline-block;width:100%;max-width:180px;height:75px;background: url('<?=$repimage;?>') no-repeat center center;background-size:cover;">&nbsp;</div>
		</div><div style="position:absolute;bottom:0px;right:0px;width:100%;height:30px;border:0px solid gold;text-align:right;">
			<div style="height:40px;display:inline-block;"><img class="article_more" id="article_more_<?=$t;?>_<?=$articleno;?>" data-t="<?=$t;?>" data-articleno="<?=$articleno;?>" data-categoryno="<?=$category;?>" data-belong="<?=$media;?>" data-author="<?=$author;?>" data-mediano="<?=$media_no;?>" data-authorno="<?=$author_no;?>" data-chartid="<?=$articleno."_".$t;?>" src = "./img/date_down.png" style="width:16px;height:16px;padding:6px 24px 6px 24px;"></div>
		</div>
</div>
</div>
</a>

<!-- addon -->
<div id="article_addon_<?=$t;?>_<?=$articleno;?>" class="article_addon" style="display:none;width:100%;">
<!-- 통계, 저자 정보, 공유기능 -->
<div class="article_info">
<?
if($_SESSION['user_id'] == 10113){ ?>
	<div style="float:left;"><a onclick="delete_article(<?=$category;?>, <?=$articleno;?>, <?=$media_no;?>)"><img src = "img/delete.png" style="width:12px;height:12px;margin:5px;margin-top:15px"></a></div>

<? } ?>
	<!-- 가운데 -->
	<div class="article_info_1">
		<div class="article_info_3" style="height:94px">
			<div class="article_info_4" style="">
				<div class="article_info_5"><img src ="img/new_rating_none.png" id="ratingstar_to_show_media_<?=$t;?>_<?=$articleno;?>" class="newslist_stars_img"><em id="media_rate_<?=$t;?>_<?=$articleno;?>" class="media_rate">0.00</em></div>
				<div class="article_info_6"><a href="./media.php?media=<?=$media;?>" class="article_info_7" title="<?=$media;?>"><?=$media;?></a></div>
			</div>
			<div class="article_info_8">
				<? if($author){ ?>
						<div class="article_info_5"><img src = "img/new_rating_none.png" id="ratingstar_to_show_author_<?=$t;?>_<?=$articleno;?>" class="newslist_stars_img"><em id="author_rate_<?=$t;?>_<?=$articleno;?>" class="author_rate">0.00</em></div>
						<div class="article_info_6"><a href="./media.php?media=<?=$media;?>&author=<?=$author;?>" class="article_info_7" title="<?=$author;?>"><?=$author;?></a></div>
				<? } ?>
			</div>
		</div><div class="article_info_2">
			<div id="chart_<?=$articleno."_".$t;?>" class="ratingchart"></div>
		</div>
	</div>
	<!-- 가운데 종료 -->
<!-- 평점 별 -->
<div class="addon_function_div">
	<div class="addon_function article_comment" data-targettile="<?=$t;?>_<?=$articleno;?>" data-t="<?=$t;?>" data-articleno="<?=$articleno;?>" data-categoryno="<?=$category;?>" data-belong="<?=$media;?>" data-author="<?=$author;?>" data-mediano="<?=$media_no;?>" data-authorno="<?=$author_no;?>" data-chartid="<?=$articleno."_".$t;?>" data-dateint="<?=$article_date_int;?>">
		<span id="article_rate_<?=$t;?>_<?=$articleno;?>"><img src="./img/star_icon.png" style="width:12px;height:12px;vertical-align:middle;margin-right:3px;margin-top:-3px;">평점</span><span> / 댓글<?
	if($comment_no>0){
		echo "(".$comment_no.")";
	}
		?></span>
	</div><div class="addon_function article_save" id="article_save_<?=$t;?>_<?=$articleno;?>" data-articleno="<?=$articleno;?>" data-targettile="<?=$t;?>_<?=$articleno;?>">
		<img src="./img/love_icon.png" style="vertical-align:middle;width:12px;height:12px;margin-right:3px;margin-top:-3px"><div style="cursor:pointer;display:inline-block;">담아두기</div>
	</div>
</div>
</div>
</div> <!-- addon 종료 -->

<?//

}//if $count
$count++;
} // 기사 목록을 출력하는 부분 foreach
?>

<div style="width:100%;height:40px;text-align:right">
<div class="drawdown" data-drawnumber='3'><div style="padding-top:10px">펼쳐보기</div></div>
</div>
</div>

<? //한달간의 랭킹뉴스 종료 ?>




<? //반년간의 랭킹뉴스 시작  ?>

<? //전날의 랭킹뉴스 시작  ?>
<div style="width:94%;margin-left:3%;margin-right:3%;height:40px;margin-top:12px;padding-top:4px;background-color:#fcfcfc;border:1px solid #e2e2e2;border-bottom:0px;border-radius:3px;padding-left:6px;">
		<div style="display:table-cell;height:20px;padding-top:4px;vertical-align:top">
			<div style="display:inline-block;background-color:rgb(245, 199, 150);width:5px;height:9px;margin-left:8px;margin-top:6px"></div><div style="display:inline-block;background-color:rgb(245, 199, 150);width:5px;height:14px;margin-left:1px;margin-top:6px"></div><div style="display:inline-block;background-color:rgb(245, 199, 150);width:5px;height:6px;margin-left:1px;margin-right:3px;margin-top:6px"></div>
		</div>
		<div style="display:table-cell;height:20px;font-weight:bold;padding-top:9px;vertical-align:top">반 년간의 순위뉴스</div>
</div>
<?
// 목록출력부
$date_int = $_GET['dateint'];
$date_timestamp = strtotime($date_int);
$one_day_ago = date("Y-m-d", $date_timestamp-24*60*60);
$sql = "SELECT textified_list from b_article_textified_1 WHERE date_int='$one_day_ago' AND period_no='8'";
$query = mysql_query($sql);
$result = mysql_fetch_array($query);
$textified_list = $result[0];
$textified_list_array = array();
$textified_list_array = json_decode($textified_list, true);
?>
<div style="min-height:300px">
<?
//여기까지 sql을 하나로 다 모았다 그 sql에는 limit 구문이 없다
//이제 sql에 limit구문을 붙여서 한페이지 분량의 row를 가져온다
if($textified_list == '[]' || $textified_list == '' ){ // 아무것도 없을 경우
?>
<div style="clear:both"?>

<table articleno="<?=$articleno;?>_mark" class="newslist_table">
<tr>
<td style="padding: 30px;">
선택하신 날짜, 기간, 카테고리에 해당하는<br>기사가 없습니다.
</td>
</tr>
</table>
<?
}
else{
$resultout = NULL;
$resultout = mysql_query($sql, $connect) or die(mysql_error());
}
$count=1;
foreach($textified_list_array as $print){
if($count<11){
$t=13;
$articleno = $print['no'];
$url = urldecode($print['url']);
$date_int_now = $print['date_int'];
$category = $print['category'];
$title = urldecode($print['title']);
$title = strip_tags($title);
$title = str_replace(")",")&nbsp;",$title);
$title = str_replace("]","] ",$title);
$title = str_replace("&lt;br&gt;","&nbsp;",$title);
$title = str_replace("&lt;BR&gt;","&nbsp;",$title);
$title = str_replace("…"," … ",$title);
$title = str_replace("/"," / ",$title);
$title = str_replace("···"," ··· ",$title);
$title = str_replace("·"," · ",$title);
$title = str_replace("· · ·","···",$title);
$title = str_replace("  "," ",$title);
$title = str_replace("  "," ",$title);
$title = str_replace("&nbsp;&nbsp;","&nbsp;",$title);
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

<!-- 기사 목록 -->
<a href='<?=$url;?>' class="newslist_a" href='javascript:void()' rel="external" target="_blank" id="newsitem<?=$count?>">
<? if($count < 4){ ?>
<? if($count>1){ ?><div style="width:100%;background-color:#f3f3f3;height:12px"></div> <? }else{ ?>
<div style="width:100%;background-color:#f3f3f3;border-top:0px solid #e2e2e2;height:1px"></div>
<? } ?><div <? if($count ==1){ echo "id='article_top_4'";}?> class="article_list article_list_main_4" data-t="<?=$t;?>" data-articleno="<?=$articleno;?>" data-categoryno="<?=$category;?>" data-belong="<?=$media;?>" data-author="<?=$author;?>" data-mediano="<?=$media_no;?>" data-authorno="<?=$author_no;?>" data-chartid="<?=$articleno."_".$t;?>" data-dateint="<?=$article_date_int;?>" data-targettile="<?=$t;?>_<?=$articleno;?>">
<? }else{ ?>
<div class="article_list_main_4 article_list_hidden" style="display:none;width:100%;background-color:#f3f3f3;border-top:0px solid #e2e2e2;height:12px"></div><div class="article_list article_list_main_4 article_list_hidden" style="display:none" data-t="<?=$t;?>" data-articleno="<?=$articleno;?>" data-categoryno="<?=$category;?>" data-belong="<?=$media;?>" data-author="<?=$author;?>" data-mediano="<?=$media_no;?>" data-authorno="<?=$author_no;?>" data-chartid="<?=$articleno."_".$t;?>" data-dateint="<?=$article_date_int;?>" data-targettile="<?=$t;?>_<?=$articleno;?>">
<? } ?>
<div class="article_count"><?=$count;?></div><div style="display:inline-block;vertical-align:top;width:61%;padding:14px;padding-left:0px;padding-top:23px;margin:0px;">
		<div class="author_div"><?=$media;?></div>
		<div class="title_div <?
		if(strpos($title, " ")==true || strpos($title, "&nbsp")==true){
			echo "title_wordbreak";
		}
		?>" style=""><?=$title;?></div>
				<div style="font-size:11px;padding:7px;padding-left:0px;padding-bottom:3px;padding-top:10px;">
			<div class="newslist_badge" style="display:table-cell;vertical-align:top;height:14px;">
				<div style="display:inline-block;padding-top:0px;border:0px solid blue;height:9px;float:left"><img src="img/ico_fb.png" style="width:9px;height:9px;margin: 0px 2px 0px 0px;"></div>
				<div style="display:inline-block;padding-top:0px;border:0px solid blue;height:9px;float:left"><?=number_format($facebook_no);?></div>
				<? if($comment_no>0){ ?>
				<div style="display:inline-block;padding-top:0px;border:0px solid blue;height:9px;float:left;margin-left:6px;margin-right:1px"><img src="img/comment_icon.png" style="width:9px;height:9px;margin: 0px 2px 0px 0px;"></div>
				<div style="display:inline-block;padding-top:0px;border:0px solid blue;height:9px;float:left"><?=number_format($comment_no);?></div>
				<? } ?>
			</div>
		</div>
		
		<div class="ratingbadge_<?=$articleno;?>" style="<?
		if($rated_time<1){ 
			echo "display:none;";
			} ?>font-size:11px;padding:7px;padding-left:0px;padding-top:0px">
			<div class="newslist_badge" style="display:table-cell;vertical-align:top;height:14px;border:1px solid #dadada;">
				<div style="display:inline-block;padding-top:0px;border:0px solid blue;height:9px;float:left">
					<img src = "img/new_rating_<?
					//dd
					$img_rate = round($rate*2,0)/2;
					if($rated_time==0){
						echo "none";
					}else{
						echo $img_rate;
					} 
					?>.png" class="ratingstar_to_show_<?=$articleno;?> newslist_stars_img ratingstar_to_show" style=";margin-top:-2px;float:none">
				</div>
				<div class="rating_to_show_<?=$articleno;?>" style="display:inline-block;padding-top:0px;border:0px solid blue;height:9px;float:left">
						<?=sprintf("%.2f", $avg_rate); ?>
				 </div><div style="float:left;">&nbsp;(<div class="rated_time rated_time_<?=$articleno;?>" style="display:inline-block;padding-top:0px;border:0px solid blue;height:9px;"><?=number_format($rated_time);?></div>)</div>
			</div>
		</div>
	</div><div style="position:absolute;right:0px;height:100%;display:inline-block;width:29%;padding:14px;padding-left:0px;margin:0px;border:0px solid pink;text-align:right;padding-top:23px;padding-right:8px;">
		<div class="article_bgcontainer">
			<div class="article_background" style="display:inline-block;width:100%;max-width:180px;height:75px;background: url('<?=$repimage;?>') no-repeat center center;background-size:cover;">&nbsp;</div>
		</div><div style="position:absolute;bottom:0px;right:0px;width:100%;height:30px;border:0px solid gold;text-align:right;">
			<div style="height:40px;display:inline-block;"><img class="article_more" id="article_more_<?=$t;?>_<?=$articleno;?>" data-t="<?=$t;?>" data-articleno="<?=$articleno;?>" data-categoryno="<?=$category;?>" data-belong="<?=$media;?>" data-author="<?=$author;?>" data-mediano="<?=$media_no;?>" data-authorno="<?=$author_no;?>" data-chartid="<?=$articleno."_".$t;?>" src = "./img/date_down.png" style="width:16px;height:16px;padding:6px 24px 6px 24px;"></div>
		</div>
</div>
</div>
</a>

<!-- addon -->
<div id="article_addon_<?=$t;?>_<?=$articleno;?>" class="article_addon" style="display:none;width:100%;">
<!-- 통계, 저자 정보, 공유기능 -->
<div class="article_info">
<?
if($_SESSION['user_id'] == 10113){ ?>
	<div style="float:left;"><a onclick="delete_article(<?=$category;?>, <?=$articleno;?>, <?=$media_no;?>)"><img src = "img/delete.png" style="width:12px;height:12px;margin:5px;margin-top:15px"></a></div>

<? } ?>
	<!-- 가운데 -->
	<div class="article_info_1">
		<div class="article_info_3" style="height:94px">
			<div class="article_info_4" style="">
				<div class="article_info_5"><img src ="img/new_rating_none.png" id="ratingstar_to_show_media_<?=$t;?>_<?=$articleno;?>" class="newslist_stars_img"><em id="media_rate_<?=$t;?>_<?=$articleno;?>" class="media_rate">0.00</em></div>
				<div class="article_info_6"><a href="./media.php?media=<?=$media;?>" class="article_info_7" title="<?=$media;?>"><?=$media;?></a></div>
			</div>
			<div class="article_info_8">
				<? if($author){ ?>
						<div class="article_info_5"><img src = "img/new_rating_none.png" id="ratingstar_to_show_author_<?=$t;?>_<?=$articleno;?>" class="newslist_stars_img"><em id="author_rate_<?=$t;?>_<?=$articleno;?>" class="author_rate">0.00</em></div>
						<div class="article_info_6"><a href="./media.php?media=<?=$media;?>&author=<?=$author;?>" class="article_info_7" title="<?=$author;?>"><?=$author;?></a></div>
				<? } ?>
			</div>
		</div><div class="article_info_2">
			<div id="chart_<?=$articleno."_".$t;?>" class="ratingchart"></div>
		</div>
	</div>
	<!-- 가운데 종료 -->
<!-- 평점 별 -->
<div class="addon_function_div">
	<div class="addon_function article_comment" data-targettile="<?=$t;?>_<?=$articleno;?>" data-t="<?=$t;?>" data-articleno="<?=$articleno;?>" data-categoryno="<?=$category;?>" data-belong="<?=$media;?>" data-author="<?=$author;?>" data-mediano="<?=$media_no;?>" data-authorno="<?=$author_no;?>" data-chartid="<?=$articleno."_".$t;?>" data-dateint="<?=$article_date_int;?>">
		<span id="article_rate_<?=$t;?>_<?=$articleno;?>"><img src="./img/star_icon.png" style="width:12px;height:12px;vertical-align:middle;margin-right:3px;margin-top:-3px;">평점</span><span> / 댓글<?
	if($comment_no>0){
		echo "(".$comment_no.")";
	}
		?></span>
	</div><div class="addon_function article_save" id="article_save_<?=$t;?>_<?=$articleno;?>" data-articleno="<?=$articleno;?>" data-targettile="<?=$t;?>_<?=$articleno;?>">
		<img src="./img/love_icon.png" style="vertical-align:middle;width:12px;height:12px;margin-right:3px;margin-top:-3px"><div style="cursor:pointer;display:inline-block;">담아두기</div>
	</div>
</div>
</div>
</div> <!-- addon 종료 -->

<?//

}//if $count
$count++;
} // 기사 목록을 출력하는 부분 foreach
?>

<div style="width:100%;height:40px;text-align:right">
<div class="drawdown" data-drawnumber='4'><div style="padding-top:10px">펼쳐보기</div></div>
</div>
</div>

<? //반년간의 랭킹뉴스 종료 ?>






<? //일년간의 랭킹뉴스 시작  ?>

<? //전날의 랭킹뉴스 시작  ?>
<div style="width:94%;margin-left:3%;margin-right:3%;height:40px;margin-top:12px;padding-top:4px;background-color:#fcfcfc;border:1px solid #e2e2e2;border-bottom:0px;border-radius:3px;padding-left:6px;">
		<div style="display:table-cell;height:20px;padding-top:4px;vertical-align:top">
			<div style="display:inline-block;background-color:rgb(245, 199, 150);width:5px;height:9px;margin-left:8px;margin-top:6px"></div><div style="display:inline-block;background-color:rgb(245, 199, 150);width:5px;height:14px;margin-left:1px;margin-top:6px"></div><div style="display:inline-block;background-color:rgb(245, 199, 150);width:5px;height:6px;margin-left:1px;margin-right:3px;margin-top:6px"></div>
		</div>
		<div style="display:table-cell;height:20px;font-weight:bold;padding-top:9px;vertical-align:top">일 년간의 순위뉴스</div>
</div>
<?
// 목록출력부
$date_int = $_GET['dateint'];
$date_timestamp = strtotime($date_int);
$one_day_ago = date("Y-m-d", $date_timestamp-24*60*60);
$sql = "SELECT textified_list from b_article_textified_1 WHERE date_int='$one_day_ago' AND period_no='9'";
$query = mysql_query($sql);
$result = mysql_fetch_array($query);
$textified_list = $result[0];
$textified_list_array = array();
$textified_list_array = json_decode($textified_list, true);
?>
<div style="min-height:300px">
<?
//여기까지 sql을 하나로 다 모았다 그 sql에는 limit 구문이 없다
//이제 sql에 limit구문을 붙여서 한페이지 분량의 row를 가져온다
if($textified_list == '[]' || $textified_list == '' ){ // 아무것도 없을 경우
?>
<div style="clear:both"?>

<table articleno="<?=$articleno;?>_mark" class="newslist_table">
<tr>
<td style="padding: 30px;">
선택하신 날짜, 기간, 카테고리에 해당하는<br>기사가 없습니다.
</td>
</tr>
</table>
<?
}
else{
$resultout = NULL;
$resultout = mysql_query($sql, $connect) or die(mysql_error());
}
$count=1;
foreach($textified_list_array as $print){
if($count<11){
$t=14;
$articleno = $print['no'];
$url = urldecode($print['url']);
$date_int_now = $print['date_int'];
$category = $print['category'];
$title = urldecode($print['title']);
$title = strip_tags($title);
$title = str_replace(")",")&nbsp;",$title);
$title = str_replace("]","] ",$title);
$title = str_replace("&lt;br&gt;","&nbsp;",$title);
$title = str_replace("&lt;BR&gt;","&nbsp;",$title);
$title = str_replace("…"," … ",$title);
$title = str_replace("/"," / ",$title);
$title = str_replace("···"," ··· ",$title);
$title = str_replace("·"," · ",$title);
$title = str_replace("· · ·","···",$title);
$title = str_replace("  "," ",$title);
$title = str_replace("  "," ",$title);
$title = str_replace("&nbsp;&nbsp;","&nbsp;",$title);
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

<!-- 기사 목록 -->
<a href='<?=$url;?>' class="newslist_a" href='javascript:void()' rel="external" target="_blank" id="newsitem<?=$count?>">
<? if($count < 4){ ?>
<? if($count>1){ ?><div style="width:100%;background-color:#f3f3f3;height:12px"></div> <? }else{ ?>
<div style="width:100%;background-color:#f3f3f3;border-top:0px solid #e2e2e2;height:1px"></div>
<? } ?><div <? if($count ==1){ echo "id='article_top_5'";}?> class="article_list article_list_main_5" data-t="<?=$t;?>" data-articleno="<?=$articleno;?>" data-categoryno="<?=$category;?>" data-belong="<?=$media;?>" data-author="<?=$author;?>" data-mediano="<?=$media_no;?>" data-authorno="<?=$author_no;?>" data-chartid="<?=$articleno."_".$t;?>" data-dateint="<?=$article_date_int;?>" data-targettile="<?=$t;?>_<?=$articleno;?>">
<? }else{ ?>
<div class="article_list_main_5 article_list_hidden" style="display:none;width:100%;background-color:#f3f3f3;border-top:0px solid #e2e2e2;height:12px"></div><div class="article_list article_list_main_5 article_list_hidden" style="display:none" data-t="<?=$t;?>" data-articleno="<?=$articleno;?>" data-categoryno="<?=$category;?>" data-belong="<?=$media;?>" data-author="<?=$author;?>" data-mediano="<?=$media_no;?>" data-authorno="<?=$author_no;?>" data-chartid="<?=$articleno."_".$t;?>" data-dateint="<?=$article_date_int;?>" data-targettile="<?=$t;?>_<?=$articleno;?>">
<? } ?>
<div class="article_count"><?=$count;?></div><div style="display:inline-block;vertical-align:top;width:61%;padding:14px;padding-left:0px;padding-top:23px;margin:0px;">
		<div class="author_div"><?=$media;?></div>
		<div class="title_div <?
		if(strpos($title, " ")==true || strpos($title, "&nbsp")==true){
			echo "title_wordbreak";
		}
		?>" style=""><?=$title;?></div>
				<div style="font-size:11px;padding:7px;padding-left:0px;padding-bottom:3px;padding-top:10px;">
			<div class="newslist_badge" style="display:table-cell;vertical-align:top;height:14px;">
				<div style="display:inline-block;padding-top:0px;border:0px solid blue;height:9px;float:left"><img src="img/ico_fb.png" style="width:9px;height:9px;margin: 0px 2px 0px 0px;"></div>
				<div style="display:inline-block;padding-top:0px;border:0px solid blue;height:9px;float:left"><?=number_format($facebook_no);?></div>
				<? if($comment_no>0){ ?>
				<div style="display:inline-block;padding-top:0px;border:0px solid blue;height:9px;float:left;margin-left:6px;margin-right:1px"><img src="img/comment_icon.png" style="width:9px;height:9px;margin: 0px 2px 0px 0px;"></div>
				<div style="display:inline-block;padding-top:0px;border:0px solid blue;height:9px;float:left"><?=number_format($comment_no);?></div>
				<? } ?>
			</div>
		</div>
		
		<div class="ratingbadge_<?=$articleno;?>" style="<?
		if($rated_time<1){ 
			echo "display:none;";
			} ?>font-size:11px;padding:7px;padding-left:0px;padding-top:0px">
			<div class="newslist_badge" style="display:table-cell;vertical-align:top;height:14px;border:1px solid #dadada;">
				<div style="display:inline-block;padding-top:0px;border:0px solid blue;height:9px;float:left">
					<img src = "img/new_rating_<?
					//dd
					$img_rate = round($rate*2,0)/2;
					if($rated_time==0){
						echo "none";
					}else{
						echo $img_rate;
					} 
					?>.png" class="ratingstar_to_show_<?=$articleno;?> newslist_stars_img ratingstar_to_show" style=";margin-top:-2px;float:none">
				</div>
				<div class="rating_to_show_<?=$articleno;?>" style="display:inline-block;padding-top:0px;border:0px solid blue;height:9px;float:left">
						<?=sprintf("%.2f", $avg_rate); ?>
				 </div><div style="float:left;">&nbsp;(<div class="rated_time rated_time_<?=$articleno;?>" style="display:inline-block;padding-top:0px;border:0px solid blue;height:9px;"><?=number_format($rated_time);?></div>)</div>
			</div>
		</div>
	</div><div style="position:absolute;right:0px;height:100%;display:inline-block;width:29%;padding:14px;padding-left:0px;margin:0px;border:0px solid pink;text-align:right;padding-top:23px;padding-right:8px;">
		<div class="article_bgcontainer">
			<div class="article_background" style="display:inline-block;width:100%;max-width:180px;height:75px;background: url('<?=$repimage;?>') no-repeat center center;background-size:cover;">&nbsp;</div>
		</div><div style="position:absolute;bottom:0px;right:0px;width:100%;height:30px;border:0px solid gold;text-align:right;">
			<div style="height:40px;display:inline-block;"><img class="article_more" id="article_more_<?=$t;?>_<?=$articleno;?>" data-t="<?=$t;?>" data-articleno="<?=$articleno;?>" data-categoryno="<?=$category;?>" data-belong="<?=$media;?>" data-author="<?=$author;?>" data-mediano="<?=$media_no;?>" data-authorno="<?=$author_no;?>" data-chartid="<?=$articleno."_".$t;?>" src = "./img/date_down.png" style="width:16px;height:16px;padding:6px 24px 6px 24px;"></div>
		</div>
</div>
</div>
</a>

<!-- addon -->
<div id="article_addon_<?=$t;?>_<?=$articleno;?>" class="article_addon" style="display:none;width:100%;">
<!-- 통계, 저자 정보, 공유기능 -->
<div class="article_info">
<?
if($_SESSION['user_id'] == 10113){ ?>
	<div style="float:left;"><a onclick="delete_article(<?=$category;?>, <?=$articleno;?>, <?=$media_no;?>)"><img src = "img/delete.png" style="width:12px;height:12px;margin:5px;margin-top:15px"></a></div>

<? } ?>
	<!-- 가운데 -->
	<div class="article_info_1">
		<div class="article_info_3" style="height:94px">
			<div class="article_info_4" style="">
				<div class="article_info_5"><img src ="img/new_rating_none.png" id="ratingstar_to_show_media_<?=$t;?>_<?=$articleno;?>" class="newslist_stars_img"><em id="media_rate_<?=$t;?>_<?=$articleno;?>" class="media_rate">0.00</em></div>
				<div class="article_info_6"><a href="./media.php?media=<?=$media;?>" class="article_info_7" title="<?=$media;?>"><?=$media;?></a></div>
			</div>
			<div class="article_info_8">
				<? if($author){ ?>
						<div class="article_info_5"><img src = "img/new_rating_none.png" id="ratingstar_to_show_author_<?=$t;?>_<?=$articleno;?>" class="newslist_stars_img"><em id="author_rate_<?=$t;?>_<?=$articleno;?>" class="author_rate">0.00</em></div>
						<div class="article_info_6"><a href="./media.php?media=<?=$media;?>&author=<?=$author;?>" class="article_info_7" title="<?=$author;?>"><?=$author;?></a></div>
				<? } ?>
			</div>
		</div><div class="article_info_2">
			<div id="chart_<?=$articleno."_".$t;?>" class="ratingchart"></div>
		</div>
	</div>
	<!-- 가운데 종료 -->
<!-- 평점 별 -->
<div class="addon_function_div">
	<div class="addon_function article_comment" data-targettile="<?=$t;?>_<?=$articleno;?>" data-t="<?=$t;?>" data-articleno="<?=$articleno;?>" data-categoryno="<?=$category;?>" data-belong="<?=$media;?>" data-author="<?=$author;?>" data-mediano="<?=$media_no;?>" data-authorno="<?=$author_no;?>" data-chartid="<?=$articleno."_".$t;?>" data-dateint="<?=$article_date_int;?>">
		<span id="article_rate_<?=$t;?>_<?=$articleno;?>"><img src="./img/star_icon.png" style="width:12px;height:12px;vertical-align:middle;margin-right:3px;margin-top:-3px;">평점</span><span> / 댓글<?
	if($comment_no>0){
		echo "(".$comment_no.")";
	}
		?></span>
	</div><div class="addon_function article_save" id="article_save_<?=$t;?>_<?=$articleno;?>" data-articleno="<?=$articleno;?>" data-targettile="<?=$t;?>_<?=$articleno;?>">
		<img src="./img/love_icon.png" style="vertical-align:middle;width:12px;height:12px;margin-right:3px;margin-top:-3px"><div style="cursor:pointer;display:inline-block;">담아두기</div>
	</div>
</div>
</div>
</div> <!-- addon 종료 -->

<?//

}//if $count
$count++;
} // 기사 목록을 출력하는 부분 foreach
?>

<div style="width:100%;height:40px;text-align:right;margin-bottom:20px;">
<div class="drawdown" data-drawnumber='5' style="margin-right:3%"><div style="padding-top:10px;">펼쳐보기</div></div>
</div>
</div>

<? //일년간의 랭킹뉴스 종료 ?>

</div>
<?
//include("footer.php");
?>