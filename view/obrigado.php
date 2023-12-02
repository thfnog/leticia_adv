<!-- Global site tag (gtag.js) - Google Analytics UA -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-234207250-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-234207250-1');
</script>

<!-- Global site tag (gtag.js) - Google Analytics GA4 -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-ZBGQPCK8DX"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-ZBGQPCK8DX');
</script>

<!-- Global site tag (gtag.js) - Google Ads -->
<script async src="https://www.googletagmanager.com/gtag/js?id=AW-10945153274"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'AW-10945153274');
</script>

<!-- Event snippet for viewpage-colittiadv conversion page -->
<script>
  gtag('event', 'conversion', {'send_to': 'AW-10945153274/5SaCCOfbh88DEPqRh-Mo'});
</script>

<!-- Event snippet for contato-lead conversion page -->
<script>
  gtag('event', 'conversion', {'send_to': 'AW-10945153274/PUapCOTbh88DEPqRh-Mo'});
</script>


<div class="btContentWrap btClear">
	<div class="btBlogHeaderContent">
		<section id="bt_bb_section5d51cd6f668e8" data-parallax="0.8" data-parallax-offset="0" class="bt_bb_section bt_bb_top_spacing_extra_large bt_bb_bottom_spacing_medium bt_bb_color_scheme_1 bt_bb_layout_boxed_1200 bt_bb_vertical_align_top bt_bb_parallax bt_bb_background_image bt_bb_background_overlay_dark_solid">
			<div class="bt_bb_port" style="padding-top:100px;padding-bottom:0px"></div>
		</section>
	</div>
	<div class="btContentHolder">
		<div class="btContent">
			<div class="bt_bb_wrapper">
				<section id="bt_bb_section5d540ac649a8d" class="bt_bb_section bt_bb_top_spacing_large bt_bb_bottom_spacing_medium bt_bb_layout_boxed_1200 bt_bb_vertical_align_top">
					<div class="bt_bb_port">
						<div class="bt_bb_cell">
							<div class="bt_bb_cell_inner">
								<div class="bt_bb_row" data-structure="6-6">
									<div class="bt_bb_column col-md-6 col-sm-12 bt_bb_align_left bt_bb_vertical_align_top bt_bb_padding_text_indent" data-width="12">
										<div class="bt_bb_column_content">
											<div class="bt_bb_column_content_inner">
												<div class="bt_bb_google_maps bt_bb_map" data-center="no">
													<div class="bt_bb_google_maps_map bt_bb_map_map" id="map_canvas5d540ac649e91"></div>
													<div class="bt_bb_google_maps_location bt_bb_map_location bt_bb_google_maps_location_without_content bt_bb_map_location_without_content bt_bb_map_location_show" data-lat="40.730720" data-lng="-73.935142" data-icon="http://law-firm.bold-themes.com/main-demo/wp-content/uploads/sites/3/2017/04/pin_gold.png"></div>
												</div>
												<div class="bt_bb_separator bt_bb_top_spacing_normal bt_bb_border_style_none"></div>
												<div class="bt_bb_column col-md-12 col-ms-12 bt_bb_align_left bt_bb_vertical_align_top bt_bb_animation_fade_in animate bt_bb_padding_normal animated" data-width="12"><h4>AGRADECEMOS PELA SUA MENSAGEM!<br>POR FAVOR, AGUARDE O RETORNO.</h4></div>
											</div>
										</div>
										<div class="bt_bb_separator bt_bb_top_spacing_small bt_bb_border_style_none"></div>
										<section id="bt_bb_section5d51cbe500005" class="bt_bb_section bt_bb_bottom_spacing_large bt_bb_layout_boxed_1200 bt_bb_vertical_align_top">
											<div class="bt_bb_port">
												<div class="bt_bb_cell">
													<div class="bt_bb_cell_inner">
														<div class="bt_bb_row" data-structure="12">
															<div class="bt_bb_column col-md-12 col-ms-12 bt_bb_align_left bt_bb_vertical_align_top bt_bb_animation_fade_in animate bt_bb_padding_normal" data-width="12">
																<div class="bt_bb_column_content">
																	<div class="bt_bb_column_content_inner">
																		<header class="bt_bb_headline bt_bb_dash_none bt_bb_size_normal bt_bb_superheadline bt_bb_align_inherit">
																			<h2><span class="bt_bb_headline_content"><span>Últimas Notícias</span></span></h2>
																		</header>
																		<div class="bt_bb_separator bt_bb_top_spacing_normal bt_bb_border_style_none"></div>
																		<div class="bt_bb_latest_posts bt_bb_columns_4 bt_bb_gap_normal bt_bb_image_shape_square">
<?
$sb = $b->query("select * from blog where s order by id desc limit 4");
while($rb=$sb->fetchObject()){
	$principal = $b->query("select * from fotos where idp={$rb->id} and tipo='blog' and principal limit 1")->fetchObject();
?>
																			<div class="bt_bb_latest_posts_item">
																				<div class="bt_bb_latest_posts_item_image"><a href="<?=$rb->t?>" target="_self"><img src="upload/blogs/thumb/<?=$principal->it?>" alt="<?=$principal->alt?$principal->alt:$rb->h1?>"></a></div>
																				<div class="bt_bb_latest_posts_item_content">
																					<h5 class="bt_bb_latest_posts_item_title"><a href="<?=$rb->t?>" target="_self"><?=$rb->h1?></a></h5>
																					<div class="bt_bb_latest_posts_item_excerpt"><?=$rb->r?></div>
																				</div>
																			</div>
<?
}
?>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</section>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>
			</div>
		</div>
	</div>
</div>
<?
Inline::a();
?>
<script type="text/javascript" src="assets/js/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="assets/js/jquery.maskedinput-1.4.1.min.js"></script>
<script type="text/javascript" src="assets/js/scripts.js"></script>
<script type="text/javascript">
$('.mk-data').mask('99/99/9999');
$('.mk-tel').mask('(99) 9999-9999');
$('.mk-cel').focusout(function(){
	var e = $(this);
	e.unmask().mask(e.val().replace(/\D/g,'').length>10?'(99) 99999-999?9':'(99) 9999-9999?9');
}).focusout();

function hasError(e){
	$("#"+e).on('keyup change',function(){
		var placeholder = $("#"+e).data('placeholder');
		$("#"+e).removeClass("haserror").css('border-color','initial').attr('placeholder',placeholder);
	});
}
</script>
<?
Inline::b();
?>