<?php
if($s->tipoAdm==3)$s->loc('admin');

$id_portfolio = $s->id;
$s->back = 'admin/portfolios';
if(!$s->id||($s->id&&!($rs=$b->query("select * from portfolio where id=$id_portfolio limit 1")->fetchObject())))$s->loc($s->back);

$s->titpg3 = 'Portfolio '.$rs->h1;

$a->id = $s->id;
if($s->id)$url_seo = $s->base.'/'.$rs->t;

$a->back = $s->back;