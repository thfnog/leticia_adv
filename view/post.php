<div class="btContentWrap btClear" style="background-color: #f7f7f7">
	<div class="btBlogHeaderContent">
		<section id="bt_bb_section5d51cd6f668e8" data-parallax="0.8" data-parallax-offset="0" class="bt_bb_section bt_bb_top_spacing_extra_large bt_bb_bottom_spacing_medium bt_bb_color_scheme_1 bt_bb_layout_boxed_1200 bt_bb_vertical_align_top bt_bb_parallax bt_bb_background_image bt_bb_background_overlay_dark_solid">
			<div class="bt_bb_port" style="padding-top:100px;padding-bottom:0px"></div>
		</section>
	</div>
	<div class="btContentHolder">
		<div class="btContent">
			<article class="btPostSingleItemStandard btPostListStandard gutter btArticleListItem animate bt_bb_animation_fade_in bt_bb_animation_move_up post-1018 post type-post status-publish format-standard has-post-thumbnail hentry category-bussines">
				<div class="port">
					<div class="btArticleContentHolder">
<?
if($fotos){
?>
						<div class="btArticleMedia ">
							<div class="btMediaBox"><img src="upload/blogs/thumb/<?=$fotos->iti?>" alt="<?=$fotos->alt?$fotos->alt:$rs->h1?>"></div>
						</div>
<?
}
?>
						<div class="btArticleHeadline">
							<header class="bt_bb_headline bt_bb_size_normal bt_bb_superheadline bt_bb_subheadline">
								<h1><span class="bt_bb_headline_content"><span><?=$rs->h1?></span></span></h2>
								<div class="bt_bb_headline_subheadline"><span class="btArticleDate"><?=datef($rs->dp,8)?></span></div>
							</header>
						</div>
						<div class="btArticleContent"><?=$rs->d?></div>
						<div class="btArticleShareEtc">
							<div class=btShareColumn>
								<div class="bt_bb_icon btIcoFacebook bt_bb_style_filled bt_bb_size_xsmall bt_bb_shape_circle"><a href="https://www.facebook.com/sharer.php?u=<?=$url?>" data-ico-fa=&#xf09a; class="bt_bb_icon_holder" onclick="window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"></a></div>
								<div class="bt_bb_icon btIcoTwitter bt_bb_style_filled bt_bb_size_xsmall bt_bb_shape_circle"><a href="https://twitter.com/share?url=<?=$url_encode?>&amp;text=<?=$text?>" data-ico-fa=&#xf099; class="bt_bb_icon_holder" onclick="window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"></a></div>
								<div class="bt_bb_icon btIcoLinkedin bt_bb_style_filled bt_bb_size_xsmall bt_bb_shape_circle"><a href="https://www.linkedin.com/shareArticle?url=<?=$url?>" data-ico-fa=&#xf0e1; class="bt_bb_icon_holder" onclick="window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"></a></div>
								<div class="bt_bb_icon btIcoGooglePlus bt_bb_style_filled bt_bb_size_xsmall bt_bb_shape_circle"><a href="https://plus.google.com/share?url=<?=$url?>&amp;title=<?=$text?>" data-ico-fa=&#xf0d5; class="bt_bb_icon_holder" onclick="window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"></a></div>
							</div>
						</div>
					</div>
				</div>
			</article>
		</div>
		<aside class="btSidebar">
			<div class="btBox widget_search">
				<div class="btSearch">
					<div class="bt_bb_icon"><a href="#" target="_self" data-ico-fa="" class="bt_bb_icon_holder"></a></div>
					<div class="btSearchInner gutter" role="search">
						<div class="btSearchInnerContent port">
							<form action="blog">
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
				<h4><span>Outros Posts</span></h4>
				<div class="btImageTextWidgetWraper">
					<ul>
<?
$so = $b->query("select b.*,f.itu,f.alt from blog b inner join fotos f on b.id=f.idp and f.tipo='blog' where b.s and b.id!={$s->id} limit 8");
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
