<?php

$dataRE = '/^(0?[1-9]|[12]\d|3[01])[\/\.\s-](0?[1-9]|1[012])[\/\.\s-](\d\d|\d{4})$/';
$w3cdataRE = '/^(\d{4})-(\d{2})-(\d{2})T(\d{2}):(\d{2}):(\d{2})(?:\.(\d+))?(?:Z|(?:(\+|-)(\d{2}):(\d{2})))$/i';
$emailRE = '/^[-_a-z0-9]+(\.[-_a-z0-9]+)*@([-a-z0-9]+\.)*([a-z]{2,6})$/i';
$md5RE = '/^([0-9a-f]{32})$/i';
$telRE = '/^\(?(\d{2})\)?[\/\.\s-]*(\d{4,5})[\/\.\s-]*(\d{4})$/';
$cnpjRE = '/^(\d{2,3})\.?(\d{3})\.?(\d{3})\/?(\d{4})-?(\d\d)$/';
$ieRE = '/^(\d{3})\.?(\d{3})\.?(\d{3})\.?(\d{3})$/';
$cpfRE = '/^(\d{3})\.?(\d{3})\.?(\d{3})-?(\d\d)$/';
$rgRE = '/^(.+)$/';
$cepRE = '/^(\d{5})-?(\d{3})$/';
$linkRE = '/((https?:\/\/|ftp:\/\/)([-\w\.]+)|www\d?\.[-\w\.]+)(:\d+)?(\/(([-\w\/\.]*)(\?\S+)?(#\S+)?[^\s\?!\.,;:])?)?/i';
$link2RE = '/^((https?:\/\/|ftp:\/\/)([-\w\.]+)|www\d?\.[-\w\.]+)(:\d+)?(\/(([-\w\/\.]*)(\?\S+)?(#\S+)?)?)?$/i';
$agRE = '/^(\d{4})-?(\d)$/';
$ccRE = '/^(\d{2})\.?(\d{3})-?(\d)$/';




function encrypt($s,$k){
	$q = strlen($s);
	$Q = strlen($k);
    for($x=0,$y=0; $x<$q; $x++){
        $s{$x} = chr(ord($s{$x})^ord($k{$y}));
        if(++$y==$Q)$y = 0;
    }
    return $s;
}



function Logger($msg='',$f='logs/_log.txt'){
	$data = date('d-m-y');
	$hora = date('H:i:s');
	$ip = $_SERVER['REMOTE_ADDR'];
	$t = "[$data $hora][$ip]> $msg\r\n";
	$f = fopen($f,'a+b');
	fwrite($f,$t);
	fclose($f);
}



class Img{// v1.0.1
	//$la = local origem
	//$lb = local destino ou 0 para o arquivo de origem ($lb = $la)
	//$x = x do quadro
	//$y = y do quadro
	//$q = qualidade
	//$m = se é pra redimensionar para o máximo definido no quadro ($x,$y)
	//
	//$x>0 && !$y: redimensionar com proporção à largura
	//!$x && $y>0: redimensionar com proporção à altura
	//!$x && !$y: mantem as dimensões
	public function resize($la=0,$lb=0,$x=0,$y=0,$q=0,$m=0){
		if(is_array($la)&&$la['tmp_name'])$la = $la['tmp_name'];
		if(!$la||!file_exists($la)||!is_file($la))return false;
		if(!$lb)$lb = $la;

		$s = getimagesize($la);
		if(!$s)return false;
		$w = $s[0];
		$h = $s[1];
		$t = $s[2];
		$tp = array('','gif','jpeg','png');
		$t = $tp[$t];
		if(!$t)return false;

		$nw = round(($y*$w)/$h);//new width em relação y do quado
		$nh = round(($x*$h)/$w);//new height em relação x do quado
		if($m&&$x&&$y){
			if($w<=$x&&$h<=$y){
				$W = $w;
				$H = $h;
			}elseif($nw<$x){
				$W = $nw;
				$H = $y;
			}else{
				$W = $x;
				$H = $nh;
			}
		}else{
			$W = $x;
			$H = $y;
			if(!$x)$W = $nw;
			if(!$y)$H = $nh;
			if((!$x&&!$y)||($W>=$w&&$H>=$h)){
				$W = $w;
				$H = $h;
			}
		}

		$ia = @call_user_func('imagecreatefrom'.$t,$la);
		if(!$ia)return false;
		$ib = imagecreatetruecolor($W,$H);

		if($t==='gif'||$t==='png'){
			imagealphablending($ib,false);
			imagesavealpha($ib,true);
			imagefill($ib,0,0,imagecolorallocatealpha($ib,255,255,255,127));
		}

		imagecopyresampled($ib,$ia,0,0,0,0,$W,$H,$w,$h);
		imagedestroy($ia);

		if(!$q&&$t=='jpeg')$q = 100;
		if($t=='gif'||$t==='png')$q = 0;
		if($q)$r = @call_user_func('image'.$t,$ib,$lb,$q);
		else $r = @call_user_func('image'.$t,$ib,$lb);
		imagedestroy($ib);	
		return $r?true:false;
	}

	public function resizeMax($la=0,$lb=0,$x=0,$y=0,$q=0){
		return self::resize($la,$lb,$x,$y,$q,1);
	}

