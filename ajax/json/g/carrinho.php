<?
if($s->adm()){
	$Q = strps('q',0,0,0,0,0);// Query passada
	$rel = strp('rel',3)?1:0;
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

	$sql = 'cart c inner join cliente l on c.idu=l.id';
	$w = array("c.s=1");

	if($q)$w[] = "(c.id='$Q' or l.n like '$qel' or l.email='$Q'".($_rel?" or (match(c.n)against('$q' in boolean mode))":'').' )';
	$w = count($w)?'where '.implode(' and ',$w):'';

	$pgn = pgnl($x->sql_count="select count(1) qt from $sql $w",$_qt,$_pg);
	if($pgn->e)$_pg = $pgn->c;

	$sql = "select c.*,l.n nome,l.email from $sql $w".($_ord?" order by $_ord":'')." limit {$pgn->i},{$pgn->l}";

	if($st=$b->query($sql)){
		$i = 0;
		$x->ok = 1;
		$x->ps = pgnbt($pgn->a,$pgn->b,$pgn->c,7,' ','<a pgn="[!num!]">[!txt!]</a>','<a class="active" pgn="[!num!]">[!txt!]</a>','','','&laquo;','&raquo;',1);
		$x->sql = $sql;
		$x->p = $pgn;
		$x->_q = $Q;
		$x->qo = $id?$id:'';
		$x->r = array();
		while($rs=$st->fetchObject()){
			$rs->id += 0;
			$rs->idu += 0;
			$rs->a += 0;
			$rs->_a = $s->ps->stt[$rs->statusPagseguro];
			$rs->statusPedido += 0;
			$rs->_p = $s->ps->sttPedido[$rs->statusPedido];
			//$rs->_importado = $rs->importado?'SIM':'NÃO';
			$rs->dc .= '';
			$rs->da .= '';
			$rs->_dc = $rs->dc?datef($rs->dc,10):'';
			$rs->_da = $rs->da?datef($rs->da,10):'';
			$rs->v += 0;
			$rs->_v = nreal($rs->v);
			$rs->t += 0;
			$rs->_t = nreal($rs->t);
			$rs->i += 0;
			$rs->n .= '';
			$x->r[$i++] = $rs;
		}
		$x->i = $i;
		//unset($x->sql_count,$x->sql);
	}else $x->m = 'Ocorreu um erro na busca, tente novamente!';
}else $neg = true;


?>