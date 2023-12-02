<?
if(isset($_GET['q'])){
	$Q = strgs('q',0,0,0,0,0);
	$id = strg('id',3);

	$qe = tag($Q,1,' ');
	$qel = '%'.tag($Q,1,'%').'%';
	$qer = str_replace(' ','.*',$qe);
	$qo = buscaTrata($Q);
	$q = buscaTrata($qe,1,1);
	$q = trim(preg_replace('/ \*| de\*| em\*| no\*| na\*| para\*| a\*| e\*| com\*| -\* /','',' '.$q));

	$i = 0;
	$_t = array();
	$sql = "select id,n,t from peso where n like '$qel' or t like '$qel' order by t";
	$st = $b->query($sql);
	while($rs=$st->fetchObject()){
		$n = $rs->h1;
		$t = $rs->t;
		$id = $rs->id;
		$img = 'upload/pesos/'.($rs->i&&$rs->i!=NULL?$rs->i:'thumb/default.jpg');
		if($n||$t){
			//$x[$i] = array('image' => $img, 'id' => $rs->id, 'text' => $rs->h1);//COM IMG
			$x[$i] = array('id' => $rs->id, 'text' => $rs->n);
			$i++;
		}
		//if($i===10)break;
	}
}