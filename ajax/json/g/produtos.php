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
	$sql = "select p.id,p.h1,f.i,p.t from produto p left join fotos f on p.id=f.idp and f.tipo='produto' and f.principal where p.s and (p.h1 like '$qel' or p.n like '$qel' or p.t like '$qel' or p.c like '$qel') order by p.t";
	$st = $b->query($sql);
	while($rs=$st->fetchObject()){
		$n = $rs->h1;
		$t = $rs->t;
		$c = $rs->c;
		$id = $rs->id;
		$img = 'upload/produtos/'.($rs->i&&$rs->i!=NULL?$rs->i:'thumb/default.jpg');
		if($n||$c){
			$x[$i] = array('image' => $img, 'id' => $rs->id, 'text' => $rs->h1);
			$i++;
		}
		//if($i===10)break;
	}
}