$('.author').each(function(){
  urlAvatar = $(this).parents('header').find('.avatar').css('background-image');
  if (urlAvatar) {
    urlAvatar = urlAvatar.substring(5, urlAvatar.length - 2);
    $.ajax({url:'https://alunos-univesp.fagan.com.br/atualizar-avatar', data:{nome: $(this).text().trim().toUpperCase(), 'url-avatar': urlAvatar}, context: this})
      .done(function(resposta){
        if(resposta){
          $(this).append(' - OK');
	  if(resposta == 'true'){
	    alert('atualizado! '+$(this).text());
	  }
        }
      });
  }
});
