<?php
/*$s->mailU->host = 'smtpout.secureserver.net';
$s->mailU->port = 80;
$s->mailU->mail = 'contato@lojadigital.com.br';
$s->mailU->pass = 'Natal**251500';
$s->mailU->name = 'Não Responder';*/
$s->mailU->host = 'smtp.alquati.com.br';
$s->mailU->port = 587;
$s->mailU->mail = 'naoresponder@alquati.com.br';
$s->mailU->pass = 'natal251500';
$s->mailU->name = 'Não Responder';

$s->mailC->mail = 'contato@alquati.com.br';
$s->cepO = '05675-030';

switch(2){
	case 0:
		$s->dom = 'http://localhost';
		$s->dir = '/aves/';
		$s->db->host = 'localhost';
		$s->db->base = 'aves';
		$s->db->user = 'root';
		$s->db->pass = '';
	break;
	case 1:
		$s->dom = 'http://www.alquati.com.br';
		$s->dir = '/sites/aves/';
		$s->db->host = '186.202.152.124';
		$s->db->base = 'site13867629782';
		$s->db->user = 'site13867629782';
		$s->db->pass = 'natal251500';
	break;
	case 2:
		$s->dom = 'http://localhost';
		$s->dir = '/aves/';
		$s->db->host = '186.202.152.124';
		$s->db->base = 'site13867629782';
		$s->db->user = 'site13867629782';
		$s->db->pass = 'natal251500';
	break;
	case 3:
		$s->dom = 'http://www.sharkpro.com.br';
		$s->dir = '/';
		$s->db->host = 'localhost';
		$s->db->base = 'avesbr34_site';
		$s->db->user = 'avesbr34_site';
		$s->db->pass = 'natal251500';
	break;
}