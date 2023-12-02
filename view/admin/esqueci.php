<script type="text/javascript">
<?
if($x->l)echo "window.location = '$x->l';\r\n";
?>
</script>
<script type="text/javascript">
function ver(f){}
</script>
<div class="col-md-3 center">
	<div class="login-box">
		<a href="." class="logo-name text-lg text-center"><img src="assets/img/logo-lg.png"/></a>
<?
if($s->id){
?>
		<h3 class="text-center m-t-md">REDEFINIR SENHA.</h3>
		<p class="text-center m-t-md">Digite os dados para redefinir a senha.</p>
		<div class="info" style="color:#f00"><strong class="err"></strong></div>
		<form method="post" class="m-t-md" onsubmit="return ver(this,'redefinir-senha-admin','admin');">
			<div class="form-group">
				<input type="text" class="form-control" placeholder="ID" name="id" value="<?=$s->id?>" srequired>
			</div>
			<div class="form-group">
				<input type="text" class="form-control" placeholder="E-mail" name="email" value="<?=$rs->email?>" srequired>
			</div>
			<div class="form-group">
				<input type="text" class="form-control" placeholder="Código" name="cod" value="<?=$rs->cod?>" srequired>
			</div>
			<div class="form-group">
				<input type="password" class="form-control" placeholder="Nova Senha" name="p1" srequired>
			</div>
			<div class="form-group">
				<input type="password" class="form-control" placeholder="Confirmar Nova Senha" name="p2" srequired>
			</div>
			<div class="clearfix"></div>
			<button type="submit" class="btn btn-success btn-block">Enviar</button>
		</form>
<?
}else{
?>
		<h3 class="text-center m-t-md">ESQUECI MINHA SENHA.</h3>
		<p class="text-center m-t-md">Digite seu e-mail para ser enviado um link de redefinição de senha.</p>
		<div class="info" style="color:#f00"><strong class="err"></strong></div>
		<form method="post" class="m-t-md" onsubmit="return ver(this,'enviar-senha-admin','admin');">
			<div class="form-group">
				<input type="text" class="form-control" placeholder="E-mail" name="email" value="<?=strgs('email',1,3)?>" srequired>
			</div>
			<div class="clearfix"></div>
			<button type="submit" class="btn btn-success btn-block">Enviar</button>
		</form>
<?
}
?>
		<p class="text-center m-t-xs text-sm">2016 &copy; <a href="https://www.alquati.com.br">Alquati</a>.</p>
	</div>
</div>
<?
Inline::a();
?>
<script type="text/javascript">
$(function(){
	erro();
});
function erro(m,e,c){
	e = $(e||'.err');
	e.html(m||'').css('display',m?'':'none');
	if(c&&c.select)c.select();
}
function ver(f,u,l){
	if(ver.l)return false;
	ver.l = 1;
	erro();
	$.post('ajax/'+u+'.json',$(f).serialize(),function(x){
		if(x.m)x.ok?alert(x.m):erro(x.m,0,f[x.c]);
		if(x.ok)f.reset();
		if(x.ok&&l)location = l;
	},'json').complete(function(x){
		//alert(x.responseText);
		ver.l = 0;
	});
	return false;
}
</script>
<?
Inline::b();
?>