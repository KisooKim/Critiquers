<?php
session_start();
require("/var/www/html/include_connect.php");
$date_int = $_GET['dateint'];
if($date_int==''){
	$date_int = date("Y-m-d");
}
$periodno = $_GET['periodno'];
if($periodno==''){
	$periodno = 3;
}
$media = $_GET['media'];
$author = $_GET['author'];
$time = strtotime($date_int);

$today = date("Y-m-d");
$date_int_time = strtotime($date_int);
$date_int_temp = date("Y-m-d", $date_int_time+15*24*60*60);
if($date_int_temp < $today){ //충분히 과거
	$date_int_chart = $date_int_temp;
}else{ //가까운 과거
	$date_int_chart = $today;
}


$period_array = array(
"date_int='".date("Y-m-d", $time)."'",
"date_int<='".date("Y-m-d", $time)."' AND date_int>='".date("Y-m-d", $time-3*24*60*60)."'",
"date_int<='".date("Y-m-d", $time)."' AND date_int>='".date("Y-m-d", $time-7*24*60*60)."'",
"date_int<='".date("Y-m-d", $time)."' AND date_int>='".date("Y-m-d", $time-31*24*60*60)."'",
"date_int<='".date("Y-m-d", $time)."' AND date_int>='".date("Y-m-d", $time-31*6*24*60*60)."'",
"date_int<='".date("Y-m-d", $time)."' AND date_int>='".date("Y-m-d", $time-365*24*60*60)."'"
);
if($author==''){
?>
<div id="mainchart" class="mainchart" style="width:100%;height:180px;padding-top:18px;"></div>
<?
}
//media no와 author no를 추출한다
$sql = "SELECT no from e_medialist WHERE media_name = '$media'";
$query = mysql_query($sql);
$result = mysql_fetch_array($query);
$media_no = $result[0];
if($author!=''){ //author 변수가 있을 경우 author_no를 찾는다
	$sql = "SELECT * from e_authorlist WHERE author_name = '$author' AND media_no='$media_no'";
	$query = mysql_query($sql);
	$result = mysql_fetch_array($query);
	$media_author_no = $result[0];
	$author_avg_rate = $result[4];
	$author_avg_rated_time = $result[5];
}

//media의 타이틀 (평가랑 타이틀있는 부분)
$sql2 = "SELECT media_name, url, avg_rate, rated_time from e_medialist WHERE no='$media_no'";
$result2 = mysql_query($sql2) or die(mysqli_error($this->db_link));
$result_array2 = mysql_fetch_array($result2);
$media_name = $result_array2[0];
$media_url = $result_array2[1];
$sql3 = "SELECT sum(facebook_no) AS facebook_sum from h_snscount_media WHERE $period_array[$periodno] AND media_no='$media_no'";
$result3 = mysql_query($sql3) or die(mysqli_error($this->db_link));
$result_array3 = mysql_fetch_array($result3);
$media_facebook_no = $result_array3[0];
$media_twitter_no = $result_array3[1];
$sql4 = "SELECT avg(rating), count(rating) from c_rating WHERE $period_array[$periodno] GROUP BY media_no having media_no=$media_no";
$result4 = mysql_query($sql4, $connect) or die(mysql_error());
$result_array4 = mysql_fetch_array($result4);
$media_avg_rate = $result_array4[0];
$media_rated_time = $result_array4[1];
?>

