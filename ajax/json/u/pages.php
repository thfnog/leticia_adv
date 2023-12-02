<?
if($s->adm()){
	$pg = tag(strpr('pg',1));
	$d = strpr('d');
	$h1 = strpr('h1');
	$t = strpr('t');

	if(!isset($s->admin->pages[$pg]))$x->m = 'Esta página não existe!';
	elseif(!($rs=$s->metatag($pg,$d,$h1,$t)))$x->m = 'Erro ao alterar a Meta Tag!';
	else{
		$x->up = $rs->up;
		if($rs->exec){
			$x->ok = 1;
			$x->m = 'Meta Tag '.($x->up?'alterada':'cadastrada').' com sucesso!';
		}else $x->m = $x->up&&++$x->noup?'Nenhum campo para alterar!':'Erro ao cadastrar a Meta Tag!';
	}
}else $neg = true;
?>