<?php
if($s->adm()){
	$id = 1;
	$idc = strp('idc',3);
	$idc2 = strp('idc2',3);
	$idc3 = strp('idc3',3);

	$P = 'upload/categorias/';
	$R = strp('ri',3)?1:0;
	$N = 0;
	$i = $s->getfile(strp('i',3));
	$i2 = $s->getfile(strp('i2',3));
	$i3 = $s->getfile(strp('i3',3));
	$I = 'i';
	$I2 = 'i2';
	$I3 = 'i3';
	$D = '';
	$D2 = '';
	$D3 = '';

	$rs = $b->query("select id from categoria_home where id=$id limit 1")->fetchObject();

	if($id&&!$rs&&++$N)$x->m = 'Esta página não existe!';
	elseif(!$idc)$x->m = 'Selecione a categoria!';
	elseif($i&&$i->e&&++$N)$x->m = 'Ocorreu um erro ao fazer upload da imagem 1!';
	elseif($i&&$i->w!=639&&++$N)$x->m = 'A largura da imagem 1 deve ser 639px!';
	elseif($i&&$i->h!=360&&++$N)$x->m = 'A altura da imagem 1 deve ser 360px!';
	elseif(!$idc2)$x->m = 'Selecione a categoria 2!';
	elseif($i2&&$i2->e&&++$N)$x->m = 'Ocorreu um erro ao fazer upload da imagem 2!';
	elseif($i2&&$i2->w!=639&&++$N)$x->m = 'A largura da imagem 2 deve ser 639px!';
	elseif($i2&&$i2->h!=360&&++$N)$x->m = 'A altura da imagem 2 deve ser 360px!';
	elseif(!$idc3)$x->m = 'Selecione a categoria 3!';
	elseif($i3&&$i3->e&&++$N)$x->m = 'Ocorreu um erro ao fazer upload da imagem 3!';
	elseif($i3&&$i3->w!=639&&++$N)$x->m = 'A largura da imagem 3 deve ser 639px!';
	elseif($i3&&$i3->h!=360&&++$N)$x->m = 'A altura da imagem 3 deve ser 360px!';
	else{
		$x->up = $id?1:0;
		if($i){
			$rc = $b->query("select t from cat where id=$idc")->fetchObject();
			$t = tag($rc->t,1);
			$C = $t.'-'.date("his").'.'.$i->ex;
			if($i=$s->movefile($i->id,$P.$C)){
				$x->i->i = $P.$C;
				$I = "'$C'";
				$D = $rs->i;
			}
		}
		if($i2){
			$rc = $b->query("select t from cat where id=$idc2")->fetchObject();
			$t = tag($rc->t,1);
			$C = $t.'-'.date("his").'.'.$i2->ex;
			if($i2=$s->movefile($i2->id,$P.$C)){
				$x->i->i2 = $P.$C;
				$I2 = "'$C'";
				$D2 = $rs->i2;
			}
		}
		if($i3){
			$rc = $b->query("select t from cat where id=$idc3")->fetchObject();
			$t = tag($rc->t,1);
			$C = $t.'-'.date("his").'.'.$i3->ex;
			if($i3=$s->movefile($i3->id,$P.$C)){
				$x->i->i3 = $P.$C;
				$I3 = "'$C'";
				$D3 = $rs->i3;
			}
		}
		if($b->exec($x->upd="update categoria_home set idc=$idc,idc2=$idc2,idc3=$idc3,i=$I,i2=$I2,i3=$I3 where id=$id limit 1")){
			$x->ok = 1;
			$x->m = 'Alterado com sucesso!';
		}else $x->m = 'Erro ao cadastar o blog!';
	}
}else $neg = true;