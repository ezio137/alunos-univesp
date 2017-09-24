<?php

use \App\Curso;
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

$router->get('atualizar-polos', function() {
    Polo::all()->each->delete();

    $client = new GuzzleHttp\Client();
    $res = $client->get('http://www.vestibularunivesp.com.br/classificacao/univesp.asp');

    $body = $res->getBody(true);
    $crawler = new Crawler((string) $body);
    $crawler = $crawler->filter('#CodUnivesp option');

    foreach ($crawler as $i => $item) {
        $opcao = new Crawler($item);
        $nome = $opcao->text();
        $codigo_polo = $opcao->attr('value');
        Polo::create(compact('nome', 'codigo_polo'));
    }

    return Polo::all();
});

$router->get('atualizar-cursos', function() {
    Curso::all()->each->delete();
    $client = new GuzzleHttp\Client();

    $polo = Polo::where('codigo_polo', '83')->first();

    Polo::all()->each(function($polo) use ($client) {
        $res = $client->post('http://www.vestibularunivesp.com.br/classificacao/lista.asp', [
            'form_params' => [
                'CodUnivesp' => $polo->codigo_polo
            ]
        ]);

        $body = $res->getBody(true);
        $crawler = new Crawler((string)$body);
        $crawler = $crawler->filter('#CodEscolaCurso option');

        foreach ($crawler as $i => $item) {
            $opcao = new Crawler($item);
            $polo_id = $polo->_id;
            $nome = $opcao->text();
            $codigo_curso = $opcao->attr('value');
            Curso::create(compact('polo_id', 'nome', 'codigo_curso'));
        }
    });

    return Curso::all();
});