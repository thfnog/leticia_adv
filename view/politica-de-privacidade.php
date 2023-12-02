<head>
    <!-- Global site tag (gtag.js) - Google Ads: 419158153 -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=AW-419158153"></script>
    <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());
    gtag('config', 'AW-419158153');
    </script>

    <!-- Event snippet for Contato Whatsapp conversion page In your html page, add the snippet and call gtag_report_conversion when someone clicks on the chosen link or button. -->
    <script>
    function gtag_report_conversion(url) {
        var callback = function() {
            if (typeof(url) != 'undefined') {
                window.location = url;
            }
        };
        gtag('event', 'conversion', {
            'send_to': 'AW-419158153/LhgvCPyJkJ0CEImx78cB',
            'event_callback': callback
        });
        return false;
    }
    </script>
       <!-- Meta Pixel Code -->
<script>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '1114644619263281');
  fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
  src="https://www.facebook.com/tr?id=1114644619263281&ev=PageView&noscript=1"
/></noscript>
<!-- End Meta Pixel Code -->
<meta name="facebook-domain-verification" content="vmdt9kwjpju3ioen79br9a7pq38lh0" />
</head>

<div id='chat-box'>
    <div id='chat-top'>
        Precisando de ajuda?
        <span id='chat-top-right'>
            <svg id='close-box' xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 48 48">
                <path
                    d="M38 12.83L35.17 10 24 21.17 12.83 10 10 12.83 21.17 24 10 35.17 12.83 38 24 26.83 35.17 38 38 35.17 26.83 24z"
                    fill='#fff' />
            </svg>
        </span>
        <div class='clear'></div>
    </div>
    <div id='chat-msg'>
        <p>Estamos aqui para o que precisar.</p>
        <div id='chat-form'>
            <div class='chat-in'>
                <input type='text' id='whats-in' Placeholder='Envie sua mensagem...' />
            </div>
            <div id='send-btn'>
                <svg xmlns="http://www.w3.org/2000/svg" width="38" height="38" viewBox="0 0 48 48">
                    <path d="M4.02 42L46 24 4.02 6 4 20l30 4-30 4z" fill='rgb(18, 140, 126)' />
                </svg>
            </div>
        </div>
    </div>
</div>
<div id='whats-chat'>

    <svg xmlns="http://www.w3.org/2000/svg" version="1" width="35" height="35" viewBox="0 0 90 90">
        <path
            d="M90 44a44 44 0 0 1-66 38L0 90l8-24A44 44 0 0 1 46 0c24 0 44 20 44 44zM46 7C25 7 9 24 9 44c0 8 2 15 7 21l-5 14 14-4a37 37 0 0 0 58-31C83 24 66 7 46 7zm22 47l-2-1-7-4-3 1-3 4h-3c-1 0-4-1-8-5-3-3-6-6-6-8v-2l2-2 1-1v-2l-4-8c0-2-1-2-2-2h-2l-3 1c-1 1-4 4-4 9s4 11 5 11c0 1 7 12 18 16 11 5 11 3 13 3s7-2 7-5l1-5z"
            fill="#FFF" />
    </svg>
</div>
<style>
body {
    width: 100%
}

* {
    margin: 0px;
    padding: 0px;
    box-sizing: border-box;
}

#whats-chat {
    position: fixed;
    right: 3%;
    bottom: 10%;
    height: auto;
    width: auto;
    background: #25D366;
    padding: 12.5px;
    border-radius: 50px;
    z-index: 100;
}

#whats-chat:hover {
    cursor: pointer;
    box-shadow: 2px 2px 15px #ccc;
    bottom: 11%;
}

#send-btn:hover {
    cursor: pointer;
}

/*===============================*/
#chat-box {
    position: fixed;
    right: -500px;
    bottom: 18%;
    width: 250px;
    height: 200px;
    transition: all .5s;
    z-index: 100;
}

#chat-top {
    width: 100%;
    line-height: 2;
    background: rgb(18, 140, 126);
    color: white;
    text-align: center;
    border-radius: 5px 5px 0 0;
    padding: 0 10px;
}