	public function resize0($la=0,$lb=0,$w=0,$h=0,$q=0){
		if(is_array($la)&&$la['tmp_name'])$la = $la['tmp_name'];
		if(!$la||!file_exists($la))return false;
		if(!$lb)$lb = $la;

		$s = getimagesize($la);
		if(!$s)return false;
		$x = $s[0];
		$y = $s[1];
		$t = $s[2];
		$tp = array('','gif','jpeg','png');
		$t = $tp[$t];
		if(!$t)return false;
		if(!$w&&!$h){
			$w = $x;
			$h = $y;
		}elseif(!$h)$h = round(($w*$y)/$x);
		elseif(!$w)$w = round(($h*$x)/$y);

		$ia = @call_user_func('imagecreatefrom'.$t,$la);
		if(!$ia)return false;
		$ib = imagecreatetruecolor($w,$h);

		imagecopyresampled($ib,$ia,0,0,0,0,$w,$h,$x,$y);
		imagedestroy($ia);

		if(!$q&&$t=='jpeg')$q = 100;
		if($t=='gif')$q = 0;
		if($q)$r = @call_user_func('image'.$t,$ib,$lb,$q);
		else $r = @call_user_func('image'.$t,$ib,$lb);
		imagedestroy($ib);	
		return $r?true:false;
	}

	public function resizeMax0($la=0,$lb=0,$x=0,$y=0,$q=0){
		if(is_array($la)&&$la['tmp_name'])$la = $la['tmp_name'];
		if(!$la||!file_exists($la))return false;
		if(!$lb)$lb = $la;

		$s = getimagesize($la);
		if(!$s)return false;
		$w = $s[0];
		$h = $s[1];
		$t = $s[2];
		$tp = array('','gif','jpeg','png');
		$t = $tp[$t];
		if(!$t)return false;
		//$nw = round($w/($h/$y));//new width em relação y do quado
		//$nh = round($h/($w/$x));//new height em relação x do quado
		$nw = round(($y*$w)/$h);//new width em relação y do quado
		$nh = round(($x*$h)/$w);//new height em relação x do quado
		if($w<=$x&&$h<=$y){
			$W = $w;
			$H = $h;
		}elseif($nw<$x){
			$W = $nw;
			$H = $y;
		}else{
			$W = $x;
			$H = $nh;
		}

		$ia = @call_user_func('imagecreatefrom'.$t,$la);
		if(!$ia)return false;
		$ib = imagecreatetruecolor($W,$H);

		imagecopyresampled($ib,$ia,0,0,0,0,$W,$H,$w,$h);
		imagedestroy($ia);

		if(!$q&&$t=='jpeg')$q = 100;
		if($t=='gif')$q = 0;
		if($q)$r = @call_user_func('image'.$t,$ib,$lb,$q);
		else $r = @call_user_func('image'.$t,$ib,$lb);
		imagedestroy($ib);	
		return $r?true:false;
	}
}
/*
//-------- exemplos
// essa função retorna true se deu certo
// e false se o arquivo não existir ou se não for imagem ou se deu erro

$imgde = 'teste.jpg';// aqui pode ser o caminho ou do form ex: $_FILES['campo_imagem']
$imgpara = 'teste2.jpg';// se você querer usar o mesmo arquivo é só colocar 0

// redimensionar com proporção à largura
echo Img::resize($imgde,$imgpara,100);
// redimensionar com proporção à largura e qualidade
echo Img::resize($imgde,$imgpara,100,0,78);

// ------------

// redimensionar com proporção à altura
echo Img::resize($imgde,$imgpara,0,50);

// redimensionar com proporção à altura e qualidade
echo Img::resize($imgde,$imgpara,0,50,78);

// ------------

// redimensionar com largura e altura fixa
echo Img::resize($imgde,$imgpara,100,50);

// redimensionar com largura e altura fixa e qualidade
echo Img::resize($imgde,$imgpara,100,50,78);

// ------------

// alterar só a qualidade
echo Img::resize($imgde,$imgpara,0,0,78);

// alterar só a qualidade do mesmo arquivo, lembrando que sempre que for mexer no mesmo arquivo, é só colocar 0 no 2º parametro
echo Img::resize($imgde,0,0,0,78);

//----------
*/



