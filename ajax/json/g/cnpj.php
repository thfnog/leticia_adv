<?php
$cnpj = strgs('cnpj');
$x->cnpj = $cnpj;

$getCNPJ = file_get_contents('https://receitaws.com.br/v1/cnpj/'.$cnpj);	
$r = json_decode($getCNPJ);

$x->status = $r->status;
$x->nome = $r->nome;
$x->fantasia = $r->fantasia;
$x->telefone = $r->telefone;
$x->email = $r->email;
$x->cep = $r->cep;
$x->logradouro = $r->logradouro;
$x->numero = $r->numero;
$x->municipio = $r->municipio;
$x->bairro = $r->bairro;
$x->uf = $r->uf;