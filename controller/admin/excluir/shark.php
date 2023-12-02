<?php
if(!$s->id)$s->loc($s->back);
if($s->id&&!($rs=$b->query("select * from formulario_team where id={$s->id} limit 1")->fetchObject()))$s->loc($s->back);

$s->titpg = 'Cadastros Shark Team';
$s->titpg2 = 'Cadastros Shark Team';
$s->titpg3 = $rs->nome;

$sexos = array('','Feminino','Masculino');
$segmentos = array('','Atleta IFBB','Crossfit','Modelo','Life Style','Artes Marciais','Futebol','Ciclismo','Outros');
$cidade = $b->query("select c.nome,u.uf from cidade c inner join estado u on c.estado=u.id where c.id='{$rs->city}'")->fetchObject();

$a->id = $s->id;
$a->back = $s->back;