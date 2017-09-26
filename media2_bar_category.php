<?
if($author==''){
	$i = 0;
	$show = $media;
}else{
	$i = 1;
	$show = $media." / ".$author;
}
?>
<div id="barcategory"><div id="li<?=$i;?>" class="categorybar category" data-categoryno="<?=$i?>" style="width:130px"><div class="barcategory_in" style="width:100%;color:#454545<? //border-bottom:2px solid #b94a48 ?>"><? //<img src='./img/media2_category=$i;.png' style='height:16px;'></div>?>
	<div style="padding-top:3px"><b><?=$show;?></b></div></div>
</div>