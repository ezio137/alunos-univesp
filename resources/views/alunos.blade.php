<doctype html>
<html>
<head>
</head>
<body>
<ul>
@foreach($polos as $polo)
<li>
  {{ $polo->nome }}
  @foreach($polo->cursos as $curso)
  <ul>
    <li>
      {{ $curso->nome }}
      @foreach($curso->alunos as $aluno)
      <ul>
        <li>
          {{ $aluno->nome }}
        </li>
      </ul>
      @endforeach
    </li>
  </ul>
  @endforeach
</li>
@endforeach
</ul>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</body>
</html>
