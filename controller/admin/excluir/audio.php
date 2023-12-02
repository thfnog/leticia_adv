<?php
if($s->tipoAdm==3)$s->loc('admin');
//if($s->tipoAdm==2)$s->loc('admin');
if(!$s->id)$s->loc('admin/produtos');
if($s->id&&!($rp=$b->query("select * from produto where id={$s->id} limit 1")->fetchObject()))$s->loc('admin/produtos');

$s->titpg = 'Áudios';
$s->titpg2 = 'Áudios';
$s->titpg3 = 'Alterar Áudios do Produto: '.$rp->h1;

//$rs = $b->query("select * from produto_audio where idp={$s->id} limit 1")->fetchObject();
$a->id = $s->id;
//$P = 'upload/produtos/audios/';
//$a->i->f = $rs->f?$P.$rs->f:'';

$a->back = $s->back;