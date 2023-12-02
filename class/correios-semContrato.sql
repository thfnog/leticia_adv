CREATE TABLE IF NOT EXISTS correios(
id int(10) unsigned NOT NULL AUTO_INCREMENT,
cepInicial int(8) unsigned COMMENT 'cep inicial',
cepFinal int(8) unsigned COMMENT 'cep final',
pesoInicial int(5) unsigned COMMENT 'peso inicial',
pesoFinal int(5) unsigned COMMENT 'peso final',
custoEntrega DECIMAL(10,2) NULL DEFAULT 0 COMMENT 'valor',
prazoEntrega int(3) unsigned COMMENT 'prazo de Entraga',
metodo char(15) DEFAULT NULL COMMENT 'metodo de entrega',
uf char(2) DEFAULT NULL COMMENT 'estado',
PRIMARY KEY (id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Pac sem Contrato 04510 e Sedex sem Contrato 04014';