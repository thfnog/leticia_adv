<?
$i = $s->addfile($_FILES['Filedata']);
$N = 0;
$I = 'i';
$It = 'it';
$P = 'upload/produtos/fotos/';
$Pt = $P.'thumb/';
$ok = 0;

if($s->adm()){
	$id = strp('id',3);
	$rs = $b->query("select max(a.o) o,count(a.id) q from prod p left join prod_ax a on p.id=a.idp where p.id=$id group by p.id limit 1")->fetchObject();

	if(!$id&&++$N)$x->m = 'Selecione um produto para editar!';
	elseif(!$rs&&++$N)$x = 'Este produto não existe!';
	elseif(!$i)$x = 'Escolha uma imagem!';
	elseif($i&&$i->e&&++$N)$x = 'Ocorreu um erro ao fazer upload da imagem "'.$i->n.'"!';
	elseif($i&&$i->w<550&&++$N)$x = 'A largura mínima da imagem "'.$i->n.'" deve ser 550px!';
	//elseif($i&&$i->w>1280&&++$N)$x = 'A largura máxima da imagem "'.$i->n.'" deve ser 1280px!';
	//elseif($i&&$i->w>900&&(!Img::resize($i->tf,0,900)||!$s->upinfofile($i->id))&&++$N)$m = 'Erro ao tentar diminuir a largura da imagem "'.$i->n.'" de '.$i->w.'px para 900px!';
	elseif($i&&$i->h<560&&++$N)$x = 'A altura mínima da imagem "'.$i->n.'" deve ser 560px!';
	else{
		$v = 0;
		$o = $rs->q?$rs->o+1:0;
		if($b->exec("insert into prod_ax set idp=$id,o=$o,dc=now()"))$v = $b->lastInsertId();
		if($i){
			$C = str_pad($id,10,'0',STR_PAD_LEFT).'_'.str_pad($v,10,'0',STR_PAD_LEFT).'_'.str_pad($i->id,10,'0',STR_PAD_LEFT).'.'.$i->ex;
			if($i=$s->movefile($i->id,$P.$C)){
				$I = "'$C'";
				//$It = Img::resizeMax($i->nf,$Pt.$C,216)?"'$C'":'null';
			}
		}
		if($b->exec("update prod_ax set i=$I,it=$It where id=$v limit 1")){
			$ra = $b->query("select dc,s,o from prod_ax where id=$v limit 1")->fetchObject();
			$x = $v.'|'.($ra->dc?'Cadastrado em '.datef($ra->dc,9):'').'|'.$ra->s.'|'.$ra->o.'|'.$C;
			$ok = 1;
		}else $x = 'Erro ao cadastar a Foto "'.$i->n.'" no projeto!';
	}
}elseif(++$N)$neg = true;

if($i&&$N)$s->delfile($i->id);

$x = $ok.'|'.$x;
?>