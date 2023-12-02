<?php
if($s->tipoAdm==3)$s->loc('admin');
//if($s->tipoAdm==2)$s->loc('admin');
//ORDEM DAS TAGS: 1-TABELA; 2-LARGURA; 3-ALTURA; 4-PASTA
//EXEMPLO: http://localhost/opsweb/admin/crop/aplicacao-55-55-aplicacoes-thumb-i-itu/1
$tags = explode('-',$s->cat);
$tabela = $tags[0];
$largura = $tags[1];
$altura = $tags[2];
$pasta = $tags[3];
$subpasta = $tags[4];
$img = $tags[5];
$thumb = $tags[6];
if($s->id&&!($rs=$b->query("select *,$img as i from $tabela where id={$s->id} limit 1")->fetchObject()))$s->loc('admin/'.$pasta);

$s->titpg = 'Recortar Imagem';
$s->titpg2 = 'Recortar Aplicação';
$s->titpg3 = $rs->n;

$a->id = $s->id;
$a->back = '';