#chat-msg {
    background: #ece5dd;
    padding: 10px;
    border-radius: 0 0 5px 5px;
    box-shadow: 0 0 25px -10px #999;
}

#chat-msg p {
    font-size: 14px;
    padding: 5px;
    background: white;
    border-radius: 0 50px 50px 50px;
    margin-bottom: 10px;
}

#chat-form {
    display: flex;
}

.chat-in {
    width: 80%;
    background: #ecefdd;
}

#chat-form input {
    border-radius: 5px 0 5px 5px;
    border: none;
    outline: none;
    font-size: 14px;
    padding: 5px;
    line-height: 2;
}

#send-btn {
    width: 20%;
    padding: 0 5px;
}

#chat-top-right {
    float: right;
    padding: 5px 0;
}

#chat-top-right:hover {
    cursor: pointer
}

#chat-box:after {
    content: '';
    position: absolute;
    top: 58%;
    left: 90%;
    width: 0;
    height: 0;
    border-top: 25px solid transparent;
    border-bottom: 25px solid transparent;

    border-right: 25px solid #ece5dd;
}

.right {
    float: right
}

.clear {
    clear: both
}
</style>
<script>
document.getElementById('whats-chat').addEventListener("mouseover", showchatbox);
document.getElementById('chat-top-right').addEventListener("click", closechatbox);
document.getElementById('send-btn').addEventListener("click", sendmsg);
document.getElementById('whats-chat').addEventListener("click", sendmsg);
window.addEventListener("load", showchatboxtime);

function showchatbox() {
    document.getElementById('chat-box').style.right = '8%'
}

function closechatbox() {
    document.getElementById('chat-box').style.right = '-500px'


}

function showchatboxtime() {
    setTimeout(launchbox, 5000)
}

function launchbox() {
    document.getElementById('chat-box').style.right = '8%'

}

function sendmsg() {
    var msg = document.getElementById('whats-in').value;
    var relmsg = msg.replace(/ /g, "%20");
    if (relmsg == '') relmsg = 'Ol%C3%A1!';
    window.open('https://api.whatsapp.com/send?phone=+5519999088533&text=' + relmsg, '_blank');
	return gtag_report_conversion();
}
</script>

<div class="btContentWrap btClear">
    <div class="btBlogHeaderContent">
        <section id="bt_bb_section5d51cd6f668e8" data-parallax="0.8" data-parallax-offset="0"
            class="bt_bb_section bt_bb_top_spacing_extra_large bt_bb_bottom_spacing_medium bt_bb_color_scheme_1 bt_bb_layout_boxed_1200 bt_bb_vertical_align_top bt_bb_parallax bt_bb_background_image bt_bb_background_overlay_dark_solid">
            <div class="bt_bb_port" style="padding-top:100px;padding-bottom:0px"></div>
        </section>
    </div>
    <div class="btContentHolder">
        <div class="btContent">
            <div class="bt_bb_wrapper">
                <section id="bt_bb_section5d540ac649a8d" style="background-color: #f7f7f7"
                    class="bt_bb_section bt_bb_top_spacing_large bt_bb_bottom_spacing_medium bt_bb_layout_boxed_1200 bt_bb_vertical_align_top">
                    <div class="bt_bb_port">
                        <div class="bt_bb_cell">
                            <div class="bt_bb_cell_inner">
                                <div class="bt_bb_row" data-structure="6-6">
                                    <div class="bt_bb_column col-md-6 col-sm-12 bt_bb_align_left bt_bb_vertical_align_top bt_bb_padding_text_indent"
                                        data-width="6">
                                        <div class="bt_bb_column_content">
                                            <div class="bt_bb_column_content_inner">
                                                <div class="bt_bb_google_maps bt_bb_map" data-center="no">
                                                    <div class="bt_bb_google_maps_map bt_bb_map_map"
                                                        id="map_canvas5d540ac649e91"></div>
                                                    <div class="bt_bb_google_maps_location bt_bb_map_location bt_bb_google_maps_location_without_content bt_bb_map_location_without_content bt_bb_map_location_show"
                                                        data-lat="40.730720" data-lng="-73.935142"
                                                        data-icon="http://law-firm.bold-themes.com/main-demo/wp-content/uploads/sites/3/2017/04/pin_gold.png">
                                                    </div>
                                                </div>
                                                <header
                                                    class="bt_bb_headline bt_bb_dash_none bt_bb_size_medium bt_bb_superheadline bt_bb_subheadline bt_bb_align_inherit">
                                                    <h2><span class="bt_bb_headline_content"><span>Politica de Privacidade</span></span>
                                                    </h2>
                                                </header>
                                                <div
                                                    class="bt_bb_separator bt_bb_top_spacing_normal bt_bb_border_style_none">
                                                </div>
                                              
                                               
                                                <div class="bt_bb_column_inner col-md-12 col-sm-12 bt_bb_align_left bt_bb_vertical_align_top bt_bb_animation_fade_in animate bt_bb_padding_normal animated"
                                                    data-width="12">
                                                    <div class="bt_bb_column_inner_content">
                                                        <div class="bt_bb_service bt_bb_color_scheme_5 bt_bb_style_borderless bt_bb_size_normal bt_bb_shape_circle bt_bb_align_inherit">
                                                          Política de Privacidade

