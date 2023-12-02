<?php
ini_set('display_errors',1);
ini_set('max_execution_time',300); 
error_reporting(E_ERROR | E_PARSE);
// ----- ----- //
class Admin{
	public function visualizar($page){
?>
<script type="text/javascript">
$.get('ajax/g/produto.json',{q:$('.q').val()},function(x){
	if(x.msg)console.log(x.msg);
},'json').success(function(x){
	if(x.r){
		$('.reg-encontrado').html(x.nrows);
		$('thead').prepend(x.head);
		$.each(x.r,function(k,v){
			$('.tab-lista').append(v.result);
		});
	}
});
$.(document).on('click','.iunblock',function(){
	$.post('ajax/s/status.json',{id:id,q:$('.q').val()},function(x){
	});
});
</script>
<?php
	}
}