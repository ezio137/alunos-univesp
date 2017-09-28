$('.author').each(function(){
  $.ajax({url:'https://alunos-univesp.fagan.com.br/alunos', data:{nome: $(this).text().trim().toUpperCase()}, context: this})
    .done(function(resposta){
      if(resposta && resposta.length > 0){
        $(this).append(' - '+resposta[0].polo);
      }
    });
});