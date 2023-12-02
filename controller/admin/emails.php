<?php
if($s->tipoAdm==3)$s->loc('admin');
//if($s->tipoAdm==2)$s->loc('admin');
$s->titpg = 'E-mails';
$s->titpg2 = 'E-mails';

$a->gru = array(array('-- Todos os Grupos --',0));
$sc = $b->query('select * from grupo order by t');
while($rc=$sc->fetchObject())$a->gru[] = array($rc->n,$rc->id+0);