A sua privacidade é importante para nós. É política do site Letícia Colitti Advocacia e Consultoria respeitar a sua privacidade em relação a qualquer informação que possamos coletar no site Letícia Colitti Advocacia e Consultoria e em outros sites que possuímos e operamos.
Trabalhamos com base na Lei de Proteção de Dados (Lei nº 13.709/2018), que traz garantias de privacidade, confidencialidade, retenção, proteção aos direitos fundamentais de liberdade e o livre desenvolvimento da personalidade da pessoa. Além disso, respeitamos a Constituição Federal da República Federativa do Brasil, o Código de Defesa do Consumidor (Lei nº 8.078/90) e o Marco Civil da Internet (Lei nº 12.965/14).
Solicitamos informações pessoais apenas quando realmente precisamos delas para lhe fornecer um serviço. Nós o fazemos por meios justos e legais, com o seu conhecimento e consentimento. Também informamos, com clareza, por que estamos coletando e como serão usados os seus dados, pois tudo é feito para a correta administração geral.
Apenas retemos as informações coletadas pelo tempo necessário para fornecer o serviço solicitado. Os dados armazenados ficam protegidos dentro de meios comercialmente aceitáveis pela legislação atual para evitar perdas e roubos, bem como acesso, divulgação, cópia, uso ou modificação não autorizados.
Não compartilhamos informações de identificação pessoal publicamente ou com terceiros, exceto por determinação judicial.
O nosso site pode ter links para sites externos que não são operados por nós. Diante disto, não nos responsabilizamos por danos causados por terceiros. Esteja ciente de que não temos controle sobre o conteúdo e práticas de sites de terceiros e não podemos aceitar responsabilidade por suas respectivas políticas de privacidade.
Na qualidade de consumidor, você é livre para recusar a nossa solicitação de informações pessoais, entendendo que talvez não possamos fornecer alguns dos serviços desejados.
O uso continuado de nosso site será considerado como aceitação de nossas práticas em torno de privacidade e informações pessoais. Se você tiver alguma dúvida sobre como lidamos com dados do usuário e informações pessoais, entre em contato conosco através do nosso formulário.
Nossa política é atualizada de forma constante.
Fica, desde já, o titular dos dados, ciente de que o conteúdo desta Política de Privacidade pode ser alterado a critério do site Letícia Colitti Advocacia e Consultoria, independente de aviso ou notificação. Em caso de alteração, as modificações produzem todos os efeitos a partir do momento da disponibilização no site.
O site Letícia Colitti Advocacia e Consultoria não se responsabiliza caso você venha a utilizar seus dados de forma incorreta ou inverídica, ficando excluído de qualquer responsabilidade neste sentido.

