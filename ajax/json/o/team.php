<?
if($s->adm()){
	$x->tot = 0;
	$x->ok = 0;
	$x->err = 0;
	$x->no = 0;
	$x->o = array();
	$d = strp('d');//ordem
	$x->idc = $idc = strp('idc',3);//categoria
	foreach($d as $k=>$v){
		$x->tot++;
		if(!preg_match('/^o(\d+)$/',$k,$_m))continue;
		$id = $_m[1]+0;
		$o = str($v,3);
		if($rs=$b->query("select o from team where id=$id limit 1")->fetchObject()){
			($rs->o==$o||$b->exec("update team set o=$o where id=$id limit 1"))&&++$x->ok?$x->o[$id]=$o:$x->err++;
		}else $x->no++;
	}
	$x->enc = $x->ok+$x->err;
	$x->qt = $x->enc+$x->no;
	if($x->enc){
		$x->ok = 1;
		$x->m = 'Ordenação alterada com sucesso!';
	}else $x->m = 'Nenhum dado foi passado!';
}else $neg = true;
?>