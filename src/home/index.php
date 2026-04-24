<?php
require '../db.php';
$pdo = $pdo ?? null;

$companies = fetchActiveBusCompanies($pdo);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Quero Passagem: Passagem de ônibus sem sair de casa</title>
    <link rel="stylesheet" href="styles.css"></head>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700&display=swap" rel="stylesheet"><body>

<!-- header -->
<header>
    <div class="header-container">
        <a href="#" class="logo">
            <img src="https://assets.queropassagem.com.br/static/Images/Logos/logo_nova_grande.png" alt="Quero Passagem">
        </a>

        <nav aria-label="Menu principal">
            <a href="#" class="active">Passagens</a>
            <a href="#">Hotéis <span class="badge-new">Novo!</span></a>
        </nav>

        <aside class="header-actions">
            <button class="btn-help">Central de Ajuda</button>
            <button class="btn-enter">ENTRAR</button>
        </aside>
    </div>
</header>

<!-- banner / busca -->
<section class="banner" aria-label="Busca de passagens">
    <div class="container">
        <article class="banner-content">
            <form class="search" action="#" method="get">
                <h2>Comprar Passagens de Ônibus</h2>

                <label for="origin">Partindo de</label>
                <input id="origin" type="text" name="origin" value="" />

                <label for="destination">Indo para</label>
                <input id="destination" type="text" name="destination" value="" />

                <fieldset>
                    <legend class="sr-only">Datas</legend>
                    <p>
                        <label for="departure">Data Saída</label>
                        <input id="departure" type="date" name="departure" value="" />
                    </p>
                    <p>
                        <label for="return">Data Retorno</label>
                        <input id="return" type="date" name="return" />
                    </p>
                </fieldset>

                <button type="submit" class="btn-search">BUSCAR PASSAGEM</button>
            </form>
        </article>
    </div>
</section>

<!-- barra de confiança -->
<aside class="trust-bar">
    <article>
        <p><strong>Viagens seguras</strong><span>Mais de 30 milhões de compras</span></p>
    </article>
    <article>
        <p><strong>Pagamento</strong><span>Pague com Pix, Nupay ou em até 12x</span></p>
    </article>
    <article>
        <p><strong>Cancelamento</strong><span>Passagens flexíveis e atendimento personalizado</span></p>
    </article>
</aside>

<!-- viações -->
<section class="transport" aria-labelledby="title-transport">
    <h2 id="title-transport">Passagens de Ônibus Baratas: Viações de Ônibus</h2>
    <p>A sua passagem de ônibus na viação de sua preferência</p>
    <ul class="transport-grid">
        <?php foreach ($companies as $company): ?>
            <li>
                <div class="card-logo">
                    <img src="/<?= $company['logo'] ?>" alt="<?= $company['name'] ?>">
                </div>
                <span class="company-name"><?= $company['name'] ?></span>
            </li>
        <?php endforeach; ?>
    </ul>
</section>

