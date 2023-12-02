<?
if($s->adm()){
	$Q = strps('q',0,0,0,0,0);// Query passada
	$_rel = strp('rel',3)?1:0;
	$_qt = strp('qt',3);
	$_pg = strp('pg',3);
	$_ord = strps('ord',1);

	if(!$_qt)$_qt = 30;
	if($_qt>500)$_qt = 500;

	$qe = tag($Q,1,' ');// Query tag com espaços
	$qel = '%'.tag($Q,1,'%').'%';// Query tag com % para like
	$qo = buscaTrata($Q);// Query original transformada para echo
	$q = buscaTrata($qe,1,1);// Query tag com espaços e * para match against
	$q = trim(preg_replace('/ \*| de\*| em\*| no\*| na\*| para\*| a\*| e\*| com\*| -\* /','',' '.$q));

	$sql = 'slider s';
	$w = array();

	/*if($idc&&$b->query("select * from cat where id=$idc limit 1")->fetchObject())$w[] = "s.idc=$idc";
	if($ids&&$b->query("select * from scat where id=$ids limit 1")->fetchObject())$w[] = "s.ids=$ids";
	if($idf&&$b->query("select * from fabricante where id=$idf limit 1")->fetchObject())$w[] = "s.idf=$idf";*/

	if($q)$w[] = "(s.n like '$qel'".($_rel?" or (match(s.n)against('$q' in boolean mode))":'').' )';
	$w = count($w)?'where '.implode(' and ',$w):'';
	$pgn = pgnl($x->sql_count="$sql $w",$_qt,$_pg);
	if($pgn->e)$pg = $pgn->c;

	/*$sql .= ' left join cat c on s.idc=c.id';
	$sql .= ' left join scat s on s.ids=s.id';
	$sql .= ' left join fabricante f on s.idf=f.id';*/

	$sql = 'select s.*'.
	($q&&$_rel?",(match(s.n)against('$q' in boolean mode)) rel":'').
	" from $sql $w".
	($_ord?" order by $_ord":'')." limit {$pgn->i},{$pgn->l}";

	if($st=$b->query($sql)){
		$i = 0;
		$x->ok = 1;
		$x->ps = pgnbt($pgn->a,$pgn->b,$pgn->c,7,' ','<a pgn="[!num!]">[!txt!]</a>','<a class="active" pgn="[!num!]">[!txt!]</a>','','','&laquo;','&raquo;',1);
		$x->sql = $sql;
		$x->p = $pgn;
		$x->_q = $Q;
		$x->qo = $qo;
		$x->q = $q;
		$x->qe = $qe;
		$x->qel = $qel;
		$x->r = array();
		while($rs=$st->fetchObject()){
			$rs->id += 0;
			$rs->s += 0;
			$rs->o += 0;
			$rs->dc .= '';
			$rs->da .= '';
			$rs->_dc = $rs->dc?datef($rs->dc,10):'';
			$rs->_da = $rs->da?datef($rs->da,10):'';
			$rs->t .= '';
			$rs->cn .= '';
			$rs->ct .= '';
			$rs->q += 0;
			$img = 'upload/sliders/'.$rs->i;
			if($rs->tipo=='imagem')$rs->i = $img&&file_exists($img)?$img:'';
			if($rs->tipo=='video')$rs->i = 'http://img.youtube.com/vi/'.$rs->y.'/2.jpg';
 			$rs->cp = $rs->it?1:0;
			$rs->e .= '';
			$rs->pg = 'slider';
			$x->r[$i++] = $rs;
		}
		$x->i = $i;
		//unset($x->sql_count,$x->sql);
	}else $x->m = 'Ocorreu um erro na busca, tente novamente!';
}else $neg = true;
?>