class Validar{
	function replace($s){
		return preg_replace('/\D/','',$s);
	}
	function fake($s){
		return preg_match('/^(.)\1*$/',$s);
	}
	function cpf($cpf){
		$cpf = $this->replace($cpf);
		if(!$cpf||strlen($cpf)!=11||$this->fake($cpf))return false;
		$sub = substr($cpf,0,9);
		for($i=0; $i<10; $i++)$dv += ($sub[$i]*(10-$i));
		if(!$dv)return false;
		$dv = 11-($dv%11); 
		if($dv>9)$dv = 0;
		if($cpf[9]!=$dv)return false;
		$dv *= 2;
		for($i=0; $i<10; $i++)$dv += ($sub[$i]*(11-$i));
		$dv = 11-($dv%11); 
		if($dv>9)$dv = 0;
		if($cpf[10]!=$dv)return false;
		return true;
	}
	function cnpj($cnpj){
		$cnpj = $this->replace($cnpj);
		if(!$cnpj||strlen($cnpj)!=14||$this->fake($cpf))return false;
		$rev = strrev(substr($cnpj,0,12));
		for($i=0; $i<12; $i++){
			if($i==0||$i==8)$m = 2;
			$sum += ($rev[$i]*$m++);
		}
		$rest = $sum%11;
		$a = $rest<2?0:11-$rest;
		$sub = substr($cnpj,0,12);
		$rev = strrev($sub.$a);
		unset($sum);
		for($i=0; $i<13; $i++){
			if($i==0||$i==8)$m = 2;
			$sum += ($rev[$i]*$m++);
		}
		$rest = $sum%11;
		$b = $rest<2?0:11-$rest;
		return $a==$cnpj[12]&&$b==$cnpj[13]?true:false;
	}
	function cartao($cartao, $cvc=false){
		$cartao = preg_replace("/[^0-9]/", "", $cartao);
		if($cvc) $cvc = preg_replace("/[^0-9]/", "", $cvc);
		
		$cartoes = array(
		'visa' => array('len' => array(13,16),    'cvc' => 3),
		'mastercard' => array('len' => array(16),       'cvc' => 3),
		'diners' => array('len' => array(14,16),    'cvc' => 3),
		'elo' => array('len' => array(16),       'cvc' => 3),
		'amex' => array('len' => array(15),       'cvc' => 4),
		'discover' => array('len' => array(16),       'cvc' => 4),
		'aura' => array('len' => array(16),       'cvc' => 3),
		'jcb' => array('len' => array(16),       'cvc' => 3),
		'hipercard'  => array('len' => array(13,16,19), 'cvc' => 3),
		);
		
		
		switch($cartao){
		case (bool) preg_match('/^(636368|438935|504175|451416|636297)/', $cartao) :
		$bandeira = 'elo'; 
		break;
		
		case (bool) preg_match('/^(606282)/', $cartao) :
		$bandeira = 'hipercard'; 
		break;
		
		case (bool) preg_match('/^(5067|4576|4011)/', $cartao) :
		$bandeira = 'elo'; 
		break;
		
		case (bool) preg_match('/^(3841)/', $cartao) :
		$bandeira = 'hipercard'; 
		break;
		
		case (bool) preg_match('/^(6011)/', $cartao) :
		$bandeira = 'discover'; 
		break;
		
		case (bool) preg_match('/^(622)/', $cartao) :
		$bandeira = 'discover'; 
		break;
		
		case (bool) preg_match('/^(301|305)/', $cartao) :
		$bandeira = 'diners'; 
		break;
		
		case (bool) preg_match('/^(34|37)/', $cartao) :
		$bandeira = 'amex'; 
		break;
		
		case (bool) preg_match('/^(36,38)/', $cartao) :
		$bandeira = 'diners'; 
		break;
		
		case (bool) preg_match('/^(64,65)/', $cartao) :
		$bandeira = 'discover'; 
		break;
		
		case (bool) preg_match('/^(50)/', $cartao) :
		$bandeira = 'aura'; 
		break;
		
		case (bool) preg_match('/^(35)/', $cartao) :
		$bandeira = 'jcb'; 
		break;
		
		case (bool) preg_match('/^(60)/', $cartao) :
		$bandeira = 'hipercard'; 
		break;
		
		case (bool) preg_match('/^(4)/', $cartao) :
		$bandeira = 'visa'; 
		break;
		
		case (bool) preg_match('/^(5)/', $cartao) :
		$bandeira = 'mastercard'; 
		break;
		}
		
		$dados_cartao = $cartoes[$bandeira];
		if(!is_array($dados_cartao)) return array(false, false, false);
		
		$valid     = true;
		$valid_cvc = false;
		
		if(!in_array(strlen($cartao), $dados_cartao['len'])) $valid = false;
		if($cvc AND strlen($cvc) <= $dados_cartao['cvc'] AND strlen($cvc) !=0) $valid_cvc = true;
		return array($bandeira, $valid, $valid_cvc);
	}
}


function buscaTrata($q,$f=0,$s=0){
	$q = preg_replace('/\\\\/','',$q);
	if(strlen(preg_replace('/[^"]/','',$q))%2==1)$q .= '"';
	$q = preg_replace('/"/',' " ',$q);
	$q = trim(preg_replace('/\s+/',' ',$q));
	$g = array();
	$p1 = 0;
	$p2 = 0;
	$a = false;
	while(($p1=strpos($q,'"',$p2))!==false){
		if(!$p2&&!$p1){
			$p2 = 1;
			continue;
		}
		if(!$p2)$a = true;
		$a = !$a;
		$t = trim(substr($q,$p2,$p1-$p2));
		if($t){
			if($a)$g[] = '"'.$t.'"';
			else $g = array_merge($g,explode(' ',$t));
		}
		$p2 = $p1+1;
	}
	$t = trim(substr($q,$p2));
	if($t)$g = array_merge($g,explode(' ',$t));
	if($f)$r = preg_replace('/\*{2,}/','*',implode('* ',$g).'*');
	else $r = implode(' ',$g);
	if($s===1)$r = str($r,1);
	return $r;
}



function linka($c,$b=1,$o=''){
	global $linkRE;
	return preg_replace_callback($linkRE,create_function('$m','$P = $m[2];$D = $m[3];$p = $m[4];$d = $m[5];if(!strlen($P)){$P = \'http://\';$D = $m[1];}$url = $D.$p.$d;return "<a href=\"".$P.$url."\"'.addslashes(($b?' target="_blank"':'').$o).'>".$url."</a>";'),$str);
}



// url
// v{valor}
// u{url}; se url==1, então url=valor; se !url e b==numeric, então retorna [span,strong,em] do valor; se !url, então retorna valor
// b{target blank}
// o{opções, atributos}
function url($v,$u=0,$b=0,$o=0){
	if($u===1)$u = $v;
	if(!$u&&$b===2)return '<span>'.$v.'</span>';
	if(!$u&&$b===3)return '<strong>'.$v.'</strong>';
	if(!$u&&$b===4)return '<em>'.$v.'</em>';
	if(!$u)return $v;
	return '<a href="'.$u.'"'.($b?' target="_blank"':'').($o?" $o":'').'>'.$v.'</a>';
}



