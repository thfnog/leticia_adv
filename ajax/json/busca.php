<?
if(isset($_POST['q'])){
	$Q = strps('q',0,0,0,0,0);
	$qe = tag($Q,1,' ');
	$qel = '%'.tag($Q,1,'%').'%';
	$qo = buscaTrata($Q);
	$q = buscaTrata($qe,1,1);
	if($Q=='papel de parede'||$Q=='papel parede')$q = trim(preg_replace('/ \*| de\*| em\*| no\*| na\*| para\*| a\*| e\*| com\*| -\* /','',' '.$q));
	else $q = trim(preg_replace('/ \*| de\*| em\*| no\*| na\*| para\*| a\*| papel\*| parede\*| e\*| com\*| -\* /','',' '.$q));
	$q2 = str_replace('*','',$q);

	$qpalavra = explode(" ",$q2);
	$qnpalavra = count($qpalavra);
	foreach($qpalavra as $v){
		$qcase2[] = "pi.nome_produto like '%$v%'";
		$qcase4[] = "p.descricao_produto like '%$v%'";
		$qcase6[] = "b.des_palavra like '%$v%'";
	}
	$qcase2 = count($qcase2)?implode(' and ',$qcase2):'';
	$qcase4 = count($qcase4)?implode(' and ',$qcase4):'';
	$qcase6 = count($qcase6)?implode(' and ',$qcase6):'';

	$_ord = "CASE 
           when pi.nome_produto = '$q2' then '1'
           when $qcase2 then '2'
           when p.descricao_produto = '$q2' then '3'
           when $qcase4 then '4'
           when b.des_palavra = '$q2' then '5'
           when $qcase6 then '6'
     END DESC";

	$idc = strp('idc',3);
	if($idc)$sql = "select pi.id_produto id,pi.titulo_produto n,pi.t t,p.CODIGO_PRODUTO c,pi.itc img from PRODUTOS_INTERNACIONAL pi left join PRODUTOS p on pi.id_produto=p.id_produto left join vss_filtro_produto_palavra b on pi.id_produto=b.id_produto where p.id_empresa='{$s->ide}' and pi.s and p.id_categoria=$idc and (pi.nome_produto like '$qel' or pi.t like '$qel' or p.codigo_produto like '$qel' or p.descricao_produto like '$qel' or b.des_palavra like '$qel' or b.t like '$qel') or (match(pi.nome_produto)against('$q' in boolean mode)) or (match(p.codigo_produto)against('$q' in boolean mode)) or (match(p.descricao_produto)against('$q' in boolean mode)) or (match(b.des_palavra)against('$q' in boolean mode)) group by pi.id_produto order by $_ord";
	else $sql = "select pi.id_produto id,pi.titulo_produto n,pi.t t,p.CODIGO_PRODUTO c,pi.itc img from PRODUTOS_INTERNACIONAL pi left join PRODUTOS p on pi.id_produto=p.id_produto left join vss_filtro_produto_palavra b on pi.id_produto=b.id_produto where p.id_empresa='{$s->ide}' and pi.s and (pi.nome_produto like '$qel' or pi.t like '$qel' or p.codigo_produto like '$qel' or p.descricao_produto like '$qel' or b.des_palavra like '$qel' or b.t like '$qel') or (match(pi.nome_produto)against('$q' in boolean mode)) or (match(p.codigo_produto)against('$q' in boolean mode)) or (match(p.descricao_produto)against('$q' in boolean mode)) or (match(b.des_palavra)against('$q' in boolean mode)) group by pi.id_produto order by $_ord";
	if($st=$b->query($sql)){
		$i = 0;
		/*$x->ok = 1;
		$x->sql = $sql;
		$x->_q = $Q;
		$x->qo = $qo;
		$x->q = $q;
		$x->qel = $qel;
		$x->r = array();*/
		if($st->rowCount()){
			while($rs=$st->fetchObject()){
				$n = $rs->n;
				$t = $rs->t;
				$id = $rs->id;
				if($t&&!in_array($n,$_t)){
					$_t[] = $t;
					$x[$i]->_q = $Q;
					$x[$i]->q = $q;
					$x[$i]->new_q = $new_q;
					//$x[$i]->busca = phpLike($Q,$rs->n)?1:0;
					$x[$i]->id = $rs->id;
					$x[$i]->n = $rs->c.' <br> '.$rs->n;
					$x[$i]->c = $rs->c;
					$x[$i]->img = 'upload/produtos/thumb/'.$rs->img;
					$x[$i]->t = $t;
					$x[$i]->l = 'produto/'.$rs->id.'/'.$rs->t;
					if($s->idc==188565)$x[$i]->r = '<li class="col-md-2"><a href="'.$x[$i]->l.'"><img src="'.$x[$i]->img.'" width="59" height="67" alt="'.$x[$i]->n.'"/><span>'.$x[$i]->c.'</span></a></li>';
					else $x[$i]->r = '<li><a href="'.$x[$i]->l.'"><img src="'.$x[$i]->img.'" width="60" height="67" alt="'.$x[$i]->n.'" style="float:left;padding-right:10px"/><span>'.$x[$i]->n.'</span></a></li>';
					$i++;
				}
				$max = $s->idc==188565?6:7;
				if($i===$max&&$st->rowCount()>$max){
					$x[$max]->r = "<li style='margin:0 auto;width:81px;padding-right:0;font-weight:bold;'><a href='produtos/1?idc=".$idc."&p=".$q."'><span>Ver Mais</span> <i class='fa fa-search' style='padding-left:10px;padding-top:14px'></i></a></li>";
					break;
				}elseif($i===$max&&$st->rowCount()<=$max)break;
			}
		}else $x[0]->r = '<li>Nenhum produto encontrado!</li>';
		//$x->i = $i;
		unset($x->sql);
	}else $x->m = "$sql\n\n\n".'Ocorreu um erro na busca, tente novamente!';
}else $neg = true;
?>