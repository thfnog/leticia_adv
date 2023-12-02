<?
if($s->adm()){
	$id = strp('id',3);
	$S = strp('s',3)?1:0;
	$n = strps('n');
	$t = tag($n,1);
	$l = strps('l');
	$i = $s->getfile(strp('i',3));
	$N = 0;
	$P = 'upload/parceiros/';
	$Pt = $P.'thumb/';
	$I = 'i';
	$It = 'it';
	$D = '';
	$Dt = '';


	if(!($rs=$b->query("select i from parceiro where id=$id limit 1")->fetchObject())&&$id&&++$N)$x->m = 'Este parceiro não existe!';
	elseif(!$n)$x->m = 'Digite o título!';
	elseif(!$id&&!$i)$x->m = 'Escolha a imagem!';
	elseif($i&&$i->e&&++$N)$x->m = 'Ocorreu um erro ao fazer upload da imagem!';
	elseif($i&&$i->w<140&&++$N)$x->m = 'A largura mínima da imagem deve ser 140px!';
	elseif($i&&$i->h<100&&++$N)$x->m = 'A altura mínima da imagem deve ser 100px!';
	else{
		$x->up = $id?1:0;
		if($R){
			$x->i->i = '';
			$I = 'null';
			$It = 'null';
			$D = $rs->i;
			$Dt = $rs->it;
		}elseif($i){
			//$C = str_pad($id,10,'0',STR_PAD_LEFT).'_'.str_pad($i->id,10,'0',STR_PAD_LEFT).'.'.$i->ex;
			$C = $t.'-'.date("his").'.'.$i->ex;
			if($i=$s->movefile($i->id,$P.$C)){
				$x->i->i = $P.$C;
				$I = "'$C'";
				$It = 'null';
				$D = $rs->i;
				$Dt = $rs->it;
				if($i->w==140&&$i->h==100){
					$Ct = $t.'-thumb-'.date("his").'.'.$i->ex;
					$It = Img::resizeMax($i->nf,$Pt.$Ct,140,100,$i->ex=='png'||$i->ex=='gif'?0:90)?"'$Ct'":'null';
				}elseif($i->w>140&&$i->h>100){
					$novaLargura = round($i->w/$i->h*100);//nova largura = largura / altura * nova altura
					$novaAltura = round($i->h/$i->w*140);//nova altura = altura / largura * nova largura
					if($novaLargura==140&&$novaAltura==100){
						$Ct = $t.'-thumb-'.date("his").'.'.$i->ex;
						$It = Img::resizeMax($i->nf,$Pt.$Ct,140,100,$i->ex=='png'||$i->ex=='gif'?0:90)?"'$Ct'":'null';
					}
				}
			}
		}
		if(!$id&&$b->exec("insert into parceiro (dc)values(now())"))$id = $b->lastInsertId();
		if($b->exec("update parceiro set s=$S,n='$n',l='$l',i=$I,it=$It where id=$id limit 1")){
			if($x->up)$b->exec("update parceiro set da=now() where id=$id limit 1");
			if($D){
				@unlink($P.$D);
				@unlink($Pt.$Dt);
			}
			$x->ok = 1;
			$x->m = 'Parceiro '.($x->up?'alterado':'cadastrado').' com sucesso!';
		}else $x->m = $x->up?'Nenhum campo para alterar!':'Erro ao cadastar o Parceiro!';
	}
	if($i&&$N){
		$x->noi->i = 1;
		$s->delfile($i->id);
	}
}else $neg = true;
?>