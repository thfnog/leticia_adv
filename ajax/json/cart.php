<?php
require_once('class/cart.php');
$x->id = $id = strp('id',3);
$x->qt = $qt = strp('qt',3);
if(!$qt||$qt<1)$qt = 1;

$ck = $_SESSION['cookie_cart'];
if($id&&$qt){
	if($s->idc)$x->cart = cart::insert($id,$qt,$s->idc);
	else $x->cart = cart::insert($id,$qt,0,'_temp',$_SESSION['cookie_cart']);
}