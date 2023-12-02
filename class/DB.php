<?php
class DB{
	public function insert($table){
		global $b;
		$b->query("insert into $table set dc=now()");
		$id = $b->lastInsertId();
		return $id;
	}
	public function update($table,$id,$updates){
		global $b;
		$updates = array_filter($updates, function ($value){
			return null !== $value;
		});
	
		$query = "update $table set";
		$values = array();
		
		foreach ($updates as $name => $value) {
			$query .= ' '.$name.' = :'.$name.','; // the :$name part is the placeholder, e.g. :zip
			$values[':'.$name] = $value; // save the placeholder
		}
		
		$query = substr($query, 0, -1); // remove last , and add a ;
		$query .= " where id=$id;";
		//print_r($query);
		//print_r($values);
	
		$sth = $b->prepare($query);
		$x->ok = 0;
		try{
			$sth->execute($values);
			if($sth->rowCount()){
				$x->rowCount = $x->ok = 1;
				//Logger("SQL QUERY >> $query;",'logs/update.txt');
				//Logger("SQL VALUES >> $values;",'logs/update.txt');
			}
		}catch(PDOException $e){
			$x->erro = 'ERRO PDO: '.$e->getMessage();
			Logger("TABELA >> $table ERRO >> {$e->getMessage()};",'logs/update-error.txt');
		}catch(Exception $e){
			$x->erro = 'ERRO GERAL: '.$e->getMessage();
		}
		return $x;
	}
	public function delete($table,$id){
		global $b;
		if($rs=$b->query("select id from $table where id=$id limit 1")->fetchObject()){
			if($b->exec("delete from $table where id=$id limit 1")){
				$x->m = 'Excluído com sucesso!';
				$x->ok = 1;
			}else $x->m = 'Erro ao excluir!';
		}else $x->m = 'Nenhum dado encontrado!';
		return $x;
	}
}