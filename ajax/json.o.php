<?
if(!isset($x))$x = array();
if($neg){
	if(is_array($x))$x['m'] = 'Acesso negado!';
	if(is_object($x))$x->m = 'Acesso negado!';
}
echo json_encode($x);
?>