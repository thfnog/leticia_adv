<?
if(true){
	$id = strp('id',3);
	$rs = $b->query("select * from cart where id=$id and idu='{$s->idc}' limit 1")->fetchObject();
	if($b->exec("update cart set idd=NULL,vd=NULL where id=$id and idu='{$s->idc}'"))$x->ok = 1;
}else $neg = true;
?>