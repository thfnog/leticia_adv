<?php
class uploadFoto{
	public function getFotos($idp=0,$tipo_post){
		global $b;
		$stf = $b->query("select i from fotos where idp=$idp and tipo='$tipo_post'");
		$array = array();
		while($rstf=$stf->fetch())array_push($array,$rstf["i"]);
		return $array;
	}
	public function getIdFotos($file_name,$tipo_post){
		global $b;
		$rstf = $b->query("select id from fotos where i='$file_name' and tipo='$tipo_post' limit 1")->fetchObject();
		return $rstf->id;
	}
	public function deleteFotos($id=0,$tipo_post,$P,$Pt){
		global $b;
		$rstf = $b->query("select * from fotos where id=$id and tipo='$tipo_post' limit 1")->fetchObject();
		if($rstf->i)@unlink($P.$rstf->i);
		if($rstf->it)@unlink($Pt.$rstf->it);
		if($rstf->itc)@unlink($Pt.$rstf->itc);
		if($rstf->ith)@unlink($Pt.$rstf->ith);
		if($rstf->iti)@unlink($Pt.$rstf->iti);
		if($rstf->itm)@unlink($Pt.$rstf->itm);
		if($rstf->itr)@unlink($Pt.$rstf->itr);
		if($rstf->itu)@unlink($Pt.$rstf->itu);
		$b->exec("delete from fotos where id=$id and tipo='$tipo_post' limit 1");
	}
	public function insertFotos($idp=0,$tipo_post,$file_name){
		global $b;
		$stf = $b->query("select i from fotos where idp=$idp and tipo='$tipo_post'");
		if($stf->rowCount())$b->exec("insert into fotos (idp,tipo,dc,i) values ($idp,'$tipo_post',now(),'$file_name')");
		else $b->exec("insert into fotos (idp,tipo,dc,i,principal) values ($idp,'$tipo_post',now(),'$file_name',1)");
	}
	public function updateFotos($id=0,$tipo_post,$it,$col){
		global $b;
		$b->exec("update fotos set $col='$it',da=now() where id=$id and tipo='$tipo_post' limit 1");
	}
}