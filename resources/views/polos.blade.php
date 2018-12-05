<!doctype html>
<html class="mdc-typography">
<head>
    <link
      rel="stylesheet"
      href="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.css">
</head>
<body>

<div class="mdc-layout">
  <div class="mdc-grid-list">
      <ul class="mdc-grid-list__tiles">
@foreach($polos as $polo)
<a href="/alunos?polo_id={{ $polo->codigo_polo }}"<
      <li class="mdc-grid-tile" style="--mdc-grid-list-tile-width: 200px;">
      <div class="mdc-grid-tile__primary">
          <img class="mdc-grid-tile__primary-content" src="http://univesp.br/sites/58f6506869226e9479d38201/theme/images/logo-univesp.png?1507034207">
      </div>
      <span class="mdc-grid-tile__secondary">
        <span class="mdc-grid-tile__title">{{ $polo->nome }}</span>
      </span>
      </li>
</a>
@endforeach
      </ul>
  </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
</body>
</html>