Política de Cookies
O que são cookies?
Como é prática comum em quase todos os sites profissionais, este site usa cookies, que são pequenos arquivos baixados no seu computador, para melhorar sua experiência. Esta página descreve quais informações eles coletam, como as usamos e por que, às vezes, precisamos armazenar esses cookies. Também compartilharemos como você pode impedir que esses cookies sejam armazenados, no entanto, isso pode fazer o downgrade ou 'quebrar' certos elementos da funcionalidade do site.
Como usamos os cookies?
Utilizamos os cookies por vários motivos, detalhados abaixo. Infelizmente, na maioria dos casos, não existem opções padrão do setor para desativar os cookies sem desativar completamente a funcionalidade e os recursos que eles adicionam a este site. Por isso, é recomendável que você deixe todos os cookies se não tiver certeza se precisa ou não deles, pois eles podem ser usados para fornecer um serviço que você usa.
Desativar cookies
Você pode impedir a configuração de cookies ajustando as configurações do seu navegador (consulte a Ajuda do navegador para saber como fazer isso). Esteja ciente de que a desativação de cookies afetará a funcionalidade deste e de muitos outros sites que você visita. A desativação de cookies geralmente resultará na desativação de determinadas funcionalidades e recursos deste site. Portanto, é recomendável que você não os desative.
Cookies que definimos
●	Cookies relacionados a pesquisas

Periodicamente, oferecemos pesquisas e questionários para fornecer informações interessantes, ferramentas úteis ou para entender nossa base de usuários com mais precisão. Essas pesquisas podem usar cookies para lembrar quem já participou de pesquisa ou para fornecer resultados precisos após a alteração das páginas.

●	Cookies relacionados a formulários
Quando você envia dados por meio de um formulário, como os encontrados nas páginas de contato ou nos formulários de comentários, os cookies podem ser configurados para lembrar os detalhes do usuário para correspondência futura.

