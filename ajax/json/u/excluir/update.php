<?php
use Respect\Validation\Exceptions\ValidationException;
use Respect\Validation\Validator as v;

if($s->adm()){
	$id = strp('id',3);
	$idp = strp('idp',3);
	$table = strps('table');

	$updates = array(
		'idp' => $idp?$idp:NULL,
		//'da' => date('Y-m-d H:i:s'),
		's' => strp('s',3)?1:0,
		'idu' => $s->idu,
		'principal' => $s->idu,
		'tipo' => strps('tipo'),
		'nome' => strps('nome'),
		'h1' => strps('h1'),
		'n' => strps('n'),
		'dp' => strps('dp'),
		'd' => strps('d'),
		'r' => strps('r'),
		'tagd' => strps('tagd'),
		'tagk' => strps('tagk'),
		'tagt' => strps('tagt')?strps('tagt'):strps('n'),
	);
	$updates['t'] = tag($updates['n'],1);

	/*try {
		v::create()
		->key('cpf',v::cpf())
		->key('user',v::length(5,5))
		->key('senha',v::notEmpty()->setName('SENHA'))
		->key('teste',v::notEmpty()->setName('TESTE'))
		->assert([
			'cpf' => '369.310.388-777',
			'user' => 'rassas',
			'senha' => '',
			'teste' => '',
		]);
	} catch (ValidationException $exception) {
		$errors = $exception->findMessages($errormessages);
		print_r($errors);
		exit;
	}*/
	$rs = $b->query("select id from $table where id=$id limit 1")->fetchObject();

	if($_dp=preg_match($dataRE,$updates['dp'],$_m))$updates['dp'] = "{$_m[3]}-{$_m[2]}-{$_m[1]}";
	$updates['m'] = tag(datef($updates['dp'],61),1);
	
	if($id&&!$rs)$x->m = 'Este post não existe!';
	else{
		try {
			v::create()
			->key('h1',v::notEmpty()->setName('Título (H1)'))
			->key('n',v::notEmpty()->setName('Slug'))
			->key('dp',v::date()->notEmpty()->setName('Data do Post'))
			->key('d',v::notEmpty()->setName('Descrição'))
			->key('r',v::notEmpty()->setName('Resumo'))
			->assert([
				'h1' => $updates['h1'],
				'n' => $updates['n'],
				'dp' => $updates['dp'],
				'd' => $updates['d'],
				'r' => $updates['r'],
			]);
		} catch (ValidationException $exception) {
			$errors = $exception->findMessages($s->errorMessages);
			$errors = $exception->getMessages();
			$x->allErrors = $errors;
			$x->m = $errors[0];
			//print_r($errors2);
			$x->errors = 1;
		}
		if(!$x->errors){
			$x->up = $id?1:0;
			if(!$id)$id = DB::insert($table);
			if($id){
				$updated = DB::update($table,$id,$updates);
				$x->ok = $updated->ok;
				if($updated->ok&&$updated->rowCount){
					$x->m = ($x->up?'Alterado':'Cadastrado').' com sucesso!';
					$b->query("update $table set da=now() where id=$id");
				}else{
					if($updated->erro)$x->m = $updated->erro;
					else $x->m = 'Nenhum campo para alterar!';
				}
			}
		}
	}
}else $neg = true;