<?php
if($s->tipoAdm==3||$s->tipoAdm==2)$s->loc('admin');
if($s->id&&!($rs=$b->query("select * from cat where id={$s->id} limit 1")->fetchObject()))$s->loc($s->back);

$s->titpg = 'Categorias';
$s->titpg2 = 'Categorias';
$s->titpg3 = $rs->n?$rs->n:'Nova Categoria';

$a->id = $s->id;
$a->idc = $rs->idp;
$P = 'upload/categorias/';
$Pt = $P.'thumb/';
$a->i->i = $rs->i?$P.$rs->i:'';
$a->i->it = $rs->it?$Pt.$rs->it:'';
$a->i->ih = $rs->ih?$P.$rs->ih:'';
$a->i->ith = $rs->ith?$Pt.$rs->ith:'';

$a->cat = array(array('-- Selecione a Categoria --',0));
$sc = $b->query("select id,idp,n from cat order by idp,t");
while($row=$sc->fetchObject()){
	$ref = & $refs[$row->id];
	$ref['idp'] = $row->idp;

	if($row->idp==0){
		$ref['n'] = $row->n;
		$a->cat[$row->id] = & $ref;
		$ref['level'] = 0;
	}else{
		$ref['n'] = '=>'.$row->n;
		$refs[$row->idp]['children'][$row->id] = & $ref;
		$ref['level'] = $refs[$row->idp]['level'] + 1;
	}
}

$a->back = $s->back;