<?php

use \App\Polo;
use \Symfony\Component\DomCrawler\Crawler;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('polos', function() {
    return Polo::all();
});

$router->get('atualizar', function() {
    Polo::all()->each->delete();

    $client = new GuzzleHttp\Client();
    $res = $client->get('http://www.vestibularunivesp.com.br/classificacao/univesp.asp');

    $body = $res->getBody(true);
    $crawler = new Crawler((string) $body);
    $crawler = $crawler->filter('#CodUnivesp option');

    foreach ($crawler as $i => $item) {
        $opcao = new Crawler($item);
        $nome = $opcao->text();
        $codigo_univesp = $opcao->attr('value');
        Polo::create(compact('nome', 'codigo_univesp'));
    }
    return 'ok';
});