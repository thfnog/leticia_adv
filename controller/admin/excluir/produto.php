<?php
if($s->tipoAdm==3)$s->loc('admin');
//if($s->tipoAdm==2)$s->loc('admin');
if($s->id&&!($rs=$b->query("select * from produto where id={$s->id} limit 1")->fetchObject()))$s->loc($s->back);

$s->titpg = 'Produtos';
$s->titpg2 = 'Produtos';
$s->titpg3 = $rs->n?$rs->n:'Novo Produto';

$a->id = $s->id;
$a->idc = $rs->idc;
/*$a->idc2 = $rs->idc2;
$a->idc3 = $rs->idc3;
$a->idm = $rs->idm;*/

$P = 'upload/produtos/';
$Pt = $P.'thumb/';
$Pa = $P.'arquivos/';
 
$a->i->i = $rs->i?$P.$rs->i:'';
$a->i->it = $rs->it?$Pt.$rs->it:'';
$a->i->iti = $rs->iti?$Pt.$rs->iti:'';
$a->i->itm = $rs->itm?$Pt.$rs->itm:'';
$a->i->f = $rs->f?$Pa.$rs->f:'';

$url_seo = $s->base.'produto/'.$s->id.'/'.$rs->t;

$a->cat = array(array('-- Selecione a Categoria --',0));
$sc = $b->query("select id,h1 from cat where s order by t");
while($rc=$sc->fetchObject())$a->cat[] = array($rc->h1,$rc->id+0);

/*$a->mar = array(array('-- Selecione a Marca --',0));
$sc = $b->query("select id,h1 from marca order by t");
while($rc=$sc->fetchObject())$a->mar[] = array($rc->h1,$rc->id+0);*/

$a->back = $s->back;