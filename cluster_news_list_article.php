<? if($count>1){ ?><div class="scrollcount_<?=$t;?>_<?=$scrollcount;?> <?
	if($scrollcount>0){
		echo "scroll_invisible";
	}
?>" style="width:100%;background-color:#f3f3f3;border-top:0px solid #e2e2e2;height:12px;<?
	if($count>10){
		echo "";
	}?>"></div> <?

	}else{ ?>
<? } ?>
<?

//HEADER기사이고 사진이 크면 크게 써준다
if($count==1 && $repimage_width>405 && $repimage_height>274){ ?>

















<!-- 기사 목록 -->
<a style="cursor:pointer;" href='<?=$url;?>' class="newslist_a" href='javascript:void()' rel="external" target="_blank" id="newsitem<?=$count?>"><div class="article_list_splash scrollcount_<?=$t;?>_<?=$scrollcount;?><?
	if($scrollcount == 0){
		echo " scroll_visible_$t";
	}else{
		echo " scroll_invisible";
	}
?>" data-t="<?=$t;?>" data-articleno="<?=$articleno;?>" data-categoryno="<?=$category;?>" data-belong="<?=$media;?>" data-author="<?=$author;?>" data-mediano="<?=$media_no;?>" data-authorno="<?=$author_no;?>" data-chartid="<?=$articleno."_".$t;?>" data-dateint="<?=$article_date_int;?>" data-scrollcount="<?=$scrollcount;?>" data-targettile="<?=$t;?>_<?=$articleno;?>"<? 
	if($count>10){
		echo " style =''";
	} ?>>
	<div style="width:100%;min-height:20px;">
		<div class="article_bgcontainer" style="display:inline-block;width:100%;border:0px solid gray;text-align:right;">
		<? if($repimage) { ?>
			<div class="splash" style="display:inline-block;padding-bottom:15px;width:100%;background: url('<?=$repimage;?>') no-repeat center center;background-size:cover;">&nbsp;</div>
		<? } ?>
		</div>
	</div>
	<div style="display:inline-block;vertical-align:top;width:100%;padding:5%;padding-top:20px;padding-bottom:0%;border:0px solid teal;border-right:1px solid #e2e2e2;border-left:1px solid #e2e2e2;">
		<div class="splash_author"><?=$media;?></div>
		<div class="splash_title <?
		if(strpos($title, " ")==true || strpos($title, "&nbsp")==true){
			echo "title_wordbreak";
		}
		?>" style=""><?=$title;?></div>
	</div>
	<div style="display:inline-block;vertical-align:top;text-align:right;width:100%;padding:0%;padding-top:0%;padding-bottom:0px;padding-left:5%;border-right:1px solid #e2e2e2;border-left:1px solid #e2e2e2;padding-bottom:10px">
		<div style="display:inline-block;vertical-align:top;width:71%;float:left;">
		<div style="font-size:11px;padding:7px;padding-left:0px;padding-bottom:3px;padding-top:17px;">
			<div class="newslist_badge" title="페이스북에서 <?=number_format($facebook_no);?> 회 공유되었습니다" style="display:table-cell;vertical-align:top;height:14px;">
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
			<div class="newslist_badge" style="display:table-cell;vertical-align:top;height:14px;border:1px solid #dadada;" title="<?=number_format($rated_time);?>명으로 부터 평균 평점 <?=sprintf("%.2f", $avg_rate); ?>점을 받았습니다">
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
	</div><div style="display:inline-block;width:19%;padding:14px;padding-left:0px;margin:0px;border:0px solid pink;text-align:right;padding-top:8px;padding-right:8px;padding-bottom:0px;">
			<div style="height:40px;display:inline-block;"><img class="article_more" id="article_more_<?=$t;?>_<?=$articleno;?>" data-t="<?=$t;?>" data-articleno="<?=$articleno;?>" data-categoryno="<?=$category;?>" data-belong="<?=$media;?>" data-author="<?=$author;?>" data-mediano="<?=$media_no;?>" data-authorno="<?=$author_no;?>" data-chartid="<?=$articleno."_".$t;?>" src = "./img/addon_down.png" style="width:16px;height:16px;padding:14px 24px 15px 24px;"></div>
		</div>
</div>
</div>
</a>

<!-- addon -->
<div id="article_addon_<?=$t;?>_<?=$articleno;?>" class="article_addon" style="display:none;width:100%;">
<!-- 통계, 저자 정보, 공유기능 -->
<div class="article_info_splash">
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





















<? }else{ //HEADER 기사 종료 목록형식 시작 

if($count==1){ ?>
<div style="width:100%;background-color:#f3f3f3;border-top:0px solid #e2e2e2;height:12px;"></div>
<? } ?>















<!-- 기사 목록 -->
<a style="cursor:pointer;" href='<?=$url;?>' class="newslist_a" href='javascript:void()' rel="external" target="_blank" id="newsitem<?=$count?>"><div class="article_list scrollcount_<?=$t;?>_<?=$scrollcount;?><?
	if($scrollcount == 0){
		echo " scroll_visible_$t";
	}else{
		echo " scroll_invisible";
	}
?>" data-t="<?=$t;?>" data-articleno="<?=$articleno;?>" data-categoryno="<?=$category;?>" data-belong="<?=$media;?>" data-author="<?=$author;?>" data-mediano="<?=$media_no;?>" data-authorno="<?=$author_no;?>" data-chartid="<?=$articleno."_".$t;?>" data-dateint="<?=$article_date_int;?>" data-scrollcount="<?=$scrollcount;?>" data-targettile="<?=$t;?>_<?=$articleno;?>"<? 
	if($count>10){
		echo " ";
	} ?>>
	<div class="article_count"><?=$count;?></div><div style="display:inline-block;vertical-align:top;width:61%;padding:14px;padding-left:0px;padding-top:23px;margin:0px;">
		<div class="author_div"><?=$media;?></div>
		<div class="title_div <?
		if(strpos($title, " ")==true || strpos($title, "&nbsp")==true){
			echo "title_wordbreak";
		}
		?>" style=""><?=$title;?></div>
		<div style="font-size:11px;padding:7px;padding-left:0px;padding-bottom:3px;padding-top:10px;">
			<div class="newslist_badge" style="display:table-cell;vertical-align:top;height:14px;" title="페이스북에서 <?=number_format($facebook_no);?> 회 공유되었습니다">
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
			<div class="newslist_badge" style="display:table-cell;vertical-align:top;height:14px;border:1px solid #dadada;" title="<?=number_format($rated_time);?>명으로 부터 평균 평점 <?=sprintf("%.2f", $avg_rate); ?>점을 받았습니다">
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
		<div class="article_bgcontainer" style="display:inline-block;width:100%;border:0px solid gray;text-align:right;">
			<div class="article_background" style="display:inline-block;width:100%;max-width:180px;height:75px;background: url('<?=$repimage;?>') no-repeat center center;background-size:cover;">&nbsp;</div>
		</div><div style="position:absolute;bottom:0px;right:0px;width:100%;height:30px;border:0px solid gold;text-align:right;">
			<div style="height:40px;display:inline-block;"><img class="article_more" id="article_more_<?=$t;?>_<?=$articleno;?>" data-t="<?=$t;?>" data-articleno="<?=$articleno;?>" data-categoryno="<?=$category;?>" data-belong="<?=$media;?>" data-author="<?=$author;?>" data-mediano="<?=$media_no;?>" data-authorno="<?=$author_no;?>" data-chartid="<?=$articleno."_".$t;?>" src = "./img/addon_down.png" style="width:16px;height:16px;padding:6px 24px 6px 24px;"></div>
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
<? } //목록형식 시작 종료?>