<?
if(!$s->adm()&&$s->spg!='login'&&$s->spg!='esqueci'){
	if($s->spg&&$s->spg!='home')$s->loc('admin/login/'.$s->spg.($s->id?'_'.$s->id:''));
	else $s->loc($s->pg.'/login');
}elseif($s->adm()&&$s->spg=='login'&&$s->spg=='esqueci')$s->loc($s->pg);



$s->lay = 'admin';
$s->tit = 'Administrador';
$s->css[0] = 'css/admin.css?6';
//$s->js = array($s->js[0],'assets/js/jquery.maskedinput-1.3.min.js','assets/js/jbr.sort-1.0.0.js?2','assets/js/jbr.file-1.0.1.js','assets/js/jbr.tab-1.0.3.js?2','assets/js/jbr.form-1.0.2.js?4','niceditor/nicEdit.js','niceditor/load.js');
$s->spg=='massa'?$s->js = array('assets/js/admin/jquery.maskedinput-1.3.1.min.js','assets/js/admin/jbr.sort-1.0.0.js','assets/js/admin/jbr.file-1.0.1.js','assets/js/admin/jbr.tab-1.0.3-massa.js','assets/js/admin/jbr.form-1.0.2.js?a'):$s->js = array('assets/js/admin/jquery.maskedinput-1.3.1.min.js','assets/js/admin/jbr.sort-1.0.0.js','assets/js/admin/jbr.file-1.0.1.js','assets/js/admin/jbr.tab-1.0.3.js?v','assets/js/admin/jbr.form-1.0.2.js?b');


$s->back = "{$s->pg}/{$s->spg}s";

if($s->tipoAdm==5&&$s->spg!='home'&&$s->spg!='cupons'&&$s->spg!='cupom-utilizado'&&$s->spg!='logout')$s->loc('admin/cupons');

if(file_exists($f="{$s->CONTROLLER}{$s->pg}/{$s->spg}.php")){
	include $f;
}
?>