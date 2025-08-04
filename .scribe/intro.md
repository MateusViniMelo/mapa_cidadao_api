# Introduction

A Mapa Cidadão é uma API RESTful desenvolvida em Laravel, que permite aos usuários registrar, listar e gerenciar ocorrências urbanas de maneira simples, geolocalizada e segura.

<aside>
    <strong>Base URL</strong>: <code>http://localhost</code>
</aside>

O <strong>Mapa Cidadão</strong> é uma API RESTful desenvolvida com Laravel que permite o registro, a listagem e o gerenciamento de <strong>ocorrências urbanas</strong> geolocalizadas, como buracos em vias públicas, problemas de iluminação, lixo acumulado, entre outros.

Esta documentação fornece todas as informações necessárias para utilizar os recursos da API, incluindo autenticação, cadastro de usuários, envio de ocorrências com coordenadas geográficas e listagem pública.

<h4>🔐 Autenticação</h4>
Alguns endpoints exigem autenticação via token. Para isso, utilize o endpoint <code>/user/login</code> para obter um token de acesso e envie-o no cabeçalho das requisições protegidas:

<pre><code>Authorization: Bearer {seu_token}</code></pre>

<h4>🧪 Teste interativo</h4>
Você pode testar os endpoints diretamente nesta documentação utilizando o botão <strong>“Try it out”</strong>, disponível ao lado de cada rota.

<h4>📦 Formatos suportados</h4>
Todas as requisições devem ser enviadas no formato <code>application/json</code>, e a localização deve seguir o padrão <a href="https://tools.ietf.org/html/rfc7946" target="_blank">GeoJSON (RFC 7946)</a>.

---

