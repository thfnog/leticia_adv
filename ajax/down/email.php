<?
if($s->adm()){
	$idg = strp('idg',3);
	$a = strp('a',3)?1:0;
	$d = strp('d',3)?1:0;
	/*$cf = strp('cf',3)?1:'';
	$cj = strp('cj',3)?2:'';
	$rf = strp('rf',3)?1:'';
	$rj = strp('rj',3)?2:'';*/
	$qt = 0;
	if($idg&&!$b->query("select id from grupo where id=$idg limit 1")->fetchObject())$x->m = 'Grupo inexistente!';
	else{
		if($a||$d){
			$w = array();
			if($idg)$w[] = "idg=$idg";
			if($a^$d)$w[] = "s=$a";
			$w = count($w)?'where '.implode(' and ',$w):'';
			$st = $b->query("select email from email $w group by email order by email");
			while($rs=$st->fetchObject()){
				$qt++;
				$x->cnt .= "{$rs->email}\r\n";
			}
		}
		/*if($cf||$cj){
			$st = $b->query("select email from cliente where email is not null and email!='' and email like '%@%'".(!$cf^!$cj?" and t={$cf}{$cj}":'').' group by email order by email');
			while($rs=$st->fetchObject()){
				$qt++;
				$x->cnt .= "{$rs->email}\r\n";
			}
		}
		if($rf||$rj){
			$st = $b->query("select email from representante where email is not null and email!='' and email like '%@%'".(!$rf^!$rj?" and t={$rf}{$rj}":'').' group by email order by email');
			while($rs=$st->fetchObject()){
				$qt++;
				$x->cnt .= "{$rs->email}\r\n";
			}
		}*/
		$x->name = 'email-'.datef(0,50).'.txt';
		if(!$qt)$x->m = 'Nenhum email!';
	}
}else $neg = true;
?>