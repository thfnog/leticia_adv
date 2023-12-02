<?php
if($s->tipoAdm==3)$s->loc('admin');
//if($s->tipoAdm==2)$s->loc('admin');
$s->lay = 'blank';
require_once('class/UploadHandler.php');
$rnome = $b->query("select n from produto where id='{$s->id}' limit 1")->fetchObject();
$nome = tag($rnome->n,1);

require_once('class/CustomUploadHandler.php');

$P = "upload/produtos/";
$Pt = $P."thumb/";
$tipo_post = 'produto';
$uploadOptions = array(
	'upload_dir' => $P,
	'upload_url' => $s->base.$P,
	'image_versions' => array(
		'interno' => array(
			'crop' => true,
			'max_width' => 760,
			'max_height' => 760,
			'jpeg_quality' => 100,
			'upload_dir' => $Pt,
			'upload_url' => $s->base.$Pt
		),
		'thumb' => array(
			'crop' => true,
			'max_width' => 400,
			'max_height' => 400,
			'jpeg_quality' => 100,
			'upload_dir' => $Pt,
			'upload_url' => $s->base.$Pt
		),
		'miniatura' => array(
			'crop' => true,
			'max_width' => 100,
			'max_height' => 100,
			'jpeg_quality' => 100,
			'upload_dir' => $Pt,
			'upload_url' => $s->base.$Pt
		),
		'carrinho' => array(
			'crop' => true,
			'max_width' => 85,
			'max_height' => 85,
			'jpeg_quality' => 100,
			'upload_dir' => $Pt,
			'upload_url' => $s->base.$Pt
		)
	),
	'script_url' => $s->base.'admin/upload-foto-produto',
	'min_width' => 760,
	'min_height' => 760,
	'tipo_post' => $tipo_post
);
$upload_handler = new CustomUploadHandler($uploadOptions);