<div class="col-md-12">
	<div class="panel panel-white">
		<div class="panel-heading clearfix">
			<h4 class="panel-title">Alterar Senha</h4>
		</div>
		<div class="panel-body">
			<form id="id-form">
				<div class="form-group col-md-12">
					<label for="pass">* Senha Anterior</label>
					<input type="password" class="form-control" id="pass" name="pass" placeholder="Digite a senha antiga">
				</div>
				<div class="form-group col-md-12">
					<label for="p1">* Nova Senha</label>
					<input type="password" class="form-control" id="p1" name="p1" placeholder="Digite a nova senha">
				</div>
				<div class="form-group col-md-12">
					<label for="p2">* Confirmar Senha</label>
					<input type="password" class="form-control" id="p2" name="p2" placeholder="Digite a confirmação da nova senha">
				</div>
				<div class="form-group col-md-12">
					<input type="submit" class="btn btn-success"/>
				</div>
			</form>
		</div>
	</div>
</div>
<?
Inline::a();
?>
<script src="assets/js/admin/jquery.validate.min.js" type="text/javascript"></script>
<script type="text/javascript">
var adm = $.form({
	a:'senha',
	sub:'Alterar'
});
$(document).ready(function() {
    var validator = $('#id-form').validate({
        rules: {
            pass: {
                required: true
            },
		   p1: {
                required: true
		    },
		    p2: {
                required: true,
                equalTo: '#p1'
		    }
        }
    });
});
</script>
<?
Inline::b();
?>