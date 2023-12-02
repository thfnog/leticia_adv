<?
if($s->adm()){
	$id = strp('id',3);
	$S = strp('s',3)?1:0;
	$n = strps('n');
	$t = tag($n,1);
	$c = strps('c');
	$tipo_cupom = strps('tipo_cupom'); // tipo de cupom: categorias; produtos; todos;
	$idc = strp('idc',3);//CATEGORIA
	$idp = strp('idp',3);//PRODUTO
	$q = strps('q');
	$l = strps('l');
	$tipo_desconto = strps('tipo_desconto'); // tipo de desconto: porcentagem; fixo;
	$dp = strps('dp');
	$dp = !$dp?'0.00':$dp;
	$df = strps('df');
	$df = !$df?'0.00':$df;
	$di = strps('di');
	$dv = strps('dv');
	$v = strps('v');
	$hj = date("Y-m-d");

	if($_di=preg_match($dataRE,$di,$_m))$di = "{$_m[3]}-{$_m[2]}-{$_m[1]}";
	if($_dv=preg_match($dataRE,$dv,$_m))$dv = "{$_m[3]}-{$_m[2]}-{$_m[1]}";

	if($id&&!$b->query("select id from cupom where id=$id limit 1")->fetchObject())$x->m = 'Este cupom não existe!';
	elseif(!$n)$x->m = 'Digite o nome do cupom!';
	elseif($b->query("select id from cupom where id!=$id and t='$t' limit 1")->fetchObject())$x->m = 'Este nome de cupom já está cadastrado!';
	elseif(!$c)$x->m = 'Digite o código do cupom!';
	elseif($b->query("select id from cupom where id!=$id and c='$c' limit 1")->fetchObject())$x->m = 'Este código de cupom já está cadastrado!';
	elseif(!$tipo_cupom)$x->m = 'Selecione o tipo do cupom!';
	elseif($tipo_cupom&&$tipo_cupom!='categoria'&&$tipo_cupom!='produto'&&$tipo_cupom!='produtos')$x->m = 'Tipo de cupom inválido!';
	elseif(!$q)$x->m = 'Digite a quantidade do cupom!';
	elseif(!$l)$x->m = 'Digite o limite de vezes que o cupom pode ser usado por cliente!';
	elseif(!$tipo_desconto)$x->m = 'Selecione o tipo de desconto!';
	elseif($tipo_desconto&&$tipo_desconto!='porcentagem'&&$tipo_desconto!='fixo')$x->m = 'Tipo de desconto inválido!';
	elseif($tipo_desconto&&$tipo_desconto=='porcentagem'&&!$dp)$x->m = 'Digite o valor porcentual de desconto!';
	elseif($tipo_desconto&&$tipo_desconto=='fixo'&&!$df)$x->m = 'Digite o valor fixo de desconto!';
	elseif(!$di)$x->m = 'Digite a data inicial!';
	elseif(!$_di)$x->m = 'Data inicial inválida!';
	elseif(!$id&&$di&&$di<$hj)$x->m = 'A data inicial precisa ser a partir da data de hoje!';
	elseif(!$dv)$x->m = 'Digite a data de validade!';
	elseif(!$_dv)$x->m = 'Data de validade inválida!';
	elseif($dv&&$dv<$di)$x->m = 'A data de validade precisa ser igual ou maior do que a data inicial!';
	elseif(!$v)$x->m = 'Digite o valor mínimo do pedido para poder usar o cupom!';
	else{
		$x->up = $id?1:0;
		if(!$id&&$b->exec("insert into cupom (dc)values(now())"))$id = $b->lastInsertId();
		if($b->exec("update cupom set s=$S,n='$n',t='$t',c='$c',tipo_cupom='$tipo_cupom',q='$q',l='$l',tipo_desconto='$tipo_desconto',dp='$dp',df='$df',di='$di',dv='$dv',v='$v' where id=$id limit 1")){
			if($x->up)$b->exec("update cupom set da=now() where id=$id limit 1");
			$x->ok = 1;
			//$x->m = 'Cupom '.($x->up?'alterado':'cadastrado').' com sucesso!';
		//}else $x->m = $x->up&&++$x->noup?'Nenhum campo para alterar!':'Erro ao cadastar o cupom!';
		}elseif($x->up)$x->noup = 1;
		else $x->m = 'Erro ao cadastar o cupom!';
		if($id){
			if($tipo_cupom=='produto'&&$idp){
				foreach($idp as $k=>&$v){
					$idp = &$v;
					$rs = $b->query("select id from cupom_ax where idp='$idp' and idc=$id limit 1")->fetchObject();
					if(!$rs&&$idp&&$b->exec("insert into cupom_ax (idc,idp,dc)values($id,$idp,now())"))$x->ok = 1;
					$re = $b->query("select id from cupom_ax where idp='$idp' and idc=$id")->fetchObject();
					$nidp[] = $re->id;
				}
				if($nidp){
					$nidp2 = implode(",",$nidp);
					$del = $b->query("delete from cupom_ax where idc=$id and id not in($nidp2)");
					if($del->rowCount())$x->ok = 1;
				}else{
					$del = $b->query("delete from cupom_ax where idc=$id");
					if($del->rowCount())$x->ok = 1;
				}
			}
			if($tipo_cupom=='categoria'&&$idc){
				foreach($idc as $k=>&$v){
					$idc = &$v;
					$rs = $b->query("select id from cupom_ax where ida='$idc' and idc=$id limit 1")->fetchObject();
					if(!$rs&&$idc&&$b->exec("insert into cupom_ax (idc,ida,dc)values($id,$idc,now())"))$x->ok = 1;
					$re = $b->query($teste="select id from cupom_ax where ida='$idc' and idc=$id")->fetchObject();
					$nida[] = $re->id;
				}
				if($nida){
					$nida2 = implode(",",$nida);
					$del = $b->query("delete from cupom_ax where idc=$id and id not in($nida2)");
					if($del->rowCount())$x->ok = 1;
				}else{
					$del = $b->query("delete from cupom_ax where idc=$id");
					if($del->rowCount())$x->ok = 1;
				}
			}
		}
		if($x->ok){
			if($x->up)$b->exec("update cupom set da=now() where id=$id limit 1");
			if(!$x->m){
				$x->m = 'Cupom '.($x->up?'alterado':'cadastrado').' com sucesso!';
				//$x->l = 'admin/cupons';
			}
		}elseif($x->noup)$x->m = 'Nenhum campo para alterar!';
	}
}else $neg = true;
?>