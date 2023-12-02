<?php
if($s->tipoAdm==3)$s->loc('admin');
//if($s->tipoAdm==2)$s->loc('admin');
if($s->id&&!($rs=$b->query("select * from produto where id={$s->id} limit 1")->fetchObject()))$s->loc('admin/produtos');

$a->back = 'admin/produtos';