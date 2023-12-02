 

<div class="btContentWrap btClear" style="background-color: #f7f7f7">
	<div class="btBlogHeaderContent">
		<section id="bt_bb_section5d51cd6f668e8" data-parallax="0.8" data-parallax-offset="0" class="bt_bb_section bt_bb_top_spacing_extra_large bt_bb_bottom_spacing_medium bt_bb_color_scheme_1 bt_bb_layout_boxed_1200 bt_bb_vertical_align_top bt_bb_parallax bt_bb_background_image bt_bb_background_overlay_dark_solid">
			<div class="bt_bb_port" style="padding-top:100px;padding-bottom:0px"></div>
		
        </section>
         
                                                    <h1><span class="bt_bb_headline_content"></span>
                                                    </h1>
                                                
	</div>
	<div class="btContentHolder">
		<div class="btContent">
        <h1><span class="bt_bb_headline_content">Blog</span>
                                                    </h1>
<?
if($stb->rowCount()){
	$t = "\t\t\t\t\t\t";
	$pgnc = "<nav class=\"pagination\"><ul class=\"page-numbers\">
	".pgnbt($pgn->a,$pgn->b,$pgn->c,1,"\r\n$t\t\t\t\t",'<li><a href="'.$s->pga.'/'.'[!num!]'.$s->pgb.'" class="page-numbers">[!txt!]</a></li>','<li><span class="page-numbers current">[!txt!]</span></li>','','','&larr;','&rarr;',1)."$t
	</ul></nav>";
	while($rs=$stb->fetchObject()){
?>
			<article class="btPostSingleItemStandard btPostListStandard gutter btArticleListItem animate bt_bb_animation_fade_in bt_bb_animation_move_up post-1018 post type-post status-publish format-standard has-post-thumbnail hentry category-bussines">
				<div class="port">
					<div class="btArticleContentHolder">
<?
		$principal = $b->query("select * from fotos where idp='{$rs->id}' and tipo='blog' and principal")->fetchObject();
		if($principal){
?>
						<div class="btArticleMedia ">
							<div class="btMediaBox"><a href="<?=$rs->t?>" alt=""><img src="upload/blogs/thumb/<?=$principal->iti?>" alt="<?=$principal->alt?$principal->alt:$rs->h1?>"></a></div>
						</div>
<?
		}
?>
						<div class="btArticleHeadline">
							<header class="bt_bb_headline bt_bb_size_normal bt_bb_superheadline bt_bb_subheadline">
								<h2><span class="bt_bb_headline_content"><span><?=$rs->h1?></span></span></h2>
								<div class="bt_bb_headline_subheadline"><span class="btArticleDate"><?=datef($rs->dp,8)?></span></div>
							</header>
						</div>
						<div class="btArticleContent"><?=$rs->r?></div>
						<div class="btArticleShareEtc">
							<div class="btReadMoreColumn">
								<div class="bt_bb_button bt_bb_icon_position_right bt_bb_style_outline bt_bb_size_small"><a href="<?=$rs->t?>" class="bt_bb_link"><span class="bt_bb_button_text">SAIBA MAIS</span><span data-ico-fa="" class="bt_bb_icon_holder"></span></a></div>
							</div>
						</div>
					</div>
				</div>
			</article>
<?
		}
		echo $pgnc;
	}else{
?>
			<h3>Nenhum post cadstrado!</h3>
<?
	}
?>
		</div>
		<aside class="btSidebar">
			<div class="btBox widget_search">
				<div class="btSearch">
					<div class="bt_bb_icon"><a href="#" target="_self" data-ico-fa="" class="bt_bb_icon_holder"></a></div>
					<div class="btSearchInner gutter" role="search">
						<div class="btSearchInnerContent port">
							<form>
								<input type="text" name="q" placeholder="Pesquisar..." class="untouched">
								<button type="submit" data-icon=""></button>
							</form>
							<div class="btSearchInnerClose">
								<div class="bt_bb_icon"><a href="#" target="_self" data-ico-fa="" class="bt_bb_icon_holder"></a></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="btBox widget_bt_bb_recent_posts">
				<h4><span>Últimos Posts</span></h4>
				<div class="btImageTextWidgetWraper">
					<ul>
					<?
$so = $b->query("select b.*,f.itu,f.alt from blog b inner join fotos f on b.id=f.idp and f.tipo='blog' where b.s ORDER BY b.id DESC limit 16 ");
while($ro=$so->fetchObject()){
?>
						<li>
							<div class="btImageTextWidget">
								<div class="btImageTextWidgetImage">
									<a href="<?=$ro->t?>"><img src="upload/blogs/thumb/<?=$ro->itu?>" class="attachment-thumbnail size-thumbnail wp-post-image" alt="<?=$ro->alt?$ro->alt:$ro->h1?>"></a>
								</div>
								<div class="btImageTextWidgetText">
									<header class="bt_bb_headline bt_bb_size_small bt_bb_superheadline">
										<h4>
											<span class="bt_bb_headline_superheadline"><?=datef($ro->dp,8)?></span>
											<span class="bt_bb_headline_content">
												<span><a href="<?=$ro->t?>"><?=$ro->h1?></a></span>
											</span>
										</h4>
									</header>
								</div>
							</div>
						</li>
<?
}
?>
					</ul>
				</div>
			</div>
		</aside>
	</div>
</div>
