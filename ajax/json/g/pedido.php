<?
if($s->adm()){
	$Q = strps('q',0,0,0,0,0);// Query passada
	$rel = strp('rel',3)?1:0;
	$_qt = strp('qt',3);
	$_pg = strp('pg',3);
	$_ord = strps('ord',1);
	if(!$_qt)$_qt = 30;
	if($_qt>500)$_qt = 500;

	$id = str($Q,3);
	$a = strp('s',3);//STATUS PAGSEGURO
	$p = strp('p',3);//STATUS PEDIDO
	$tf = strp('tf',3);//TIPO DE FRETE
	//$importado = strp('importado',3);//IMPORTADO NA BL
	if(!array_key_exists($a,$s->ps->stt))$a = 0;
	if(!array_key_exists($p,$s->ps->sttPedido))$p = 0;
	if(!array_key_exists($tf,$s->ps->envio))$tf = 0;

	$sql = 'pedido p';
	$w = array();
	if($id)$w[] = "p.id=$id";
	if($a)$w[] = "p.statusPagseguro=$a";
	if($p)$w[] = "p.statusPedido=$p";
	if($tf)$w[] = "p.tf=$tf";
	//if(($importado||$importado==0)&&$importado!=300)$w[] = "p.importado=$importado";
	//if($importado==300)$w[] = "p.importado!=$importado";
	$w = count($w)?'where '.implode(' and ',$w):'';

	$pgn = pgnl($x->sql_count="select count(1) qt from $sql $w",$_qt,$_pg);
	if($pgn->e)$_pg = $pgn->c;

	$sql = "select p.* from $sql $w".($_ord?" order by $_ord":'')." limit {$pgn->i},{$pgn->l}";

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