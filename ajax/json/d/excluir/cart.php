<?php
require_once('class/cart.php');
$id = strp('id',3);
if($s->idc)$x->cart = cart::delete($id,$s->idc);
else $x->cart = cart::delete($id,0,'_temp',$_SESSION['cookie_cart']);