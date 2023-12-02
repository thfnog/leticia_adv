<?
if($s->adm(1)){
	$id = strp('id',3);
	$a = strp('s',3)?1:0;
	$t = strp('t',3);
	$t = 1;
	$n = strps('n');
	$tag = tag($n,1);
	$email = strps('email');
	$u = strps('u',1);
	$p1 = strps('p1',1);
	$p2 = strps('p2',1);

	/*$P = 'upload/users/';
	$Pt = $P.'thumb/';
	$R = strp('ri',3)?1:0;
	$N = 0;
	$i = $s->getfile(strp('i',3));
	$I = 'i';
	$D = '';*/

	$rs = $b->query("select * from user where id=$id limit 1")->fetchObject();

	if($id&&!$rs)$x->m = 'Este usuário não existe!';
	elseif(!$t)$x->m = 'Selecione o tipo de usuário!';
	elseif($t>3)$x->m = 'Tipo de usuário inválido!';
	elseif(!$n)$x->m = 'Digite o nome do usuário!';
	elseif(!$email)$x->m = 'Digite o e-mail do usuário!';
	elseif($b->query("select id from user where id!=$id and email='$email' limit 1")->fetchObject())$x->m = 'Este e-mail já está cadastrado!';
	elseif(!$u)$x->m = 'Digite o login do usuário!';
	elseif($b->query("select id from user where id!=$id and u='$u' limit 1")->fetchObject())$x->m = 'Este Usuário já está cadastrado!';
	elseif(!$id&&!$p1)$x->m = 'Digite a senha!';
	elseif((!$id||$p1)&&!$p2)$x->m = 'Digite a confirmação da senha!';
	elseif($p1!=$p2)$x->m = 'Confirmação da senha diferente!';
	elseif($i&&$i->e&&++$N)$x->m = 'Ocorreu um erro ao fazer upload da imagem do banner!';
	elseif($i&&$i->w<150&&++$N)$x->m = 'A largura mínima da imagem deve ser 150px!';
	elseif($i&&$i->h<150&&++$N)$x->m = 'A altura mínima da imagem deve ser 150px!';
	else{
		$x->up = $id?1:0;
		//$p = $p1?"'$p1'":'p';
		$p = $p1?sha1($p1):$rs->p;
		if(!$id&&$b->exec("insert into user (dc)values(now())"))$id = $b->lastInsertId();
		if($R){
			$x->i->i = '';
			$I = 'null';
			$D = $rs->i;
		}elseif($i){
			$C = $id.'-'.$tag.'.'.$i->ex;
			if($i=$s->movefile($i->id,$P.$C)){
				$x->i->i = $P.$C;
				$I = "'$C'";
				$D = $rs->i;
				if($i->w>800&&++$N)$I = Img::resize($i->nf,$P.$C,800,0)?"'$C'":'null';
			}
		}
		if($b->exec("update user set s=$a,t=$t,n='$n',tag='$tag',email='$email',u='$u',p='$p' where id=$id limit 1")){
			if($x->up)$b->exec("update user set da=now() where id=$id limit 1");
			$x->ok = 1;
			$x->m = 'Usuário '.($x->up?'alterado':'cadastrado').' com sucesso!';
		}else $x->m = $x->up&&++$x->noup?'Nenhum campo para alterar!':'Erro ao cadastar o usuário!';
	}
}else $neg = true;
?>