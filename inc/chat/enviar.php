<?
	include('../conexao.php');
	include('../bancofuncoes.php');
	session_start();

	if($_SESSION['idUser'] > 0){
		$nome 		= $_SESSION['nomeUser'];
		$mensagem 	= trim($_POST['mensagem']);
		$hora 		= date('H:i:s');
		$ip 		= $_SERVER['REMOTE_ADDR'];


		//FILTRO DE PALAVRÕES
		$exp = explode(" ", $mensagem);
		foreach ($exp as $key => $value) {

			switch (strtolower($value)) {
				case 'puta':
				case 'porra':
				case 'poha':
				case 'arrombado':
				case 'merda':
				case 'caralho':
				case 'krl':
				case 'cu':
				case 'buceta':

				$numLetras = strlen($value);
				$value = "";
				for($x = 0; $x < $numLetras; $x++){
					$value .= "*";
				}

				break;
			}

			$exp[$key] = $value;
		}

		$mensagem = implode(" ", $exp);

		$dados = array();
		$dados['nome'] 		= $nome;
		$dados['id_pessoa'] = $_SESSION['idUser'];
		$dados['mensagem'] 	= $mensagem;
		$dados['hora'] 		= $hora;
		$dados['ip'] 		= $ip;
		inserirDados('chat_historico', $dados);
	}
?>