function BBcodeurlcall($m){
	global $link2RE;
	$u = trim($m[1]);
	$t = trim($m[2]);
	if(preg_match($link2RE,$u,$m)){
		$P = $m[2];
		$D = $m[3];
		$p = $m[4];
		$d = $m[5];
		if(!strlen($P)){
			$P = 'http://';
			$D = $m[1];
		}
		$url = $D.$p.$d;
	}else{
		$P = '';
		$url = $u;
	}
	if(!$t)$t = $url;
	return '<a href="'.$P.$url.'" target="_blank">'.$t.'</a>';
}
function BBcode($str,$br=0){
	$str = htmlspecialchars($str,ENT_QUOTES);
	$c1 = array(
		'i'=>'<em>$1</em>',
		'b'=>'<strong>$1</strong>',
		'u'=>'<u>$1</u>',
		'img'=>'<img src=\"$1\"/>',
		'url'=>'[url=$1][/url]'
	);
	$c2 = array();
	$a = array();
	$b = array();
	foreach($c1 as $k=>$v){
		$a[] = '/\['.$k.'\](.*?)\[\/'.$k.'\]/is';
		$b[] = $v;
	}
	foreach($c2 as $k=>$v){
		$a[] = '/\['.$k.'=(.*?)\](.*?)\[\/'.$k.'\]/is';
		$b[] = $v;
	}
	$str = preg_replace($a,$b,$str);
	$str = preg_replace_callback('/\[url=(.*?)\](.*?)\[\/url\]/is','BBcodeurlcall',$str);
	if(is_string($br))$str = preg_replace('/\n/',"<br/>$br",$str);
	return $str;
}



function strg($v='',$s=0,$c=0,$h=0,$b=0,$u=0,$t=1,$g=1){
	return str($v,$s,$c,$h,$b,$u,$t,$g);
}
function strp($v='',$s=0,$c=0,$h=0,$b=0,$u=0,$t=1,$g=2){
	return str($v,$s,$c,$h,$b,$u,$t,$g);
}
function strr($v='',$s=0,$c=0,$h=0,$b=0,$u=0,$t=1,$g=3){
	return str($v,$s,$c,$h,$b,$u,$t,$g);
}

function strgr($v='',$c=0,$h=0,$b=0,$u=0,$t=1,$g=1){
	return str($v,-2,$c,$h,$b,$u,$t,$g);
}
function strpr($v='',$c=0,$h=0,$b=0,$u=0,$t=1,$g=2){
	return str($v,-2,$c,$h,$b,$u,$t,$g);
}
function strrr($v='',$c=0,$h=0,$b=0,$u=0,$t=1,$g=3){
	return str($v,-2,$c,$h,$b,$u,$t,$g);
}

function strgs($v='',$c=0,$h=0,$b=0,$u=0,$t=1,$g=1){
	return str($v,2,$c,$h,$b,$u,$t,$g);
}
function strps($v='',$c=0,$h=0,$b=0,$u=0,$t=1,$g=2){
	return str($v,2,$c,$h,$b,$u,$t,$g);
}
function strrs($v='',$c=0,$h=0,$b=0,$u=0,$t=1,$g=3){
	return str($v,2,$c,$h,$b,$u,$t,$g);
}

function strs($v='',$c=0,$h=0,$b=0,$u=0,$t=1,$g=0){
	return str($v,1,$c,$h,$b,$u,$t,$g);
}

function strh($v='',$s=0,$c=0,$h=3,$b=0,$u=0,$t=1,$g=0){
	return str($v,$s,$c,$h,$b,$u,$t,$g);
}

function strb($v='',$s=0,$c=0,$h=0,$b=2,$u=0,$t=1,$g=0){
	return str($v,$s,$c,$h,$b,$u,$t,$g);
}

function strhb($v='',$s=0,$c=0,$h=3,$b=2,$u=0,$t=1,$g=0){
	return str($v,$s,$c,$h,$b,$u,$t,$g);
}

