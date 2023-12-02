<?
class PgsFrete{
    public function gerar($codigo,$senha,$origem,$destino,$peso,$formato,$comprimento,$altura,$largura,$diametro,$mao,$valor,$recebimento,$retorno,$servico){
		global $b;
		if(is_numeric($peso))$peso = "$peso";
		if(is_numeric($valor))$valor = "$valor";
		if(is_string($peso))$peso = str_replace('.',',',$peso);
		if(is_string($valor))$valor = str_replace('.',',',$valor);
		$data['nCdEmpresa'] = $codigo;
		$data['sDsSenha'] = $senha;
		$data['sCepOrigem'] = $origem;
		$data['sCepDestino'] = $destino;
		$data['nVlPeso'] = $peso;
		$data['nCdFormato'] = $formato;// 1 para caixa / pacote e 2 para rolo/prisma.
		$data['nVlComprimento'] = $comprimento;
		$data['nVlAltura'] = $altura;
		$data['nVlLargura'] = $largura;
		$data['nVlDiametro'] = $diametro;
		$data['sCdMaoPropria'] = $mao;//Mão própria, nesse parâmetro você informa se quer a encomenda deverá ser entregue somente para uma determinada pessoa após confirmação por RG. Use “s” para declarar e “n” para não declarar
		$data['nVlValorDeclarado'] = $valor;
		$data['sCdAvisoRecebimento'] = $recebimento;
		$data['StrRetorno'] = $retorno;
		$data['nCdServico'] = $servico;
		$data = http_build_query($data);

		$destino2 = str_replace('-','',$destino);
		$cepOff = str_replace('-','',$destino);
		$pesoPonto = str_replace(',','.',$peso);
		$pesoOff = $pesoPonto*1000;

		$url = "http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx";
		$r->url = 'URL: '.$url.'?'.$data;
		$curl = curl_init($url.'?'.$data);
		curl_setopt($curl, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
		curl_setopt($curl, CURLOPT_TIMEOUT, '5');
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

		$result = curl_exec($curl);
		$result = simplexml_load_string($result);
		if($result)foreach($result->cServico as $row){
			if($row->Codigo=="41106"){//COM CONTRATO: 04669 SEM CONTRATO 41106 ou 04510
				if($row->Erro=="0"||$row->Erro=="010"||$row->Erro=="011"||!$row->Erro){
					$r->ok = 1;
					$r->e = '';
					$valor = str_replace(",",".",$row->Valor);
					$r->pac = $valor;//SEM JUROS
					$r->pacReal = nreal($r->pac);//SEM JUROS
					//$r->pac .= $valor / 0.90;//COM JUROS
					$r->gratis = $s->PACGratis.': '.$s->PACGratisValor;
					//if($s->PACGratis&&$prodValor>=$s->PACGratisValor)$r->pac = '0.00';
					$r->q = $q;
					$r->pacPrazo .= $row->PrazoEntrega;
					$r->pacOk = 1;
					$r->altura = $altura;
					$r->largura = $largura;
					$r->comprimento = $comprimento;
					$r->peso = $peso;
					$r->cubagem = $cubagem;
					if($row->Erro)$r->pacErro = $row->Erro.': '.$row->MsgErro;
				}else{
					$getPAC = $b->query("select * from correios where '$cepOff' between cepInicial and cepFinal and '$pesoOff' between pesoInicial and pesoFinal and metodo='PAC'");
					if($getPAC->rowCount()){
						$pac = $getPAC->fetchObject();					
						$r->ok = $r->pacOk = 1;
						$r->pac = $pac->custoEntrega;
						$r->pacReal = nreal($pac->custoEntrega);
						$r->pacPrazo = $pac->prazoEntrega;
					}else{
						$r->ok = 0;
						//$r->m = $r->e = $row->MsgErro;
						$r->pacErro = $row->Erro.': '.$row->MsgErro;
						$r->pac = 0;
						$r->pacOk = 0;
						$valor = str_replace(",",".",$row->Valor);
						$r->pacValorErro .= $valor / 0.90;//CONTRATO
					}
				}
			}
			if($row->Codigo=="40010"){//COM CONTRATO: 04162 SEM CONTRATO 40010 ou 04014
				if($row->Erro==0||$row->Erro=="010"||$row->Erro=="011"){
					$r->ok = 1;
					$valor = str_replace(",",".",$row->Valor);
					$r->sedex = $valor;//SEM JUROS
					$r->sedexReal = nreal($r->sedex);//SEM JUROS
					//$r->sedex .= $valor / 0.90;//COM JUROS
					$r->q = $q;
					$r->sedexPrazo .= $row->PrazoEntrega;
					$r->sedexOk = 1;
					if($row->Erro)$r->sedexErro = $row->Erro.': '.$row->MsgErro;
				}else{
					$getSEDEX = $b->query("select * from correios where '$cepOff' between cepInicial and cepFinal and '$pesoOff' between pesoInicial and pesoFinal and metodo='SEDEX'");
					if($getSEDEX->rowCount()){
						$sedex = $getSEDEX->fetchObject();					
						$r->ok = $r->sedexOk = 1;
						$r->sedex = $sedex->custoEntrega;
						$r->sedexReal = nreal($sedex->custoEntrega);
						$r->sedexPrazo = $sedex->prazoEntrega;
					}else{
						$r->ok = 0;
						$r->sedexErro = $row->Erro.': '.$row->MsgErro;
						$r->sedex = 0;
						$r->sedexOk = 0;
						$valor = str_replace(",",".",$row->Valor);
						$r->sedexValorErro .= $valor / 0.90;//CONTRATO
					}
				}
			}
		}else{
			$getPAC = $b->query("select * from correios where '$cepOff' between cepInicial and cepFinal and '$pesoOff' between pesoInicial and pesoFinal and metodo='PAC'");
			if($getPAC->rowCount()){
				$pac = $getPAC->fetchObject();					
				$r->ok = $r->pacOk = 1;
				$r->pac = $pac->custoEntrega;
				$r->pacReal = nreal($pac->custoEntrega);
				$r->pacPrazo = $pac->prazoEntrega;
			}
			$getSEDEX = $b->query("select * from correios where '$cepOff' between cepInicial and cepFinal and '$pesoOff' between pesoInicial and pesoFinal and metodo='SEDEX'");
			if($getSEDEX->rowCount()){
				$sedex = $getSEDEX->fetchObject();					
				$r->ok = $r->sedexOk = 1;
				$r->sedex = $sedex->custoEntrega;
				$r->sedexReal = nreal($sedex->custoEntrega);
				$r->sedexPrazo = $sedex->prazoEntrega;
			}
		}
		return $r;
	}
}