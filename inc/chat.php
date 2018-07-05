<!DOCTYPE html>
<html>
<head>
	<title>Chat</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="../css/chat.css" />
</head>
<body>

	<div id="mensagens"></div>
	<form method="post">
		<input type="text" name="mensagens" id="mensagem" placeholder="Digite sua mensagem" maxlength="50" autocomplete="off">
	</form>
</body>
</html>

<script>
	function ver(){
		var url;
		url = 'ver.php';
		jQuery.get(url, function(data){
			$('#mensagens').empty().append(data);
		});
	}
	function enviar(){
		var url;
		var mensagem;
		var enviando;

		url = 'enviar.php';
		mensagem = $('#mensagem').val();
		$('#mensagem').on('keyup', function(e){
			if(e.which == 13){
				var m = $(this).val();
				if(m.length >= 1){
					$(this).val('');
					enviando = $.post(url,{mensagem:mensagens});
					enviando.done(function(){
						mensagem = '';
						ver();
					});
				}
			}
		});
	}

	//2:26
</script>