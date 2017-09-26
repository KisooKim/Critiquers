<?
session_start();
require("/var/www/html/include_connect.php");
require("/var/www/html/include_variables.php");
if($_SESSION['user_id'] == ''){
	$_SESSION['user_id'] = 1;
}
$date_int = $_GET['date'];
if($date_int==''){
	$date_int = date("Y-m-d");
}
$category = $_GET['category'];
if($category==''){
	$category = 1;	
}
$periodno = $_GET['period'];
if($periodno==''){
	$periodno = 1;
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,height=device-height, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
<meta property="fb:app_id" content="493328504033025" /> 
<meta property="og:type"   content="article" /> 
<meta property="og:title"  content="크리티커스 - 언론평가 프로젝트" />
<meta property="og:description"  content="현재까지 <?=number_format($rating_total_count);?>번의 언론평가가 누적되었습니다." />
<meta property="og:image"  content="http://www.critiquers.org/img/logo/logo_fb_4.png" /> 
<head>
<link type="text/css" rel="stylesheet" href="css/default.css" />
<link rel="shortcut icon" href="img/favi.ico" type='image/x-ico' />
<title>크리티커스</title>

</head>
<body>
<form name="locator" action="./" method="GET">
<input type="hidden" id="center_div_id" name="center_div_id" value="layer1" /><!-- center_div_id 변수 -->
<input type="hidden" id="userid" name="userid" value="<?=$_SESSION['user_id']; ?>" style="margin-top:150px;"/><!-- userid 변수 -->
<input type="hidden" id="dateint" name="dateint" value="<?=$date_int;?>" /><!-- date 변수 -->
<input type="hidden" id="periodno" name="periodno" value="<?=$periodno;?>" /><!-- period 변수 -->
<input type="hidden" id="categoryno" name="categoryno" value="<?=$category;?>" /><!-- category 변수 -->
<input type="hidden" id="categoryno_prev" name="categoryno_prev" value="0" style="width:30px"/>
<input type="hidden" id="categoryno_cur" name="categoryno_cur" value="0" style="width:30px;margin-top:150px"/>
<input type="hidden" id="categoryno_next" name="categoryno_next" value="0" style="width:30px"/>
<input type="hidden" id="targettile" name="targettile" value="0" style="width:30px;margin-top:150px"/>
<input type="hidden" id="targetarticleno" name="targetarticleno" value="0" style="width:30px;margin-top:150px"/>
<input type="hidden" id="targetrate" name="targetrate" value="0" style="width:30px;margin-top:150px"/>
<input type="hidden" id="targetauthor" name="targetauthor" value="" style="width:30px;margin-top:150px"/>
<input type="hidden" id="targetmediano" name="targetmediano" value="" style="width:30px;margin-top:150px"/>
<input type="hidden" id="targetauthorno" name="targetauthorno" value="" style="width:30px;margin-top:150px"/>
<input type="hidden" id="targetdateint" name="targetdateint" value="" style="width:30px;margin-top:150px"/>
<input type="hidden" id="targetchartid" name="targetchartid" value="" style="width:30px;margin-top:150px"/>
<input type="hidden" id="targett" name="targett" value="" style="width:30px;margin-top:150px"/>
<input type="hidden" id="targetcategoryno" name="targetcategoryno" value="" style="width:30px;margin-top:150px"/>
<input type="hidden" id="currentscroll" name="currentscroll" value="" style="width:30px;margin-top:150px"/>
<input type="hidden" id="commentarticleno" name="commentarticleno" value="" style="width:30px;margin-top:150px"/>
<input type="hidden" id="ip" name="ip" value="<?=$_SERVER['REMOTE_ADDR'];?>" /><!-- 접속자의 ip -->
</form>

<div id="panel_cover" style="display:none;position:fixed;top:0;left:0;width:100%;height:130%;background-color:rgba(0, 0, 0, 0.35);z-index:40;cursor:pointer"></div>

<div id="right_panel" style="position:fixed;top:0;left:-300px;height:150%;width:300px;max-width:45%;background-color:#fafafa;z-index:50;">
	<div style="position: static;width:100%;padding:0;border-bottom:0px solid #f0f0f0;text-align:right"><img class="right_panel_x" src="img/delete.png" style="width:20px;height:20px;padding:10px;cursor:pointer"></div>
	<div style="width:100%;text-align:center;font-size:14px;">
			<a href="./" style="color:#0a0a0a;font-weight:bold;"><div style="width:100%;border-top:1px solid #eaeaea;border-bottom:1px solid #eaeaea;display:block;padding:15px 6px;text-align:center;">메인화면</div></a><a href="./about.php" style="color:#0a0a0a;font-weight:bold;"><div style="width:100%;display:block;padding:15px 6px;text-align:center;border-bottom:1px solid #eaeaea;">크리티커스 소개</div></a>
			<a href="http://www.facebook.com/critiquers" target="_blank" style="color:#0a0a0a;font-weight:bold;"><div style="width:100%;border-bottom:1px solid #eaeaea;display:block;padding:15px 6px;text-align:center;">페이스북 페이지</div></a>
	</div>
	<div style="width:100%;text-align:center;padding-top:30px;">
		<div class="fb-like" data-href="http://www.facebook.com/critiquers" data-layout="button_count" data-action="like" data-size="small" data-show-faces="true" data-share="true"></div>
	</div>
</div>

<div id="comment_panel" style="position:fixed;top:-100%;left:50%;width:800px;max-width:88%;height:80%;background-color:#fafafa;font-size:12px;box-shadow: 0 10px 12px -4px rgba(0, 0, 0, 0.35);border-radius:20px;transform:translate(-50%, -50%);z-index:60;">
	<div style="width:100%;height:100%;display: flex;flex-flow:column-reverse;">
		<div id="ratingstars_float" style="flex: 0 0 120px;width:100%;font-size:42px;text-align:center;font-size:10px;border-top:1px solid #eaeaea;background-color:#fafafa;border-radius:0px 0px 20px 20px;padding-top:10px;">
			<div style="width:100%;max-width:290px;margin:auto;">
				<div class="ratingstars_img" data-rate="0" style="width:16%;height:55px;display:inline-block;margin:0px;"><img class="ratingstars_0" src="img/star_float_bad.png" style="width:30px;height:30px;margin-bottom:4px;"><br>최악예요</div><div class="ratingstars_img" data-rate="1" style="width:16%;height:55px;display:inline-block;margin:0px;"><img class="ratingstars_img_in ratingstars_1" src="img/star_float_empty.png" style="width:30px;height:30px;margin-bottom:6px;"><br>안좋아요</div><div class="ratingstars_img" data-rate="2" style="width:16%;height:55px;display:inline-block;margin:0px;"><img class="ratingstars_img_in ratingstars_2" src="img/star_float_empty.png" style="width:30px;height:30px;margin-bottom:6px;"><br>별로예요</div><div class="ratingstars_img" data-rate="3" style="width:16%;height:55px;display:inline-block;margin:0px;"><img class="ratingstars_img_in ratingstars_3" src="img/star_float_empty.png" style="width:30px;height:30px;margin-bottom:6px;"><br>괜찮아요</div><div class="ratingstars_img" data-rate="4" style="width:16%;height:55px;display:inline-block;margin:0px;"><img class="ratingstars_img_in ratingstars_4" src="img/star_float_empty.png" style="width:30px;height:30px;margin-bottom:6px;"><br>좋아요</div><div class="ratingstars_img" data-rate="5" style="width:16%;height:55px;display:inline-block;margin:0px;"><img class="ratingstars_img_in ratingstars_5" src="img/star_float_empty.png" style="width:30px;height:30px;margin-bottom:6px;"><br>최고예요</div>
			</div>
			<div class="ratingstars_submit">기사평가 제출하기</div>
		</div>
		<div id="comment_iframe_container" style="flex: 1 1 auto;width:100%;-webkit-overflow-scrolling:touch;overflow:auto">
			<iframe id="comment_iframe" src="" scrolling="auto" style="overflow:auto;display:block;width:100%;border:0px;border-radius:20px;"></iframe>
		</div>
	</div>
</div>

<div id="left_arrow" class="arrow" title="키보드의 ← 버튼으로도 작동합니다" style="display:none;"><</div>
<div id="right_arrow" class="arrow" title="키보드의 → 버튼으로도 작동합니다">></div>

<div id="total_container" style="margin:auto">

<!-- header -->
<div id="header_container">
	<div style="display:table;width:29%;border:0px solid red;text-align:center;float:left;height:100%;">
		<div style="display:table-cell;vertical-align:middle;">
			<img id="person" src="img/personal.png" style="width:30px;height:30px;padding:3px 3px 3px 3px;cursor:pointer;">
		</div>
	</div><div style="display:inline-block;width:42%;height:100%;text-align:center;">
		<a href="./" style=";"><img class="title_logo" src="img/logo/logo_new.png"></a>
	</div><div id="sand" style="display:table;width:29%;border:0px solid red;text-align:center;float:right;height:100%;margin-top:1px;">
	</div>
	<!--로고-->
</div>
<!-- header 종료 -->

<?
$category_names = array("▩","전체","보수","진보","중도","인디","블로거","비즈","소셜");
$category_howmany = count($category_names);
?>
<!-- 상단카테고리 바 -->
<div id="upperbar" style="width:100%;padding:0;border-bottom:0px #F0F0F0 solid;z-index:10">
<? include("./media_bar_category.php"); ?>
</div>
<!-- div upperbar 종료 -->

<!-- 상단 카테고리 바 종료-->
<!-- -->
	<div id="mflick" data-role="page" style="height:auto;overflow:visible;width:100%;">
		<div id="flick-container" class="flick-container" data-role="content" style="height:auto;overflow:visible;">
			<div id="layer1" class="flick-ct" style="height:auto;overflow:visible;width:100%;padding-top:0px;">
				<div style='margin-top:50%;margin-bottom:50%;margin-left:50%;width:100px;'><img src = 'img/ajax_load.gif' style='margin-left:-10px'></div>
			</div>
			<div id="layer2" class="flick-ct" style="height:auto;overflow:visible;width:100%;padding-top:0px;">
				<div style='margin-top:50%;margin-bottom:50%;margin-left:50%;width:100px;'><img src = 'img/ajax_load.gif' style='margin-left:-10px'></div>
			</div>
		</div>
	</div>

<div id="panel_bottom" class="panel_bottom" style="z-index:10;text-align:center;font-size:10px;cursor:default">
	<div id="gototop" style="border:padding:5px;width:55px;height:55px;position:absolute;bottom:63px;right:8px;cursor:pointer;display:none;"><img src = "/img/date_up.png" style="border:1px solid #cacaca;width:25px;height:25px;background:rgba(249, 249, 249, 0.84);padding:7px;"></div>
	<div style="display:inline-block;width:25%;text-align:center;cursor:default">
		<a href="./" style="display:block;margin:auto;width:50px;color:#000000"><div style="margin:auto;width:50px;">
			<img src="img/bottom_1.png" style="width:22px;margin-bottom:2px;"><br>
			순위별
		</div></a>
	</div><div style="display:inline-block;width:25%;text-align:center;cursor:default">
		<a href="./cluster.php" style="display:block;margin:auto;width:50px;color:#000000"><div style="margin:auto;width:50px;">
			<img src="img/bottom_2.png" style="width:22px;margin-bottom:2px;"><br>
			이슈별
		</div></a>
	</div><div style="display:inline-block;width:25%;text-align:center;cursor:default">
		<a href="./media.php" style="display:block;margin:auto;width:50px;color:#000000"><div style="margin:auto;width:50px;">
			<img src="img/bottom_4_a.png" style="width:22px;margin-bottom:2px;"><br>
			<b style="color:teal">언론순위</b>
		</div></a>
	</div><div style="display:inline-block;width:25%;text-align:center;cursor:default">
		<div id="bottom_login" style="margin:auto;width:50px;cursor:pointer;color:#000000">
			<img src="img/bottom_5.png" style="width:22px;margin-bottom:2px;"><br>
			<span id="top_menu_login"><?
				if($_SESSION['user_id']>1){
					echo "마이페이지";
				}else{
					echo "로그인";
				}
			?></span>
		</div>
	</div>
</div>

<div class="toast" style="display:none;z-index:30">
	평가가 반영되었습니다.
</div>
<div class="toast_rate toast" style="display:none;z-index:70;cursor:default;">
	평가가 입력되었습니다.<br>잠시후 뉴스 순위에 반영됩니다.
</div>
</div> <!--total_container 종료 -->
</body>
<!-- 기본 스크립트 -->
<script type="text/javascript" src="jindo/jindo.all.ns.js" charset="utf-8"></script>
<script type="text/javascript" src="jindo/jindo_mobile_component.js"></script>
<script type="text/javascript" src="jindo/jquery-1.9.1.min.js" charset="utf-8"></script>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/d3.js"></script>
<script type="text/javascript" src="js/d3.min.js"></script>
<script type="text/javascript" src="facebook_login.js"></script>
<script type="text/javascript" src="js/jQueryRotate.js"></script>
<!--GoogleAnalytics-->
<script>
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
ga('create', 'UA-48747835-1', 'critiquers.org');
ga('send', 'pageview');
</script>
<!--// 기본 스크립트 끝 -->
<script>
var nDelay = jindo.m.getDeviceInfo().android? 1000: 0;

function delete_article(categoryno, articleno, mediano){
	if (confirm("선택한 글을 정말 삭제하시겠습니까?") == true){    //확인
		window.open("./function_delete.php?categoryno="+categoryno+"&mediano="+mediano+"&articleno="+articleno)
	}else{   //취소
		return;
	}
}


function numberWithCommas(x) {
	return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}
function mypage(){
	userid = document.getElementById('userid').value
	if(userid>1){ //로그인 되었을 경우
		window.location.replace('./private.php');
	}else{
		fblogin('clicked');
	}
}


$(document).ready(function(){

window.setInterval(function(){
	var desiredheight = $("#comment_iframe_container").css("height")
	$("#comment_iframe").css("height", desiredheight);
}, 3000);

function drawgraph(chartid, articleno){
// Your beautiful D3 code will go here
var outerwidth = $("#chart_"+chartid).width();
var outerheight = $("#chart_"+chartid).height();
var margin = {top: 4, right: 9, bottom: 0, left: 15}
width = outerwidth - margin.left - margin.right,
height = outerheight - margin.top - margin.bottom;
width=80;
height = 85;
$("#chart_"+chartid).html('');
var svgcont = d3.select("div#chart_"+chartid).append("svg")
	.attr("width", width + margin.left + margin.right)
	.attr("height", height + margin.top + margin.bottom)
	.append("g")
	.attr("transform", "translate(" + margin.left + "," + margin.top + ")");

d3.json("/rssdb/data_article_eval.php?article_no="+articleno, function(dataset){
	console.log(dataset);
	dataset.forEach(function(d) {
		d.count = +d.count;
	});

	var max = d3.max(dataset, function(d) { return parseInt(d.count); })

	var xScale = d3.scale.linear()
		.domain([0, max])
		.range([0, width])

	svgcont.selectAll(".bar")
		.data(dataset)
		.enter()
		.append("rect")
		.attr("fill", function(d, i){
					return color[i];
		})
		.attr("x", 4)
		.attr("y", function(d, i){
					return i * (height / dataset.length)+2;
		})
		.attr("height", height / dataset.length)
		.attr("width", function(d){
			return xScale(d.count) + 'px';
		})

	// add legend	 
	var legend = svgcont.append("g")
	.attr("class", "legend")
	.attr("x", width)
	.attr("y", 50)
	.attr("height", height)
	.attr("width", 10)
	.attr('transform', 'translate(-12,9)')
	
	legend.selectAll('text')
	.data(dataset)
	.enter()
	.append("text")
	.attr("x", 0)
	.attr("y", function(d, i){ return i * height/dataset.length+2;})
	.text(function(d) {
		return "☆"+d.rate;
	})
	.style("fill", "#505050")
	.style("font-size", "8px")

	var value = svgcont.append("g")
	.attr("class", "legend")
	.attr("x", width)
	.attr("y", 50)
	.attr("height", height)
	.attr("width", 10)
	.attr('transform', 'translate(3,9)')
	
	value.selectAll('text')
	.data(dataset)
	.enter()
	.append("text")
	.attr("x", 4)
	.attr("y", function(d, i){ return i * height/dataset.length+2;})
	.text(function(d) {
		return numberWithCommas(d.count);
	})
	.style("fill", "#505050")
	.style("font-size", "8px")
})//dataset 종료	
}//function 종료


$(".cluster_title").live("click", function(e){
	$(".cluster_title").css('background-color', '#fcfcfc');
	$(this).css('background-color', '#eaeaea');
	var articlelist = $(this).data("articlelist");
	$("#layer2").load("cluster_news.php?articlelist="+articlelist);
	oFlicking.moveNext();
	document.getElementById('categoryno_cur').value = 1;
	$("#right_arrow").hide();
	$("#left_arrow").show();
	$(".category").children("div").css("border-bottom", "0px");
	$(".category").children("div").css("font-weight", "normal");
	$(".li1").children("div").css("font-weight", "bold");
	$(".li1").children("div").css("border-bottom", "2px solid teal");
})

$("#loggedout_button").live("click", function(){
	fblogin('clicked');
})
$("#loggedin_button").live("click", function(){
	fblogout();
})

$("#bottom_login").live("click", function(){
	userid = document.getElementById('userid').value
	if(userid>1){ //로그인 되었을 경우
		window.location.replace('./private.php');
	}else{
		fblogin('clicked');
	}
})

var color = ["#9fc05a", "#ccdb38", "#eaff5b", "#ffd834", "#ffb05b", "#ff8b5a"];

$(".article_more").live("click", function(e){
	e.stopPropagation();
	e.preventDefault();
	var this_now = $(this)
	var mediano = $(this).data("mediano");
	var authorno = $(this).data("authorno");
	var chartid = $(this).data("chartid");
	var articleno = $(this).data("articleno");
	var commentarticlenonow = document.getElementById("commentarticleno").value;
	document.getElementById("commentarticleno").value=articleno;
	if(commentarticlenonow != articleno){
		$("#comment_iframe").attr("src", "./include_comment.php?articleno="+articleno);
	}
	document.getElementById("commentarticleno").value=articleno;
	var t = $(this).data("t");
	var target = $('#article_more_'+t+'_'+articleno);
	var rotate = target.getRotateAngle();
	if(rotate==0){
		target.rotate({
		angle: 0,
		animateTo:180
		})
	}
	var toshow = $('#article_addon_'+t+'_'+articleno).css('display');
	if(toshow == 'none'){
		$('#article_addon_'+t+'_'+articleno).show();
		target.rotate({
		angle: 0,
		animateTo:180
		})
	}else{
		$('#article_addon_'+t+'_'+articleno).hide();
		target.rotate({
		angle: 180,
		animateTo:0
		})
	}

	var center_div_id = document.getElementById('center_div_id').value;
	var center = $("#"+center_div_id);
	center.css('height', 'auto');
	var height = center.height();
	$("#mflick").css('height', height);
	drawgraph(chartid, articleno);
	$.post("./function_rating.php",
	{ mediano : mediano, authorno : authorno, articleno : articleno},
	function(data) {
		var data = data.split(";");
		var media_rate_original = data[0];
		var author_rate_original = data[1];
		var love = data[2];
		var myrate = data[3];
		var media_rated_time = data[4];
		var author_rated_time = data[5];
		if(myrate != ''){
			$("#article_rate_"+t+"_"+articleno).html("<img src='./img/star_icon_filled.png' style='width:12px;height:12px;vertical-align:middle;margin-right:3px;margin-top:-3px;'><span style='cursor:pointer;display:inline-block;'>"+myrate+".00점</span>")
		}
		var media_rate = parseFloat(data[0]);
		var author_rate = parseFloat(data[1]);
		var media_rate_rounded = Math.round(media_rate*2)/2*10;
		var author_rate_rounded = Math.round(author_rate*2)/2*10;
		if(isNaN(author_rate)){
			author_rate_rounded = 'none';
			author_rate_original = '0.00';
		}
		var media_rating_star = $("#ratingstar_to_show_media_"+t+"_"+articleno);
		if(media_rate_original=='none'){
			media_rating_star.attr("src", "img/new_rating_none.png");
		}else{
			media_rating_star.attr("src", "img/new_rating_"+media_rate_rounded+".png");
			var media_rate_text = $("#media_rate_"+t+"_"+articleno);
			var media_rate = Math.round(media_rate*100)/100;
			media_rate_text.html(media_rate_original+" ("+media_rated_time+")")
		}
		var author_rating_star = $("#ratingstar_to_show_author_"+t+"_"+articleno)
		if(author_rate_original=='none'){
			author_rating_star.attr("src", "img/new_rating_none.png");
		}else{
			author_rating_star.attr("src", "img/new_rating_"+author_rate_rounded+".png");
			var author_rate_text = $("#author_rate_"+t+"_"+articleno)
			author_rate_text.html(author_rate_original+" ("+author_rated_time+")")
		}
		if(love=='yes'){
			$('#article_save_'+t+'_'+articleno).html("<img src='./img/love_icon_filled.png' style='width:12px;height:12px;vertical-align:middle;margin-right:3px;margin-top:-3px;'><div style='cursor:pointer;display:inline-block;'>담아두기</div>")

		}
	});
})



$(".article_list, .article_list_splash").live("click", function(){ //여기여기
	var articleno = $(this).data("articleno");
	var commentarticlenonow = document.getElementById("commentarticleno").value;
	document.getElementById("commentarticleno").value=articleno;
	if(commentarticlenonow != articleno){
		$("#comment_iframe").attr("src", "./include_comment.php?articleno="+articleno);
	}
	var t = $(this).data("t");
	var target = $('#article_more_'+t+'_'+articleno);
	var rotate = target.getRotateAngle();
	if(rotate==0){
		target.rotate({
		angle: 0,
		animateTo:180
		})
	}
	$('#article_addon_'+t+'_'+articleno).show();
	var userid = document.getElementById('userid').value;
	if(userid>1){
		$("#panel_cover").show();
		$("#comment_panel").animate({ top: '50%' }, 0)
		$("body").css("overflow", "hidden");
	}
	var targettile = $(this).data("targettile");
	var targetarticleno = $(this).data("articleno");
	var targetrate = $(this).data("rate");
	var targetauthor = $(this).data("author");
	var targetmediano = $(this).data("mediano");
	var targetauthorno = $(this).data("authorno");
	var targetdateint = $(this).data("dateint");
	var targetchartid = $(this).data("chartid");
	var targett = $(this).data("t");
	var targetcategoryno = $(this).data("categoryno");

	document.getElementById("targettile").value=targettile;
	document.getElementById("targetarticleno").value=targetarticleno;
	document.getElementById("targetrate").value=targetrate;
	document.getElementById("targetauthor").value=targetauthor;
	document.getElementById("targetmediano").value=targetmediano;
	document.getElementById("targetauthorno").value=targetauthorno;
	document.getElementById("targetdateint").value=targetdateint;
	document.getElementById("targetchartid").value=targetchartid;
	document.getElementById("targett").value=targett;
	document.getElementById("targetcategoryno").value=targetcategoryno;
	document.getElementById('targetrate').value='none';
	
	var this_now = $(this)
	var mediano = $(this).data("mediano");
	var authorno = $(this).data("authorno");
	var chartid = $(this).data("chartid");
	var center_div_id = document.getElementById('center_div_id').value;
	var center = $("#"+center_div_id);
	center.css('height', 'auto');
	var height = center.height();
	$("#mflick").css('height', height);
	drawgraph(chartid, articleno);
	$.post("./function_rating.php",
	{ mediano : mediano, authorno : authorno, articleno : articleno},
	function(data) {
		var data = data.split(";");
		var media_rate_original = data[0];
		var author_rate_original = data[1];
		var love = data[2];
		var myrate = data[3];
		var media_rated_time = data[4];
		var author_rated_time = data[5];
		if(myrate != ''){
			$("#article_rate_"+t+"_"+articleno).html("<img src='./img/star_icon_filled.png' style='width:12px;height:12px;vertical-align:middle;margin-right:3px;margin-top:-3px;'><span style='cursor:pointer;display:inline-block;'>"+myrate+".00점</span>")
		}
		var media_rate = parseFloat(data[0]);
		var author_rate = parseFloat(data[1]);
		var media_rate_rounded = Math.round(media_rate*2)/2*10;
		var author_rate_rounded = Math.round(author_rate*2)/2*10;
		if(isNaN(author_rate)){
			author_rate_rounded = 'none';
			author_rate_original = '0.00';
		}
		var media_rating_star = $("#ratingstar_to_show_media_"+t+"_"+articleno);
		if(media_rate_original=='none'){
			media_rating_star.attr("src", "img/new_rating_none.png");
		}else{
			media_rating_star.attr("src", "img/new_rating_"+media_rate_rounded+".png");
			var media_rate_text = $("#media_rate_"+t+"_"+articleno);
			var media_rate = Math.round(media_rate*100)/100;
			media_rate_text.html(media_rate_original+" ("+media_rated_time+")")
		}
		var author_rating_star = $("#ratingstar_to_show_author_"+t+"_"+articleno)
		if(author_rate_original=='none'){
			author_rating_star.attr("src", "img/new_rating_none.png");
		}else{
			author_rating_star.attr("src", "img/new_rating_"+author_rate_rounded+".png");
			var author_rate_text = $("#author_rate_"+t+"_"+articleno)
			author_rate_text.html(author_rate_original+" ("+author_rated_time+")")
		}
		if(love=='yes'){
			$('#article_save_'+t+'_'+articleno).html("<img src='./img/love_icon_filled.png' style='width:12px;height:12px;vertical-align:middle;margin-right:3px;margin-top:-3px;'><div style='cursor:pointer;display:inline-block;'>담아두기</div>")

		}
	});
})

$(".ratingstars_img").live("click", function(){
	var userid = document.getElementById('userid').value;
	if(userid<2){
		//로그인 안되었을때
		alert("로그인이 필요합니다.")
	}else{
		$(".ratingstars_img").css('font-weight', '500');
		$(this).css('font-weight', 'bold');
		var rate = $(this).data("rate");
		document.getElementById('targetrate').value=rate;
		for (i = 1; i < 6; i++) { 
			if(i>rate){		
				$(".ratingstars_"+i).attr("src", "img/star_float_dark.png");
			}else{
				$(".ratingstars_"+i).attr("src", "img/star_float_filled.png");
			}
		}
	}
})

$(".ratingstars_submit").live("click", function(){
	var userid = document.getElementById('userid').value;
	if(userid<2){
		//로그인 안되었을때
		alert("로그인이 필요합니다.")
	}else{
	$("#comment_panel").animate({ top: '-100%' }, 0);
	$("#panel_cover").hide();
	$("body").css("overflow", "auto");
	$(".ratingstars_img_in").attr("src", "img/star_float_empty.png");
	$(".ratingstars_img").css('font-weight', '500');
	$('.toast_rate').stop().fadeIn(400).delay(3000).fadeOut(400);
	//$('.toast_rate').stop().fadeIn(400).delay(3000).fadeOut(400);
	//$('.toast_signout').stop().fadeIn(400).delay(8000).fadeOut(400);
	
	var targettile = document.getElementById('targettile').value;
	var rate = document.getElementById('targetrate').value;

	var author = document.getElementById("targetauthor").value;
	var mediano = document.getElementById("targetmediano").value;
	var authorno = document.getElementById("targetauthorno").value;
	var articleno = document.getElementById("targetarticleno").value;
	var dateint = document.getElementById("targetdateint").value;
	var chartid = document.getElementById("targetchartid").value;
	var categoryno = document.getElementById("targetcategoryno").value;

	$.post("./function_rating_input.php", 
	{ rate : rate, mediano : mediano, authorno : authorno, articleno : articleno, categoryno : categoryno, dateint : dateint},
	function(data) {
		//입력한 점수 애니메이션
		if(rate=='none'){
		$("#article_rate_"+targettile).html("<img src='./img/star_icon.png' style='width:12px;height:12px;vertical-align:middle;margin-right:3px;margin-top:-3px;'><span style='cursor:pointer;display:inline-block;'>평가하기</span>")
		}else{
		$("#article_rate_"+targettile).html("<img src='./img/star_icon_filled.png' style='width:12px;height:12px;vertical-align:middle;margin-right:3px;margin-top:-3px;'><span style='cursor:pointer;display:inline-block;'>"+rate+".00점</span>")
		}
		var data = data.split(";");
		if(data[0]=='none'){
			var avg_rate = 0;
			var rate_rounded = 'none'
		}else{
			var avg_rate = parseFloat(data[0]);
			var rate_rounded = Math.round(avg_rate*2)/2*10;			
		}
		var rated_time = data[1];
		var media_avg_rate = parseFloat(data[2]);
		var media_rate_rounded = Math.round(media_avg_rate*2)/2*10;
		var author_avg_rate = parseFloat(data[3]);
		var author_rate_rounded = Math.round(author_avg_rate*2)/2*10;
		if(isNaN(author_avg_rate)){
			author_rate_rounded = 'none';
			author_avg_rate = '0.00';
		}
		// article star reload
		var target_now = $(".ratingstar_to_show_"+articleno);
		target_now.animate({ opacity: 0 }, 500, function () { target_now.attr("src", "img/new_rating_"+rate_rounded+".png");});
		target_now.animate({ opacity: 1 }, 500);

		// article star 옆 rate
		var target_now11 = $(".rating_to_show_"+articleno)
		target_now11.html(avg_rate.toFixed(2));

		// article star count reload
		var target_now15 = $(".rated_time_"+articleno)
		target_now15.html(rated_time);

		// media rating load
		var target_now1 = $("#ratingstar_to_show_media_"+targettile)
		target_now1.animate({ opacity: 0 }, 500, function () { target_now1.attr("src", "img/new_rating_"+media_rate_rounded+".png");});
		target_now1.animate({ opacity: 1 }, 500);
		var target_now2 = $("#media_rate_"+targettile)
		var avg_rate = Math.round(media_avg_rate*100)/100;
		target_now2.html(avg_rate.toFixed(2));

		// author rating load
		var target_now3 = $("#ratingstar_to_show_author_"+targettile)
		target_now3.animate({ opacity: 0 }, 500, function () { target_now3.attr("src", "img/new_rating_"+author_rate_rounded+".png");});
		target_now3.animate({ opacity: 1 }, 500);
		var target_now4 = $("#author_rate_"+targettile)
		var avg_rate = Math.round(author_avg_rate*100)/100;
		target_now4.html(avg_rate.toFixed(2));

		drawgraph(chartid, articleno);
		if(rated_time==0){
			$(".ratingbadge_"+articleno).hide();
		}else{
			$(".ratingbadge_"+articleno).show();
		}
		var center_div_id = document.getElementById('center_div_id').value;
		var center = $("#"+center_div_id);
		center.css('height', 'auto');
		var height = center.height();
		$("#mflick").css('height', height);
	});
	}//로그인 되었을때
})//click

$(".article_save").live("click", function(){
	var userid = document.getElementById('userid').value;
	if(userid<2){
		alert("로그인이 필요합니다.")
	}else{
		var articleno = $(this).data("articleno");
		var targettile = $(this).data("targettile");
		$.post("./function_save.php", 
		{ articleno : articleno },
		function(love) {
			if(love == 'yes'){
				$("#article_save_"+targettile).html("<img src='./img/love_icon_filled.png' style='width:12px;height:12px;vertical-align:middle;margin-right:3px;margin-top:-3px;'><div style='cursor:pointer;display:inline-block;'>담아두기</div>")
			}else{
				$("#article_save_"+targettile).html("<img src='./img/love_icon.png' style='width:12px;height:12px;vertical-align:middle;margin-right:3px;margin-top:-3px;'><div style='cursor:pointer;display:inline-block;'>담아두기</div>")
			}
		});
	}
})//click


document.getElementById('categoryno_cur').value = 0;
// 카테고리 bar를 탑으로 고정
$(window).scroll(function() {
	categoryno_cur = document.getElementById('categoryno_cur').value;
	if(categoryno_cur == 0){
		var windowpos = $(window).scrollTop();
		document.getElementById('currentscroll').value = windowpos;
	}
	//현재스크롤의 위치가 화면의 보이는 위치보다 크다면
	if ($(window).scrollTop() >= $(document).height() - $(window).height()-550){ 
		var category = document.getElementById('categoryno_cur').value;
		var last_scroll_count = $(".scroll_visible_"+category+":last").data("scrollcount");
		next_scroll_count = parseInt(last_scroll_count)+1;
		$(".scrollcount_"+category+"_"+next_scroll_count).addClass("scroll_visible_"+category)
		$(".scrollcount_"+category+"_"+next_scroll_count).show(0, function(){
			var center_div_id = document.getElementById('center_div_id').value;
			var center = $("#"+center_div_id);
			center.css('height', 'auto');
			var height = center.height();
			$("#mflick").css('height', height);
		});
	}
	var windowpos = $(window).scrollTop();
	var headercontainerheight = $('#header_container').css('height');
	var headercontainerheight = parseInt(headercontainerheight);
	if (windowpos >= headercontainerheight) {
		//alert("많이 내려왔어")
		$('#barcategory').css('position', 'fixed');
		$('#barcategory').css('top', '0px');
		var widthfornow = $('#total_container').css('width');
		$('#barcategory').css('width', widthfornow);
	} else {
		//alert("덜 내려왔어")
		$('#barcategory').css('position', 'relative');
		$('#barcategory').css('top', '0px');
		$('#barcategory').css('width', '100%');
	}


	if ($(window).scrollTop() >= 600){
		$("#gototop").show()
	}else{
		$("#gototop").hide()
	}
}); //scroll

$("#gototop").live("click", function(){
	$("html, body").animate({ scrollTop: 0 }, 0);
})

//보여지는 카테고리 전체 수를 입력한다
var category_howmany = 2;

$("#panel_cover, .left_panel_x").live("click", function(){
	$("#left_panel").hide();
	$("#right_panel").animate({ left: '-300px' }, 0)
	$("#panel_cover").hide();
	$("#comment_panel").animate({ top: '-1000px' }, 0);
	$("body").css("overflow", "auto");
	$("body").css("position", "static");
	$(".ratingstars_img_in").attr("src", "img/star_float_empty.png");
	$(".ratingstars_img").css('font-weight', '500');
})

$("#panel_cover, .right_panel_x").live("click", function(){
	var dateint = document.getElementById("dateint").value;
	var showdate = dateint;
	$("#panel_cover").hide();
	$("#left_panel").hide();
	$("#right_panel").animate({ left: '-300px' })
	$("#right_panel").animate({ scrollTop: 0 }, 0);
	$("body").css("overflow", "auto");
	$("body").css("position", "static");
	$('#bardate_container').load('./bar_date.php?date='+dateint+'&showdate='+showdate)
})

$("#person").live("click", function(){
	if ($("#right_panel").css('left') == '-300px') {
		$("body").css("overflow", "hidden");
		$("#panel_cover").show(0);
		$("#right_panel").animate({ left: '0px' })
	}else{
		$("body").css("overflow", "auto");
		$("#panel_cover").hide(500);
		$("#right_panel").animate({ left: '-300px' })
	}
})

$(".article_rate").live("click", function(){
	$("#panel_cover").show();
	$("#ratingstars_float").show(500);
	$("body").css("overflow", "hidden");
	$(".ratingstars_img_in").attr("src", "img/star_float_empty.png");
	$(".ratingstars_img").css('font-weight', '500');
	var targettile = $(this).data("targettile");
	var targetarticleno = $(this).data("articleno");
	var targetrate = $(this).data("rate");
	var targetauthor = $(this).data("author");
	var targetmediano = $(this).data("mediano");
	var targetauthorno = $(this).data("authorno");
	var targetdateint = $(this).data("dateint");
	var targetchartid = $(this).data("chartid");
	var targett = $(this).data("t");
	var targetcategoryno = $(this).data("categoryno");

	document.getElementById("targettile").value=targettile;
	document.getElementById("targetarticleno").value=targetarticleno;
	document.getElementById("targetrate").value=targetrate;
	document.getElementById("targetauthor").value=targetauthor;
	document.getElementById("targetmediano").value=targetmediano;
	document.getElementById("targetauthorno").value=targetauthorno;
	document.getElementById("targetdateint").value=targetdateint;
	document.getElementById("targetchartid").value=targetchartid;
	document.getElementById("targett").value=targett;
	document.getElementById("targetcategoryno").value=targetcategoryno;
	document.getElementById('targetrate').value='none';
})



var periodno = jindo.$('periodno').value;
$("#li_period_"+periodno).css("font-weight", "bold");
$("#li_period_"+periodno).css("background-color", "#f0f0f0");

var category = document.getElementById('categoryno_cur').value;
$(".li"+category).children("div").css("font-weight", "bold");
$(".li"+category).children("div").css("border-bottom", "2px solid teal");

var oFlicking = new jindo.m.Flicking(jindo.$('mflick'),{
		nTotalContents : category_howmany, //전체 아이템 개수
		sAnimation : 'slide',
		bUseDiagonalTouch : false,
		bUseCircular : false,
		nFlickThreshold:30
	}).attach({
		'beforeFlicking' : function(oCustomEvt){
			var nIndex = oCustomEvt.nContentsIndex * 1;
			$('#top_menu').hide();
			$('#scroll_invisible').hide();

			if(oCustomEvt.bLeft){
				var nextelement = this.getPrevElement();
				//nextelement.html("<div style='margin-top:50%;margin-bottom:50%;margin-left:50%;width:100px;'><img src = 'http://critiquers.org/img/ajax_load.gif' style='margin-left:-10px'></div>")
				var next = this.getContentIndex()+1;
				var next = parseInt(next % category_howmany);
				var next = document.getElementById('categoryno_next').value;

			}else{
				var prevelement = this.getNextElement();
				//prevelement.html("<div style='margin-top:50%;margin-bottom:50%;margin-left:50%;width:100px;'><img src = 'http://critiquers.org/img/ajax_load.gif' style='margin-left:-10px'></div>")
				var prev_or = this.getContentIndex();
				var prev = this.getContentIndex()+category_howmany-1;
				var prev = parseInt(prev % category_howmany);
				var prev = document.getElementById('categoryno_prev').value;
			}
			},
		'afterFlicking' : function(oCustomEvt){
			$(".article_addon").hide();
			$('.article_more').rotate(0)
			$("html, body").animate({ scrollTop: 0 }, 0);
			//플리킹 효과를 통해 현재 화면을 움직였을 경우
			if(oCustomEvt.bLeft){
				var nextelement = this.getNextElement();
				//왼쪽으로 움직였을 경우 오른쪽 panel만 업데이트
				//var next = this.getNextIndex();
				var next = document.getElementById('categoryno_next').value;
				var next = (parseInt(next)+1) % category_howmany;

				var dateint = jindo.$('dateint').value;
				var periodno = jindo.$('periodno').value;
				var url_now = "cluster_main.php";
				var center = this.getElement();
				var center_div_id = center.attr("id");
				document.getElementById('center_div_id').value=center_div_id;
				center.css('height', 'auto');
				var height = center.height();
				$("#mflick").css('height', height);

			}else{
				//오른쪽으로 움직였을 경우 왼쪽 panel만 업데이트
				var prevelement = this.getPrevElement();
				var prev = document.getElementById('categoryno_prev').value;
				var prev = (((parseInt(prev)-1) % category_howmany)+category_howmany) % category_howmany;
				var dateint = jindo.$('dateint').value;
				var periodno = jindo.$('periodno').value;
				var url_now = "cluster_main.php"
				var center = this.getElement();
				var center_div_id = center.attr("id");
				document.getElementById('center_div_id').value=center_div_id;
				center.css('height', 'auto');
				var height = center.height();
				$("#mflick").css('height', height);

			}
			categoryno_cur = document.getElementById('categoryno_cur').value;
			if(categoryno_cur == 0){
				windowpos = document.getElementById('currentscroll').value;
				$(window).scrollTop(windowpos);
				$('#right_arrow').css('display','block');
				$('#left_arrow').css('display','none');
			}else{
				var windowpos = $(window).scrollTop();
				var headercontainerheight = $('#header_container').css('height');
				var headercontainerheight = parseInt(headercontainerheight);
				if (windowpos >= headercontainerheight) {
					$("html, body").animate({ scrollTop: headercontainerheight }, 0); //48
				}
				$('#right_arrow').css('display','none');
				$('#left_arrow').css('display','block');
			}
			var oScroll = new jindo.m.Scroll("view", {
				bUseHScroll : false,
				bUseVScroll: true,
				bUseBounce:false,
				bUseMomentum : false,
				bUseScrollbar:false
			});
		},
		'beforeMove' : function(oCustomEvt){
				var nIndex = oCustomEvt.nContentsIndex * 1;
			},
		'move' : function(oCustomEvt){
			//setContentIndex로 플리킹 효과가 아닌 전체 panel의 정보가 바뀔경우 3개 panel의 모든 정보를 바꾼다
			$('#top_menu').hide();
			$("html, body").animate({ scrollTop: 0 }, 0);
			var center = this.getElement();
			var center_div_id = center.attr("id");
			document.getElementById('center_div_id').value=center_div_id;
			var prevelement = this.getPrevElement();
			var nextelement = this.getNextElement();
			center.html("<div style='margin-top:50%;margin-bottom:50%;margin-left:50%;width:100px;'><img src = 'http://critiquers.org/img/ajax_load.gif' style='margin-left:-10px'></div>")
			prevelement.html("<div style='margin-top:50%;margin-bottom:50%;margin-left:50%;width:100px;'><img src = 'http://critiquers.org/img/ajax_load.gif' style='margin-left:-10px'></div>")
			nextelement.html("<div style='margin-top:50%;margin-bottom:50%;margin-left:50%;width:100px;'><img src = 'http://critiquers.org/img/ajax_load.gif' style='margin-left:-10px'></div>")

			var dateint = jindo.$('dateint').value;
			var periodno = jindo.$('periodno').value;
			//getPrevIndex 이런 애들이 이동 후에 번호를 따라가지를 않네
			var cur = this.getContentIndex(cur);
			var prev_or = this.getPrevIndex();
			var next = this.getNextIndex();
			var next = (parseInt(cur)+1) % category_howmany;

			document.getElementById('categoryno_prev').value=prev_or;
			document.getElementById('categoryno_cur').value=cur;
			document.getElementById('categoryno_next').value=next;

			categoryscrollno = document.getElementById('categoryno_cur').value;
			categorybarwidth = $('.barcategory_in').css('width');
			temp = parseInt(categoryscrollno)*parseInt(categorybarwidth);
			$('#barcategory_scroll').animate({scrollLeft: temp}, 300);

			var url_center = "cluster_main.php";
			var url_prevelement = "cluster_news.php";
			var url_nextelement = "cluster_news.php";
			
			$.ajax({
				url: url_center,
				type: "POST",
				async: true,
				success: function(data){
				center.html(data);
				},
				complete: function(){
					center.css('height', 'auto');
					var height = center.height();
					$("#mflick").css('height', height);
				}
			});
			$.ajax({
				url: url_prevelement,
				type: "POST",
				async: true,
				success: function(data){
				prevelement.html(data);
				$("#mflick").find("script").each(function(i) {
					eval($(this).text());
				});
			}
			});
			$.ajax({
				url: url_nextelement,
				type: "POST",
				async: true,
				success: function(data){
				nextelement.html(data);
				$("#mflick").find("script").each(function(i) {
					eval($(this).text());
				});
			}
			});
		}
	});

//불러온다
$("#layer1").load("media_1_main.php?category=0&periodno=3");
$("#layer2").load("media_1_main.php?category=1&periodno=3");


$('#category_move2').live("click", function(){
	var $elem=$('#barcategory_scroll');
	var newScrollLeft = $elem.scrollLeft(),
	    width=$elem.outerWidth(),
	    scrollWidth=$elem.get(0).scrollWidth;
	if (scrollWidth-newScrollLeft==width) {
	    $('#barcategory_scroll').animate({scrollLeft: 0}, 300);
	}else{
		$('#barcategory_scroll').animate({scrollLeft: 1600}, 300);
	}
})
$('#category_move1').live("click", function(){
	var $elem=$('#barcategory_scroll');
	var newScrollLeft = $elem.scrollLeft()
	if (newScrollLeft==0) {
	    $('#barcategory_scroll').animate({scrollLeft: 1600}, 300);
	}else{
		$('#barcategory_scroll').animate({scrollLeft: 0}, 300);
	}
})


//매체 카테고리 설정
$(".category_prev, #left_arrow").live("click", function(){
	oFlicking.movePrev();
	document.getElementById('categoryno_cur').value = 0;
	$("#right_arrow").show();
	$("#left_arrow").hide();
	$(".category").children("div").css("border-bottom", "0px");
	$(".category").children("div").css("font-weight", "normal");
	$(".li0").children("div").css("font-weight", "bold");
	$(".li0").children("div").css("border-bottom", "2px solid teal");

})
$(".category_next, #right_arrow").live("click", function(){
	oFlicking.moveNext();
	document.getElementById('categoryno_cur').value = 1;
	$("#right_arrow").hide();
	$("#left_arrow").show();
	$(".category").children("div").css("border-bottom", "0px");
	$(".category").children("div").css("font-weight", "normal");
	$(".li1").children("div").css("font-weight", "bold");
	$(".li1").children("div").css("border-bottom", "2px solid teal");
})


//Rotation 시 width 재설정
$(window).bind( 'orientationchange', function(e){
	setTimeout(function () {
	$(".chart").html("");
	$(".markscript").find("script").each(function(i) {
	eval($(this).text());
	});
	}, 500);
});//Rotation 시 width 재설정 종료

window.setInterval(function(){
	var center_div_id = document.getElementById('center_div_id').value;
	if(center_div_id=='layer1'){
		var center = $("#"+center_div_id);
		center.css('height', 'auto');
		var height = center.height();
		$("#mflick").css('height', height);
	}
}, 1000);

$(document).keydown(function(e) {
	switch(e.which) {
	case 37: // left
		oFlicking.movePrev();
		document.getElementById('categoryno_cur').value = 0;
		$("#right_arrow").show();
		$("#left_arrow").hide();
		$(".category").children("div").css("border-bottom", "0px");
		$(".category").children("div").css("font-weight", "normal");
		$(".li0").children("div").css("font-weight", "bold");
		$(".li0").children("div").css("border-bottom", "2px solid teal");
	break;

	case 39: // right
		oFlicking.moveNext();
		document.getElementById('categoryno_cur').value = 1;
		$("#right_arrow").hide();
		$("#left_arrow").show();
		$(".category").children("div").css("border-bottom", "0px");
		$(".category").children("div").css("font-weight", "normal");
		$(".li1").children("div").css("font-weight", "bold");
		$(".li1").children("div").css("border-bottom", "2px solid teal");
	break;

	default: return; // exit this handler for other keys
	}
	e.preventDefault(); // prevent the default action (scroll / move caret)
});

});//ready 종료
</script>
<script>(function(d, s, id) {
	var js, fjs = d.getElementsByTagName(s)[0];
	if (d.getElementById(id)) return;
	js = d.createElement(s); js.id = id;
	js.src = "//connect.facebook.net/ko_KR/sdk.js#xfbml=1&version=v2.3&appId=493328504033025";
	fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
</html>