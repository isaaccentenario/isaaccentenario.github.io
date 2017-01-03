$(function(){
	
	function formInfo( status ) {
		var sucess = $(".form-info .sucess");
		var error = $(".form-info .error");
		if( status == true ) {
			sucess.fadeIn("fast",function(){
				setTimeout(function(){ sucess.fadeOut('fast');},3000 );
			});
		} else {
			error.fadeIn("fast",function(){
				setTimeout(function(){ error.fadeOut('fast');},3000 );
			});
		}
	}
	$(".parceiro img").each(function(){
		if( $(window).width() > 767 ) {
			$(this).load(function(){
				var height = $(this).height();
				height = -( height / 2 );
				if( height != 0 ) {
					$(this).css({
						"position" : "relative",
						"margin-top" : "50%",
						"top" : height + 'px'
					});
				}
			});
		}
	});
	$(".contact-form").submit( function(event){
		$(".submit").prop( 'disabled', true );
		var loader = $(".loader");
		event.preventDefault();
		var nome = $(".nome").val();
		var email = $(".email").val();
		var assunto = $(".assunto").val();
		var mensagem = $(".mensagem").val();
		loader.show();
		if( nome.length < 5 ) {
			alert('Nome inválido');
			$(".nome").focus();
			loader.hide();
		} else if( email.length < 5 ) {
			alert('Email inválido');
			$(".email").focus();
			loader.hide();
		} else if( assunto.length < 5 ) {
			alert('Assunto inválido');
			$(".assunto").focus();
			loader.hide();
		} else if( mensagem.length < 5 ) {
			alert('Mensagem inválido');
			$(".mensagem").focus();
			loader.hide();
		} else {
			var data_form = {
				nome:nome,
				email:email,
				assunto:assunto,
				mensagem:mensagem
			};
			$.post( "sendmail.php", data_form, function(data){
				loader.hide();
				var data = $.parseJSON(data);
				
				$(".submit").prop( 'disabled', false );
				if( data.send == true ) {
					$(".contact-form").find('input, textarea').val('');
					formInfo( true );
				} else {
					formInfo( false );
				}
			});
		}
	});
	/** scroll suave */
	$("a[href*='#']").click(function(event) {
		event.preventDefault();
		var path = $(this).attr("href");
		var location = $(path);
		
		$("html, body").stop().animate({
			scrollTop: location.offset().top - 70
		},'slow',function(){});
	});
	$( document ).scroll(function(){
		var obj = $(this);
		var top = obj.scrollTop();
		$(".menu li a").each(function(){
			var selector = $($(this).attr("href"));
			var selector_top = selector.offset().top;
			var height = selector.height();

			if( selector_top <= top && top <= selector_top + height ) {
				$("*").removeClass("in-selector");
				$(this).addClass("in-selector");
			}

		});
	});
});