●	Cookies de preferências do site
Para proporcionar uma ótima experiência neste site, fornecemos a funcionalidade para definir suas preferências de como esse site é executado quando você o usa. Para lembrar suas preferências, precisamos definir cookies para que essas informações possam ser chamadas sempre que você interagir com uma página que for afetada por suas preferências.
Cookies de Terceiros
Em alguns casos especiais, também usamos cookies fornecidos por terceiros confiáveis. A seção a seguir detalha quais cookies de terceiros você pode encontrar através deste site.
●	Este site usa o Google Analytics, que é uma das soluções de análise mais difundidas e confiáveis da Web, para nos ajudar a entender como você usa o site e como podemos melhorar sua experiência. Esses cookies podem rastrear itens como quanto tempo você gasta no site e as páginas visitadas, para que possamos continuar produzindo conteúdo atraente.
Para mais informações sobre cookies do Google Analytics, consulte a página oficial do Google Analytics.
●	As análises de terceiros são usadas para rastrear e medir o uso deste site, para que possamos continuar produzindo conteúdo atrativo. Esses cookies podem rastrear itens como o tempo que você passa no site ou as páginas visitadas, o que nos ajuda a entender como podemos melhorar o site para você.
●	Periodicamente, testamos novos recursos e fazemos alterações sutis na maneira como o site se apresenta. Quando ainda estamos testando novos recursos, esses cookies podem ser usados para garantir que você receba uma experiência consistente enquanto estiver no site, enquanto entendemos quais otimizações os nossos usuários mais apreciam.
●	À medida que vendemos produtos, é importante entendermos as estatísticas sobre quantos visitantes de nosso site realmente compram e, portanto, esse é o tipo de dados que esses cookies rastrearão. Isso é importante para você, pois significa que podemos fazer previsões de negócios com precisão. A partir de tais dados, conseguimos analisar nossos custos de publicidade e produtos para garantir a você o melhor preço possível.
●	O serviço Google AdSense, que usamos para veicular publicidade, usa um cookie DoubleClick para veicular anúncios mais relevantes em toda a Web e limitar o número de vezes que um determinado anúncio é exibido para você.
Para mais informações sobre o Google AdSense, consulte as FAQs oficiais sobre privacidade do Google AdSense.
●	Utilizamos anúncios para compensar os custos de funcionamento deste site e fornecer financiamento para futuros desenvolvimentos. Os cookies de publicidade comportamental, usados por este site, foram projetados para mapear os anúncios mais relevantes para você sempre que possível, rastreando anonimamente seus interesses e apresentando coisas semelhantes que possam ser do seu interesse.
Compromisso do Usuário
O usuário se compromete a fazer uso adequado dos conteúdos e da informação que o site Letícia Colitti Advocacia e Consultoria oferece. Com caráter enunciativo, mas não limitativo, você se compromete a:
A.	Não se envolver em atividades que sejam ilegais ou contrárias à boa fé e à ordem pública;
B.	Respeitar todas as legislações nacionais ou internacionais em que o Brasil é signatário;
C.	Não difundir propaganda ou conteúdo de natureza racista, xenofóbica, casas de apostas, jogos de sorte e azar, qualquer tipo de pornografia ilegal, de apologia ao terrorismo ou contra os direitos humanos;
D.	Não causar danos aos sistemas físicos (hardwares) e lógicos (softwares) do site Letícia Colitti Advocacia e Consultoria, de seus fornecedores ou terceiros, para introduzir ou disseminar vírus informáticos ou quaisquer outros sistemas de hardware ou software que sejam capazes de causar os danos anteriormente mencionados.
Os conteúdos publicados possuem direitos autorais e de propriedade intelectual reservados, conforme estabelece a Lei de Direitos Autorais nº 9.610, de 19.2.1998 do Governo Federal Brasileiro e correlatas. Quaisquer infringências serão comunicados às autoridades competentes.
Direitos do titular de dados
O titular de dados pessoais possui o direito de solicitar ao site Letícia Colitti Advocacia e Consultoria, através do canal específico de tratamento, a qualquer momento, mediante requisição formal, informações referentes aos seus dados.
Os pedidos serão analisados, conforme previsto em legislação vigente, dentro de um prazo de 72 horas, salvo determinação legal e/ou objeto de lei.
Os titulares de dados, segundo o texto da LGPD, podem exercer os seus direitos por meio de:
●	Confirmação da existência de tratamento;
●	Anonimização, bloqueio ou eliminação de dados desnecessários, excessivos ou tratados em desconformidade com o disposto nesta Lei;
●	Informação das entidades públicas e privadas com as quais o controlador realizou uso compartilhado de dados;
●	Informação sobre a possibilidade de não fornecer consentimento e sobre as consequências da negativa.
Como exercer os seus direitos de titular de dados?
Para as demais solicitações em relação aos direitos do titular de dados pessoais, entre em contato conosco através do nosso formulário.
Mais informações
Com nossa política esclarecida, recomendamos, como mencionado anteriormente, que, se houver algo de que você não tem certeza se precisa ou não, geralmente é mais seguro deixar os cookies ativados para o caso de você interagir com um dos recursos que você usa em nosso site.
O site Letícia Colitti Advocacia e Consultoria empregará esforços para resguardar as informações e dados coletados do usuário pelo site. Todavia, considerando que não há meio de transmissão e retenção de dados eletrônicos plenamente eficaz e seguro, o site Letícia Colitti Advocacia e Consultoria não pode assegurar que terceiros não autorizados não logrem êxito no acesso indevido, eximindo-se de qualquer responsabilidade por danos e prejuízos decorrentes da conduta de terceiros, ataques externos ao site como: vírus, invasão ao banco de dados, vícios ou defeitos técnicos, assim como operacionais, resultantes da utilização do site e em razão de falhas de conexão.


                                                        </div>
                                                        <div
                                                            class="bt_bb_separator bt_bb_top_spacing_normal bt_bb_border_style_none">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
<?
Inline::a();
?>
<script type="text/javascript" src="assets/js/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="assets/js/jquery.maskedinput-1.4.1.min.js"></script>
<script type="text/javascript" src="assets/js/scripts.js"></script>
<script type="text/javascript">
$('.mk-data').mask('99/99/9999');
$('.mk-tel').mask('(99) 9999-9999');
$('.mk-cel').focusout(function() {
    var e = $(this);
    e.unmask().mask(e.val().replace(/\D/g, '').length > 10 ? '(99) 99999-999?9' : '(99) 9999-9999?9');
}).focusout();

function hasError(e) {
    $("#" + e).on('keyup change', function() {
        var placeholder = $("#" + e).data('placeholder');
        $("#" + e).removeClass("haserror").css('border-color', 'initial').attr('placeholder', placeholder);
    });
}
</script>
<?
Inline::b();
?>
