<?
if($s->adm()){
	$id = strp('id',3);
	$idc = strp('idc',3);
	$idc2 = strp('idc2',3);
	$idc3 = strp('idc3',3);
	$idm = strp('idm',3);
	$S = strp('s',3)?1:0;
	$home = strp('home',3)?1:0;
	$principal = strp('principal',3);
	$hover = strp('hover',3);
	$h1 = strps('h1');
	$h2 = strps('h2');
	$t = tag($h1,1);
	$n = strps('n');
	$d = strps('d');
	$nutricional = strps('nutricional');
	$tecnico = strps('tecnico');
	$obs = strps('obs');//DESCRIÇÃO TOPO
	$ingredientes = strps('ingredientes');
	$diabeticos = strps('diabeticos');
	$sugestao = strps('sugestao');
	$recomendacao = strps('recomendacao');
	$page = 'produto';

//MEDIDAS
	$largura = strps('largura');
	$altura = strps('altura');
	$comprimento = strps('comprimento');
	$peso = strps('peso');
	$v = strps('v');
	//$estoque = strp('estoque',3);
	//$estoque_minimo = strp('estoque_minimo',3);
//MEDIDAS

	$idp = strp('idp',3);//PRODUTO RELACIONADO

	$P = 'upload/produtos/arquivos/';
	$Rf = strp('rf',3)?1:0;
	$f = $s->getfile(strp('f',3));
	$F = 'f';
	$Df = '';

	$tagd = strps('tagd');
	$tagk = strps('tagk');
	$tagt = strps('tagt')?strps('tagt'):$n;

//VARIAÇÕES
	$pesoVariacao = strps('peso');
	$saborVariacao = strps('sabor');
	$adicionalVariacao = strps('adicional');
	$estoqueVariacao = strps('estoque');
//VARIAÇÕES

	$rs = $b->query("select id,f from produto where id=$id limit 1")->fetchObject();

	//INÍCIO BLING
	if($apiBling->strApiKey)$xmlData = array();
	//INÍCIO BLING

	if($id&&!$rs&&++$N)$x->m = 'Este produto não existe!';
	//elseif(!$idc)$x->m = 'Selecione a categoria!';
	//elseif(!$idm)$x->m = 'Selecione a marca!';
	elseif(!$h1)$x->m = 'Digite o título (h1) do produto!';
	elseif(!$n)$x->m = 'Digite o slug do produto usado para url!';
	elseif($checkSlug=='indisponivel')$x->m = 'Esta slug já está sendo utilizada, por favor altere a slug!';
	/*elseif(!$d)$x->m = 'Digite a descrição geral!';
	elseif(!isset($largura))$x->m = 'Digite a largura do produto!';
	elseif(isset($largura)&&$largura<11)$x->m = 'A largura mínima do produto é 11cm!';
	elseif(!isset($altura))$x->m = 'Digite a altura do produto!';
	elseif(isset($altura)&&$altura<2)$x->m = 'A altura mínima do produto é 2cm!';
	elseif(!isset($comprimento))$x->m = 'Digite o comprimento do produto!';
	elseif(isset($comprimento)&&$comprimento<16)$x->m = 'O comprimento mínimo do produto é 16cm!';
	elseif(!isset($peso))$x->m = 'Digite o peso do produto!';
	elseif(!isset($v))$x->m = 'Digite o valor do produto!';
	elseif(!isset($estoque))$x->m = 'Digite o estoque do produto!';
	elseif(!isset($estoque_minimo))$x->m = 'Digite o estoque do produto!';
	elseif($f&&$f->e&&++$N)$x->m = 'Ocorreu um erro ao fazer upload do arquivo!';*/
	//elseif($f&&($f->ex!='zip'&&$f->ex!='rar')&&++$N)$x->m = 'O arquivo deve ser .zip ou .rar!';
	else{
		$x->up = $id?1:0;
		if(!$id&&$b->exec("insert into produto set dc=now()"))$id = $b->lastInsertId();
		if($Rf){
			$x->i->f = '';
			$F = 'null';
			$Df = $rs->f;
		}elseif($f){
			$C = $t.'-'.date('his').'.'.$f->ex;
			if($f=$s->movefile($f->id,$P.$C)){
				$x->i->f = $P.$C;
				$F = "'$C'";
				$Df = $rs->f;
			}
		}
		if($b->exec($x->upd="update produto set s=$S,home=$home,idc=$idc,idc2=$idc2,idc3=$idc3,idm=$idm,h1='$h1',h2='$h2',n='$n',t='$t',d='$d',obs='$obs',nutricional='$nutricional',ingredientes='$ingredientes',diabeticos='$diabeticos',sugestao='$sugestao',recomendacao='$recomendacao',v='$v',f=$F,tagd='$tagd',tagt='$tagt' where id=$id limit 1")){
			if($x->up)$b->exec("update produto set da=now() where id=$id limit 1");
			if($Df)@unlink($P.$Df);
			$x->ok = 1;
			//BLING
			if($apiBling->strApiKey){
				$xmlData['codigo'] = $id;//STRING(60)
				$xmlData['descricao'] = limitaCaracteres($h1,120);//STRING(120)
				$xmlData['situacao'] = $S?'Ativo':'Inativo';
				$xmlData['descricaoCurta'] = $obs;//STRING
				$xmlData['descricaoComplementar'] = $d;//STRING
				$xmlData['un'] = 'pc';//pc, un, cx
				$xmlData['vlr_unit'] = $v;
				$xmlData['preco_custo'] = '';
				$xmlData['peso_bruto'] = $peso;
				$xmlData['peso_liq'] = $peso;
				$xmlData['class_fiscal'] = '';//NCM do produto 9999.99.99
				$xmlData['marca'] = 'Shark Pro';//STRING(40)
				$xmlData['origem'] = 0;
				$xmlData['estoque'] = $estoque;
				$xmlData['gtin'] = '';
				$xmlData['largura'] = $largura;
				$xmlData['altura'] = $altura;
				$xmlData['profundidade'] = $comprimento;
				$xmlData['estoqueMinimo'] = $estoque_minimo;
				$xmlData['estoqueMaximo'] = '';
				$xmlData['cest'] = '';//CEST 99.999.99
				$xmlData['idGrupoProduto'] = 0;
				$xmlData['condicao'] = 'Novo';//Condição do produto (Não especificado, Novo ou Usado)
				$xmlData['freteGratis'] = 'N';
				$xmlData['linkExterno'] = "https://www.sharkpro.com.br/$t";
				$xmlData['observacoes'] = '';
				$xmlData['producao'] = 'P';//P = própria ou T = Terceirizada
				$xmlData['dataValidade'] = '';//Data de validade do produto dd/mm/YYYY
				$xmlData['descricaoFornecedor'] = '';
				$xmlData['unidadeMedida'] = 'Centímetros';
				$xmlData['garantia'] = 4;//Meses de Garantia
				$xmlData['itensPorCaixa'] = 1;//Quantidade de Itens por caixa
				$xmlData['volumes'] = 0;//Quantidade de volumes do produto
				$xmlData['urlVideo'] = '';//URL WATCH DO YOUTUBE
				$xmlData['variacoes'][0]['variacao']['nome'] = 'Sabor:Morango;Peso:1Kg';
				$xmlData['variacoes'][0]['variacao']['codigo'] = $id.'-Morango';
				$xmlData['variacoes'][0]['variacao']['vlr_unit'] = $v;
				//$xmlData['variacoes'][0]['variacao']['deposito']['id'] = 2;
				$xmlData['variacoes'][0]['variacao']['estoque'] = 15;
				$xmlData['variacoes'][1]['variacao']['nome'] = 'Sabor:Chocolate;Peso:1Kg';
				$xmlData['variacoes'][1]['variacao']['codigo'] = $id.'-Chocolate';
				$xmlData['variacoes'][1]['variacao']['vlr_unit'] = $v;
				//$xmlData['variacoes'][1]['variacao']['deposito']['id'] = 2;
				$xmlData['variacoes'][1]['variacao']['estoque'] = 17;
				$x->bling = $apiBling->postProduct($xmlData);
			}
			//BLING
			if($x->up)$s->updateSlug($id,$t,$page);
			else $s->insertSlug($id,$t,$page);
		}elseif($x->up)$x->noup = 1;
		else $x->m = 'Erro ao cadastar o produto!';
		if($id){
			//VARIAÇÕES
			if($peso)foreach($peso as $k=>$v){
				if($v){
					$peso = $v;
					$sabor = $saborVariacao[$k];
					$adicional = $adicionalVariacao[$k];
					$estoque = $estoqueVariacao[$k];
		
					$rs = $b->query("select id_produto from produto_estoque where id_peso='$peso' and id_produto=$id limit 1")->fetchObject();
					if(!$rs&&$peso&&$b->exec("insert into produto_estoque (id_produto,id_peso,id_sabor,estoque,adicional,dc)values($id,'$peso','$sabor','$estoque','$adicional',now())"))$x->ok = 1;
					$re = $b->query("select id_peso from produto_estoque where id_peso='$peso' and id_produto=$id")->fetchObject();
					$nidpeso[] = $re->id_peso;
				}
			}
			if($nidpeso){
				$nidpeso2 = implode(",",$nidpeso);
				$del = $b->query("delete from produto_estoque where id_produto=$id and id_peso not in($nidpeso2)");
				if($del->rowCount())$x->ok = 1;
			}else{
				$del = $b->query("delete from produto_estoque where id_produto=$id and id_peso!='$peso'");
				if($del->rowCount())$x->ok = 1;
			}
			//CATEGORIAS
			if($idc)foreach($idc as $k=>&$v){
				$idc = &$v;
				$rs = $b->query("select idp from produto_cat where idc='$idc' and idp=$id limit 1")->fetchObject();
				if(!$rs&&$idc&&$b->exec("insert into produto_cat (idc,idp,dc)values($idc,$id,now())"))$x->ok = 1;
				$re = $b->query("select idc from produto_cat where idc='$idc' and idp=$id")->fetchObject();
				$nidc[] = $re->idc;
			}
			if($nidc){
				$nidc2 = implode(",",$nidc);
				$del = $b->query("delete from produto_cat where idp=$id and idc not in($nidc2)");
				if($del->rowCount())$x->ok = 1;
			}else{
				$del = $b->query("delete from produto_cat where idp=$id and idc!=$idc");
				if($del->rowCount())$x->ok = 1;
			}
			//PRODUTOS RELACIONADOS
			if($idp)foreach($idp as $k=>&$v){
				$idp = &$v;
				$rs = $b->query("select id from produto_relacionado where (idp='$idp' and idp2=$id) or (idp='$id' and idp2='$idp') limit 1")->fetchObject();
				if(!$rs&&$idp&&$b->exec("insert into produto_relacionado (idp,idp2,dc)values($id,$idp,now())"))$x->ok = 1;
				$re = $b->query("select id from produto_relacionado where (idp='$idp' and idp2=$id) or (idp='$id' and idp2='$idp')")->fetchObject();
				$nidp[] = $re->id;
			}
			if($nidp){
				$nidp2 = implode(",",$nidp);
				$del = $b->query("delete from produto_relacionado where (idp=$id or idp2=$id) and id not in($nidp2)");
				if($del->rowCount())$x->ok = 1;
			}else{
				$del = $b->query("delete from produto_relacionado where idp=$id or idp2=$id");
				if($del->rowCount())$x->ok = 1;
			}
			if($principal){
				$sfoto = $b->query("select id,i from fotos where id=$principal and idp=$id and tipo='produto' and principal limit 1");
				if(!$sfoto->rowCount()){				
					$b->exec("update fotos set principal=1,da=now() where id=$principal and idp=$id and tipo='produto' limit 1");
					$b->exec("update fotos set principal=0,da=now() where id!=$principal and idp=$id and tipo='produto'");
					$x->ok = 1;
				}else{
					$rfoto = $sfoto->fetchObject();
					//BLING
					if($apiBling->strApiKey){
						$imgData = array();
						$imgData['codigo'] = $id;//STRING(60)
						$imgData['descricao'] = limitaCaracteres($h1,120);//STRING(120)
						$imgData['imagens']['url'] = "{$s->dom}{$s->dir}upload/produtos/".$rfoto->i;
						$x->blingIMG = $apiBling->postProduct($imgData);
					}
					//BLING
				}
			}
			if($hover){
				$sfoto = $b->query("select id from fotos where id=$hover and idp=$id and tipo='produto' and hover limit 1");
				if(!$sfoto->rowCount()){				
					$b->exec("update fotos set hover=1,da=now() where id=$hover and idp=$id and tipo='produto' limit 1");
					$b->exec("update fotos set hover=0,da=now() where id!=$hover and idp=$id and tipo='produto'");
					$x->ok = 1;
				}
			}
		}
		if($x->ok){
			$s->googleShopping('produtos',0);
			if($x->up)$b->exec("update produto set da=now() where id=$id limit 1");
			if(!$x->m)$x->m = 'Produto '.($x->up?'alterado':'cadastrado').' com sucesso!';
			$x->ok = 1;
			if(!$x->up)$x->l = 'admin/produto';
		}elseif($x->noup)$x->m = 'Nenhum campo para alterar!';
	}
	if($i&&$N&&++$x->noi->i)$s->delfile($i->id);
}else{
	if(!$s->adm())$neg = true;
	else $x->m = 'Você não pode adicionar produtos no site!';
}
?>