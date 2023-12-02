CREATE TABLE IF NOT EXISTS user (
id int(10) unsigned NOT NULL AUTO_INCREMENT,
s tinyint(3) unsigned DEFAULT '1' COMMENT 'status; 1-ativo',
t tinyint(3) unsigned DEFAULT '2' COMMENT 'tipo de usuário',
dc datetime DEFAULT NULL COMMENT 'data cadastrado',
da datetime DEFAULT NULL COMMENT 'data alterado',
n varchar(255) DEFAULT NULL COMMENT 'nome',
tag varchar(255) DEFAULT NULL COMMENT 'tag',
u varchar(255) DEFAULT NULL COMMENT 'usuario',
email varchar(255) DEFAULT NULL COMMENT 'email',
cod char(32) DEFAULT NULL COMMENT 'código para email: quando c=0, cod para ativar email; quando c=1, cod para esquecer a senha',
p char(40) DEFAULT NULL COMMENT 'senha',
PRIMARY KEY (id),
KEY s (s),
KEY t (t),
KEY dc (dc),
KEY da (da)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Admin';

insert into user values
(1,1,1,now(),null,'Administrador','administrador','admin','richard@alquati.com.br',null,'40bd001563085fc35165329ea1ff5c5ecbdbbeef'),
(2,1,1,now(),null,'Administrador','administrador','administrador','rodrigo@alquati.com.br',null,'b2f557d99dd7e3644573ea2396a048f45bdc0697');



CREATE TABLE IF NOT EXISTS jbr_file (
id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
m TINYINT UNSIGNED NULL COMMENT 'movido; 1-movido',
d TINYINT UNSIGNED NULL COMMENT 'deletado; 1-deletado',
e TINYINT UNSIGNED NULL COMMENT 'error',
s INT UNSIGNED NULL COMMENT 'size',
w INT UNSIGNED NULL COMMENT 'width',
h INT UNSIGNED NULL COMMENT 'height',
dc DATETIME NULL COMMENT 'data cadastrado',
dm DATETIME NULL COMMENT 'data movido',
dd DATETIME NULL COMMENT 'data deletado',
t varchar(255) NULL COMMENT 'type',
f varchar(255) NULL COMMENT 'nome gerado + extensao do arquivo',
tf TEXT NULL COMMENT 'caminho temporario + nome gerado + extensao do arquivo',
nf TEXT NULL COMMENT 'novo caminho completo quando movido',
n varchar(255) NULL COMMENT 'nome original do arquivo',
nm varchar(255) NULL COMMENT 'nome original do arquivo sem extensao',
tn varchar(255) NULL COMMENT 'tag do nome original do arquivo sem extensao',
ex varchar(255) NULL COMMENT 'extensao do arquivo',
KEY m (m),
KEY e (e)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='jbr_file; salva todos os uploads';



CREATE TABLE IF NOT EXISTS metatag (
id int(10) unsigned NOT NULL AUTO_INCREMENT,
dc datetime DEFAULT NULL COMMENT 'data cadastrado',
da datetime DEFAULT NULL COMMENT 'data alterado',
pg varchar(255) DEFAULT NULL COMMENT 'página',
d text COMMENT 'description',
t text COMMENT 'title',
h1 text COMMENT 'h1',
PRIMARY KEY (id),
KEY dc (dc),
KEY da (da),
KEY pg (pg)
)ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='meta tags do site';


CREATE TABLE slugs (
id int(10) unsigned NOT NULL AUTO_INCREMENT,
idp INT UNSIGNED NULL DEFAULT 0 COMMENT 'id do post',
dc datetime DEFAULT NULL COMMENT 'data cadastrado',
da datetime DEFAULT NULL COMMENT 'data alterado',
slug varchar(255) DEFAULT NULL COMMENT 'slug',
page varchar(255) DEFAULT NULL COMMENT 'Página',
PRIMARY KEY (id),
KEY slug (slug),
KEY page (page),
KEY dc (dc),
KEY da (da)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Slugs do site';


CREATE TABLE IF NOT EXISTS fotos(
id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
idp INT UNSIGNED NULL DEFAULT 0 COMMENT 'id do post',
tipo varchar(255) NULL COMMENT 'tipo de post',
principal TINYINT UNSIGNED NULL DEFAULT 0 COMMENT 'principal; 1-ativo',
hover TINYINT UNSIGNED NULL DEFAULT 0 COMMENT 'hover; 1-ativo',
o INT UNSIGNED DEFAULT 0 COMMENT 'ordem das fotos',
dc DATETIME NULL COMMENT 'data cadastrado',
da DATETIME NULL COMMENT 'data alterado',
i varchar(255) NULL COMMENT 'img',
it varchar(255) NULL COMMENT 'img thumb',
itc varchar(255) NULL COMMENT 'img thumb carrinho',
ith varchar(255) NULL COMMENT 'img thumb home',
iti varchar(255) NULL COMMENT 'img thumb interna',
itm varchar(255) NULL COMMENT 'img thumb miniatura',
itr varchar(255) NULL COMMENT 'img thumb relacionados',
itu varchar(255) NULL COMMENT 'img thumb últimos',
alt varchar(255) NULL COMMENT 'Alt da imagem',
title varchar(255) NULL COMMENT 'Title da imagem',
KEY principal(principal),
KEY dc(dc),
KEY da(da)
)ENGINE = InnoDB DEFAULT CHARSET=utf8 COMMENT='Fotos do Post';

CREATE TABLE IF NOT EXISTS grupo (
id int(10) unsigned NOT NULL AUTO_INCREMENT,
dc datetime DEFAULT NULL COMMENT 'data cadastrado',
da datetime DEFAULT NULL COMMENT 'data alterado',
n varchar(255) DEFAULT NULL COMMENT 'nome',
t varchar(255) DEFAULT NULL COMMENT 'tag',
d text COMMENT 'descrição',
PRIMARY KEY (id),
KEY dc (dc),
KEY da (da),
KEY t (t)
)ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COMMENT='Grupo de E-mails';

INSERT INTO grupo VALUES (1,'2017-10-02 11:05:21',NULL,'Cadastrado Pelo Site','cadastrado-pelo-site',''),(2,'2017-10-02 11:05:21',NULL,'Cadastro Administrador','cadastro-administrador','');

CREATE TABLE IF NOT EXISTS email (
id int(10) unsigned NOT NULL AUTO_INCREMENT,
idg int(10) unsigned DEFAULT '0' COMMENT 'id do grupo de E-mails',
s tinyint(3) unsigned DEFAULT '1' COMMENT 'receber E-mail; 0-a pessoa optou por não receber; 1-ativo',
dc datetime DEFAULT NULL COMMENT 'data cadastrado',
da datetime DEFAULT NULL COMMENT 'data alterado',
n varchar(255) DEFAULT NULL COMMENT 'nome',
email varchar(255) DEFAULT NULL COMMENT 'email',
PRIMARY KEY (id),
KEY idg (idg),
KEY s (s),
KEY dc (dc),
KEY da (da),
KEY email (email)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='E-mail para marketing';

CREATE TABLE IF NOT EXISTS blog (
id int(10) unsigned NOT NULL AUTO_INCREMENT,
idu int(10) unsigned DEFAULT NULL COMMENT 'id do usuário',
dc datetime DEFAULT NULL COMMENT 'data cadastrado',
da datetime DEFAULT NULL COMMENT 'data alterado',
dp date DEFAULT NULL COMMENT 'data do post',
m varchar(255) DEFAULT NULL COMMENT 'mês do post',
s tinyint(3) unsigned DEFAULT '1' COMMENT 'status: 1-ativo;',
h1 varchar(255) NULL COMMENT 'título (h1)',
n varchar(255) NULL COMMENT 'slug (url)',
t varchar(255) DEFAULT NULL COMMENT 'tag',
d longtext COMMENT 'descrição',
r text COMMENT 'resumo da descrição',
tagd varchar(255) DEFAULT NULL COMMENT 'meta tag:description',
tagt varchar(255) DEFAULT NULL COMMENT 'meta tag:title',
PRIMARY KEY (id),
KEY s (s),
KEY dc (dc),
KEY da (da)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Blog';

CREATE TABLE IF NOT EXISTS portfolio (
id int(10) unsigned NOT NULL AUTO_INCREMENT,
idu int(10) unsigned DEFAULT NULL COMMENT 'id do usuário',
id_icone int(10) unsigned DEFAULT NULL COMMENT 'id do icone',
oh INT UNSIGNED DEFAULT 9999 COMMENT 'ordem home',
om INT UNSIGNED DEFAULT 9999 COMMENT 'ordem menu',
of INT UNSIGNED DEFAULT 9999 COMMENT 'ordem footer',
dc datetime DEFAULT NULL COMMENT 'data cadastrado',
da datetime DEFAULT NULL COMMENT 'data alterado',
s tinyint(3) unsigned DEFAULT '1' COMMENT 'status: 1-ativo;',
h1 varchar(255) NULL COMMENT 'título (h1)',
n varchar(255) NULL COMMENT 'slug (url)',
t varchar(255) DEFAULT NULL COMMENT 'tag',
tagd varchar(255) DEFAULT NULL COMMENT 'meta tag:description',
tagt varchar(255) DEFAULT NULL COMMENT 'meta tag:title',
PRIMARY KEY (id),
KEY s (s),
KEY dc (dc),
KEY da (da)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Portfolio';

CREATE TABLE IF NOT EXISTS portfolio_section (
id int(10) unsigned NOT NULL AUTO_INCREMENT,
id_portfolio int(10) unsigned DEFAULT NULL COMMENT 'id do portfolio',
id_blog int(10) unsigned DEFAULT NULL COMMENT 'id do blog',
o INT UNSIGNED DEFAULT 9999 COMMENT 'ordem das sections',
dc datetime DEFAULT NULL COMMENT 'data cadastrado',
da datetime DEFAULT NULL COMMENT 'data alterado',
s tinyint(3) unsigned DEFAULT '1' COMMENT 'status: 1-ativo;',
n varchar(255) NULL COMMENT 'título',
n2 varchar(255) DEFAULT NULL COMMENT 'subtítulo',
d text COMMENT 'descrição',
button_text varchar(255) DEFAULT NULL COMMENT 'texto do botão',
button_link varchar(255) DEFAULT NULL COMMENT 'link do botão',
button_blank tinyint(3) unsigned DEFAULT '0' COMMENT 'status: 1-blank;',
PRIMARY KEY (id),
KEY dc (dc),
KEY da (da)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Portfolio Section';

CREATE TABLE IF NOT EXISTS tag (
id int(10) unsigned NOT NULL AUTO_INCREMENT,
idp int(10) unsigned DEFAULT NULL COMMENT 'id do post',
tipo varchar(255) DEFAULT NULL COMMENT 'tipo de tag;',
dc datetime DEFAULT NULL COMMENT 'data cadastrado',
da datetime DEFAULT NULL COMMENT 'data alterado',
s tinyint(3) unsigned DEFAULT '1' COMMENT 'status: 1-ativo;',
n varchar(255) DEFAULT NULL COMMENT 'título',
t varchar(255) DEFAULT NULL COMMENT 'tag',
PRIMARY KEY (id),
KEY s (s),
KEY dc (dc),
KEY da (da)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='Tags';

CREATE TABLE IF NOT EXISTS codigo_externo (
id int(10) unsigned NOT NULL AUTO_INCREMENT,
s tinyint(3) unsigned DEFAULT '1' COMMENT 'status; 1-ativo',
o int(10) unsigned DEFAULT '0' COMMENT 'ordem do team',
dc datetime DEFAULT NULL COMMENT 'data cadastrado',
da datetime DEFAULT NULL COMMENT 'data alterado',
ga varchar(255) DEFAULT NULL COMMENT 'google analytics',
tipoGA varchar(255) DEFAULT 'global' COMMENT 'tipo google analytics: universal, global ou legacy;',
googleTagManager varchar(255) DEFAULT NULL COMMENT 'Código Google Tag Manager',
pixelFacebook varchar(255) DEFAULT NULL COMMENT 'Pixel facebook',
pixelFacebookObrigado varchar(255) DEFAULT NULL COMMENT 'Pixel Facebook Obrigado',
pixelFacebookContato varchar(255) DEFAULT NULL COMMENT 'Pixel facebook Obrigado Contato',
PRIMARY KEY (id),
KEY dc (dc),
KEY da (da)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Códigos Externos';

CREATE TABLE IF NOT EXISTS formulario (
id int(10) unsigned NOT NULL AUTO_INCREMENT,
s tinyint(3) unsigned DEFAULT '1' COMMENT 'status; 1-ativo',
o int(10) unsigned DEFAULT '0' COMMENT 'ordem do team',
dc datetime DEFAULT NULL COMMENT 'data cadastrado',
da datetime DEFAULT NULL COMMENT 'data alterado',
pagina varchar(255) DEFAULT NULL COMMENT 'Página do Formulário',
enviado varchar(255) DEFAULT NULL COMMENT 'Sim ou Não',
nome varchar(255) DEFAULT NULL COMMENT 'nome',
email varchar(255) DEFAULT NULL COMMENT 'email',
telefone varchar(255) DEFAULT NULL COMMENT 'telefone',
assunto varchar(255) DEFAULT NULL COMMENT 'assunto',
empresa varchar(255) DEFAULT NULL COMMENT 'empresa',
mensagem text COMMENT 'mensagem',
PRIMARY KEY (id),
KEY dc (dc),
KEY da (da)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Formulários do Site';

CREATE TABLE IF NOT EXISTS formulario_ax (
id int(10) unsigned NOT NULL AUTO_INCREMENT,
id_formulario int(10) unsigned DEFAULT '0' COMMENT 'id do formulário',
id_user int(10) unsigned DEFAULT '0' COMMENT 'id do usuário',
s tinyint(3) unsigned DEFAULT '1' COMMENT 'status; 1-ativo',
o int(10) unsigned DEFAULT '0' COMMENT 'ordem do team',
dc datetime DEFAULT NULL COMMENT 'data cadastrado',
da datetime DEFAULT NULL COMMENT 'data alterado',
mensagem text COMMENT 'mensagem',
PRIMARY KEY (id),
KEY dc (dc),
KEY da (da)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Formulários do Site';