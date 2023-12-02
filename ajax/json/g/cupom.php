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

	$tipo_cupom = strp('tipo_cupom',3);
	if($tipo_cupom!='categoria'&&$tipo_cupom!='produto'&&$tipo_cupom!='produtos')$tipo_cupom = 0;

	$dci = strps('dci');
	$dcf = strps('dcf');
	$dci = preg_match($dataRE,$dci,$_m)?"'{$_m[3]}-{$_m[2]}-{$_m[1]}'":'';
	$dcf = preg_match($dataRE,$dcf,$_m)?"'{$_m[3]}-{$_m[2]}-{$_m[1]}'":'';
	if($dci>$dcf&&$dcf)$dci = $dcf;

	$sql = 'cupom c';
	$w = array();
	if($tipo_cupom)$w[] = "c.tipo_cupom='$tipo_cupom'";
	if($s->tipoAdm==5)$w[] = "c.id_atleta='{$s->idu}'";

	if(!$dci&&!$dcf);
	elseif($dci&&!$dcf)$w[] = "c.di>=$dci";
	elseif(!$dci&&$dcf)$w[] = "c.dv<=$dcv";
	elseif($dci==$dcf)$w[] = "c.di>=$dci and c.dv<=$dcf";
	else $w[] = "c.di>=$dci and c.dv<=$dcf";
	/*if(!$dci&&!$dcf);
	elseif($dci&&!$dcf)$w[] = "c.di=$dci";
	elseif(!$dci&&$dcf)$w[] = "c.dv=$dcf";
	elseif($dci==$dcf)$w[] = "c.di=$dci and c.dv=$dcf";
	else $w[] = "c.di=$dci and c.dv=$dcf";*/

	if($q)$w[] = "(c.n like '$qel' or c.c like '$qel'".($_rel?" or (match(c.n,c.c)against('$q' in boolean mode))":'').' )';
	$w = count($w)?'where '.implode(' and ',$w):'';
	$pgn = pgnl($x->sql_count="$sql $w",$_qt,$_pg);
	if($pgn->e)$pg = $pgn->c;

	$sql = 'select c.*'.
	($q&&$_rel?",(match(c.n,c.c)against('$q' in boolean mode)) rel":'').
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
			$rs->u += 0;
			$rs->_tipo_cupom = strtoupper($rs->tipo_cupom);
			$rs->dc .= '';
			$rs->da .= '';
			$rs->di .= '';
			$rs->df .= '';
			$rs->_dc = $rs->dc?datef($rs->dc,10):'';
			$rs->_da = $rs->da?datef($rs->da,10):'';
			$rs->_di = $rs->di?datef($rs->di,8):'';
			$rs->_dv = $rs->dv?datef($rs->dv,8):'';
			$rs->t .= '';
			$rs->e .= '';
			$rs->pg = 'cupom';
			$x->r[$i++] = $rs;
		}
		$x->i = $i;
		//unset($x->sql_count,$x->sql);
	}else $x->m = 'Ocorreu um erro na busca, tente novamente!';
}else $neg = true;
?>