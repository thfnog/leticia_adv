<?php
if($s->tipoAdm==3)$s->loc('admin');
//if($s->tipoAdm==2)$s->loc('admin');
if($s->id&&!($rs=$b->query("select * from portfolio_section where id={$s->id} limit 1")->fetchObject()))$s->loc('admin/portfolios');

$a->back = 'admin/portfolios';