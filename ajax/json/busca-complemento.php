<?
$c = strps('c');
if(!$c)$x->m = 'Digite o código!';
else{
	$Q = strps('q',0,0,0,0,0);
	$qe = tag($Q,1,' ');
	$qel = '%'.tag($Q,1,'%').'%';
	$qo = buscaTrata($Q);
	$q = buscaTrata($qe,1,1);
	$q = trim(preg_replace('/ \*| de\*| em\*| no\*| na\*| para\*| a\*| e\*| com\*| -\* /','',' '.$q));

	//$sql = "select * from vss_mat_aux where cod_produto='$c' limit 1";
	//$sql = "select * from vss_mat_aux where cod_produto='$c'";
	$sql = "select c.*,c.cod_mat id,f.NOME_FORNECEDOR fn from vss_mat_aux c  left join FORNECEDORES f on c.id_fornecedor=f.id_fornecedor where c.cod_produto='$c'";
	if($st=$b->query($sql)){
		$i = 0;
		$x->ok = 1;
		$x->sql = $sql;
		$x->cpf = $cpf;
		$x->r = array();
		while($rs=$st->fetchObject()){
			$rs->id += 0;
			$x->d = $rs->desc_mat;
			$x->idf = $rs->id_fornecedor;
			$x->fn = $rs->fn;
			$x->idc = $rs->clas_fiscal;
			$x->qtd = $rs->qtd_estoque;
			$x->u = $rs->unid_med;
			$x->v = $rs->val_compra;
			$x->cst = $rs->sit_trib;
			$x->ide = $rs->ide_origem;
			$x->o = $rs->des_obs;
			$x->r[$i++] = $rs;
		}
		$x->i = $i;
		$x->ok = 1;
		unset($x->sql);
	}else $x->m = "$sql\n\n\n".'Ocorreu um erro na busca, tente novamente!';
}
//else $neg = true;
?>