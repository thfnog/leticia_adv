<?
if($s->adm()){
	$Q = strps('q',0,0,0,0,0);// Query passada
	$rel = strp('rel',3)?1:0;
	$_qt = strp('qt',3);
	$_pg = strp('pg',3);
	$_ord = strps('ord',1);
	if(!$qt)$qt = 30;
	if($qt>500)$qt = 500;

	$qe = tag($Q,1,' ');// Query tag com espaços
	$qel = '%'.tag($Q,1,'%').'%';// Query tag com % para like
	$qo = buscaTrata($Q);// Query original transformada para echo
	$qs = strs($qo);// Query original transformada escapada para SQL
	$q = buscaTrata($qe,1,1);// Query tag com espaços e * para match against
	$q = trim(preg_replace('/ \*| de\*| em\*| no\*| na\*| para\*| a\*| e\*| com\*| -\* /','',' '.$q));

	$idg = strp('idg',3);

	$sql = 'email e';
	$w = array();
	if($idg)$w[] = "e.idg=$idg";
	if($qe)$w[] = "(e.id='$qe' or
		e.email='$qs' or
		e.email like '$qel')";
	$w = count($w)?'where '.implode(' and ',$w):'';

	$pgn = pgnl($x->sql_count="select count(1) qt from $sql $w",$_qt,$_pg);
	if($pgn->e)$pg = $pgn->b;

	$sql = "select e.*,g.n,g.t from $sql left join grupo g on e.idg=g.id $w ".($_ord?" order by $_ord":'')." limit {$pgn->i},{$pgn->p}";

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
			$rs->idg += 0;
			$rs->s += 0;
			$rs->_dc = $rs->dc?datef($rs->dc,10):'';
			$rs->_da = $rs->da?datef($rs->da,10):'';
			$rs->dc = $rs->dc.'';
			$rs->da = $rs->da.'';
			$rs->email .= '';
			$rs->n .= '';
			$rs->t .= '';
			$x->r[$i++] = $rs;
		}
		$x->i = $i;
		//unset($x->sql_count,$x->sql);
	}else $x->m = 'Ocorreu um erro na busca, tente novamente!';
}else $neg = true;


?>