<!-- destinos -->
<section class="destinations" aria-labelledby="title-destinations">
    <h2 id="title-destinations">Escolha seu destino</h2>
    <p>São mais de 5 mil destinos em todo o país para escolher sem sair de casa.</p>

    <ul class="destination-cards">

        <li class="destination-card">
            <img src="https://assets.queropassagem.com.br/public/Upload/cidades/1a.jpg" alt="São Paulo" />
            <article>
                <h3>São Paulo</h3>
                <table>
                    <thead>
                    <tr><th>Partindo de</th><th>A partir de</th></tr>
                    </thead>
                    <tbody>
                    <tr><td>Rio de Janeiro, RJ</td><td>R$ 104</td></tr>
                    <tr><td>Belo Horizonte, MG</td><td>R$ 139</td></tr>
                    <tr><td>Ribeirão Preto, SP</td><td>R$ 144</td></tr>
                    <tr><td>Sorocaba, SP</td><td>R$ 44</td></tr>
                    </tbody>
                </table>
            </article>
        </li>

        <li class="destination-card">
            <img src="https://assets.queropassagem.com.br/public/Upload/cidades/57a.jpg" alt="Rio de Janeiro" />
            <article>
                <h3>Rio De Janeiro</h3>
                <table>
                    <thead>
                    <tr><th>Partindo de</th><th>A partir de</th></tr>
                    </thead>
                    <tbody>
                    <tr><td>São Paulo, SP</td><td>R$ 104</td></tr>
                    <tr><td>Belo Horizonte, MG</td><td>R$ 69</td></tr>
                    <tr><td>Cabo Frio, RJ</td><td>R$ 75</td></tr>
                    <tr><td>Macaé, RJ</td><td>R$ 89</td></tr>
                    </tbody>
                </table>
            </article>
        </li>

        <li class="destination-card">
            <img src="https://assets.queropassagem.com.br/public/Upload/cidades/55a.jpg" alt="Curitiba" />
            <article>
                <h3>Curitiba</h3>
                <table>
                    <thead>
                    <tr><th>Partindo de</th><th>A partir de</th></tr>
                    </thead>
                    <tbody>
                    <tr><td>Florianópolis, SC</td><td>R$ 72</td></tr>
                    <tr><td>Porto Alegre, RS</td><td>R$ 27</td></tr>
                    <tr><td>Joinville, SC</td><td>R$ 38</td></tr>
                    <tr><td>Rio de Janeiro, RJ</td><td>R$ 22</td></tr>
                    </tbody>
                </table>
            </article>
        </li>

        <li class="destination-card">
            <img src="https://assets.queropassagem.com.br/public/Upload/cidades/64a.jpg" alt="Belo Horizonte" />
            <article>
                <h3>Belo Horizonte</h3>
                <table>
                    <thead>
                    <tr><th>Partindo de</th><th>A partir de</th></tr>
                    </thead>
                    <tbody>
                    <tr><td>São Paulo, SP</td><td>R$ 139</td></tr>
                    <tr><td>Vitória, ES</td><td>R$ 59</td></tr>
                    <tr><td>Rio de Janeiro, RJ</td><td>R$ 69</td></tr>
                    <tr><td>Monte Claro, MG</td><td>R$ 69</td></tr>
                    </tbody>
                </table>
            </article>
        </li>

    </ul>

    <a href="#" class="link-more-destinations">MOSTRE-ME MAIS DESTINOS</a>
</section>

<!-- banner app -->
<img src="https://assets.queropassagem.com.br/static/Images/banner_download_app_2.png" alt="Banner" />

<!-- trechos -->
<section class="routes" aria-labelledby="title-routes">
    <h2 id="title-routes">Top 15 trechos de ônibus</h2>
    <p>Os trechos mais procurados em nossa Central de Passagens.</p>

    <ul class="routes-grid">
        <li>
            <table>
                <thead>
                <tr><th>Partindo de</th><th>Indo para</th></tr>
                </thead>
                <tbody>
                <tr><td>Rio de Janeiro</td><td>São Paulo</td></tr>
                <tr><td>São Paulo</td><td>Rio de Janeiro</td></tr>
                <tr><td>São Paulo</td><td>Curitiba</td></tr>
                <tr><td>Curitiba</td><td>São Paulo</td></tr>
                <tr><td>Brasília</td><td>Goiânia</td></tr>
                </tbody>
            </table>
        </li>
        <li>
            <table>
                <thead>
                <tr><th>Partindo de</th><th>Indo para</th></tr>
                </thead>
                <tbody>
                <tr><td>Goiânia</td><td>Brasília</td></tr>
                <tr><td>São Paulo</td><td>Goiânia</td></tr>
                <tr><td>Belo Horizonte</td><td>São Paulo</td></tr>
                <tr><td>Goiânia</td><td>São Paulo</td></tr>
                <tr><td>São Paulo</td><td>Belo Horizonte</td></tr>
                </tbody>
            </table>
        </li>
        <li>
            <table>
                <thead>
                <tr><th>Partindo de</th><th>Indo para</th></tr>
                </thead>
                <tbody>
                <tr><td>Florianópolis</td><td>Curitiba</td></tr>
                <tr><td>São Paulo</td><td>Londrina</td></tr>
                <tr><td>Porto Alegre</td><td>Curitiba</td></tr>
                <tr><td>Curitiba</td><td>Florianópolis</td></tr>
                <tr><td>São Paulo</td><td>Bauru</td></tr>
                </tbody>
            </table>
        </li>
    </ul>
