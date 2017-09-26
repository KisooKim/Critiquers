<?
if($author==''){
	$i = 0;
	$show = $media;
}else{
	$i = 1;
	$show = $media." / ".$author;
}
?>
<div id="barcategory"><div id="li<?=$i;?>" class="categorybar category" data-categoryno="<?=$i?>" style="width:auto"><div class="barcategory_in" style="width:100%;color:#454545;cursor:default">
	<div style="padding-top:3px"><b><?=$show;?></b></div></div>
</div>