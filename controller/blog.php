<?php
$s->bodyCls = 'blog bt_bb_plugin_active woocommerce-js btHeadingStyle_default btHasAltLogo btMenuRightEnabled btStickyEnabled btHideHeadline btLightSkin btBelowMenu noBodyPreloader btSoftRoundedButtons btTransparentLightHeader btWithSidebar btSidebarRight btMenuRight btMenuHorizontal btMenuInitFinished vsc-initialized btRemovePreloader';
$hj = date("Y-m-d");

$_rel = 0;
$qe = tag($s->q,1,' ');// Query tag com espaços
$qel = '%'.tag($s->q,1,'%').'%';// Query tag com % para like
$qo = buscaTrata($s->q);// Query original transformada para echo
$q = buscaTrata($qe,1,1);// Query tag com espaços e * para match against
$q = trim(preg_replace('/ \*| de\*| em\*| no\*| na\*| para\*| a\*| e\*| com\*| -\* /','',' '.$q));

$sql = 'blog b';
$w = array("b.s and b.dp<='$hj'");
$_qt = 6;
$pg = $s->pg;
$_red = 0;

//if($s->cat)$w[] = "b.m='{$s->cat}'";
if($s->spg=='tag'&&$s->cat){
	if($rtag=$b->query("select id from tag where t='{$s->cat}' limit 1")->fetchObject()){
		$sql .= " inner join tag t on b.id=t.idp and t.tipo='blog'";
		$w[] = "t.id=$rtag->id";
	}else{
		$w[] = 'b.id=0';
	}
}

// REDIRECIONAR
if($s->pgn===1)++$_red;
if(!$s->pgn)$s->pgn = 1;

if((isset($_GET['q'])&&!$q)||$s->q!=strs($qo))++$_red;

if(!$_red){
	if($q)$w[] = "(b.t like '$qel' or b.d like '$qel' or b.h1 like '$qel'".($_rel?" or (match(b.t,b.d,b.h1)against('$q' in boolean mode))":'').' )';
	$w = count($w)?'where '.implode(' and ',$w):'';
	$pgn = pgnl($count_sql="$sql $w",$_qt,$s->pgn);
	if($pgn->e&&++$_red)$s->pgn = $pgn->c;
}

$s->pga = $s->pg.($s->cat?'/'.$s->cat:'');
//$s->pga = $s->pg.'/'.($s->cat?$s->cat.'/'.($s->scat?$s->scat.'/':''):'');
//$s->pga = $s->pg.'/'.($s->cat?$s->cat.'/'.($s->scat?$s->scat.'/'.($s->sscat?$s->sscat.'/':''):''):'');
//$s->pga = $s->pg.'/';
$s->pgb = ($q?'?q='.urlencode($qo):'');
$s->upLink($pgn->b,$_red,301);

if($_red){
	echo '<!-- '.$s->loc.' -->';
	exit;
}
// FIM do REDIRECIONAR

$sql = 'select b.*'.
//($q&&$_rel?",(match(b.t)against('$q' in boolean mode)) rel":'').
($q&&$_rel?",((1.6*(match(b.t,b.d)against('$q' in boolean mode)))+(0.6*(match(b.t,b.d)against('$q' in boolean mode)))) rel":'').
" from $sql $w order by b.dp desc limit {$pgn->i},{$pgn->l}";
$stb = $b->query($sql);
//echo '<!-- '.$sql.' -->';

$s->seo['@og:type'] = 'object';
$s->seo['revisit-after'] = '1 day';