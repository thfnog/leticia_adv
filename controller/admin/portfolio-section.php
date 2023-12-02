<?php
if($s->tipoAdm==3)$s->loc('admin');

$s->back = 'admin/portfolios';
if($s->cat){
	$id_portfolio = (int)$s->cat;
	$rp = $b->query("select * from portfolio where id=$id_portfolio limit 1")->fetchObject();
	if(!($rs=$b->query("select * from portfolio_section where id={$s->id} limit 1")->fetchObject()))$s->loc($s->back);
}else{
	$id_portfolio = $s->id;
	$s->id = 0;
	if(!($rp=$b->query("select * from portfolio where id=$id_portfolio limit 1")->fetchObject()))$s->loc($s->back);
}

$s->titpg3 = 'Portfolio '.$rp->h1;

$a->id = $s->id;
if($s->id)$url_seo = $s->base.'/'.$rp->t;

$a->back = $s->back;