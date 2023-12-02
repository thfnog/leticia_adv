<?
$id = strp('id',3);
$x->codigo = $c = strpr('c');

$rc = $b->query("select * from pedido where id=$id limit 1")->fetchObject();

if(!$c)$x->m = 'Digite o código!';
elseif($c==$rc->cod)$x->m = 'Nenhum valor para alterar!';
else{
	$b->query("update pedido set cod='$c' where id=$id limit 1");
	$rc->cod?$x->m = 'Código alterado com sucesso!':$x->m = 'Código cadastrado com sucesso!';
	$x->ok = 1;
	require_once('class/email-codigo.php');
}
?>