<a class="newslist_a" href='media.php?media=<?=urlencode($media_name);?>' id="newsitem<?=$count?>"><div class="article_list_media" style="margin-bottom:13px;margin-top:13px;">
	<div class="article_info_10" style="background: none; width:24%;height:96px;">
		<div class="newslist_article_no" style="float:left;margin-left:0px;">
		</div>
		<!-- 동그라미 시작 -->
		<div style="border-radius:70px 70px 0% 0%;border:1px solid #D4D4D4;border-bottom:0px;width:70px;height:35px;margin:3px 5px 0px 20px;text-align:center">
			<div style="width:100%;height:100%;text-align:center;"><div style="width:100%;margin-top:6px;font-style:italic;margin-left:0px;font-size:14px"><?
						$ratetoshow = round($media_avg_rate,2);
						printf("%.2f", $ratetoshow);
						?></div><div><?
						$rate = 5*round($media_avg_rate*2,0)
						?><img src = "img/new_rating_<?
									if($media_avg_rate==NULL){
										echo "none";
									}else{
										echo $rate;
									} 
									?>.png" class="" style="width:60px;margin-top:0px">
					</div>
			</div>
		</div>
		<div style="border-radius:0% 0% 70px 70px;border:1px solid #D4D4D4;border-top:0px;width:70px;height:35px;margin:0px 5px 10px 20px;text-align:center;padding-top:0px;overflow:hidden">
			<div style="border-top:1px solid #D4D4D4;margin:auto;width:100%;height:75%;text-align:center;overflow:hidden;">
				<div style="margin:auto;margin-top:5px;width:60%;height:60%;background: url('img/media/<?=$media_name;?>.png') no-repeat center center;background-size:cover;background-size: contain;"></div>
			</div>
		</div>
		<!-- 동그라미 끝 -->
	</div>
	<div class="article_info_12" style="width:43%;margin:0px;border:0px solid pink;vertical-align:top;">
		<div class="newslist_newsbox_in" style="width:100%;float:left;white-space:nowrap;overflow: hidden;text-overflow:ellipsis;padding:0px;margin-left:10px;">
				<div class="newslist_newsbox_in_in" style="margin-top:4px;"> 
					<div style="margin-bottom:7px;width:100%;">
					<h4 class="newslist_title_h4" style="font-size:16px;line-height:1.32;margin-bottom:0px;"><?
							echo $media_name;
							?></h4><div style="width:100%;height:15px;font-size:11px;color:#C0C0C0;white-space:nowrap;overflow: hidden;text-overflow:ellipsis;"><?=$media_url;?></div>
					</div>
					<div class="newslist_badge" style="display:table-cell;vertical-align:top;height:14px;">
						<div style="display:inline-block;padding-top:0px;border:0px solid blue;height:9px;float:left"><img src="img/ico_fb.png" style="width:9px;height:9px;margin: 0px 2px 0px 0px;"></div>
						<div style="display:inline-block;padding-top:0px;border:0px solid blue;height:9px;float:left"><?=number_format($media_facebook_no);?></div>
						<div style="display:inline-block;padding-top:0px;border:0px solid blue;height:9px;float:left;margin-left:4px"><img src="img/ico_str.png" style="width:9px;height:9px;margin: 0px 2px 0px 0px;"></div>
						<div id="rated_time_<?=$t;?>_<?=$articleno;?>" class="rated_time" style="display:inline-block;padding-top:0px;border:0px solid blue;height:9px;float:left"><?=number_format($media_rated_time);?></div>
					</div>
				</div>
		</div>
	</div>
	<div class="article_info_13" style="width:27%;height:96px;border:0px solid purple;padding:4px 10px 4px 0px;vertical-align:top">
		<div id="media_chart" class="newslist_newsbox" style="width:100%;height:100%;float:left;margin-top:10px;margin-bottom:6px;text-align:center"></div>
	</div>
