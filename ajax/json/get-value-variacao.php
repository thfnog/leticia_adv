<?
$id = strg('id',3);
$idp = strg('idp',3);
if($id){
	$rs = $b->query("select p.v,e.adicional from produto p inner join produto_estoque e on p.id=e.id_produto and e.id=$id limit 1")->fetchObject();
	if($rs){
		$x->preco = nreal($rs->v+$rs->adicional);
	}else{
		$rp = $b->query("select v from produto where id=$id limit 1")->fetchObject();
		$x->preco = nreal($rp->v);
	}
}else{
	$rp = $b->query("select v from produto where id=$idp limit 1")->fetchObject();
	$x->preco = nreal($rp->v);
}