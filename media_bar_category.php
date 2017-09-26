<?
session_start();
require("/var/www/html/include_connect.php");
require("/var/www/html/include_variables.php");

$today = date("Y-m-d");
$date_int = $_GET['date'];
if($date_int == ''){
	$date_int = $today;
}
?>


<div id="barcategory" style="overflow:hidden;"><div id="category_move1" style="width:10%;float:left;display:inline-block;background-color:transparent"><div class="barcategory_in" style="width:100%;"><div style="padding-top:2px;"></div></div></div><div id="barcategory_scroll" style="z-index:99;width:80%;overflow-x: scroll;margin:0px;">

	<div id="li0" class="li0 category_prev categorybar category" data-categoryno="<?=$i?>" style="width:30%;border-bottom:2px solid teal"><div class="barcategory_in" style="width:100%;"><img src='./img/media_category0.png' style='height:14px;padding-top:2px;'></div>
	</div>
	<div id="li1" class="li1 category_next categorybar category" data-categoryno="<?=$i?>" style="width:30%"><div class="barcategory_in" style="width:100%;"><img src='./img/media_category1.png' style='height:14px;padding-top:2px;'></div>
	</div>

</div><div id="category_move2" style="display:inline-block;width:10%;float:right;display:inline-block;background-color:transparent"><div class="barcategory_in" style="width:100%;"><div style="padding-top:2px;"></div></div></div>
</div>