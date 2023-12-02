<?
if($s->adm()){
	$id = strp('id',3);
	$a = strp('s',3)?1:0;
	$pg = strp('pg');
	if($b->exec($x->upd="update $pg set s=$a where id=$id limit 1")){
		if($pg=='produto'){
			$s->googleShopping('produtos-google-shopping',0);
			$s->siteMap('product-sitemap','produto');
		}elseif($pg=='blog')$s->siteMap('post-sitemap','blog');
		elseif($pg=='objetivo')$s->siteMap('post-sitemap','objetivo');
		elseif($pg=='cat')$x->siteMap = $s->siteMap('category-sitemap','categoria');
		$x->ok = 1;
	}else $x->m = 'Ocorreu um erro, tente novamente!';
}else $neg = true;
?>