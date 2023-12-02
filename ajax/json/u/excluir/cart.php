<?
$id = strp('id',3);
$qt = strp('qt',3);
$ck = $_SESSION['cookie_cart'];
if($id&&$qt){
	if($s->idc)$sc = $b->query("select * from cart where idu='{$s->idc}' and s=1 order by id desc");
	else $sc = $b->query("select * from cart_temp where cookie='$ck' and s=1 order by id desc");

	if($sc->rowCount()){
		$rc = $sc->fetchObject();
		$rq = $b->query("select peso w from produto where id=$id limit 1")->fetchObject();
		if($s->idc)$x->cart = $s->cartUpd($id,$qt,$rc->id,$rq->w);
		else $x->cart = $s->cartUpd($id,$qt,$rc->id,$rq->w,'_temp');
	}
}