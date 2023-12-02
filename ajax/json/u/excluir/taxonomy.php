<?
if($s->adm()){
	$id = strp('id',3);
	$idc = strp('idc',3);
	$S = strp('s',3)?1:0;
	$h1 = strps('h1');
	$n = strps('n');
	$t = tag($n,1);
	$d = strps('d');

	$N = 0;
	$P = 'upload/categorias/';
	$Pt = $P.'thumb/';

	$R = strp('ri',3)?1:0;
	$i = $s->getfile(strp('i',3));
	$I = 'i';
	$It = 'it';

	$Rh = strp('rih',3)?1:0;
	$ih = $s->getfile(strp('ih',3));
	$Ih = 'ih';
	$Ith = 'ith';

//SEO
	$tagd = strps('tagd');
	$tagk = strps('tagk');
	$tagt = strps('tagt')?strps('tagt'):$n;
//SEO

	$rs = $b->query("select id,i,it from cat where id=$id")->fetchObject();

	if($id&&!$b->query("select id from cat where id=$id limit 1")->fetchObject())$x->m = 'Esta Categoria não existe!';
	elseif(!$h1)$x->m = 'Digite o h1 da página!';
	elseif(!$n)$x->m = 'Digite o nome da categoria!';
	elseif($idc==$id)$x->m = 'A categoria pai não pode ser a mesma categoria!';
	//elseif(!$d)$x->m = 'Digite a descrição da categoria!';
	elseif($b->query("select id from cat where id!=$id and t='$t' limit 1")->fetchObject())$x->m = 'Esta Categoria já está cadastrada!';
	elseif($i&&$i->e&&++$N)$x->m = 'Ocorreu um erro ao fazer upload da imagem!';
	elseif($i&&$i->w<1920&&++$N)$x->m = 'A largura mínima da imagem deve ser 1920px!';
	elseif($i&&$i->h<300&&++$N)$x->m = 'A altura mínima da imagem deve ser 300px!';
	elseif($ih&&$ih->e&&++$N)$x->m = 'Ocorreu um erro ao fazer upload da imagem home!';
	elseif($ih&&$ih->w<120&&++$N)$x->m = 'A largura mínima da imagem da home deve ser 120px!';
	elseif($ih&&$ih->h<180&&++$N)$x->m = 'A altura mínima da imagem da home deve ser 180px!';
	else{
		$x->up = $id?1:0;
		if($R){
			$x->i->i = '';
			$I = 'null';
			$It = 'null';
			$D = $rs->i;
			$Dt = $rs->it;
		}elseif($i){
			$C .= tag($t,1).'-'.date("his").'.'.$i->ex;
			if($i&&$i=$s->movefile($i->id,$P.$C)){
				$x->i->i = $P.$C;
				$I = "'$C'";
				$It = 'null';
				$D = $rs->i;
				$Dt = $rs->it;
				if($i->w==1920&&$i->h==300)$It = Img::resizeMax($i->nf,$Pt.$C,1920,300,$i->ex=='png'||$i->ex=='gif'?0:90)?"'$C'":'null';
				elseif($i->w>1920&&$i->h>300){
					//largura/ altura * nova altura = nova largura
					$novaLargura = round($i->w/$i->h*300);
					//altura / largura * nova largura = nova altura
					$novaAltura = round($i->h/$i->w*1920);
					if($novaLargura==1920&&$novaAltura==300)$It = Img::resizeMax($i->nf,$Pt.$C,1920,300,$i->ex=='png'||$i->ex=='gif'?0:90)?"'$C'":'null';
				}
			}
		}
		if($Rh){
			$x->i->ih = '';
			$Ih = 'null';
			$Ith = 'null';
			$Dh = $rs->ih;
			$Dth = $rs->ith;
		}elseif($ih){
			$Ch .= tag($t,1).'-home-'.date("his").'.'.$ih->ex;
			if($ih&&$ih=$s->movefile($ih->id,$P.$Ch)){
				$x->i->i = $P.$Ch;
				$Ih = "'$Ch'";
				$Ith = 'null';
				$Dh = $rs->ih;
				$Dth = $rs->ith;
				if($ih->w==120&&$ih->h==180)$Ith = Img::resizeMax($ih->nf,$Pt.$Ch,120,180,$ih->ex=='png'||$ih->ex=='gif'?0:90)?"'$Ch'":'null';
				elseif($ih->w>120&&$ih->h>180){
					//largura/ altura * nova altura = nova largura
					$novaLargura = round($ih->w/$ih->h*180);
					//altura / largura * nova largura = nova altura
					$novaAltura = round($ih->h/$ih->w*120);
					if($novaLargura==120&&$novaAltura==180)$Ith = Img::resizeMax($ih->nf,$Pt.$Ch,120,180,$ih->ex=='png'||$ih->ex=='gif'?0:90)?"'$Ch'":'null';
				}
			}
		}
		if(!$id&&$b->exec("insert into cat (dc)values(now())"))$id = $b->lastInsertId();
		if($b->exec("update cat set s=$S,idp=$idc,h1='$h1',n='$n',t='$t',d='$d',i=$I,it=$It,ih=$Ih,ith=$Ith,tagd='$tagd',tagk='$tagk',tagt='$tagt' where id=$id limit 1")){
			if($x->up)$b->exec("update cat set da=now() where id=$id limit 1");
			$x->ok = 1;
			$x->m = 'Categoria '.($x->up?'alterada':'cadastrada').' com sucesso!';
			if(!$x->up)$x->l = 'admin/categoria';
			if($D){
				@unlink($P.$D);
				@unlink($Pt.$Dt);
			}
			if($Dh){
				@unlink($P.$Dh);
				@unlink($Pt.$Dth);
			}
		}else $x->m = $x->up&&++$x->noup?'Nenhum campo para alterar!':'Erro ao cadastar a categoria!';
	}
	if($i&&$N&&++$x->noi->i)$s->delfile($i->id);
}else $neg = true;
?>