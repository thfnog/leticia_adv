<?php
if($s->tipoAdm==3)$s->loc('admin');
//if($s->tipoAdm==2)$s->loc('admin');
$s->id = 1;
$s->back = "{$s->pg}/{$s->spg}";
if($s->cat&&!isset($s->admin->pages[$s->cat]))$s->loc($s->back);
$rs = $s->metatag($s->cat);

if($s->cat){
	$a->id = $s->id;
	$a->back = $s->back;
	$s->ijs = array("
	var adm = $.form({
		a:'pages',
	});
	","
	$.extend(adm,".json_encode($a).");
	","
	$(document).ready(function () {
	   $('input').keypress(function (e) {
			var code = null;
			code = (e.keyCode ? e.keyCode : e.which);                
			return (code == 13) ? false : true;
	   });
	});
	");
}else{
	$meta = array();
	$st = $b->query("select * from metatag");
	while($rs=$st->fetchObject())$meta[$rs->pg] = $rs->t;
	$i = 0;
	$_rs = array();
	foreach($s->admin->pages as $k=>$v)$_rs[] = array('id'=>$k,'i'=>++$i,'n'=>$v,'t'=>$meta[$k]);

	$s->ijs = array("
	var adm = $.tab({
		c:{add:'admin/pages/'},
		e:'#table-0',
		v:'',
		o:'i',
		oi:['id','i','t'],
		th:[
			{n:'#',w:50,o:'i'},
			{n:'Página',w:150,o:'id',l:1,tt:'n',a:'admin/pages/',c:'id',tb:0},
			{n:'Título',w:400,o:'t',l:1},
			{t:1,n:'Opções',w:70,bt:['a']}
		]
	});
	",
	"
	adm.rs = ".json_encode($_rs).";
	");
}
?>