function str($v='',$s=0,$c=0,$h=0,$b=0,$u=0,$t=1,$g=0){
	if(is_string($v)&&$g){
		$k = preg_split('/\s+/',trim($v));
		$v = NULL;
		foreach($k as $i=>$w){
			if($i===0){
				if($g===1)$v = $_GET[$w];
				elseif($g===2)$v = $_POST[$w];
				elseif($g===3)$v = $_REQUEST[$w];
				elseif(is_array($g))$v = $g[$w];
				elseif(is_object($g))$v = $g->$w;
			}else{
				if(is_array($v))$v = $v[$w];
				elseif(is_object($v))$v = $v->$w;
				else $v = NULL;
			}
		}
		$g = 0;
	}
	if(is_array($v)){
		foreach($v as $k=>$w)$v[$k] = str($w,$s,$c,$h,$b,$u,$t,$g);
		return $v;
	}
	if(is_object($v)){
		foreach($v as $k=>$w)$v->$k = str($w,$s,$c,$h,$b,$u,$t,$g);
		return $v;
	}
	if($t===1)$t = ' ';
	if($t&&is_string($v))$v = trim($v,$t);

	if($s>=3&&$s<=8){
		if($s===3)$v = (int)$v;
		if($s===4)$v = (float)$v;
		if($s===5)$v = preg_replace('/\D/','',$v)+0;
		if($s===6)$v = (float)str_replace(',','.',$v);
		if($s===7)$v = (int)str_replace(',','',$v);
		if($s===8)$v = (float)str_replace(',','',$v);
		if($c===1&&$v<0)$v = 0;
		if($c===2&&$v<0)$v = abs($v);
		return $v;
	}

	if(is_numeric($v))return "$v";
	if(is_bool($v))return $v?'true':'false';
	if(is_null($v))return '';
	if(!is_string($v))return $v;

	if($s===-2||$s===-1)$v = preg_replace('/(\\\\r)?\\\\n/',"\n",$v);
	if($s===-2&&get_magic_quotes_gpc())$s = -1;
	if($s===-1)$v = stripslashes($v);
	if($h&&$s===2&&get_magic_quotes_gpc()){
		$v = stripslashes($v);
		$s = 1;
	}

	if($h===-1)$v = htmlspecialchars_decode($v,ENT_COMPAT);
	if($h===-2)$v = htmlspecialchars_decode($v,ENT_NOQUOTES);
	if($h===-3)$v = htmlspecialchars_decode($v,ENT_QUOTES);
	if($h===1)$v = htmlspecialchars($v,ENT_COMPAT);
	if($h===2)$v = htmlspecialchars($v,ENT_NOQUOTES);
	if($h===3)$v = htmlspecialchars($v,ENT_QUOTES);

	if($s===2&&!get_magic_quotes_gpc())$s = 1;
	if($s===1)$v = addslashes($v);
	if($s===1||$s===2)$v = preg_replace('/\r?\n/','\n',$v);

	if($c===1)$v = mb_strtolower($v,'utf-8');
	if($c===2)$v = mb_strtoupper($v,'utf-8');

	if($b===1)$v = preg_replace('/<br\s?\/?>/i',"\n",$v);
	if($b===2)$v = nl2br($v);

	if($u===1)$v = utf8_decode($v);
	if($u===2)$v = utf8_encode($v);

	return $v;
}



function strf($v,$s=0,$c=1,$t=' '){
	if($s==-2)$v = htmlspecialchars("$v",ENT_QUOTES);
	if(($s==-2||$s==-1)&&get_magic_quotes_gpc())$v = stripslashes("$v");
	if($s==1&&!get_magic_quotes_gpc())$v = addslashes("$v");
	if($s==2)return preg_replace('/\D/','',$v)+0;
	if($s==3)$v = utf8_encode("$v");
	if($s==4)$v = utf8_decode("$v");
	if($c==1)$v = mb_strtolower($v,'utf-8');
	if($c==2)$v = mb_strtoupper($v,'utf-8');
	if($c==3)$v = nl2br($v);
	if($c==4)$v = preg_replace('/<br\s?\/?>/i',"\n",$v);
	if($t)$v = trim($v,$t);
	return $v;
}






