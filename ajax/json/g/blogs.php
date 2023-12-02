<?
if(isset($_GET['q'])){
	$Q = strgs('q',0,0,0,0,0);

	$qe = tag($Q,1,' ');
	$qel = '%'.tag($Q,1,'%').'%';
	$qer = str_replace(' ','.*',$qe);
	$qo = buscaTrata($Q);
	$q = buscaTrata($qe,1,1);
	$q = trim(preg_replace('/ \*| de\*| em\*| no\*| na\*| para\*| a\*| e\*| com\*| -\* /','',' '.$q));

	$i = 0;
	$_t = array();
	$sql = "select b.*,b.id,b.h1,f.i from blog b left join fotos f on b.id=f.idp and f.tipo='blog' and f.principal where b.t like '$qel' or b.h1 like '$qel' and b.s order by b.t";
	$st = $b->query($sql);
	while($rs=$st->fetchObject()){
		$n = $rs->n;
		$t = $rs->t;
		$id = $rs->id;
		$img = 'upload/blogs/'.($rs->i&&$rs->i!=NULL?$rs->i:'thumb/default.jpg');
		if($t&&!in_array($n,$_t)){
			$_t[] = $t;
			$x[$i] = array('image' => $img, 'id' => $rs->id, 'text' => $rs->h1);
			$i++;
		}
		//if($i===10)break;
	}
}
?>