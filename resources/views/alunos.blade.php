<!doctype html>
<html class="mdc-typography">
<head>
    <link
      rel="stylesheet"
      href="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.css">
</head>
<body>

<div class="mdc-layout">
@foreach($polos as $polo)
  <h3 class="mdc-typography--display2">{{ $polo->nome }}</h3>
  @if($polo->cursoComputacao)
  <h4 class="mdc-typography--display3">{{ $polo->cursoComputacao->nome }}</h4>
  <div class="mdc-grid-list">
      <ul class="mdc-grid-list__tiles">
      @foreach($polo->cursoComputacao->alunosComFoto as $aluno)
      <li class="mdc-grid-tile" style="--mdc-grid-list-tile-width: 200px;">
      <div class="mdc-grid-tile__primary">
          <img class="mdc-grid-tile__primary-content" src="{{ $aluno->url_avatar }}">
      </div>
      <span class="mdc-grid-tile__secondary">
        <span class="mdc-grid-tile__title">{{ $aluno->nome }}</span>
      </span>
      </li>
      @endforeach
      </ul>
  </div>
  @endif
@endforeach
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
<script>
  $(function(){
    $('.mdc-grid-tile__secondary').hide();
    $('.mdc-grid-tile').hover(function(){
      $(this).find('.mdc-grid-tile__secondary').show('500');
    }, function(){
      $(this).find('.mdc-grid-tile__secondary').hide('500');
    });
  });
</script>
</body>
</html>