function datef($t=0,$mk=13,$oha=0,$t2=0,$u=1){
	if(!$t)$t = time();
	if(is_string($t)&&is_string($t2))$t = strtotime($t);
	elseif(is_string($t)){
		$tmp = $t2;
		$t2 = $t;
		$t = $tmp?$tmp:time();
	}
	if(is_string($t2))$t = strtotime($t2,$t);
	/*if(!$t)$t = time();
	if(!$t2)$t2 = time();
	if(is_string($t2))$t2 = strtotime($t);
	if(is_string($t))$t = strtotime($t,$t2);*/
	if($mk===0)return $t;
	if($mk===1)$mk = '%A, %d de %B de %Y';
	if($mk===2)$mk = '%A, %d de %B de %Y %H:%M:%S';
	if($mk===3)$mk = '%A, %d de %B de %Y %H:%M';
	if($mk===4)$mk = '%A, %d de %B de %Y %Hh%M';
	if($mk===5)$mk = '%H:%M:%S';
	if($mk===6)$mk = '%H:%M';
	if($mk===7)$mk = '%Hh%M';
	if($mk===8)$mk = '%d/%m/%Y';
	if($mk===9)$mk = '%d/%m/%Y %H:%M:%S';
	if($mk===10)$mk = '%d/%m/%Y %H:%M';
	if($mk===11)$mk = '%d/%m/%Y %Hh%M';
	if($mk===12)$mk = '%Y-%m-%d';
	if($mk===13)$mk = '%Y-%m-%d %H:%M:%S';
	if($mk===14)$mk = '%Y-%m-%d %H:%M';
	if($mk===15)$mk = '%Y-%m-%d %Hh%M';
	if($mk===16)$mk = '%d/%m/%Y às %H:%M:%S';
	if($mk===17)$mk = '%d/%m/%Y às %H:%M';
	if($mk===18)$mk = '%d/%m/%Y às %Hh%M';
	if($mk===19)$mk = '%A, %d de %B de %Y às %H:%M:%S';
	if($mk===20)$mk = '%A, %d de %B de %Y às %H:%M';
	if($mk===21)$mk = '%A, %d de %B de %Y às %Hh%M';
	if($mk===22)$mk = '%d de %B de %Y às %H:%M:%S';
	if($mk===23)$mk = '%d de %B de %Y às %H:%M';
	if($mk===24)$mk = '%d de %B de %Y às %Hh%M';
	if($mk===25)$mk = '%d de %B de %Y';
	if($mk===26)$mk = '%d de %B de %Y %H:%M:%S';
	if($mk===27)$mk = '%d de %B de %Y %H:%M';
	if($mk===28)$mk = '%d de %B de %Y %Hh%M';
	if($mk===29)$mk = '%a, %d de %b de %Y às %H:%M:%S';
	if($mk===30)$mk = '%a, %d de %b de %Y às %H:%M';
	if($mk===31)$mk = '%a, %d de %b de %Y às %Hh%M';
	if($mk===32)$mk = '%a, %d de %b de %Y';
	if($mk===33)$mk = '%a, %d de %b de %Y %H:%M:%S';
	if($mk===34)$mk = '%a, %d de %b de %Y %H:%M';
	if($mk===35)$mk = '%a, %d de %b de %Y %Hh%M';
	if($mk===50)$mk = '%Y%m%d%H%M%S';
	if($mk===51)$mk = '%Y,%m,%d,%H,%M,%S';
	if($mk===52)$mk = 'new Date(%Y,%m,%d,%H,%M,%S)';
	if($mk===53)$mk = 'new Date(\'%Y-%m-%d %H:%M:%S\')';
	if($mk===60)$mk = '%d/%m';
	if($mk===61)$mk = '%B';
	if($mk===62)$mk = '%b';
	if($mk==='')$mk = '%Z';
	if($oha){
		$dt = datef($t,12);
		if($dt==datef('-1 day',12))$oha = 'ontem';
		elseif($dt==datef(0,12))$oha = 'hoje';
		elseif($dt==datef('+1 day',12))$oha = 'amanhã';
		$mk = templ($mk,array('mk'=>$oha));
	}
	$r = strftime(mb_convert_encoding($mk,'ISO-8859-1','UTF-8'),$t);
	if($u)$r = ucfirst($r);
	return mb_convert_encoding($r,'UTF-8','ISO-8859-1');
/*
%a – Dia da semana abreviado de acordo com a localidade
%A – Nome da semana completo de acordo com a localidade
%b – Nome do mês abreviado de acordo com a localidade
%B – Nome do mês completo de acordo com a localidade
%c – Representação da data e hora preferida pela a localidade
%C – Número do século (o ano dividido por 100 e truncado para um inteiro, de 00 até 99)
%d – Dia do mês como um número decimal (de 01 até 31)
%D – Mesmo que %m/%d/%y
%e - Dia do mês como um número decimal, um simples dígito é precedido por espaço (de ' 1' até '31')
%g – Como %G, mas sem o século.
%G – O 4-dígito do ano correspodendo as ISO week number (see %V). Este tem o mesmo formato e valor que %Y, exceto que se o ISO week number pertence ao prévio ou próximo ano, aquele ano é usado ao invés deste.
%h – Mesmo que %b
%H – Hora como um número decimal usando um relógio de 24-horas (de 00 até 23)
%I - Hora como um número decimal usando um relógio de 12-hoas (de 01 até 12)
%j – Dia do ano como número decimal (de 001 até 366)
%m – Mês como número decimal (de 01 até 12)
%M – Minuto como número decimal
%n – Caracter novalinha
%p - Um dos dois `am' ou `pm' de acordo com o valor da hora dada, ou as strings correspondentes para a localidade
%r - Hora em a.m. e p.m. notação
%R – Hora em notação de 24 horas
%S – Segundo como um número decimal
%t - Caracter tab
%T – Hora corrente, igual a %H:%M:%S
%u – Dia da semana como número decimal [1,7], com 1 representando Segunda-feira
%U – Dia da semana do ano corrente como número decimal, começando com o primeiro domingo como o primeiro dia da primeira semana
%V - O número da semana corrente ISO 8601:1988 do ano corrente como um número decimal, de 01 até 53, onde semana 1 é a primeira semana que tem pelo menos 4 dias no ano corrente, e com segunda-feira como o primeiro dia da semana. (Use %G ou %g para o componente anual que corresponde ao dia da semana para o para o timestamp especificado.)
%W – Dia da semana do ano corrente como número decimal, começando com o a segunda-feira como o primeiro dia da primera semana
%w – Dia da semana como número decimal, domingo sendo 0
%x – Representação preferida para a data para a localidade corrente sem a hora
%X - Representação preferida para a hora para a localidade corrente sem a data
%y - Ano como número decimal sem o século (de 00 até 99)
%Y - Ano como número decimal incluindo o século
%Z ou %z – Time zone, nome ou abreviação (dependendo do sistema operacional)
%% – A literal '%' characte
*/
}