</div></a>
<?
if($media_author_no){
//author의 타이틀 (평가랑 타이틀있는 부분)
$sql5 = "SELECT sum(facebook_no) AS facebook_sum from h_snscount_author WHERE $period_array[$periodno] AND author_no='$media_author_no'";
$result5 = mysql_query($sql5) or die(mysqli_error($this->db_link));
$result_array5 = mysql_fetch_array($result5);
$author_facebook_no = $result_array5[0];
//$author_twitter_no = $result_array5[1];
$sql6 = "SELECT avg(rating), count(rating) from c_rating WHERE $period_array[$periodno] GROUP BY author_no having author_no=$media_author_no";
$result6 = mysql_query($sql6, $connect) or die(mysql_error());
$result_array6 = mysql_fetch_array($result6);
$author_avg_rate = $result_array6[0];
$author_rated_time = $result_array6[1];
?>

<a class="newslist_a" href='media.php?media=<?=urlencode($media_name);?>' id="newsitem<?=$count?>"><div class="article_list_media">
	<div class="article_info_10" style="background: none; width:24%;height:96px;">
		<div class="newslist_article_no" style="float:left;margin-left:0px;">
		</div>
		<!-- 동그라미 시작 -->
		<div style="border-radius:70px 70px 0% 0%;border:1px solid #D4D4D4;border-bottom:0px;width:70px;height:35px;margin:3px 5px 0px 20px;text-align:center">
			<div style="width:100%;height:100%;text-align:center;"><div style="width:100%;margin-top:6px;font-style:italic;margin-left:0px;font-size:14px"><?
						$ratetoshow = round($author_avg_rate,2);
						printf("%.2f", $ratetoshow);
						?></div><div><?
						$rate = 5*round($author_avg_rate*2,0)
						?><img src = "img/new_rating_<?
									if($author_avg_rate==NULL){
										echo "none";
									}else{
										echo $rate;
									} 
									?>.png" class="" style="width:60px;margin-top:0px">
					</div>
			</div>
		</div>
		<div style="border-radius:0% 0% 70px 70px;border:1px solid #D4D4D4;border-top:0px;width:70px;height:35px;margin:0px 5px 10px 20px;text-align:center;padding-top:0px;overflow:hidden">
			<div style="border-top:1px solid #D4D4D4;margin:auto;width:100%;height:75%;text-align:center;overflow:hidden;">
				<div style="margin:auto;margin-top:5px;width:60%;height:60%;background: url('img/media/<?=$media_name;?>.png') no-repeat center center;background-size:cover;background-size: contain;"></div>
			</div>
		</div>
		<!-- 동그라미 끝 -->
	</div>
	<div class="article_info_12" style="width:43%;height:96px;margin:0px;border:0px solid pink;vertical-align:top;">
		<div class="newslist_newsbox_in" style="width:100%;float:left;white-space:nowrap;overflow: hidden;text-overflow:ellipsis;padding:0px;margin-left:10px;">
				<div class="newslist_newsbox_in_in" style="margin-top:4px;"> 
					<div style="margin-bottom:7px;width:100%;">
					<h4 class="newslist_title_h4" style="font-size:16px;line-height:1.32;margin-bottom:0px;"><?
							echo $author;
							?></h4><div style="width:100%;height:15px;font-size:11px;color:#C0C0C0;white-space:nowrap;overflow: hidden;text-overflow:ellipsis;"><?=$media_name;?></div>
					</div>
					<div class="newslist_badge" style="display:table-cell;vertical-align:top;height:14px;padding-left:4px">
						<!--<div style="display:inline-block;padding-top:0px;border:0px solid blue;height:9px;float:left"><img src="img/ico_fb.png" style="width:9px;height:9px;margin: 0px 2px 0px 0px;"></div>
						<div style="display:inline-block;padding-top:0px;border:0px solid blue;height:9px;float:left">--><?
						//=number_format($facebook_no);
						?><!--</div>-->
						<div style="display:inline-block;padding-top:0px;border:0px solid blue;height:9px;float:left;margin-left:4px"><img src="img/ico_str.png" style="width:9px;height:9px;margin: 0px 2px 0px 0px;"></div>
						<div id="rated_time_<?=$t;?>_<?=$articleno;?>" class="rated_time" style="display:inline-block;padding-top:0px;border:0px solid blue;height:9px;float:left"><?=number_format($author_rated_time);?></div>
					</div>
				</div>
		</div>
	</div>
	<div class="article_info_13" style="width:27%;height:96px;border:0px solid purple;padding:4px 10px 4px 0px;vertical-align:top">
		<div id="author_chart" class="newslist_newsbox" style="width:100%;height:100%;float:left;margin-top:10px;margin-bottom:6px;text-align:center"></div>
	</div>
</div></a>

<?
}//if authorno
?>
<script type="text/javascript"> //미디어 그래프
function numberWithCommas(x) {
	return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}
