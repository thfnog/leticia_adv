<?
if($s->adm()){
	$id = strp('id',3);
	$tipo = strps('tipo');
	$tipo = 'imagem';
	$S = strp('s',3)?1:0;
	$n = strps('n');
	$t = tag($n,1);
	$n2 = strps('n2');
	$l = strps('l');
	$cor_n = strps('cor_n');
	$cor_n2 = strps('cor_n2');
	$cor_l = strps('cor_l');
	$background_l = strps('background_l');
	$i = $s->getfile(strp('i',3));
	$ie = $s->getfile(strp('ie',3));//ELEMENT
	$N = 0;
	$P = 'upload/sliders/';
	$Pt = $P.'thumb/';
	$Pe = $P.'element/';
	$I = 'i';
	$It = 'it';
	$Im = 'im';
	$Ie = 'ie';
	$Iet = 'iet';
	$Iem = 'iem';
	$D = '';
	$Dt = '';
	$Dm = '';
	$De = '';
	$Det = '';
	$Dem = '';
	//$R = strp('ri',3)?1:0;
	$Re = strp('rie',3)?1:0;
	$y = strps('y');


	if(!($rs=$b->query("select i,it,im,ie,iet,iem from slider where id=$id limit 1")->fetchObject())&&$id&&++$N)$x->m = 'Este Slider não existe!';
	elseif(!$tipo)$x->m = 'Selecione o tipo!';
	elseif($tipo!='imagem'&&$tipo!='video')$x->m = 'Tipo inválido!';
	//elseif(!$n)$x->m = 'Digite o título!';
	elseif($tipo=='imagem'&&!$id&&!$i)$x->m = 'Escolha a imagem!';
	elseif($tipo=='imagem'&&$i&&$i->e&&++$N)$x->m = 'Ocorreu um erro ao fazer upload da imagem!';
	elseif($tipo=='imagem'&&$i&&$i->w!=1920&&++$N)$x->m = 'A largura da imagem deve ser 1920px!';
	elseif($tipo=='imagem'&&$i&&$i->h!=1080&&++$N)$x->m = 'A altura da imagem deve ser 1080px!';
	elseif($tipo=='imagem'&&$ei&&$ie->e&&++$N)$x->m = 'Ocorreu um erro ao fazer upload da imagem do elemento!';
	elseif($tipo=='imagem'&&$ie&&$ie->ex!='png'&&++$N)$x->m = 'A imagem do elemento precisa ser .png!';
	elseif($tipo=='imagem'&&$ie&&$ie->w!=1920&&++$N)$x->m = 'A largura da imagem do elemento deve ser 1920px!';
	elseif($tipo=='imagem'&&$ie&&$ie->h!=1080&&++$N)$x->m = 'A altura da imagem do elemento deve ser 1080px!';
	elseif($tipo=='video'&&!$y)$x->m = 'Digite o vídeo!';
	else{
		$x->up = $id?1:0;
		$C = $t.'-'.date("his").'.'.$i->ex;
		if($i&&$i=$s->movefile($i->id,$P.$C)){
			$x->i->i = $P.$C;
			$I = "'$C'";
			$Ct = $t.'-tablet-'.date("his").'.'.$i->ex;
			$Cm = $t.'-mobile-'.date("his").'.'.$i->ex;
			$It = Img::resize($i->nf,$Pt.$Ct,1024,0,$i->ex=='png'||$i->ex=='gif'?0:90)?"'$Ct'":'null';
			$Im = Img::resize($i->nf,$Pt.$Cm,600,0,$i->ex=='png'||$i->ex=='gif'?0:90)?"'$Cm'":'null';
			$D = $rs->i;
			$Dt = $rs->it;
			$Dm = $rs->im;
		}
		$Ce = $t.'-element-'.date("his").'.'.$ie->ex;
		if($Re){
			$x->i->ie = '';
			$Ie = 'null';
			$Iet = 'null';
			$Iem = 'null';
			$De = $rs->ie;
			$Det = $rs->iet;
			$Dem = $rs->iem;
		}elseif($ie&&$ie=$s->movefile($ie->id,$Pe.$Ce)){
			$x->i->ie = $Pe.$Ce;
			$Ie = "'$Ce'";
			$Ct = $t.'-tablet-'.date("his").'.'.$ie->ex;
			$Cm = $t.'-mobile-'.date("his").'.'.$ie->ex;
			$Iet = Img::resize($ie->nf,$Pe.$Ct,1024,0,$i->ex=='png'||$i->ex=='gif'?0:90)?"'$Ct'":'null';
			$Iem = Img::resize($ie->nf,$Pe.$Cm,600,0,$ie->ex=='png'||$ie->ex=='gif'?0:90)?"'$Cm'":'null';
			$De = $rs->ie;
			$Det = $rs->iet;
			$Dem = $rs->iem;
		}
		if(!$id&&$b->exec("insert into slider (dc)values(now())"))$id = $b->lastInsertId();
		if($b->exec("update slider set s=$S,tipo='$tipo',n='$n',n2='$n2',t='$t',l='$l',cor_n='$cor_n',cor_n2='$cor_n2',background_l='$background_l',cor_l='$cor_l',i=$I,it=$It,im=$Im,ie=$Ie,iet=$Iet,iem=$Iem,y='$y' where id=$id limit 1")){
			if($x->up)$b->exec("update slider set da=now() where id=$id limit 1");
			if($D)@unlink($P.$D);
			if($Dt)@unlink($Pt.$Dt);
			if($Dm)@unlink($Pt.$Dm);
			if($De)@unlink($Pe.$De);
			if($Det)@unlink($Pe.$Det);
			if($Dem)@unlink($Pe.$Dem);
			$x->ok = 1;
			$x->m = 'Slider '.($x->up?'alterado':'cadastrado').' com sucesso!';
			if(!$x->up)$x->l = 'admin/slider';
		}else $x->m = $x->up?'Nenhum campo para alterar!':'Erro ao cadastar o Slider!';
	}
	if($i&&$N&&++$x->noi->i)$s->delfile($i->id);
}else $neg = true;
?>