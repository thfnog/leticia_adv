//FUNCTIONS
function message(ok,msg){
	$('#sys-notification').show();
	var answer = ok==1?'success':'danger';
	var icon = ok==1?'check':'question';
	$('#notification').html('<div class="alert alert-'+answer+'"><i class="fa fa-'+icon+'-circle"></i> '+msg+'<button type="button" class="close" data-dismiss="alert">×</button></div>').show();
	setTimeout(function(){$('#notification').hide();},5000);
}

//SUBMETE FORMULÁRIO
function onSubmit(token,event){
	event.preventDefault();
	button = $('#actionForm').find('button');
	button.addClass('face');
	var data = $('#actionForm').serializeArray(),dataObj = {};
	$(data).each(function(i, field){
		dataObj[field.name] = field.value;
	});
	$.post(dataObj['caminho'],data,function(x){
		if(x.hasCaptcha==1)grecaptcha.execute();
		button.removeClass('face');
		//if(x.m)message(x.ok,x.m);
		if(x.m)alert(x.m);
	},'json').success(function(x){
		button.removeClass('face');
		if(x.hasCaptcha==1)grecaptcha.reset();
		if(x.ok==1)window.location = x.l;
	});
}

$(document).on('submit','#actionForm',function(){
	token = 'teste';
	onSubmit(token,event);
});