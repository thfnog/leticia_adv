<?php
/*if(!$s->db->host){//TIRAR ESSE IF PROVISARIO
	$host = '186.202.152.121';
	$base = 'site13867629781';
	$user = 'site13867629781';
	$pass = 'natal251500';
	if($host&&$user&&$base){
		$b = new PDO("mysql:host={$host};dbname={$base}",$user,$pass);
		$b->exec('SET CHARACTER SET utf8');
	}
}*/

class restApi{
	public function readAll($table,$condition,$fields,$join){
		global $b;
		if(!$fields)$fields = "*";
		$query = "select $fields from $table";
		if($join)$query .= $join;
		if($condition)$query .= " where ".$condition;
		$rs = $b->query($query)->fetchAll(PDO::FETCH_ASSOC);
		return $rs;
	}
	public function read($table,$condition,$fields,$join){
		global $b;
		if(!$fields)$fields = "*";
		$query = "select $fields from $table";
		if($join)$query .= $join;
		if($condition)$query .= " where ".$condition;
		$st = $b->query($query);
		$rs = $st->fetchObject();
		return $rs;
	}
	public function readDetalhes($table,$condition,$join){
		global $b;
		$query = "select a.idc id_pedido,p.c id_produto,a.q quantidade,a.p peso_unitario,a.w peso_total,a.v valor_unitario,a.t valor_total,p.n produto from $table";
		if($join)$query .= $join;
		if($condition)$query .= " where ".$condition;
		$rs = $b->query($query)->fetchAll(PDO::FETCH_ASSOC);
		return $rs;
	}
	public function insertAll($table,$condition){
		global $b;
		$condition = "id=1 or id=2";
		$query = "select * from $table";
		if($condition)$query .= " where ".$condition;
		$rs = $b->query($query)->fetchAll(PDO::FETCH_ASSOC);
		$insert = $b->prepare("insert into cat (id,s,n,t) VALUES (?,?,?,?)");
		foreach($rs as $v){
			$id = $v['id'];
			$s = 0;
			$n = strs($v['n']);
			$t = tag($n,1);
			$insert->execute(array($id,$s,$n,$t));
		}
		return $rs;
	}
	public function insert($table,$condition){
		global $b;
		$query = "select * from $table";
		if($condition)$query .= " where ".$condition;
		$rs = $b->query($query)->fetchAll(PDO::FETCH_ASSOC);
		$insert = $b->prepare("insert into cat (n,t) VALUES (?,?)");
		$insert->execute(array('apple', 'green'));
		return $rs;
	}
	public function insertCat($id,$n){
		global $b;
		$s = 0;
		$n = strs($n);
		$t = tag($n,1);
		$st = $b->query("select id from cat where id=$id limit 1");
		if($st->rowCount()){
			return restApi::updateCat($id,$n);
		}else{
			$insert = $b->prepare("insert into cat (id,s,h1,n,t,tagt,dc) VALUES (?,?,?,?,?,?,now())");
			return $insert->execute(array($id,$s,$n,$n,$t,$n));
		}
	}
	public function updateCat($id,$n){
		global $b;
		$n = strs($n);
		$t = tag($n,1);
		$st = $b->query("select id,n from cat where id=$id and n='$n' limit 1");
		if($st->rowCount()){
			$x->msg = 'Já existe uma categoria com esse ID e nome!';
			return $x->msg;
		}else{
			$update = $b->query("update cat set da=now(),n='$n',t='$t' where id=$id limit 1");
			return $update->rowCount();
		}
	}
	public function insertMarca($id,$n){
		global $b;
		$s = 0;
		$n = strs($n);
		$t = tag($n,1);
		$st = $b->query("select id from marca where id=$id limit 1");
		if($st->rowCount()){
			return restApi::updateMarca($id,$n);
		}else{
			$insert = $b->prepare("insert into marca (id,s,h1,n,t,tagt,dc) VALUES (?,?,?,?,?,?,now())");
			return $insert->execute(array($id,$s,$n,$n,$t,$n));
		}
	}
	public function updateMarca($id,$n){
		global $b;
		$n = strs($n);
		$t = tag($n,1);
		$st = $b->query("select id,n from marca where id=$id and n='$n' limit 1");
		if($st->rowCount()){
			$x->msg = 'Já existe uma marca com esse ID e nome!';
			return $x->msg;
		}else{
			$update = $b->query("update marca set da=now(),n='$n',t='$t' where id=$id limit 1");
			return $update->rowCount();
		}
	}
	public function insertProduto($id,$idc,$idm,$n,$cod,$estoque,$valor){
		global $b;
		$s = 0;
		$idc = $idc;
		$idm = 0;
		$idm = 0;
		$n = strs($n);
		$t = tag($n,1);
		$cod = strs($cod);
		$ref = strs($cod);
		$v = strs($valor);
		$q = (int)$estoque;
		$st = $b->query($teste="select id from produto where c='$id' limit 1");
		Logger("SELECT >> $teste;",'logs/insert-produto.txt');
		if($st->rowCount()){
			return restApi::updateProduto($id,$idc,$idm,$q,$v);
		}else{
			//$insert = $b->prepare("insert into produto (idc,idm,s,h1,n,t,tagt,c,ref,v,estoque,dc) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,now())");
			//return $insert->execute(array($idc,$idm,$s,$n,$n,$t,$n,$id,$ref,$v,$q));
			if($q>0)$insert = $b->exec($sql_log="insert into produto (idc,idm,s,h1,n,t,tagt,c,ref,v,estoque,dc) VALUES ($idc,$idm,$s,'$n','$n','$t','$n','$id','$ref','$v','$q',now())");
			Logger("INSERT >> $sql_log;",'logs/insert-produto.txt');
			return $insert->rowCount();
		}
	}
	public function updateProduto($id,$idc,$idm,$estoque,$valor,$n,$cod){
		global $b;
		$idc = $idc;
		$idm = 0;
		$idm = 0;
		$v = strs($valor);
		$q = $estoque;
		$n = strs($n);
		$t = tag($n,1);
		$cod = strs($cod);
		$ref = strs($cod);

		$st = $b->query("select id from produto where c='$id' and v='$v' and estoque='$q' limit 1");
		if($st->rowCount()){
			$x->msg = 'Já existe um produto com esse ID, estoque e valor!';
			return $x->msg;
		}else{
			$sp = $b->query("select id from produto where c='$id' limit 1");
			if($sp->rowCount()){
				$update = $b->query("update produto set da=now(),idc=$idc,idm=$idm,estoque='$q',v='$v' where c='$id' limit 1");
				return $update->rowCount();
			}else{
				//return restApi::insertProduto($id,$idc,$idm,$q,$v);
				return restApi::insertProduto($id,$idc,$idm,$n,$cod,$q,$v);
			}
		}
	}
	public function updatePedido($id){
		global $b;
		$st = $b->query("select id from pedido where id=$id and importado=1 limit 1");
		if($st->rowCount()){
			$x->msg = 'Pedido já importado!';
			return $x->msg;
		}else{
			$update = $b->query("update pedido set importado=1 where id=$id limit 1");
			return $update->rowCount();
		}
	}

