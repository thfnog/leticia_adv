<?
$id = 0;
$ip = $s->ip;
$l = strpr('l');
$url = strgr('url');
$ht = 'http://';
$url = substr($url,0,7)=='http://'?$url:$ht.$url;
$velocidade = '';
$experiencia = '';
$AvoidPlugins = '';
$AvoidPluginsTit = '';
$ConfigureViewport = '';
$ConfigureViewportTit = '';
$SizeContentToViewport = '';
$SizeContentToViewportTit = '';
$SizeTapTargetsAppropriately = '';
$SizeTapTargetsAppropriatelyTit = '';
$UseLegibleFontSizes = '';
$UseLegibleFontSizesTit = '';

if(!$url)$j->m = 'Digite o Link!';
else{
	if($teste=file_get_contents("https://www.googleapis.com/pagespeedonline/v2/runPagespeed?url={$url}&locale=pt_BR&strategy=mobile&key=AIzaSyAL9bsOAmJ7XrwZTfYRO-s6LPav3CrfCho")){
		$json = json_decode($teste);
		$velocidade = $json->ruleGroups->SPEED->score;
		$experiencia = $json->ruleGroups->USABILITY->score;
		$AvoidPlugins = $json->formattedResults->ruleResults->AvoidPlugins->ruleImpact;
		$AvoidPluginsTit = $json->formattedResults->ruleResults->AvoidPlugins->localizedRuleName;
		$ConfigureViewport = $json->formattedResults->ruleResults->ConfigureViewport->ruleImpact;
		$ConfigureViewportTit = $json->formattedResults->ruleResults->ConfigureViewport->localizedRuleName;
		$SizeContentToViewport = $json->formattedResults->ruleResults->SizeContentToViewport->ruleImpact;
		$SizeContentToViewportTit = $json->formattedResults->ruleResults->SizeContentToViewport->localizedRuleName;
		$SizeTapTargetsAppropriately = $json->formattedResults->ruleResults->SizeTapTargetsAppropriately->ruleImpact;
		$SizeTapTargetsAppropriatelyTit = $json->formattedResults->ruleResults->SizeTapTargetsAppropriately->localizedRuleName;
		$UseLegibleFontSizes = $json->formattedResults->ruleResults->UseLegibleFontSizes->ruleImpact;
		$UseLegibleFontSizesTit = $json->formattedResults->ruleResults->UseLegibleFontSizes->localizedRuleName;
		$j->velocidade = $velocidade;
		$j->experiencia = $experiencia;
		$j->AvoidPlugins = $AvoidPlugins;
		$j->AvoidPluginsTit = $AvoidPluginsTit;
		$j->ConfigureViewport = $ConfigureViewport;
		$j->ConfigureViewportTit = $ConfigureViewportTit;
		$j->SizeContentToViewport = $SizeContentToViewport;
		$j->SizeContentToViewportTit = $SizeContentToViewportTit;
		$j->SizeTapTargetsAppropriately = $SizeTapTargetsAppropriately;
		$j->SizeTapTargetsAppropriatelyTit = $SizeTapTargetsAppropriatelyTit;
		$j->UseLegibleFontSizes = $UseLegibleFontSizes;
		$j->UseLegibleFontSizesTit = $UseLegibleFontSizesTit;
		$j->m = 'Consulta realizada com sucesso!';
	}else $j->m = 'Erro!';
}
$x = 'var x='.json_encode($j).'||{};x.m=x.m||m;opener&&opener.adm&&opener.adm.cbgerar&&opener.adm.cbgerar(x);';
?>