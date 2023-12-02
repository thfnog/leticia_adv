<?
if($s->adm()){
	$id = strp('id',3);
	$sx = strps('x');
	$sy = strps('y');
	$sw = strps('w');
	$sh = strps('h');
	$dw = strps('largura');
	$dh = strps('altura');
	$tabela = strps('tabela');
	$pasta = strps('pasta');
	$subpasta = strps('subpasta');
	$img = strps('img');
	$thumb = strps('thumb');
	//$x->infos = $dw.' / '.$dh.' / '.$tabela.' / '.$pasta.' / '.$subpasta.' / '.$img.' / '.$thumb;
	$q = 0;

	$It = 0;
	$Dt = 0;
	$P = 'upload/'.$pasta.'/';
	$Pt = $P.$subpasta.'/';
	$tip = array('','gif','jpeg','png');

	$tipo = 51;//tipo de filtro

	$rs = $b->query("select $img as i,$thumb as it from $tabela where id=$id limit 1")->fetchObject();
	if($la=$P.$rs->i){
		$f = basename($la);
		$ex = '';
		if(preg_match('/^(.*)\.([^.]+)$/',$f,$_m)){
			$f = $_m[1];
			$ex = str($_m[2],0,1);
		}
		$f = $f.'-'.date('his').($ex?'.'.$ex:'');
		$lb = $Pt.$f;
	}

	$x->up = $id?1:0;

	if($id&&!$rs)$x->m = 'Esta foto não existe!';
	//elseif(!$sx||!$sy||!$sw||!$sh)$x->m = 'Por favor selecione a região a ser recortada!';
	elseif(!$rs->i||!file_exists($la)||!is_file($la))$x->m = 'Não tem a imagem para recortar!';
	elseif(!($sz=getimagesize($la)))$x->m = 'Erro ao pegar os dados da imagem!';
	elseif(!(list($w,$h,$t)=$sz)||!($tp=$tip[$t]))$x->m = 'Tipo de imagem inválida!';
	elseif(!($ia=@call_user_func('imagecreatefrom'.$tp,$la)))$x->m = 'Erro ao manipular a imagem!';
	else{
		$ib = imagecreatetruecolor($dw,$dh);

		if($t===1||$t===3){
			imagealphablending($ib,false);
			imagesavealpha($ib,true);
			imagefill($ib,0,0,imagecolorallocatealpha($ib,255,255,255,127));
		}

		imagecopyresampled($ib,$ia,0,0,$sx,$sy,$dw,$dh,$sw,$sh);
		imagedestroy($ia);

		if(!$q&&$t===2)$q = 90;
		if($t===1)$q = 0;
		if($q)$r = @call_user_func('image'.$tp,$ib,$lb,$q);
		else $r = @call_user_func('image'.$tp,$ib,$lb);
		imagedestroy($ib);

		if($r){
			$It = "'$f'";
			$Dt = $rs->it;
			if($b->exec("update $tabela set $thumb=$It where id=$id limit 1")){
				if($x->up)$b->exec("update $tabela set da=now() where id=$id limit 1");
				if($Dt)@unlink($Pt.$Dt);
				$x->ok = 1;
				$x->m = 'Foto recortada com sucesso!';
			}else{
				$x->m = 'Erro ao salvar imagem!';
				@unlink($lb);
			}
		}else $x->m = 'Erro ao gerar a imagem!';
	}
}else $neg = true;
?>