	public function delete($table,$id){
		global $b;
		$delete = $b->query("delete from $table where id=$id limit 1");
		return $delete->rowCount();
	}
	/*public function read($table,$condition){
		global $b;
		$query = "select * from $table";
		if($condition)$query .= " where ".$condition;
		$st = $b->query($query);
		$rs = $st->fetchObject();
		return $rs;
	}*/
/*

URLS PARA BL TECNOLOGIA

SELECT TODOS PEDIDOS - https://www.adaptogen.com.br/ajax/view-data.json?table=pedido&id=&token=Nt07m46OQGi5JgdPqThYa2oRucwVpLvMYG

SELECT PEDIDO - https://www.adaptogen.com.br/ajax/view-data.json?table=pedido&id=22&token=Nt07m46OQGi5JgdPqThYa2oRucwVpLvMYG

UPDATE PEDIDO - https://www.adaptogen.com.br/ajax/update-pedido.json?id=IDPEDIDO&token=Nt07m46OQGi5JgdPqThYa2oRucwVpLvMYG

INSERT CATEGORIA - https://www.adaptogen.com.br/ajax/insert-cat.json?id=IDCATEGORIA&nome=NOMECATGORIA&token=Nt07m46OQGi5JgdPqThYa2oRucwVpLvMYG

UPDATE CATEGORIA - https://www.adaptogen.com.br/ajax/update-cat.json?id=IDCATEGORIA&nome=NOMECATGORIA&token=Nt07m46OQGi5JgdPqThYa2oRucwVpLvMYG

INSERT MARCA - https://www.adaptogen.com.br/ajax/insert-marca.json?id=IDMARCA&nome=NOMEMARCA&token=Nt07m46OQGi5JgdPqThYa2oRucwVpLvMYG

UPDATE MARCA - https://www.adaptogen.com.br/ajax/update-marca.json?id=IDMARCA&nome=NOMEMARCA&token=Nt07m46OQGi5JgdPqThYa2oRucwVpLvMYG

INSERT PRODUTO - https://www.adaptogen.com.br/ajax/insert-produto.json?id=IDPRODTO&id_categoria=IDCATEGORIA&id_marca=IDMARCA&nome=NOMEPRODUTO&codigo=CODIGOPRODUTO&estoque=ESTOQUEPRODUTO&valor=VALORPRODUTO&token=Nt07m46OQGi5JgdPqThYa2oRucwVpLvMYG

UPDATE PRODUTO - https://www.adaptogen.com.br/ajax/update-produto.json?id=IDPRODTO&id_categoria=IDCATEGORIA&id_marca=IDMARCA&nome=NOMEPRODUTO&codigo=CODIGOPRODUTO&estoque=ESTOQUEPRODUTO&valor=VALORPRODUTO&token=Nt07m46OQGi5JgdPqThYa2oRucwVpLvMYG

*/
}