</section>

<!-- parceiros -->
<section class="partners" aria-labelledby="title-partners">
    <article class="partners-image"></article>

    <article class="partners-info">
        <article class="partner-type">
            <p>
            <h3>Agências de Viagem</h3>
            Sistema completo de emissão e venda de passagens rodoviárias para agências de viagens.
            </p>
        </article>

        <article class="partner-type">
            <p>
            <h3>OTA's</h3>
            Insira nosso banner (buscador de passagens) em seu site e ganhe comissões por cada venda.
            </p>
        </article>

        <a href="#" class="btn-learn-more">Saiba mais</a>
    </article>
</section>

<!-- newsletter -->
<section class="newsletter" aria-labelledby="title-newsletter">
    <h2 id="title-newsletter">Deseja receber e-mails com novidades e descontos exclusivos?</h2>

    <form class="newsletter-form" action="#" method="post">
        <input id="name-newsletter" type="text" name="name" placeholder="Seu nome" />
        <input id="email-newsletter" type="email" name="email" placeholder="Seu e-mail" />
        <button type="submit">Inscreva-se</button>
    </form>
</section>

<!-- sobre -->
<section class="about" aria-labelledby="title-about">
    <h2 id="title-about">Viajar de ônibus é rápido e fácil com a Quero Passagem</h2>
    <p>A Quero Passagem é o maior Portal de Passagens de Ônibus do Brasil - sua Central de Passagens Rodoviárias online. Pesquise viações, compare horários, preços e compre passagens rodoviárias sem sair de casa. São mais de 5 mil destinos em todo o país, conectando cidades como Belo Horizonte, Curitiba, Brasília, São Paulo, Rio de Janeiro, Salvador, Goiânia e muito mais.</p>

    <ul class="about-cards">
        <li>
            <img src="https://assets.queropassagem.com.br/static/Images/card_pagamento.png" alt="Pagamento" />
            <p>Escolha a melhor forma de pagamento para você: compre sua passagem de ônibus em até 12x no cartão de crédito ou pague com débito, transferência bancária, boleto ou via Pix.</p>
        </li>
        <li>
            <img src="https://assets.queropassagem.com.br/static/Images/card_onibus.png" alt="Conforto" />
            <p>Viaje com conforto e segurança nas melhores companhias de ônibus do Brasil, como Viação Cometa, 1001, Catarinense, Itapemirim, Guanabara e outras 350 viações parceiras.</p>
        </li>
        <li>
            <img src="https://assets.queropassagem.com.br/static/Images/card_bilhetes.png" alt="Escolha"
                 style="background-color: #2764C0;"/>
            <p>Na Quero Passagem, você escolhe o horário, o assento e a empresa favorita para viajar. Finalize sua compra de passagem rodoviária online de forma rápida, segura e sem complicação.</p>
        </li>
        <li>
            <img src="https://assets.queropassagem.com.br/static/Images/card_praia.png" alt="Confiança" />
            <p>Confiança de quem já colocou mais de 15 milhões de passageiros na estrada. Compre sua passagem de ônibus em menos de 5 minutos e bora viajar tranquilo.</p>
        </li>
    </ul>
</section>

