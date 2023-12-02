<?php
if($s->tipoAdm==3||$s->tipoAdm==2)$s->loc('admin');
$s->ijs = array("
var _xm = '".$x->m."';
var _xl = '".$x->l."';
if(_xm)alert(_xm);
if(_xl)window.location = _xl;
",
"
function ver(f){
}
");

if(isset($_POST['user'])){
	$u = strps('user');
	$senha = strpr('pass');
	$p = sha1($senha);
	$referer = strpr('referer');

	if(!$u)$x->m = 'Digite o usuário!';
	elseif(!$p)$x->m = 'Digite a senha!';
	elseif($rs=$b->query("select * from user where u='$u' limit 1")->fetchObject()){
		if($rs->s!=1)$x->m = 'Usuário desativado pelo Administrador!';
		elseif($rs->p==$p){
			$s->idu = $_SESSION['idu'] = $rs->id+0;
			$s->nomeAdm = $_SESSION['nomeAdm'] = $rs->n;
			$s->userAdm = $_SESSION['userAdm'] = $rs->u;
			$s->tipoAdm = $_SESSION['tipoAdm'] = $rs->t+0;
			$s->timeoutAdm = $_SESSION['timeoutAdm'] = time();
			if($referer&&$referer=explode("_",$referer))$s->loc('admin/'.$referer[0].($referer[1]?'/'.$referer[1]:''));
			else $s->loc($s->pg);
		}else $x->m = 'Senha inválida!';
		
	}else $x->m = 'Usuário inexistente!';
}
?>