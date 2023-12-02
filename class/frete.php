<?php
ini_set('display_errors',1);
ini_set('max_execution_time',10); 
error_reporting(E_ERROR | E_PARSE);
require_once('class/PgsFrete.php');
class SysFrete extends Sys{
	public $ps;
	public $cepO;
	public $codigoCorreios;
	public $senhaCorreios;
	public $frete;
	public $FreteGratis = false;
	public $FreteGratisValor = 250;
	public $FreteDesconto = 0;

	function __construct(){
		$this->ps->frete = new PgsFrete();
	}

	public function checkout($r=1){
		global $s;
		global $b;
		$cookie_frete = $_SESSION["cookie_cart"];
		if($s->idc)$rp = $b->query("select * from cart where idu='{$s->idc}' and s=1 order by id desc")->fetchObject();
		if(!$s->end->cep||!$rp){
			if(!is_array($this->frete)&&!is_object($this->frete)){
				$this->frete->ok = 0;
				$this->frete->e = !$rp?'O carrinho está vazio.':(!$s->idc?'Faça login ou cadastre-se para calcular o frete.':(!$s->end->cep?'Digite os dados do Endereço de Entrega.':''));
				$this->frete->pac = 0;
				$this->frete->sedex = 0;
				$this->frete->peso = 0;
				$this->frete->valor = 0;
			} 
		}else{
			//$rm = $b->query("select p.val_altura altura,p.val_comprimento largura,p.val_profund comprimento from cart c left join cart_ax a on c.id=a.idc left join PRODUTOS p on a.idp=p.id_produto where c.idu='{$s->idc}' and c.s=1 and c.id='{$rp->id}'")->fetchObject();
			
			$rm = $b->query("select max(p.altura) altura,max(p.comprimento) comprimento,max(p.largura) largura,count(a.id) qtd from cart c left join cart_ax a on c.id=a.idc left join produto p on a.idp=p.id where c.idu='{$s->idc}' and c.s=1 and c.id='{$rp->id}'")->fetchObject();
			$peso = 0;
			$valor = 0;
			$codigo = '';
			$senha = '';
			$formato = 1;
			$comprimento = $rm->comprimento;
			$altura = $rm->altura;
			$largura = $rm->largura;
			$diametro = '0';
			$mao = 'n';
			$recebimento = 'n';
			$retorno = 'xml';
			$servico = '41106,40010';//SEM CONTRATO ou 04510 e 04014
			//$servico = '04669,04162';//COM CONTRATO
			if($s->idc){
				$scart_peso = $b->query("select a.*,p.peso from cart_ax a inner join produto p on a.idp=p.id where a.idc='{$rp->id}'");
				while($rcart_peso=$scart_peso->fetchObject()){
					if($rcart_peso->p!=$rcart_peso->peso)$b->exec("update cart_ax set p='{$rcart_peso->peso}' where id='{$rcart_peso->id}' limit 1"); 
				}
				$ra = $b->query("select sum(p*q) as peso,sum(t) total from cart_ax where idc='{$rp->id}'")->fetchObject();
			}
			else{
				$scart_peso = $b->query("select a.*,p.peso from cart_ax_temp a inner join produto p on a.idp=p.id where a.idc='{$rp->id}'");
				while($rcart_peso=$scart_peso->fetchObject()){
					if($rcart_peso->p!=$rcart_peso->peso)$b->exec("update cart_ax set p='{$rcart_peso->peso}' where id='{$rcart_peso->id}' limit 1"); 
				}
				$ra = $b->query("select sum(p*q) as peso,sum(t) total from cart_ax_temp where idc='{$rp->id}'")->fetchObject();
			}
			$valor = $ra->total;
			//$peso = (float)$ra->peso/1000;//SE PESO ESTIVER EM GRAMS
			$peso = (float)$ra->peso;
			$cubagem = $comprimento*$altura*$largura/6000;
			$cubagem = number_format($cubagem, 3, '.', ',');
			$comprimento = $comprimento>=16?$comprimento:16;
			$altura = $altura>=2?$altura:2;
			$largura = $largura>=11?$largura:11;
			$valor_declarado = 0;//SE COBRAM O VALOR DO PEDIDO DO CLIENTE USAR $valor_declarado ELSE usar $valor
			//if(!$s->cep)$s->cep = $this->end->cep;

			$fretePac = 0;
			$freteSedex = 0;
			if($peso>30){
				do{
					if($peso>30)$pesoCal = 30;	
					else $pesoCal = $peso;
					$peso = $peso - 30;
					$pesoCal = $cubagem>=10&&$cubagem>$pesoCal?$cubagem:$pesoCal;
					$this->frete = $this->ps->frete->gerar($codigo,$senha,$s->cepO,$s->cep,$pesoCal,$formato,$comprimento,$altura,$largura,$diametro,$mao,$valor_declarado,$recebimento,$retorno,$servico);
					//echo 'PAC: '.$this->frete->pac.'<br>';
					$fretePac+= $this->frete->pac;
					$freteSedex+= $this->frete->sedex;
				}while($peso&&$peso>0);
			}else{
				$this->frete = $this->ps->frete->gerar($codigo,$senha,$s->cepO,$s->cep,$peso,$formato,$comprimento,$altura,$largura,$diametro,$mao,$valor_declarado,$recebimento,$retorno,$servico);
				$fretePac = $this->frete->pac;
				$freteSedex = $this->frete->sedex;
			}

			$this->frete->altura = $altura;
			$this->frete->largura = $largura;
			$this->frete->comprimento = $comprimento;
			$this->frete->peso = $peso;
			$this->frete->cubagem = $cubagem;
			$this->frete->valor = $valor;
			$gratis = $b->query("select frete,vf from dados where id=1")->fetchObject();
			//if($gratis->frete&&$valor>=$gratis->vf)$fretePac = '0.00';//SÓ PAC GRÁTIS
			//if($this->FreteGratis&&$valor>=$this->FreteGratisValor)$this->frete->pac = '0.00';//SÓ PAC GRÁTIS
			$this->frete->pac = $fretePac;
			$this->frete->pacReal = nreal($fretePac);
			$this->frete->sedex = $freteSedex;
			$this->frete->sedexReal = nreal($freteSedex);
			if($this->FreteDesconto){
				$this->frete->pac = $this->frete->pac * $this->FreteDesconto;
				$this->frete->pacReal = nreal($this->frete->pac);
				$this->frete->sedex = $this->frete->sedex * $this->FreteDesconto;
				$this->frete->sedexReal = nreal($this->frete->sedex);
			}
		}
		if($r)return $this->frete;
	}

