<?
$uf = strg('uf');
if($uf){
	$st = $b->query("select c.id,c.nome from cidade c inner join estado e on c.estado=e.id where e.uf='$uf'");
	if($st->rowCount()){
		$x->cidades = array();
		while($rs=$st->fetchObject()){
			$x->cidades[$rs->id] = $rs->nome;
		}
		$x->ok = 1;
	}
	//if($rs)$x->preco = nreal($rs->v);
}