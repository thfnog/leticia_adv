<?
if(isset($_POST['q'])){
	$Q = strps('q',0,0,0,0,0);
	$qe = tag($Q,1,' ');
	$qel = '%'.tag($Q,1,'%').'%';
	$qo = buscaTrata($Q);
	$q = buscaTrata($qe,1,1);
	//$_rel = strp('rel',3)?1:0;
	$_rel = 1;
	if($Q=='papel de parede'||$Q=='papel parede')$q = trim(preg_replace('/ \*| de\*| em\*| no\*| na\*| para\*| a\*| e\*| com\*| -\* /','',' '.$q));
	else $q = trim(preg_replace('/ \*| de\*| em\*| no\*| na\*| para\*| a\*| papel\*| parede\*| e\*| com\*| -\* /','',' '.$q));
	$q2 = str_replace('*','',$q);
	$_tipo = json_decode(strp('tipo'));//tipo de produto
	$_preco = json_decode(strp('preco'));//preço
	//$_tema = json_decode(strp('tema'));//tema
	$_tema = strps('tema',0,0,0,0,0);// Temas passados
	$_cor = json_decode(strp('cor'));//cor

	$qpalavra = explode(" ",$q2);
	$qnpalavra = count($qpalavra);
	foreach($qpalavra as $v){
		$qcase2[] = "pi.nome_produto like '%$v%'";
		$qcase4[] = "p.codigo_produto like '%$v%'";
		$qcase6[] = "p.descricao_produto like '%$v%'";
		$qcase8[] = "b.des_palavra like '%$v%'";
	}
	$qcase2 = count($qcase2)?implode(' and ',$qcase2):'';
	$qcase4 = count($qcase4)?implode(' and ',$qcase4):'';
	$qcase6 = count($qcase6)?implode(' and ',$qcase6):'';
	$qcase8 = count($qcase8)?implode(' and ',$qcase8):'';

	$_ord = "CASE 
           when pi.nome_produto = '$q2' then '1'
           when $qcase2 then '2'
           when p.codigo_produto = '$q2' then '3'
           when $qcase4 then '4'
           when p.descricao_produto = '$q2' then '5'
           when $qcase6 then '6'
           when b.des_palavra = '$q2' then '7'
           when $qcase8 then '8'
     END DESC,pi.posicao asc";

	$idc = strp('idc',3);
	if($_tipo)foreach($_tipo as $k=>&$v){
		$tp[] = "tp.cod_filtro=$v";
		$tipo = count($tp)?implode(' or ',$tp):'';
	}
	if($_preco)foreach($_preco as $k=>&$v){
		if($v==1){
			$vmin = '0';
			$vmax = '50';
		}if($v==2){
			$vmin = '50';
			$vmax = '150';
		}if($v==3){
			$vmin = '150';
			$vmax = '300';
		}if($v==4){
			$vmin = '300';
			$vmax = '500';
		}if($v==5){
			$vmin = '500';
			$vmax = '1000';
		}if($v>=6){	
			$vmin = '1000';
			$vmax = '1000000';
		}
		//if($vmin&&$vmax)$w[] = "p.PRECO_VENDA >= $vmin and p.PRECO_VENDA <= $vmax";
		$idp[] = "p.PRECO_VENDA >= $vmin and p.PRECO_VENDA <= $vmax";
		$preco = count($idp)?implode(' or ',$idp):'';
	}
	if($_tema){
		$_tema = explode("-",$_tema);
		foreach($_tema as $k=>&$v){
			/*$idt[] = "t.cod_filtro=$v";
			$tema = count($idt)?implode(' or ',$idt):'';*/
			if($v==1){
				$temas[]= 15;
				$temas[]= 16;
				$temas[]= 17;
			}if($v==2){
				$temas[]= 5;
				$temas[]= 38;
				$temas[]= 39;
			}if($v==3){
				$temas[]= 6;
				$temas[]= 40;
				$temas[]= 41;
			}
			if($v==4)$temas[]= 8;
			if($v==5)$temas[]= 35;
			if($v==6){
				$temas[]= 3;
				$temas[]= 12;
			}if($v==7)$temas[] = 13;
			if($v==8){
				$temas[] = 14;
				$temas[] = 26;
				$temas[] = 1;
				$temas[] = 4;
			}if($v==9){
				$temas[]= 7;
				$temas[]= 33;
				$temas[]= 43;
			}if($v==10){
				$temas[]= 19;
				$temas[]= 36;
				$temas[]= 32;
				$temas[]= 44;
			}if($v==11){
				$temas[]= 20;
				$temas[]= 23;
				$temas[]= 24;
				$temas[]= 25;
			}if($v==12){
				$temas[]= 22;
				$temas[]= 11;
			}if($v==13)$temas[]= 29;
			if($v==14){
				$temas[]= 30;
				$temas[]= 18;
			}if($v>=15){
				$temas[]= 31;
				$temas[]= 45;
			}
		}
		$temas = implode(",",$temas);
	}
	if($_cor)foreach($_cor as $k=>&$v){
		$idcor[] = "c.cod_filtro=$v";
		$cor = count($idcor)?implode(' or ',$idcor):'';
	}

	$sql = 'PRODUTOS_INTERNACIONAL pi';
	$sql .= ' left join PRODUTOS p on pi.id_produto=p.id_produto';
	$sql .= ' left join vss_filtro_produto_palavra b on pi.id_produto=b.id_produto';
	if($_tipo)$sql .= ' left join produto_tipo tp on p.id_produto=tp.id_produto and tp.cod_tipo_filtro=49';
	if($_tema)$sql .= ' left join produto_tema t on pi.id_produto=t.id_produto and t.cod_tipo_filtro=51';
	if($_cor)$sql .= ' left join produto_cor c on pi.id_produto=c.id_produto and c.cod_tipo_filtro=52';

	$w = array("p.id_empresa='{$s->ide}' and pi.s and pi.ith is not null and pi.it is not null and pi.itm is not null and pi.itr is not null and pi.itc is not null and pi.ito is not null");

	if($_tipo)$w[] = "($tipo)";
	if($_preco)$w[] = "($preco)";
	//if($_tema)$w[] = "($tema)";
	if($temas)$w[] = "(t.cod_filtro in ($temas))";
	if($_cor)$w[] = "($cor)";
	$w[] = "(pi.nome_produto like '$qel' or pi.t like '$qel' or p.codigo_produto like '$qel' or p.descricao_produto like '$qel' or b.des_palavra like '$qel' or b.t like '$qel'".($_rel?" or (match(pi.nome_produto)against('$q' in boolean mode)) or (match(p.codigo_produto)against('$q' in boolean mode)) or (match(p.descricao_produto)against('$q' in boolean mode)) or (match(b.des_palavra)against('$q' in boolean mode))":'').' )';

	$w = count($w)?'where '.implode(' and ',$w):'';

	$sql = 'select pi.id_produto id,pi.titulo_produto n,pi.t t,p.CODIGO_PRODUTO c,pi.itc img'.
	/*($q&&$_rel?",(match(pi.nome_produto,pi.titulo_produto,pi.t,p.codigo_produto,p.descricao_produto,b.des_palavra,b.t)against('$q' in boolean mode)) rel":'').
	($pes&&$_rel?",(match(pi.nome_produto,pi.titulo_produto,pi.t,p.codigo_produto,p.descricao_produto,b.des_palavra,b.t)against('$pes' in boolean mode)) rel":'').*/
	" from $sql $w group by pi.id_produto".
	($_ord?" order by $_ord":'')." limit 6";
	if($st=$b->query($sql)){
		$i = 0;
		if($st->rowCount()){
			while($rs=$st->fetchObject()){
				$n = $rs->n;
				$t = $rs->t;
				$id = $rs->id;
				if($t&&!in_array($n,$_t)){
					$_t[] = $t;
					$x[$i]->sql = $sql;
					$x[$i]->tema = $_tema;
					$x[$i]->_q = $Q;
					$x[$i]->q = $q;
					$x[$i]->new_q = $new_q;
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
		}else $x[0]->r = '<li class="col-md-12">Nenhum produto encontrado!</li>';
		unset($x->sql);
	}else $x->m = "$sql\n\n\n".'Ocorreu um erro na busca, tente novamente!';
}else $neg = true;
?>