
<?
	include('../conexao.php');
	include('../bancofuncoes.php');
	session_start();

	if($_SESSION['idUser'] > 0){
		$nome 		= $_SESSION['nomeUser'];
		$exe = executaSQL("SELECT * FROM chat_historico");

		echo "<p>Seja bem-vindo ".$nome.", use o chat com moderação</p><br>";
		if(nLinhas($exe) > 0){
			while($reg = objetoPHP($exe)){
				$nome 		= $reg->nome;
				$mensagem 	= $reg->mensagem;
				$hora 		= $reg->hora;
				$ip			= $reg->ip;

				if($reg->id_pessoa == $_SESSION['idUser']){
					$mensagem = '<li class="send-msg float-right mb-2">
	                                <p class="pt-1 pb-1 pl-2 pr-2 m-0 rounded">
	                                    '.$mensagem.'
	                                </p>
	                            </li>';
				}else{

					$mensagem = '<li class="receive-msg float-left mb-2">
									<div class="sender-img">
	                                    <img src="../../images/user.png" class="float-left">
	                                </div>
	                                <div class="receive-msg-desc float-left ml-2">
	                                    <p class="bg-white m-0 pt-1 pb-1 pl-2 pr-2 rounded">
	                                        '.$mensagem.'
	                                    </p>
	                                </div>
	                            </li>';
				}

				echo $mensagem;

			}
		}else{
			echo "<p>Nenhuma mensagem até o momento...</p>";
		}
		
	}
?>