<!-- faq -->
<section class="faq" aria-labelledby="title-faq">
    <h2 id="title-faq">Perguntas frequentes</h2>

    <ul class="faq-list">
        <li class="faq-item">
            <button class="faq-question" aria-expanded="false">Quero Passagem é seguro para comprar passagens de ônibus online? <span>&#8964;</span></button>
            <p class="faq-answer">Sim! Comprar sua passagem pela Quero Passagem é seguro. A plataforma utiliza tecnologia de proteção de dados e pagamentos confiáveis para garantir que suas informações estejam sempre protegidas.</p>
        </li>
        <li class="faq-item">
            <button class="faq-question" aria-expanded="false">Quero Passagem é Confiável? <span>&#8964;</span></button>
            <p class="faq-answer">Sim! A Quero Passagem conecta você a diversas empresas de ônibus em todo o Brasil, permitindo comparar preços, horários e rotas para escolher a melhor opção.</p>
        </li>
        <li class="faq-item">
            <button class="faq-question" aria-expanded="false">Como fazer o cancelamento da minha passagem de ônibus? <span>&#8964;</span></button>
            <p class="faq-answer">Basta acessar Minha Conta, localizar sua passagem e seguir as orientações. O pedido deve ser feito antes do horário da viagem e segue as regras da empresa de ônibus.</p>
        </li>
        <li class="faq-item">
            <button class="faq-question" aria-expanded="false">Como e onde vou receber a confirmação de compra da minha passagem de ônibus? <span>&#8964;</span></button>
            <p class="faq-answer">Assim que o pagamento for aprovado, você recebe um e-mail com todos os detalhes da sua viagem, como dados da passagem, horário e orientações para o embarque.</p>
        </li>
        <li class="faq-item">
            <button class="faq-question" aria-expanded="false">Como alterar a data ou o horário da minha viagem de ônibus? <span>&#8964;</span></button>
            <p class="faq-answer">Basta acessar Minha Conta, encontrar sua passagem e solicitar a mudança. A alteração depende da disponibilidade de novos horários e das regras da empresa de ônibus.</p>
        </li>
        <li class="faq-item">
            <button class="faq-question" aria-expanded="false">Como usar o ID Jovem na reserva da passagem de ônibus? <span>&#8964;</span></button>
            <p class="faq-answer">Se você possui o ID Jovem, pode utilizar o benefício em viagens interestaduais. Para a compra, é necessário utilizar o link: https://queropassagem.com.br/gratuidade.</p>
        </li>
        <li class="faq-item faq-extra hidden">
            <button class="faq-question" aria-expanded="false">Qual é o melhor app para comprar passagens de ônibus? <span>&#8964;</span></button>
            <p class="faq-answer">Com o aplicativo da Quero Passagem você pode pesquisar destinos, comparar horários e comprar sua passagem diretamente pelo celular de forma rápida e segura.</p>
        </li>
        <li class="faq-item faq-extra hidden">
            <button class="faq-question" aria-expanded="false">Como comprar passagens de ônibus online? <span>&#8964;</span></button>
            <p class="faq-answer">Informe origem, destino e data; escolha o horário e a empresa; preencha os dados do passageiro e finalize o pagamento. A confirmação chegará por e-mail.</p>
        </li>
        <li class="faq-item faq-extra hidden">
            <button class="faq-question" aria-expanded="false">Qual é o telefone e whatsapp da Quero Passagem? <span>&#8964;</span></button>
            <p class="faq-answer">O número de WhatsApp da Quero Passagem é 11 4680-2994.</p>
        </li>
        <li class="faq-item faq-extra hidden">
            <button class="faq-question" aria-expanded="false">Quais são os canais de atendimento da Quero Passagem? <span>&#8964;</span></button>
            <p class="faq-answer">Você pode falar com a equipe de atendimento pelo chat no Minha Conta, e-mail ou WhatsApp.</p>
        </li>
        <li class="faq-item faq-extra hidden">
            <button class="faq-question" aria-expanded="false">Quanto tempo demora para confirmar a passagem de ônibus na Quero Passagem? <span>&#8964;</span></button>
            <p class="faq-answer">Normalmente a confirmação acontece logo após a aprovação do pagamento.</p>
        </li>
        <li class="faq-item faq-extra hidden">
            <button class="faq-question" aria-expanded="false">Quais as regras para viajar com animais de estimação? <span>&#8964;</span></button>
            <p class="faq-answer">As regras variam por empresa. Em geral, o pet deve estar em caixa de transporte adequada e com a documentação veterinária exigida.</p>
        </li>
        <li class="faq-item faq-extra hidden">
            <button class="faq-question" aria-expanded="false">Quais são os documentos necessários para embarcar no ônibus da rodoviária? <span>&#8964;</span></button>
            <p class="faq-answer">Basta apresentar um documento oficial e físico com foto, como RG, CNH ou passaporte.</p>
        </li>
        <li class="faq-item faq-extra hidden">
            <button class="faq-question" aria-expanded="false">Quais são os meios de pagamento aceitos na Quero Passagem? <span>&#8964;</span></button>
            <p class="faq-answer">São aceitos cartão de crédito, Pix, Boleto, Transferência Bancária, Carteira Digital e outras opções disponíveis no momento da compra.</p>
        </li>
        <li class="faq-item faq-extra hidden">
            <button class="faq-question" aria-expanded="false">Posso comprar passagens de ônibus para outras pessoas/terceiros? <span>&#8964;</span></button>
            <p class="faq-answer">Sim! Basta preencher os dados do passageiro que irá viajar no momento da compra.</p>
        </li>
        <li class="faq-item faq-extra hidden">
            <button class="faq-question" aria-expanded="false">Qual limite de peso e com quantas bagagens eu posso embarcar na minha viagem de ônibus? <span>&#8964;</span></button>
            <p class="faq-answer">Normalmente é permitido levar até 30 kg no bagageiro e até 5 kg de bagagem de mão, mas as regras podem variar dependendo da empresa de ônibus.</p>
        </li>
    </ul>

    <button class="btn-show-more" id="btn-show-more">Ver mais perguntas</button>
