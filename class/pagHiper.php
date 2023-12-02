<?php
class pagHiper{
	public function gerarBoleto($data){
		$data_post = json_encode($data);
		$url = "http://api.paghiper.com/transaction/create/";
		return $this->curl($data_post,$url);
		// Exemplo de como capturar a resposta json
		//$transaction_id = $json['create_request']['transaction_id'];
		//$url_slip = $json['create_request']['bank_slip']['url_slip'];
		//$digitable_line = $json['create_request']['bank_slip']['digitable_line'];
	}
	public function cancelarBoleto($data){
		$data_post = json_encode($data);
		$url = "http://api.paghiper.com/transaction/cancel/";
		return $this->curl($data_post,$url);
		//$json['cancellation_request']['response_message']; // Exemplo de como capturar a resposta json
	}
	public function notification($data){
		$data_post = json_encode($data);
		$url = "http://api.paghiper.com/transaction/notification/";
		return $this->curl($data_post,$url);
		//$json['cancellation_request']['response_message']; // Exemplo de como capturar a resposta json
	}
	public function curl($data_post,$url){
		$mediaType = "application/json"; // formato da requisição
		$charSet = "UTF-8";
		$headers = array();
		$headers[] = "Accept: ".$mediaType;
		$headers[] = "Accept-Charset: ".$charSet;
		$headers[] = "Accept-Encoding: ".$mediaType;
		$headers[] = "Content-Type: ".$mediaType.";charset=".$charSet;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_post);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$result = curl_exec($ch);
		$json = json_decode($result, true);
		// captura o http code
		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		if($httpCode!=201)$json = 'ERRO: '.$result;// CÓDIGO 201 SIGNIFICA QUE O BOLETO FOI GERADO COM SUCESSO
		return $json;
	}
}
$PAGHIPER = new pagHiper();