function tag($v,$c=0,$s=0,$n=0,$e=0){
	if($s===1&&!is_string($n))$n = 1;
	if(!is_string($s))$s = '-';
	if($n===1)$n = $s;
	if(!is_string($n))$n = '_';
	$p = preg_replace('/([-[\]{}()*+?.,\\\\^$|#\s]])/','\\$1',$s);
	if(!$p)$p = ' ';
	if($e===1)$e = '';
	if($e===2)$e = 'utf-8';
	$a=array(
		'/À|Á|Â|Ã|Ä|Å|Ā|Ă|Ą|Ǻ|Ǎ/','/à|á|â|ã|ä|å|ā|ă|ą|ǎ|ǻ|ª|@/','/Æ|Ǽ/','/æ|ǽ/'
		,'/ß/'
		,'/Ç|Ć|Ĉ|Ċ|Č|¢/','/ç|ć|ĉ|ċ|č/'
		,'/Ð|Ď|Đ/','/ď|đ/'
		,'/È|É|Ê|Ë|Ē|Ĕ|Ė|Ę|Ě|€/','/è|é|ê|ë|ē|ĕ|ė|ę|ě|\&/'
		,'/ƒ/'
		,'/Ĝ|Ğ|Ġ|Ģ/','/ĝ|ğ|ġ|ģ/'
		,'/Ĥ|Ħ/','/ĥ|ħ/'
		,'/Ì|Í|Î|Ï|Ĩ|Ī|Ĭ|Į|İ|Ǐ/','/ì|í|î|ï|ĩ|ī|ĭ|į|ı|ǐ/','/Ĳ/','/ĳ/'
		,'/Ĵ/','/ĵ/'
		,'/Ķ/','/ķ/'
		,'/Ĺ|Ļ|Ľ|Ŀ|£/','/ĺ|ļ|ľ|ŀ|Ł|ł/'
		,'/Ñ|Ń|Ņ|Ň/','/ñ|ń|ņ|ň|ŉ/'
		,'/Ò|Ó|Ô|Õ|Ö|Ø|Ō|Ŏ|Ő|Ơ|Ǒ|Ǿ|º/','/ò|ó|ô|õ|ö|ø|ō|ŏ|ő|ơ|ǒ|ǿ/','/Œ/','/œ/'
		,'/Ŕ|Ŗ|Ř/','/ŕ|ŗ|ř/'
		,'/Ś|Ŝ|Ş|Š|§|\$/','/ś|ŝ|ş|š|ſ/'
		,'/Ţ|Ť|Ŧ/','/ţ|ť|ŧ|†/'
		,'/Ù|Ú|Û|Ü|Ũ|Ū|Ŭ|Ů|Ű|Ų|Ư|Ǔ|Ǖ|Ǘ|Ǚ|Ǜ/','/ù|ú|û|ü|ũ|ū|ŭ|ů|ű|ų|ư|ǔ|ǖ|ǘ|ǚ|ǜ/'
		,'/Ŵ/','/ŵ/'
		,'/Ý|Ÿ|Ŷ/','/ý|ÿ|ŷ/'
		,'/Ź|Ż|Ž/','/ź|ż|ž/'
		,'/¹/','/²/','/³/'
		,'/\s+|"|\'|#|%|!|\.|:|,|;|´|`|~|-|=|'.urldecode('%E2%80%93|%E2%80%98|%E2%80%99|%E2%80%9C|%E2%80%9D').'|\^|\+|\*|\?|\||\/|\\\\|\(|\)|\[|\]|\{|\}/'
		,'/([^0-9a-zA-Z'.preg_replace('/([-\\\]])/','\\$1',$s).'])/'
		,'/('.$p.')+/'
	);
	$b=array(
		'A','a','AE','ae'
		,'B'
		,'C','c'
		,'D','d'
		,'E','e'
		,'f'
		,'G','g'
		,'H','h'
		,'I','i','IJ','ij'
		,'J','j'
		,'K','k'
		,'L','l'
		,'N','n'
		,'O','o','OE','oe'
		,'R','r'
		,'S','s'
		,'T','t'
		,'U','u'
		,'W','w'
		,'Y','y'
		,'Z','z'
		,'1','2','3'
		,$s
		,$n
		,$s
	);
	$v = preg_replace($a,$b,is_string($e)?($e?htmlentities($v,ENT_NOQUOTES,$e):htmlentities($v,ENT_NOQUOTES)):$v);
	return str($v,0,$c,0,0,0,$s?$s:0);
}



function templ($s,$va=array()){
	foreach($va as $k=>$v)$s = preg_replace('/\[!'.$k.'!\]/',$v,$s);
	$s = preg_replace('/\[!!/','[!',$s);
	$s = preg_replace('/!!\]/','!]',$s);
	return $s;
}



function npeso($v,$m='.',$s=','){
	$v = (float)$v;
	return number_format($v,2,$s,$m);
}



function nreal($v,$m='.',$s=','){
	$v = (float)$v;
	return number_format($v,2,$s,$m);
}



function greal($v){
	return (float)str_replace(',','.',preg_replace('/[^\d,-\.]/','',$v));
}



function ireal($v,$g=0,$d=2,$s='',$m=''){
	if($g)$v = greal($v);
	if($s==''&&$m=='')return (int)number_format($v,$d,$s,$m);
	return number_format($v,$d,$s,$m);
}



function pgnl($qt=0,$qtp=0,$c=0){//QT: number ou sql; QTP: quantidade por pg; C: pg atual
	global $b;
	//echo "[$qt]";
	if(is_string($qt))$qt = ($rs=$b->query(strpos($qt,'select')===0?$qt:'select count(1) qt from '.$qt)->fetchObject())?$rs->qt+0:0;
	$A = 1;
	$B = $qt?ceil($qt/$qtp):1;
	$C = $c;
	if($C<$A)$C = $A;
	if($C>$B)$C = $B;
	$r->a = $A;// primeira pg
	$r->b = $B;// ultima pg
	$r->c = $C;// pg atual ou 1
	$r->e = $c===$C?false:true;// pg passada não está entre $A e $B

	$r->p = $qtp;// quantidade por pg
	$r->q = $qt;// total de registros

	$r->i = $C*$qtp-$qtp;// inicio do SQL limit
	$r->A = $r->i+1;// registro inicio
	$r->B = $C*$qtp;// registro fim
	if($r->B>$qt)$r->B = $qt;
	$r->l = $r->B-$r->i;// limite do SQL limit
	return $r;
}