</section>

<!-- footer -->
<footer>

    <!-- footer: links -->
    <section class="footer-links">
        <article class="footer-column">
            <h4>TOP DESTINOS</h4>
            <ul>
                <li><a href="#">Ônibus Rio de Janeiro</a></li>
                <li><a href="#">Ônibus São Paulo</a></li>
                <li><a href="#">Ônibus Brasília</a></li>
                <li><a href="#">Ônibus Campinas</a></li>
                <li><a href="#">Ônibus Londrina</a></li>
                <li><a href="#"><strong>+ Destinos</strong></a></li>
            </ul>
        </article>

        <article class="footer-column">
            <h4>TOP VIAÇÕES</h4>
            <ul>
                <li><a href="#">Passagens Cometa</a></li>
                <li><a href="#">Passagens Gontijo</a></li>
                <li><a href="#">Passagens 1001</a></li>
                <li><a href="#">Passagens Águia Branca</a></li>
                <li><a href="#">Passagens Pássaro Marron</a></li>
                <li><a href="#"><strong>+ Viações</strong></a></li>
            </ul>
        </article>

        <article class="footer-column">
            <h4>TOP RODOVIÁRIAS</h4>
            <ul>
                <li><a href="#">Rodoviária São Paulo - Tietê</a></li>
                <li><a href="#">Rodoviária Rio de Janeiro - Novo Rio</a></li>
                <li><a href="#">Rodoviária Belo Horizonte - Gov. Israel Pinheiro (Tergip)</a></li>
                <li><a href="#">Rodoviária Curitiba</a></li>
                <li><a href="#">Rodoviária São Paulo - Barra Funda</a></li>
                <li><a href="#"><strong>+ Rodoviárias</strong></a></li>
            </ul>
        </article>
    </section>

    <!-- footer: info -->
    <section class="footer-info">
        <article class="footer-about">
            <img src="https://assets.queropassagem.com.br/static/Images/Logos/logo_nova_grande.png" alt="Quero Passagem" />
            <p><strong>Na Quero Passagem sua compra é totalmente segura!</strong></p>
            <p>Para garantirmos que seus dados estejam sempre protegidos, não armazenamos nenhuma informação do cartão de crédito utilizado, seguindo os protocolos de criptografia e de segurança das principais instituições bancárias do Brasil.</p>
        </article>

        <nav class="footer-nav" aria-label="Links institucionais">
            <a href="#">Sobre nós</a>
            <a href="#">Atendimento Online</a>
            <a href="#">Afiliados</a>
            <a href="#">Termos de uso</a>
            <a href="#">Trabalhe Conosco</a>
            <a href="#">Versão Mobile</a>
            <a href="#">Política de privacidade</a>
            <a href="#">Gratuidade</a>
            <a href="#">Rodomilhas</a>
            <a href="#">Termos de Uso Louge Vip</a>
            <a href="#">Auto Viações</a>
            <a href="#">Viajo Mucho</a>
            <a href="#">Imprensa</a>
            <a href="#">Rodoviárias</a>
            <a href="#">La terminal Costa Rica</a>
            <a href="#">Minha Conta</a>
            <a href="#">Destinos</a>
        </nav>
    </section>

    <!-- footer: redes sociais e grupo -->
    <section class="footer-social-group">
        <article class="footer-social">
            <p>SIGA NOSSAS REDES SOCIAIS:</p>
            <ul>
                <img src="https://media.discordapp.net/attachments/1491487629529841754/1492134134791798885/insta.png?ex=69ecaeb4&is=69eb5d34&hm=16257f8359bd78789e031f76e8fea2f5ddb0b924ad4cd44213d6772c0b16dfa4&=&format=webp&quality=lossless" alt="Insta">
                <img src="https://media.discordapp.net/attachments/1491487629529841754/1492134135647436950/youtube.png?ex=69ecaeb4&is=69eb5d34&hm=644610cdc11c006565936aec04a4ca20b877663c2a08632a3bdd77c804c1d4dc&=&format=webp&quality=lossless" alt="Youtube">
                <img src="https://media.discordapp.net/attachments/1491487629529841754/1492134135374811296/face.png?ex=69ecaeb4&is=69eb5d34&hm=42882b6969ade2e3598265585dbf4a1a670e290f5e06ab2f9c429935360b14df&=&format=webp&quality=lossless" alt="Facebook">
                <img src="https://media.discordapp.net/attachments/1491487629529841754/1492134135085662359/linkedin.png?ex=69ecaeb4&is=69eb5d34&hm=e5d8c04795e2b090ba1d2967cbfaaa6b9407cb66155322d4e99fe0829be5d683&=&format=webp&quality=lossless" alt="Linkedin">
            </ul>
        </article>

        <article class="footer-group">
            <p>CONHEÇA O GRUPO QP:</p>
            <ul>
                <li><img src="https://assets.queropassagem.com.br/static/Images/Logos/rodoviaria-online.svg" alt="Rodon" /></li>
                <li><img src="https://assets.queropassagem.com.br/static/Images/Logos/viajo-mucho.svg" alt="Viajo Mucho" /></li>
                <li><img src="https://assets.queropassagem.com.br/static/Images/Logos/la-terminal.svg" alt="La Terminal" /></li>
            </ul>
        </article>
    </section>

    <!-- footer: pagamentos e segurança -->
    <section class="footer-payments">
        <article>
            <p>FORMAS DE PAGAMENTO</p>
            <ul>
                <li><img src="https://assets.queropassagem.com.br/static/Images/Logos/Pagamento/mastercard.svg" alt="Mastercard" /></li>
                <li><img src="https://assets.queropassagem.com.br/static/Images/Logos/Pagamento/visa.svg" alt="Visa" /></li>
                <li><img src="https://assets.queropassagem.com.br/static/Images/Logos/Pagamento/hipercard.svg" alt="Hipercard" /></li>
                <li><img src="https://assets.queropassagem.com.br/static/Images/Logos/Pagamento/american.svg" alt="American Express" /></li>
                <li><img src="https://assets.queropassagem.com.br/static/Images/Logos/Pagamento/elo.svg" alt="Elo" /></li>
                <li><img src="https://assets.queropassagem.com.br/static/Images/Logos/Pagamento/pix.svg" alt="Pix" /></li>
                <li><img src="https://assets.queropassagem.com.br/static/Images/Logos/Pagamento/mercado-pago.svg" alt="Mercado Pago" /></li>
                <li><img src="https://assets.queropassagem.com.br/static/Images/Logos/Pagamento/boleto.png" alt="Boleto" /></li>
                <li><img src="https://assets.queropassagem.com.br/static/Images/Logos/Pagamento/nupay.svg" alt="NuPay" /></li>
            </ul>
        </article>

        <article>
            <p>SEGURANÇA</p>
            <ul>
                <li><img src="https://assets.queropassagem.com.br/static/Images/Logos/cadastur.svg" alt="Cadastur" /></li>
                <li><img src="https://assets.queropassagem.com.br/static/Images/Icones/compra-segura.png" alt="Compra Segura" /></li>
            </ul>
        </article>
    </section>

    <!-- footer: copyright -->
    <section class="footer-copy">
        <p>Calçada das Margaridas, 163 - Sala 02 - Condomínio Centro Comercial Alphaville, Barueri - SP | CEP: 06453-038 | CNPJ: 18.087.991/0001-57 | saconibus@queropassagem.com.br</p>
        <p>Copyright 2026 © QueroPassagem.com.br</p>
    </section>

</footer>

<script src="home.js"></script>

</body>
</html>
