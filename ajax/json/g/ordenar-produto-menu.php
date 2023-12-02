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

	$idc = strp('idc',3);//categoria

	if($idc){
		$sql = 'produto p';
		$w = array("p.idc=$idc");
	
		/*if($idc&&$b->query("select * from cat where id=$idc limit 1")->fetchObject())$w[] = "p.idc=$idc";
		if($ids&&$b->query("select * from scat where id=$ids limit 1")->fetchObject())$w[] = "p.ids=$ids";
		if($idf&&$b->query("select * from fabricante where id=$idf limit 1")->fetchObject())$w[] = "p.idf=$idf";*/
	
		if($q)$w[] = "(p.n like '$qel'".($_rel?" or (match(p.n)against('$q' in boolean mode))":'').' )';
		$w = count($w)?'where '.implode(' and ',$w):'';
		$pgn = pgnl($x->sql_count="$sql $w",$_qt,$_pg);
		if($pgn->e)$pg = $pgn->c;
	
		/*$sql .= ' left join cat c on p.idc=c.id';
		$sql .= ' left join scat s on p.ids=s.id';
		$sql .= ' left join fabricante f on p.idf=p.id';*/
	
		$sql_total = 'select p.*'.($q&&$_rel?",(match(p.n)against('$q' in boolean mode)) rel":'')." from $sql $w".($_ord?" order by $_ord":'');
		$x->nrows = $b->query($sql_total)->rowCount();
	
		$sql = 'select p.*'.
		($q&&$_rel?",(match(p.n)against('$q' in boolean mode)) rel":'').
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
				$rf = $b->query("select * from fotos where idp={$rs->id} and tipo='produto'")->fetchObject();
				$rpr = $b->query("select * from fotos where idp={$rs->id} and tipo='produto' and principal")->fetchObject();
				$img = 'thumb/'.($rpr->it?$rpr->it:($rf->it?$rf->it:'default.jpg'));
				$rs->i = $img&&file_exists("upload/produtos/$img")?$img:'';
				$rs->cp = $rf?1:0;
				$rs->e .= '';
				$rs->result = '<tr class="lrow img odd" _id="'.$rs->id.'">
					<td class="cell box-img" title="'.$rs->h1.'"><span class="box-img-center auto w"><span></span><img src="upload/produtos/'.$img.'"></span></td>
					<td class="cell line" title="'.$rs->h1.'"><a href="admin/produto/'.$rs->id.'" target="">'.$rs->h1.'</a></td>
					<td class="cell">'.$rs->_dc.'</td>
					<td class="cell"><a class="ico icrop" title="Recortar Imagens" href="admin/crop-produtos/'.$rs->id.'"></a></td>
					<td class="cell"><a class="ico ifolder" title="Adicionar Fotos" href="admin/produto-foto/'.$rs->id.'"></a></td>
					<td class="cell"><span class="ico iunblock" title="Desativar"></span> <a class="ico ialt" title="Alterar" href="admin/produto/'.$rs->id.'"></a> <span class="ico idel" title="Excluir"></span></td>
				</tr>';
				//$rs->add = ' Adicionar Fotos';
				$rs->pg = 'produto';
				$x->r[$i++] = $rs;
			}
			$x->i = $i;
			$x->head = '<tr class="lrow th">
				<th class="cell i"><a href="javascript:;" class="ord ord-i">Imagem</a></th><th class="cell t"><a href="javascript:;" class="ord ord-t">Título</a></th>
				<th class="cell dc"><a href="javascript:;" class="ord ord-dc za ord-index-0">Cadastrado em</a></th>
				<th class="cell it"><a href="javascript:;" class="ord ord-it">Recortar Imagens</a></th>
				<th class="cell t"><a href="javascript:;" class="ord ord-t">Adicionar Fotos</a></th><th class="cell s"><a href="javascript:;" class="ord ord-s">Opções</a></th>
			</tr>';
			//unset($x->sql_count,$x->sql);
		}else $x->m = 'Ocorreu um erro na busca, tente novamente!';
	}
}else $neg = true;
?>