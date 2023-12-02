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
	$sql = "select *,id,n from cat where t like '$qel' and s order by t";
	$st = $b->query($sql);
	while($rs=$st->fetchObject()){
		$n = $rs->n;
		$t = $rs->t;
		$id = $rs->id;
		if($t&&!in_array($n,$_t)){
			$_t[] = $t;
			$x[$i] = array('id' => $rs->id, 'text' => $rs->n);
			$i++;
		}
		//if($i===10)break;
	}
}
?>