function pgnbt($a,$b,$c,$q=0,$sp='',$lk,$nl=0,$at=0,$px=0,$pr=0,$ut=0,$nob=0){
	if($q){
		$i = $c-$q;
		$f = $c+$q;
		$si = $i<$a?$a-$i:0;
		$sf = $f>$b?$f-$b:0;
		$i -= $sf;
		$f += $si;
		if($i<$a)$i = $a;
		if($f>$b)$f = $b;
	}else{
		$i = $a;
		$f = $b;
	}
	if($nl===0)$nl = $lk;
	if($at===0)$at = 'Anterior';
	if($px===0)$px = 'Próximo';
	if($pr===0)$pr = 'Primeira';
	if($ut===0)$ut = 'Última';
	if($at===1){
		$at = '&lsaquo;';
		$px = '&rsaquo;';
		$pr = '&laquo;';
		$ut = '&raquo;';
	}
	if($at===2){
		$at = '&lt;';
		$px = '&gt;';
		$pr = '&lt;&lt;';
		$ut = '&gt;&gt;';
	}
	$bt = array();
	if(($pr&&!$nob)||($pr&&$nob&&$a!=$i))$bt[] = templ(($a==$c?$nl:$lk),array('num'=>$a,'txt'=>$pr));
	if(($at&&!$nob)||($at&&$nob&&$a!=$i))$bt[] = templ(($a==$c?$nl:$lk),array('num'=>$c-1,'txt'=>$at));
	for($j=$i; $j<=$f; $j++)$bt[] = templ(($j==$c?$nl:$lk),array('num'=>$j,'txt'=>$j));
	if(($px&&!$nob)||($px&&$nob&&$b!=$f))$bt[] = templ(($b==$c?$nl:$lk),array('num'=>$c+1,'txt'=>$px));
	if(($ut&&!$nob)||($ut&&$nob&&$b!=$f))$bt[] = templ(($b==$c?$nl:$lk),array('num'=>$b,'txt'=>$ut));
	return $sp.implode($sp,$bt);
}



function ford($a=array(),$h='',$p='',$l=0){
	global $s;
	$r->o = '';
	$r->o2 = '';
	$r->h = $h;
	$r->p = $p;
	$r->np = true;
	$r->dp = '';
	foreach($a as $v){
		$r->c->$v[1] = templ('<a href="'.$h.'" class="'.($p==$v[1]?'ord':($p==$v[1].'-d'?'ord d':'')).'">[!t!]</a>',array('h'=>$v[1].($p==$v[1]?'-d':''),'t'=>$v[2]));
		if($p==$v[1]){
			$r->o = $v[0];
			$r->np = false;
		}elseif($p==$v[1].'-d'){
			$r->o = $v[0].' desc';
			$r->np = false;
		}
		if($v[3]===1)$d = $v[1];
		elseif($v[3]===2)$d = $v[1].'-d';
		if($d)$r->dp = templ($h,array('h'=>$d));
	}
	if($l==1&&$r->np)$s->loc($r->dp);
	if($r->o)$r->o2 = 'order by '.$r->o;
	return $r;
}

function addhttp($url) {
    if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
        $url = "http://" . $url;
    }
    return $url;
}


class C{
	public $f = '';
	public $is = true;

	function __construct($f='',$t1=0,$t2=0){
		$this->f = $f;
		if(file_exists($f)){
			$this->is = false;
			if(($t1||$t2)&&filemtime($f)<=datef($t1,0,0,$t2))$this->is = true;
		}
	}

	public function a(){
		if($this->is)ob_start();
		return $this->is;
	}

	public function b(){
		if($this->is){
			file_put_contents($this->f,ob_get_contents());
			ob_end_flush();
		}else{
			if(file_exists($this->f)){
				global $s,$b;
				include $this->f;
			}
		}
	}

	public function c(){
		if($this->is){
			file_put_contents($this->f,ob_get_contents());
			ob_end_clean();
		}else{
			if(file_exists($this->f)){
				global $s,$b;
				include $this->f;
			}
		}
	}

	public function no($v=false){
		$this->is = $v;
	}
}

function limitaCaracteres($texto, $limite, $quebra = true){
   $tamanho = strlen($texto);
   if($tamanho <= $limite){ //Verifica se o tamanho do texto é menor ou igual ao limite
      $novo_texto = $texto;
   }else{ // Se o tamanho do texto for maior que o limite
      if($quebra == true){ // Verifica a opção de quebrar o texto
         //$novo_texto = trim(substr($texto, 0, $limite))."...";
		 $novo_texto = trim(substr($texto, 0, $limite));
      }else{ // Se não, corta $texto na última palavra antes do limite
         $ultimo_espaco = strrpos(substr($texto, 0, $limite), " "); // Localiza o útlimo espaço antes de $limite
         //$novo_texto = trim(substr($texto, 0, $ultimo_espaco))."..."; // Corta o $texto até a posição localizada
		 $novo_texto = trim(substr($texto, 0, $ultimo_espaco)); // Corta o $texto até a posição localizada
      }
   }
   return $novo_texto; // Retorna o valor formatado
}

function validaFone($tel){
	return preg_match('/^(?:(?:\+|00)?(55)\s?)?(?:\(?([1-9][0-9])\)?\s?)?(?:((?:9\d|[2-9])\d{3})\-?(\d{4}))$/', $tel);
}

class Inline{
	private static $in = array();
	private static $init = 0;

	public static function a(){
		if(self::$init)return;
		self::$init = 1;
		ob_start();
	}

	public static function b(){
		if(!self::$init)return;
		$cnt = ob_get_contents();
		if($cnt)self::$in[] = $cnt;
		ob_end_clean();
	}

	public static function write(){
		foreach(self::$in as $v){
			echo $v;
		}
	}
}

function imgWebp($img){
	$find = array('/.jpg/','/.jpeg/','/.png/','/.gif/');
	return $result = preg_replace($find,'.webp',$img);
}