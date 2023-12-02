<?
if(!$neg){
	if($_P=is_string($x->path)){
		$file = $x->path.(($_F=is_string($x->file))?$x->file:'');
		if(file_exists($file)&&is_file($file)){
			if(!$x->file&&$x->file!==0)$x->file = basename($x->path);
			if(!is_numeric($x->size))$x->size = filesize($file);
		}elseif(!$x->m)$x->m = 'Arquivo inexistente!';
	}elseif(is_string($x->cnt)){
		if(!is_numeric($x->size))$x->size = mb_strlen($x->cnt);
	}elseif(!$x->m)$x->m = 'Erro ao fazer o download do arquivo!';
	if(!is_string($x->name)&&is_string($x->file))$x->name = $x->file;
	if(!$x->m){
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		if(is_string($x->name)&&$x->name)header('Content-Disposition: attachment; filename='.$x->name);
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		if(is_numeric($x->size))header('Content-Length: '.$x->size);
		if($_P){
			readfile($file);
			if($x->delete)@unlink($file);
		}
		else echo $x->cnt;
		exit;
	}
}
header('Content-type: text; charset=utf-8');
if($neg)echo "Acesso negado!\r\n";
if($x->m)echo $x->m;
exit;
?>