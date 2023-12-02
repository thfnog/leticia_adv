<?php
if(true){
	$id = strg('id',3);//id do produto
	$qt = strg('qt',3);//qtd 
	$x->ida = $ida = strg('ida',3);//id do cart auxiliar
	$hj = date("Y-m-d");

	$rs = $b->query("select id,h1,c,v,t from produto where id=$id limit 1")->fetchObject();
	$foto = $b->query("select itc from fotos where tipo='produto' and idp=$id and principal limit 1")->fetchObject();
	$img = $foto?$foto->itc:'default-itc.jpg';
	if($rs){
		$x->qt = $qt;
		$x->result = '<li data-id="'.$ida.'">
			<a class="rmv-top"><i class="fa fa-trash-o"></i></a>
			<a href="'.$rs->t.'">
				<img width="80" height="80" src="upload/produtos/thumb/'.$img.'" alt="'.$rs->h1.'">
				'.$rs->h1.'
			</a>
			<div class="quantity-select">
				<div class="button-wrapper">
					<button class="adjust adjust-minus qty-operator" data-operator="minus" data-idp="'.$rs->id.'"><i class="fa fa-minus-circle"></i></button>
				</div>
				<div class="button-wrapper">
					<input type="text" min="1" value="'.$qt.'" class="cart-qtd" data-qtd-idp="'.$rs->id.'">
				</div>
				<div class="button-wrapper">
					<button class="adjust adjust-plus qty-operator" data-operator="plus" data-idp="'.$rs->id.'"><i class="fa fa-plus-circle"></i></button>
				</div>
			</div>
			<span class="price price-'.$rs->id.'">R$ '.nreal($rs->v*$qt).'</span>
		</li>';
	}else $x->m = 'Ocorreu um erro na busca, tente novamente!';
}