var color = ["#9fc05a", "#ccdb38", "#eaff5b", "#ffd834", "#ffb05b", "#ff8b5a"];
$(document).ready(function(){ //탭 클릭할 떄 submit 하기
	$("#media_chart").html('');
})
var outerwidth2 = $("#media_chart").width();
//var outerwidth2 = 90;
var outerheight2 = 70;

var margin2 = {top: 0, right: 0, bottom: 2, left: 15}
	width2 = outerwidth2 - margin2.left - margin2.right,
	height2 = outerheight2 - margin2.top - margin2.bottom;

var svgcontmedia = d3.select("#media_chart").append("svg")
	.attr("width", width2 + margin2.left + margin2.right)
	.attr("height", height2 + margin2.top + margin2.bottom)
	.append("g")
	.attr("transform", "translate(" + margin2.left + "," + margin2.top + ")");

d3.json("../rssdb/data_media_eval.php?media_no=<?=$media_no;?>&dateint=<?=$date_int;?>&periodno=<?=$periodno;?>", function(dataset){
	console.log(dataset);
	dataset.forEach(function(d) {
		d.count = +d.count;
	});
	var max = d3.max(dataset, function(d) { return parseInt(d.count); })
	var xScale = d3.scale.linear()
		.domain([0, max])
		.range([0, width2])

	svgcontmedia.selectAll(".bar")
		.data(dataset)
		.enter()
		.append("rect")
		.attr("fill", function(d, i){
    			return color[i];
		})
		.attr("x", 4)
		.attr("y", function(d, i){
    			return i * (height2 / dataset.length)+2;
		})
		.attr("height", height2 / dataset.length)
		.attr("width", function(d){
			return xScale(d.count) + 'px';
		})

	// add legend   
	var legendmedia = svgcontmedia.append("g")
	.attr("class", "legend")
	.attr("x", width2)
	.attr("y", 50)
	.attr("height", height2)
	.attr("width", 10)
	.attr('transform', 'translate(-12,9)')
	
	legendmedia.selectAll('text')
	.data(dataset)
	.enter()
	.append("text")
	.attr("x", 0)
	.attr("y", function(d, i){
		return i * height2/dataset.length+1;
	})
	.text(function(d) {
		return "☆"+d.rate;
	})
	.style("fill", "#505050")
	.style("font-size", "8px")

	var valuemedia = svgcontmedia.append("g")
	.attr("class", "legend")
	.attr("x", width2)
	.attr("y", 50)
	.attr("height", height2)
	.attr("width", 10)
	.attr('transform', 'translate(3,9)')
	
	valuemedia.selectAll('text')
	.data(dataset)
	.enter()
	.append("text")
	.attr("x", 4)
	.attr("y", function(d, i){
		return i * height2/dataset.length+1;
	})
	.text(function(d) {
		return numberWithCommas(d.count);
	})
	.style("fill", "#505050")
	.style("font-size", "8px")
})//dataset 종료
</script>
<? if($author!=NULL){ ?>
<script type="text/javascript"> // author 있을때 그래프 그리기
function numberWithCommas(x) {
	return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}
var color = ["#9fc05a", "#ccdb38", "#eaff5b", "#ffd834", "#ffb05b", "#ff8b5a"];
$(document).ready(function(){ //탭 클릭할 떄 submit 하기
	$("#author_chart").html('');
})

var outerwidth2 = $("#author_chart").width();
var outerheight2 = 70;
var margin2 = {top: 0, right: 0, bottom: 2, left: 15}
	width2 = outerwidth2 - margin2.left - margin2.right,
	height2 = outerheight2 - margin2.top - margin2.bottom;

var svgcontauthor = d3.select("#author_chart").append("svg")
	.attr("width", width2 + margin2.left + margin2.right)
	.attr("height", height2 + margin2.top + margin2.bottom)
	.append("g")
	.attr("transform", "translate(" + margin2.left + "," + margin2.top + ")");

d3.json("../rssdb/data_author_eval.php?author_no=<?=$media_author_no;?>&dateint=<?=$date_int;?>&periodno=<?=$periodno;?>", function(dataset){
	console.log(dataset);
	dataset.forEach(function(d) {
		d.count = +d.count;
	});
	var max = d3.max(dataset, function(d) { return parseInt(d.count); })
	var xScale = d3.scale.linear()
		.domain([0, max])
		.range([0, width2])

	svgcontauthor.selectAll(".bar")
		.data(dataset)
		.enter()
		.append("rect")
		.attr("fill", function(d, i){
    			return color[i];
		})
		.attr("x", 4)
		.attr("y", function(d, i){
    			return i * (height2 / dataset.length)+2;
		})
		.attr("height", height2 / dataset.length)
		.attr("width", function(d){
			return xScale(d.count) + 'px';
		})

	// add legend   
	var legendauthor = svgcontauthor.append("g")
	.attr("class", "legend")
	.attr("x", width2)
	.attr("y", 50)
	.attr("height", height2)
	.attr("width", 10)
	.attr('transform', 'translate(-12,9)')
	
	legendauthor.selectAll('text')
	.data(dataset)
	.enter()
	.append("text")
	.attr("x", 0)
	.attr("y", function(d, i){
		return i * height2/dataset.length+1;
	})
	.text(function(d) {
		return "☆"+d.rate;
	})
	.style("fill", "#505050")
	.style("font-size", "8px")

	var valueauthor = svgcontauthor.append("g")
	.attr("class", "legend")
	.attr("x", width2)
	.attr("y", 50)
	.attr("height", height2)
	.attr("width", 10)
	.attr('transform', 'translate(3,9)')
	
	valueauthor.selectAll('text')
	.data(dataset)
	.enter()
	.append("text")
	.attr("x", 4)
	.attr("y", function(d, i){
		return i * height2/dataset.length+1;
	})
	.text(function(d) {
		return numberWithCommas(d.count);
	})
	.style("fill", "#505050")
	.style("font-size", "8px")
})//dataset 종료
</script>
<? }//author있으면 종료 ?>

