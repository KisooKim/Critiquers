<?
$sql0 = "SELECT * from c_cluster WHERE dateint='$date_int' ORDER BY facebook_total desc";
$resultout0 = mysql_query($sql0);
$numResults0 = mysql_num_rows($resultout0);
if($numResults0==0){ ?>
	<div style="width:100%;padding:40px;">아직 해당 날짜의 이슈모음이 없습니다.</div>
<? }

$cluster_count = 1;
while($print1 = mysql_fetch_array($resultout0)){ // 뉴스 클러스터를 뿌려준다
	$no = $print1[0];
	$facebook_total = $print1[2];
	$articlelist = $print1[3];
	$articlelist_array = explode(',', $articlelist);
	$articlelist_count = sizeof($articlelist_array);
$sql = "SELECT * from b_article_all WHERE no IN($articlelist) ORDER by facebook_no desc";
$count=1;
$resultout = mysql_query($sql);
$numResults = mysql_num_rows($resultout);
if($numResults>10){
	$numResults = 10;
}

while($print = mysql_fetch_array($resultout)){ // 그 클러스터의 기사들을 뿌려준다
$articleno = $print[0];
$url = $print[1];
$title = $print[2];
$title = html_entity_decode($title);
$article_date_int = $print[3];
$categoryno = $print[5];
$media = $print[6];
$media_no = $print[7];
$author = $print[8];
$author_no = $print[9];
$rate_total = $print[10];
$rated_time = $print[11];
if($rated_time>0){
	$or = $rate_total/$rated_time;
}else{
	$or = 0;
}
$avg_rate = round($or*100,0)/100;
$rate = round($or*2,0)/2*10;
$facebook_no = $print[13];
$twitter_no = $print[14];
$repimage = urldecode($print['rep_image']);
if($repimage == 'cqrs_noimage'){
	$repimage = '';
}
if($count<16){ //100개까지만 게시합니다
if($count == 1){ //클러스터링 제목을 뽑아냅니다 ?>

<div style="width:100%;background-color:#f3f3f3;border-top:1px solid #e2e2e2;height:12px<?
if($cluster_count ==1){ echo 'display:none;border:0px;'; }?>"></div><div class="cluster_title" data-articlelist="<?=$articlelist;?>" data-t="<?=$t;?>" data-articleno="<?=$articleno;?>" data-categoryno="<?=$category;?>" data-belong="<?=$media;?>" data-author="<?=$author;?>" data-mediano="<?=$media_no;?>" data-authorno="<?=$author_no;?>" data-chartid="<?=$articleno."_".$t;?>" data-dateint="<?=$article_date_int;?>" data-clusterno="<?=$cluster_count;?>" <?
	if($cluster_count==1 && $k==0){
		echo "style='background-color:#eaeaea'";
	}
	?>>

	<div class="article_info_10" style="display:table-cell;<?if($repimage){?>background: url('<?=$repimage;?>') no-repeat center center;<? }?>background-size:cover;">
		<span class="article_info_11" style="background-color:rgba(0, 128, 128, .58);"><?=$cluster_count;?></span>
	</div>
	<div class="article_info_12" style="display:table-cell;">
		<div class="article_info_13">
		<div class="title_div"><?=$title;?></div>
		</div>

		<div class="newslist_newsbox_span_author"><b style="color:teal"><?=$articlelist_count;?></b>건의 관련 기사가 <b style="color:teal"><?=number_format($facebook_total);?></b>회 공유</div>
	</div>
</div>

<? } //클러스터링 제목 종료
// -- 기사 목록 --
//include('./include_main_news_list_cluster_article.php');
}//if $count
$count++;
$t++;
}// 기사 목록을 출력하는 부분 foreach
$cluster_count++;
}//뉴스 클러스터를 뿌려준다 종료
?>
<div style="width:100%;border-top:1px solid #eaeaea;"></div>