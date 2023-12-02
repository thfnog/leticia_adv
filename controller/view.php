<?
$slug = $b->query("select * from slugs where slug='{$s->slug}' limit 1")->fetchObject();
$s->pg = $slug->page;
$hj = date("Y-m-d");

if($s->pg=='post'){
	$s->bodyCls = 'blog bt_bb_plugin_active woocommerce-js btHeadingStyle_default btHasAltLogo btMenuRightEnabled btStickyEnabled btHideHeadline btLightSkin btBelowMenu noBodyPreloader btSoftRoundedButtons btTransparentLightHeader btWithSidebar btSidebarRight btMenuRight btMenuHorizontal btMenuInitFinished vsc-initialized btRemovePreloader';
	if($s->idu)$rs = $b->query("select * from blog where t='{$s->slug}' limit 1")->fetchObject();
	else $rs = $b->query("select * from blog where t='{$s->slug}' and s and dp<='$hj' limit 1")->fetchObject();
	if(!$rs)$s->loc('blog');
	
	$s->id = $rs->id;
	$s->tagd = $rs->tagd;
	$s->tagt = $rs->tagt;
	$fotos = $b->query("select * from fotos where idp='{$s->id}' and tipo='blog' and principal limit 1")->fetchObject();
	$url = $s->base.$rs->t;
	$url_encode = rawurlencode($url);
	$text = rawurlencode($rs->h1);
	//$url_amp = $s->pg.'-amp/'.$rs->id.'/'.$rs->t;
	$s->seo['@og:image'] = $s->base.'upload/blogs/'.($fotos->i?$fotos->i:'thumb/default.png');
	$s->seo['/canonical'] = $url;
	//$s->seo['/amphtml'] = $url_amp;
	$s->seo['/alternate'] = $url;
	
	$s->seo['@og:type'] = 'article';
	$s->seo['@article:published_time'] = datef($rs->dc,'%Y-%m-%dT%H:%M:%S');
	$s->seo['@article:modified_time'] = $s->seo['@og:updated_time'] = $rs->da?datef($rs->da,'%Y-%m-%dT%H:%M:%S'):'';
}elseif($s->pg=='servico'){
	$s->bodyCls = 'blog bt_bb_plugin_active woocommerce-js btHeadingStyle_default btHasAltLogo btMenuRightEnabled btStickyEnabled btHideHeadline btLightSkin btBelowMenu noBodyPreloader btSoftRoundedButtons btTransparentLightHeader btWithSidebar btSidebarRight btMenuRight btMenuHorizontal btMenuInitFinished vsc-initialized btRemovePreloader';
	if($s->idu)$rs = $b->query("select * from servico where t='{$s->slug}' limit 1")->fetchObject();
	else $rs = $b->query("select * from servico where t='{$s->slug}' and s limit 1")->fetchObject();
	if(!$rs)$s->loc('servicos');
	
	$s->id = $rs->id;
	$s->tagd = $rs->tagd;
	$s->tagt = $rs->tagt;
	$fotos = $b->query("select * from fotos where idp='{$s->id}' and tipo='servico' and principal limit 1")->fetchObject();
	$url = $s->base.$rs->t;
	$url_encode = rawurlencode($url);
	$text = rawurlencode($rs->h1);
	//$s->seo['@og:image'] = $s->base.'upload/blogs/'.($fotos->i?$fotos->i:'thumb/default.png');
	$s->seo['/canonical'] = $url;
	//$s->seo['/amphtml'] = $url_amp;
	$s->seo['/alternate'] = $url;
	
	$s->seo['@og:type'] = 'article';
	$s->seo['@article:published_time'] = datef($rs->dc,'%Y-%m-%dT%H:%M:%S');
	$s->seo['@article:modified_time'] = $s->seo['@og:updated_time'] = $rs->da?datef($rs->da,'%Y-%m-%dT%H:%M:%S'):'';
}