<!DOCTYPE html>
<html>
<head>
	<title>Chat</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="../css/chat.css" />
</head>
<body>
            <div class="chat-main">
                <div class="col-md-12 chat-header hide-chat-box">
                    <div class="row header-one text-white p-1">
                        <div class="col-md-6 name pl-2">
                            <i class="fa fa-comment"></i>
                            <h6 class="ml-1 mb-0">Chat</h6>
                        </div>
                        <div class="col-md-6 options text-right pr-0">
                            <i class="fa fa-window-minimize hover text-center pt-1"></i>
                            <!-- <p class="arrow-up mb-0">
                                <i class="fa fa-arrow-up text-center pt-1"></i>
                            </p>
                            <i class="fa fa-times hover text-center pt-1"></i> -->
                        </div>
                    </div>
                    <div class="row header-two w-100">
                        <div class="col-md-6 options-left pl-1">
                            <i class="fa fa-video-camera mr-3"></i>
                            <i class="fa fa-user-plus"></i>
                        </div>
                        <div class="col-md-6 options-right text-right pr-2">
                            <i class="fa fa-cog"></i>
                        </div>
                    </div>
                </div>
                <div class="chat-content">

                	<div id="msg" class="col-md-12 chats pt-3 pl-2 pr-3 pb-3">
                        <ul class="p-0">
							<div id="mensagens"></div>
                        </ul>
                    </div>

					<form method="post" onsubmit="enviar();return false;">
						<div class="col-md-12 p-2 msg-box border border-primary">
				            <div class="row">
				                <div class="col-md-2 options-left">
				                    <i class="fa fa-smile-o"></i>
				                </div>
				                <div class="col-md-7 pl-0">
				                    <input type="text" class="border-0" name="mensagens" id="mensagem" placeholder="Digite sua mensagem" maxlength="50" autocomplete="off">
				                </div>
				                <div class="col-md-3 text-right options-right">
				                    <i class="fa fa-picture-o mr-2"></i>
				                </div>
				            </div>
				        </div>
					</form>
				</div>
            </div>
</body>
</html>

<script>

	$('.hide-chat-box').click(function(){
        $('.chat-content').slideToggle();
 	});

	$(document).ready(function(){

		$('.chat-content').slideToggle();

		$('#mensagens').load('inc/chat/ver.php');
		var RefreshId = setInterval(function(){
			$('#mensagens').load('inc/chat/ver.php');

		}, 500);

		$.ajaxSetup({cache:false});
	});

	function ver(){
		var url;
		url = 'inc/chat/ver.php';
		jQuery.get(url, function(data){
			$('#mensagens').empty().append(data);
		});
	}

	function enviar(){
		var url;
		var mensagem;
		var enviando;

		url = 'inc/chat/enviar.php';
		mensagem = $('#mensagem').val();
		$('#mensagem').on('keyup', function(e){
			if(e.which == 13){
				var m = $(this).val();
				m = mensagem.trim();
				if(m.length >= 1){
					$(this).val('');
					enviando = $.post(url,{mensagem:mensagem});
					enviando.done(function(){
						mensagem = '';
						ver();
					});
				}
			}
		});
	}

</script>