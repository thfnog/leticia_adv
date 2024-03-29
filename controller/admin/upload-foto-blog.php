<?php
if($s->tipoAdm==3)$s->loc('admin');
//if($s->tipoAdm==2)$s->loc('admin');
$s->lay = 'blank';
require_once('class/UploadHandler.php');
$rs = $b->query("select h1 from blog where id='{$s->id}' limit 1")->fetchObject();
$nome = tag($rs->h1,1);

$largura_interno = 880;
$altura_interno = 440;
$largura_thumb = 278;
$altura_thumb = 139;
$largura_ultimos = 160;
$altura_ultimos = 80;


require_once('class/CustomUploadHandler.php');

$P = "upload/blogs/";
$Pt = $P."thumb/";
$tipo_post = 'blog';
$uploadOptions = array(
	'upload_dir' => $P,
	'upload_url' => $s->base.$P,
	'image_versions' => array(
		'interno' => array(
			'crop' => true,
			'max_width' => $largura_interno,
			'max_height' => $altura_interno,
			'jpeg_quality' => 100,
			'upload_dir' => $Pt,
			'upload_url' => $s->base.$Pt
		),
		'thumb' => array(
			'crop' => true,
			'max_width' => $largura_thumb,
			'max_height' => $altura_thumb,
			'jpeg_quality' => 100,
			'upload_dir' => $Pt,
			'upload_url' => $s->base.$Pt
		),
		'ultimos' => array(
			'crop' => true,
			'max_width' => $largura_ultimos,
			'max_height' => $altura_ultimos,
			'jpeg_quality' => 100,
			'upload_dir' => $Pt,
			'upload_url' => $s->base.$Pt
		)
	),
	'script_url' => $s->base.'admin/upload-foto-blog',
	'min_width' => $largura_interno,
	'min_height' => $altura_interno,
	'tipo_post' => $tipo_post
);
$upload_handler = new CustomUploadHandler($uploadOptions);