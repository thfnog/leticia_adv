<?
$lc = $s->dir;
$date = datef(0,9);
$str = <<<PHP_HD
#{$s->dom}
#{$s->dir}
#last updated: {$date}

RewriteEngine On

# www
RewriteCond %{HTTP_HOST} !^www\. [NC]
RewriteCond %{HTTP_HOST} !^localhost
RewriteCond %{REQUEST_METHOD} ^GET$
RewriteRule (.*) {$s->dom}{$lc}$1 [R=301,L]

#RewriteCond %{HTTPS} off
#RewriteRule (.*) https://www.avesbrasil.com.br/$1 [R=301,L,E=nocache:1]
#RewriteCond %{HTTP_HOST} !^www\.avesbrasil\.com\.br$
#RewriteRule (.*) https://www.avesbrasil.com.br/$1 [R=301,L,E=nocache:1]

#GOOGLE PAGESPEED
#ModPagespeed on
#ModPagespeedEnableFilters rewrite_javascript_external
#ModPagespeedDisableFilters rewrite_javascript_inline
#ModPagespeedDisallow url_do_arquivo
#ModPagespeedDisallow url_do_arquivo
#ModPagespeedEnableFilters extend_cache
#ModPagespeedEnableFilters make_google_analytics_async
#ModPagespeedEnableFilters remove_comments

#OPTIMAZATION
<ifModule mod_expires.c>
	# Enable expirations
	ExpiresActive On
	# Default directive
	ExpiresDefault A29030400
	# My favicon
	ExpiresByType image/x-icon A29030400
	# Images
	ExpiresByType image/gif A2419200
	ExpiresByType image/png A2419200
	ExpiresByType image/jpg A2419200
	ExpiresByType image/jpeg A2419200
	# CSS
	ExpiresByType text/css A2419200
	# Javascript
	ExpiresByType text/javascript A2419200
	ExpiresByType application/javascript A29030400
	ExpiresByType text/plain A2419200
	ExpiresByType text/html A2419200
</ifModule>

<ifModule mod_headers.c>
	Header unset ETag
	# YEAR
	<FilesMatch "\.(ico|gif|jpg|jpeg|png|flv|pdf)$">
		Header set Cache-Control "public, max-age=31536000"
	</FilesMatch>
	# MONTH
	<FilesMatch "\.(js|css|swf)$">
		Header set Cache-Control "max-age=2419200"
	</FilesMatch>
	# WEEK
	#<FilesMatch "\.(js|css|swf)$">
		#Header set Cache-Control "max-age=604800"
	#</FilesMatch>
	# 45 MIN
	<FilesMatch "\.(html|htm|txt)$">
		Header set Cache-Control "max-age=2700"
	</FilesMatch>
</ifModule>
FileETag None

<IfModule mod_mime.c>
    AddType application/javascript          js
    AddType application/vnd.ms-fontobject   eot
    AddType application/x-font-ttf          ttf ttc
    AddType font/opentype                   otf
    AddType application/x-font-woff         woff
    AddType image/svg+xml                   svg svgz 
    AddEncoding gzip                        svgz
</Ifmodule>

<IfModule mod_deflate.c>
	# compress text, HTML, JavaScript, CSS, and XML
	AddOutputFilterByType DEFLATE text/plain
	AddOutputFilterByType DEFLATE text/html
	AddOutputFilterByType DEFLATE text/xml
	AddOutputFilterByType DEFLATE text/css
	AddOutputFilterByType DEFLATE application/xml
	AddOutputFilterByType DEFLATE application/xhtml+xml
	AddOutputFilterByType DEFLATE application/rss+xml
	AddOutputFilterByType DEFLATE application/javascript
	AddOutputFilterByType DEFLATE application/x-javascript
	AddType image/svg+xml .svg
	#AddOutputFilterByType DEFLATE image/svg+xml
	AddOutputFilterByType DEFLATE image/x-icon image/svg+xml application/vnd.ms-fontobject application/x-font-ttf font/opentype
</Ifmodule>

<IfModule mod_gzip.c>
	# remove browser bugs
	BrowserMatch ^Mozilla/4 gzip-only-text/html
	BrowserMatch ^Mozilla/4\.0[678] no-gzip
	BrowserMatch \bMSIE !no-gzip !gzip-only-text/html
	Header append Vary User-Agent
</Ifmodule>
#OPTIMAZATION



# BEGIN Turn ETags Off
#Header unset ETag
#FileETag None
# END Turn ETags Off


#php_value upload_max_filesize 100M
#php_value max_input_vars 10000

# Barra no fim
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.+)/$ {$lc}$1 [QSA,R=301,NC,L]
RewriteRule ^fb-callback$ index.php?pg=fb-callback&%{QUERY_STRING} [NC,L]
RewriteRule ^retorno-paypal$ index.php?pg=retorno-paypal&%{QUERY_STRING} [NC,L]
RewriteRule ^fb-callback-debug$ index.php?pg=fb-callback-debug&%{QUERY_STRING} [NC,L]

# Paginacao
#RewriteRule ^(produtos(?:/\d+-[\w\-]+)?)$ {$lc}$1/1 [QSA,R=301,NC,L]
###RewriteRule ^((?:produtos|en/products|es/productos)(?:(?:/[^/]+)*/\d*[a-z_\-][\w\-]*)?)$ {$lc}$1/1 [QSA,R,NC,L]


