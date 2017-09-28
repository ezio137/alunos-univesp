<?php

use \App\Aluno;
use \App\Curso;
use \App\Polo;
use \Symfony\Component\DomCrawler\Crawler;
use \Illuminate\Http\Request;

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
    //return $router->app->version();
    $exemplo = <<<'EOT'
$('.author').each(function(){<br>
&nbsp;&nbsp;$.ajax({url:'https://alunos-univesp.fagan.com.br/alunos', data:{nome: $(this).text().trim().toUpperCase()}, context: this})<br>
&nbsp;&nbsp;&nbsp;&nbsp;.done(function(resposta){<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;if(resposta && resposta.length > 0){<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$(this).append(' - '+resposta[0].polo);<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;}<br>
&nbsp;&nbsp;&nbsp;&nbsp;});<br>
});
EOT;
    return $exemplo;
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

$router->get('atualizar-alunos', function() {
    Aluno::all()->each->delete();
    $client = new GuzzleHttp\Client();

    Curso::where('nome', 'like', '%Compu%')
        ->get()
        ->each(function($curso) use ($client) {
        $res = $client->get('http://www.vestibularunivesp.com.br/classificacao/lista.asp', [
            'query' => [
                'codunivesp' => $curso->polo->codigo_polo,
                'codescolacurso' => $curso->codigo_curso,
                'o' => 1,
            ]
        ]);

        $body = $res->getBody(true);
        $crawler = new Crawler((string)$body);
        $crawler = $crawler->filter('table tr');

        foreach ($crawler as $i => $item) {
            $linha = new Crawler($item);
            $curso_id = $curso->_id;
            $nome = $linha->children()->eq(2)->text();
            Aluno::create(compact('curso_id', 'nome'));
        }
    });

    return Aluno::all();
});

$router->get('alunos', function(Request $request) {
    $nome = strtoupper($request->get('nome'));
    $alunos = Aluno::where('nome', 'like', "%$nome%")
        ->get()
        ->map(function($aluno) {
            return [
                'nome' => $aluno->nome,
                'curso' => $aluno->curso->nome,
                'polo' => $aluno->curso->polo->nome,
            ];
        });
    return $alunos;
});
