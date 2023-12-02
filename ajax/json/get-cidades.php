<?
$uf = strg('uf',3);
if($uf){
	$st = $b->query("select id,nome from cidade where estado=$uf");
	if($st->rowCount()){
		$x->cidades = array();
		while($rs=$st->fetchObject()){
			$x->cidades[$rs->id] = $rs->nome;
		}
		$x->ok = 1;
	}
	//if($rs)$x->preco = nreal($rs->v);
}