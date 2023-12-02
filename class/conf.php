<?php
$s->mailU->host = 'smtp.colittiadv.com.br';
$s->mailU->port = 587;
$s->mailU->mail = 'naoresponder@colittiadv.com.br';
$s->mailU->pass = 'Natal**251500';
$s->mailU->name = 'Não Responder';

$s->mailC->mail = 'naoresponder@colittiadv.com.br';
//$s->cepO = '13360-000';

switch(1){
	case 0:
		$s->dom = 'http://localhost';
		$s->dir = '/leticia/';
		$s->db->host = 'localhost';
		$s->db->base = 'leticia';
		$s->db->user = 'root';
		$s->db->pass = '';
	break;
	case 1:
		$s->dom = 'https://www.colittiadv.com.br';
		$s->dir = '/';
		$s->db->host = 'site_leticia.mysql.dbaas.com.br';
		$s->db->base = 'site_leticia';
		$s->db->user = 'site_leticia';
		$s->db->pass = 'Natal**251500!';
	break;
}