<?php
if($s->tipoAdm==3)$s->loc('admin');
//if($s->tipoAdm==2)$s->loc('admin');
$s->lay = 'blank';
require_once('class/UploadHandler.php');
$rs = $b->query("select nome from team where id='{$s->id}' limit 1")->fetchObject();
$nome = tag($rs->nome,1);

$largura_thumb = 370;
$altura_thumb = 370;


require_once('class/CustomUploadHandler.php');

$P = "upload/team/";
$Pt = $P."thumb/";
$tipo_post = 'team';
$uploadOptions = array(
	'upload_dir' => $P,
	'upload_url' => $s->base.$P,
	'image_versions' => array(
		'thumb' => array(
			'crop' => true,
			'max_width' => $largura_thumb,
			'max_height' => $altura_thumb,
			'jpeg_quality' => 100,
			'upload_dir' => $Pt,
			'upload_url' => $s->base.$Pt
		),
	),
	'script_url' => $s->base.'admin/upload-foto-team',
	'min_width' => $largura_thumb,
	'min_height' => $altura_thumb,
	'tipo_post' => $tipo_post
);
$upload_handler = new CustomUploadHandler($uploadOptions);