<div style="min-height:300px">
<? // 목록출력부
if($media_author_no==''){
	$sql = "SELECT * from z_media_$media_no WHERE $period_array[$periodno] ORDER BY rate_value desc, facebook_no desc";
}else{
	$sql = "SELECT * from z_media_$media_no WHERE author_no='$media_author_no' AND $period_array[$periodno] ORDER BY rate_value desc, facebook_no desc";
}
$sql = $sql." LIMIT 0, 100";
$resultout = mysql_query($sql, $connect) or die(mysql_error());
$count=1;
while($print = mysql_fetch_array($resultout)){
$scrollcount = floor(($count-1)/10);
$articleno = $print['no'];
$url = urldecode($print['url']);
$article_date_int = $print['date_int'];
$t=1;
$category = $print['category_no'];
$title = urldecode($print['title']);
$title = strip_tags($title);
$title = str_replace(")",")&nbsp;",$title);
$title = str_replace("]","] ",$title);
$title = str_replace("&lt;br&gt;","&nbsp;",$title);
$title = str_replace("&lt;BR&gt;","&nbsp;",$title);
$title = str_replace("…"," … ",$title);
$title = str_replace("/"," / ",$title);
$title = str_replace("·"," · ",$title);
$title = str_replace("···"," ··· ",$title);
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
$comment_no = $print['comment_no'];
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
include("include_main_news_list_article.php");
//
	$count++;
	} // 기사 목록을 출력하는 부분