	public function cart($r=1){
		global $s;
		global $b;
		$cookie_frete = $_SESSION["cookie_cart"];
		if($s->idc)$rp = $b->query("select * from cart where idu='{$s->idc}' and s=1 order by id desc")->fetchObject();
		else $rp = $b->query("select * from cart_temp where cookie='$cookie_frete' and s=1 order by id desc")->fetchObject();
		if(!$s->cep||!$rp){
			if(!is_array($this->frete)&&!is_object($this->frete)){
				$this->frete->ok = 0;
				$this->frete->e = !$rp?'O carrinho está vazio.':(!$s->idc?'Faça login ou cadastre-se para calcular o frete.':(!$s->cep?'Digite os dados do Endereço de Entrega.':''));
				$this->frete->pac = 0;
				$this->frete->sedex = 0;
				$this->frete->peso = 0;
				$this->frete->valor = 0;
			}
		}else{
			//$rm = $b->query("select p.altura altura,p.largura largura,p.comprimento comprimento from cart c left join cart_ax a on c.id=a.idc left join produto p on a.idp=p.id where c.idu='{$s->idc}' and c.s=1 and c.id='{$rp->id}'")->fetchObject();
			
			if($s->idc)$rm = $b->query("select max(p.altura) altura,max(p.largura) largura,max(p.comprimento) comprimento,count(a.id) qtd from cart c left join cart_ax a on c.id=a.idc left join produto p on a.idp=p.id where c.idu='{$s->idc}' and c.s=1 and c.id='{$rp->id}'")->fetchObject();
			else $rm = $b->query("select max(p.altura) altura,max(p.largura) largura,max(p.comprimento) comprimento,count(a.id) qtd from cart_temp c left join cart_ax_temp a on c.id=a.idc left join produto p on a.idp=p.id where c.cookie='$cookie_frete' and c.s=1 and c.id='{$rp->id}'")->fetchObject();
			$peso = 0;
			$valor = 0;
			$codigo = '';
			$senha = '';
			$formato = 1;
			$comprimento = $rm->comprimento;
			$altura = $rm->altura;
			$largura = $rm->largura;
			$diametro = '0';
			$mao = 'n';
			$recebimento = 'n';
			$retorno = 'xml';
			$servico = '41106,40010';//SEM CONTRATO
			//$servico = '04669,04162';//COM CONTRATO
			if($s->idc){
				$scart_peso = $b->query("select a.*,p.peso from cart_ax a inner join produto p on a.idp=p.id where a.idc='{$rp->id}'");
				while($rcart_peso=$scart_peso->fetchObject()){
					if($rcart_peso->p!=$rcart_peso->peso)$b->exec("update cart_ax set p='{$rcart_peso->peso}' where id='{$rcart_peso->id}' limit 1"); 
				}
				$ra = $b->query("select sum(p*q) as peso,sum(t) total from cart_ax where idc='{$rp->id}'")->fetchObject();
			}
			else{
				$scart_peso = $b->query("select a.*,p.peso from cart_ax_temp a inner join produto p on a.idp=p.id where a.idc='{$rp->id}'");
				while($rcart_peso=$scart_peso->fetchObject()){
					if($rcart_peso->p!=$rcart_peso->peso)$b->exec("update cart_ax_temp set p='{$rcart_peso->peso}' where id='{$rcart_peso->id}' limit 1");
				}
				$ra = $b->query("select sum(p*q) as peso,sum(t) total from cart_ax_temp where idc='{$rp->id}'")->fetchObject();
			}
			$valor = $ra->total;
			$peso = (float)$ra->peso;
			$cubagem = $comprimento*$altura*$largura/6000;
			$cubagem = number_format($cubagem, 3, '.', ',');
			$comprimento = $comprimento>=16?$comprimento:16;
			$altura = $altura>=2?$altura:2;
			$largura = $largura>=11?$largura:11;
			$valor_declarado = 0;//SE COBRAM O VALOR DO PEDIDO DO CLIENTE USAR $valor_declarado ELSE usar $valor
			//if(!$s->cep)$s->cep = $this->end->cep;

			$fretePac = 0;
			$freteSedex = 0;
			//$peso = 91;
			if($peso>30){
				do{
					if($peso>30)$pesoCal = 30;	
					else $pesoCal = $peso;
					$peso = $peso - 30;
					$pesoCal = $cubagem>=10&&$cubagem>$pesoCal?$cubagem:$pesoCal;
					$this->frete = $this->ps->frete->gerar($codigo,$senha,$s->cepO,$s->cep,$pesoCal,$formato,$comprimento,$altura,$largura,$diametro,$mao,$valor_declarado,$recebimento,$retorno,$servico);
					//echo 'PAC: '.$this->frete->pac.'<br>';
					$fretePac+= $this->frete->pac;
					$freteSedex+= $this->frete->sedex;
				}while($peso&&$peso>0);
			}else{
				$this->frete = $this->ps->frete->gerar($codigo,$senha,$s->cepO,$s->cep,$peso,$formato,$comprimento,$altura,$largura,$diametro,$mao,$valor_declarado,$recebimento,$retorno,$servico);
				$fretePac = $this->frete->pac;
				$freteSedex = $this->frete->sedex;
			}

			$this->frete->altura = $altura;
			$this->frete->largura = $largura;
			$this->frete->comprimento = $comprimento;
			$this->frete->peso = $peso;
			$this->frete->cubagem = $cubagem;
			$this->frete->valor = $valor;
			$gratis = $b->query("select frete,vf from dados where id=1")->fetchObject();
			//if($gratis->frete&&$valor>=$gratis->vf)$fretePac = '0.00';//SÓ PAC GRÁTIS
			//if($this->FreteGratis&&$valor>=$this->FreteGratisValor)$this->frete->pac = '0.00';//SÓ PAC GRÁTIS
			if($gratis->frete&&$valor>=$gratis->vf)$this->frete->gratis = 1;
			$this->frete->pac = $fretePac;
			$this->frete->pacReal = nreal($fretePac);
			$this->frete->sedex = $freteSedex;
			$this->frete->sedexReal = nreal($freteSedex);
			if($this->FreteDesconto){
				$this->frete->pac = $this->frete->pac * $this->FreteDesconto;
				$this->frete->pacReal = nreal($this->frete->pac);
				$this->frete->sedex = $this->frete->sedex * $this->FreteDesconto;
				$this->frete->sedexReal = nreal($this->frete->sedex);
			}
		}
		if($r)return $this->frete;
	}
}
$FRETE = new SysFrete();