# Paginacao
#RewriteRule ^((?:produtos|en/products|es/productos)(?:(?:/[^/]+)*/\d*[a-z_\-][\w\-]*)?)$ {$lc}$1/1 [QSA,R,NC,L]


# AJAX
RewriteRule ^ajax/([\w\-]+)$ ajax.php?cat=$1 [QSA,NC,L]
RewriteRule ^ajax/([\w\-]+)(.(\d+))?.([\w\-]{1,6})$ ajax.php?act=$1&id=$3&cat=$4 [QSA,NC,L]
RewriteRule ^ajax/([\w\-]+)/([\w\-]+)(.(\d+))?.([\w\-]{1,6})$ ajax.php?act=$1&pg=$2&id=$4&cat=$5 [QSA,NC,L]
RewriteRule ^ajax/([\w\-]+)/([\w\-]+)/([\w\-]+)(.(\d+))?.([\w\-]{1,6})$ ajax.php?act=$1&pg=$2&spg=$3&id=$5&cat=$6 [QSA,NC,L]
###RewriteRule ^(carrinho)/([\w\-]+)?$ index.php?pg=$1&spg=$2 [NC,L]

RewriteRule ^(fotos|esqueci|faq-search|pedidos)$ index.php?pg=$1 [QSA,NC,L]
RewriteRule ^(pedidos)/(\d+)$ index.php?pg=$1&id=$2 [NC,L]


#QSA
###RewriteRule ^(esqueci)$ index.php?pg=$1 [QSA,NC,L]



###RewriteRule ^(?:(en|es)/)?(produtos|products|productos)(?:/(\d*[a-z_\-][\w\-]*))?(?:/([\w\-]+).(\d+))?(?:/(\d+))?$ index.php?pg=$2&cat=$3&ord=$4&qt=$5&pgn=$6&lang=$1 [QSA,NC,L]

###RewriteRule ^(?:(en|es)/)?(produtos|noticias|products|news|productos|noticias)/(\d+)-([\w\-]+).html$ index.php?pg=$2&id=$3&tag=$4&lang=$1 [NC,L]

#QSA
RewriteRule ^(blog|atletas|patrocinados|novidades|receitas|treinos|produtos)$ index.php?pg=$1 [QSA,NC,L]
RewriteRule ^(blog|atletas|patrocinados|novidades|receitas|treinos|produtos)/(\d+)$ index.php?pg=$1&pgn=$2 [QSA,NC,L]
RewriteRule ^(produtos|atletas|patrocinados|novidades|receitas|treinos)(?:/(\d*[a-z_\-][\w\-]*))?(?:/(\d*[a-z_\-][\w\-]*))?(?:/(\d+))?$ index.php?pg=$1&spg=$2&cat=$3&pgn=$4 [QSA,NC,L]
#RewriteRule ^(blog)(?:/(\d*[a-z_\-][\w\-]*))?(?:/(\d*[a-z_\-][\w\-]*))?(?:/(\d+))?$ index.php?pg=$1&cat=$2&pgn=$3 [QSA,NC,L]
#RewriteRule ^(?:(en|es)/)?(produtos|products|productos|dicas-sobre-sexo|na-midia)(?:/(\d*[a-z_\-][\w\-]*))?(?:/(\d*[a-z_\-][\w\-]*))?(?:/(\d+))?$ index.php?pg=$2&cat=$3&scat=$4&pgn=$5&lang=$1 [QSA,NC,L]


#interno
RewriteRule ^(produto|blog|atleta|patrocinado|novidade|receita|treino|loja)/(\d+)/([\w-]+)$ index.php?pg=$1&id=$2&tag=$3 [NC,L]
RewriteRule ^(obrigado|boleto|cancelar|segunda-via|pedido|upload-produto-foto|notification|notification-pagseguro)/(\d+)$ index.php?pg=$1&id=$2 [NC,L]


#DOWNLOAD
RewriteRule ^(download-tabela)/([\w-]+)$ index.php?pg=$1&arq=$2 [QSA,NC,L]
RewriteRule ^(video|video-zoom|download-arte|download-produto|download-catalogo)/(\d+)$ index.php?pg=$1&id=$2 [QSA,NC,L]
RewriteRule ^(rastreio)/([\w-]+)$ index.php?pg=$1&tag=$2 [QSA,NC,L]
RewriteRule ^(login)/([\w-]+)$ index.php?pg=$1&referer=$2 [QSA,NC,L]


RewriteRule ^(admin)/(login)/([\w-]+)$ index.php?pg=$1&spg=$2&referer=$3 [QSA,NC,L]
RewriteRule ^(admin)/([\w\-]+)(?:/(\d+))?$ index.php?pg=$1&spg=$2&id=$3 [NC,L]
RewriteRule ^(admin)/([\w\-]+)/([\w\-]+)(?:/(\d+))?$ index.php?pg=$1&spg=$2&cat=$3&id=$4 [NC,L]

RewriteRule ^(en|es)(?:/([\w\-]+))?$ index.php?pg=$2&lang=$1 [NC,L]

RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^([\w\-]+)$ index.php?pg=$1 [NC,L]

ErrorDocument 404 {$lc}404


PHP_HD;
file_put_contents('.htaccess',$str);


$str = "deny from all";
file_put_contents('class/.htaccess',$str);


$x->ok = '.htaccess atualizado. '.$date;
?>