if($count == 0){
?>
<div style="clear:both"?>
<div style="width:100%;border-top:1px solid #eaeaea;"></div>
<table articleno="<?=$articleno;?>" class="newslist_table">
<tr>
<td style="padding: 30px;">
선택하신 날짜와 기간에 해당하는 기사가 없습니다.
</td>
</tr>
</table>
<?
}
?>
</div>
</div>
<div style="width:100%;height:60px;"></div>
<div id="markscript">
<script type="text/javascript"> //공유수 추이 그래프
function parseDate(input) {
	var parts = input.split('-');
	// new Date(year, month [, day [, hours[, minutes[, seconds[, ms]]]]])
	return new Date(parts[0], parts[1]-1, parts[2]); // Note: months are 0-based
}
// Your beautiful D3 code will go here
var outerwidth = $("#mainchart").width();
var outerheight = 157;
var margin = {top: 20, right: 30, bottom: 20, left: 55},
	width = outerwidth - margin.left - margin.right,
	height = outerheight - margin.top - margin.bottom;
var barPadding = 1;
var dateint = document.getElementById('dateint').value;
var svgcont = d3.select("#mainchart").append("svg")
	.attr("width", width + margin.left + margin.right)
	.attr("height", height + margin.top + margin.bottom)
	.append("g")
	.attr("transform", "translate(" + margin.left + "," + margin.top + ")");

d3.json("../rssdb/data.php?dateint=<?=$date_int_chart;?>&media=<?=$media_no;?>&author=<?=$media_author_no;?>", function(dataset){
	console.log(dataset);
	var max = d3.max(dataset, function(d) { return parseInt(d.howmany); })

	var xScale = d3.time.scale()
		.domain(d3.extent(dataset, function(d) { return parseDate(d.date_int); }))
		.range([0, width])

	var yScale = d3.scale.linear()
		.domain([0, max])
		.range([height, 0])

	var xAxis = d3.svg.axis()
		.scale(xScale)
		//.ticks(dataset.length)
		.ticks(5)
		//.tickFormat(d3.time.format('%m/%d-%a'))
		.tickFormat(d3.time.format('%m/%d'))
		.orient("bottom")

	var yAxis = d3.svg.axis()
		.scale(yScale)
		.orient("left")
		.ticks(5)

	svgcont.selectAll(".bar")
		.data(dataset)
		.enter()
		.append("rect")
		.attr("class", function(d){
			var datenow = d.date_int
			if(datenow == dateint){
				return "barmainchart"+" bartoday"
			}else{
				return "barmainchart";
			}
		})
		.attr("x", function(d, i){
			return i*(width / dataset.length)
		})
		.attr("y", function(d){
			return yScale(d.howmany) + 'px';
		})
		.attr("width", width / dataset.length - barPadding)
		.attr("height", function(d){
			return height-yScale(d.howmany) + 'px';
		})
		.attr("data-dateint", function(d){
			return d.date_int
		})
		.append("svg:title")
		.text(function(d){
			return d.date_int
		})

		svgcont.append("g")
			.attr("class", "axis")
			.attr('fill', 'black')
			.attr("transform", "translate(0," + height + ")")
			.call(xAxis)
			.selectAll("text")  
			.style("text-anchor", "end")
			.attr("dx", "1.3em")
			.attr("dy", "1em")
			.attr("transform", function(d) {
			//return "rotate(-90)" 
			});

    		svgcont.append("g")
			.attr("class", "axis")
			.call(yAxis)
			.append("text")
			//.attr("transform", "rotate(-90)")
			.attr("y", 6)
			.attr("dx", "1.7em")
			.attr("dy", "-1.2em")
			.style("text-anchor", "end")
			.text("공유수");
})
</script>
</div>