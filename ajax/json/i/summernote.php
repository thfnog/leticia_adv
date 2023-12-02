<?
if($s->adm()){
	$P = 'upload/summernote/';
	$i = $s->addfile($_FILES['file']);
	if(!$i)$x->m = 'Selecione a imagem!';
	elseif($i){
		$C = $i->id.'-'.date("his").'.'.$i->ex;
		if($i=$s->movefile($i->id,$P.$C)){
			if($i->w>1200)$I = Img::resize($i->nf,$P.$C,1200,0,$i->ex=='png'||$i->ex=='gif'?0:90)?"'$C'":'null';
			$x->url = "{$s->base}".$P.$C;
		}
	}
}else $neg = true;
?>