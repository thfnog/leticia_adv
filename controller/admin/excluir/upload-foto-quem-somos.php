<?php
if($s->tipoAdm==3)$s->loc('admin');
//if($s->tipoAdm==2)$s->loc('admin');
$s->lay = 'blank';
require_once('class/UploadHandler.php');
$rs = $b->query("select h1 from empresa where id='{$s->id}' limit 1")->fetchObject();
$nome = tag($rs->h1,1);

$largura_thumb = $altura_thumb = 653;

require_once('class/CustomUploadHandler.php');

$P = "upload/quem-somos/";
$Pt = $P;
$tipo_post = 'quem-somos';
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
		)
	),
	'script_url' => $s->base.'admin/upload-foto-quem-somos',
	'min_width' => $largura_thumb,
	'min_height' => $altura_thumb,
	'tipo_post' => $tipo_post
);
$upload_handler = new CustomUploadHandler($uploadOptions);