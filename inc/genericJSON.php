<?
	session_start();	

	include_once('bancofuncoes.php');
	include_once('funcoes.php');

	switch ($_POST['acao']) {
		case 'login':
			
			$id 	= $_POST['id'];
			$nome 	= $_POST['nome'];
			$email 	= $_POST['email'];
			$imagem = $_POST['imagem'];
			$dados	= array();

			$exe = executaSQL("SELECT * FROM pessoa WHERE email = '".$email."'");

			if(nLinhas($exe) > 0){
				$reg = objetoPHP($exe);

				$dados['status'] = true;
				$dados['msg'] = "Login efetuado com sucesso!";

				$_SESSION['idUser']		= $reg->id;
				$_SESSION['nomeUser']	= $nome;
				$_SESSION['emailUser'] 	= $email;
				$_SESSION['imgUser'] 	= $imagem;

			}else{
				$dados['status'] = false;
				$dados['msg'] = "Email não encontrado!";
			}

			echo json_encode($dados);
		break;

		case 'likeImagem':
			
				$idImagem = $_POST['id'];
				$votado = 0; //Variável que informa se já havido sido votado nesta imagem
				$totalLikes = $totalDislikes = 0;
				$dados = array();

				//Verifica se esse usuário já votou nesta imagem
				$exeVotos = executaSQL("SELECT * FROM imagem_votos WHERE id_imagem = '".$idImagem."'");
				if(nLinhas($exeVotos) > 0){
					while ($regVotos = objetoPHP($exeVotos)) {
						
						//Se já foi votado, deleta o voto
						if($regVotos->id_pessoa == $_SESSION['idUser']){
							excluirDados("imagem_votos", "id = '".$regVotos->id."'");
							

							if($regVotos->tipo == 1){
								$votado = 1;
								$totalLikes--; //Diminui um voto, afinal o voto foi retirado
							}elseif($regVotos->tipo == 2){
								$totalDislikes--; //Tira o dislike que foi dado, pois foi trocado pelo like
							}
						}

						if($regVotos->tipo == 1){ //se for like
							$totalLikes++;
						}elseif($regVotos->tipo == 2){ //dislike
							$totalDislikes++;
						}
					}
				}

				//Se ainda não foi votado
				if($votado == 0){

					//Salva o voto do usuário
					$dadosIns['id_pessoa'] = $_SESSION['idUser'];
					$dadosIns['id_imagem'] = $idImagem;
					$dadosIns['tipo']		= 1; //like
					if(inserirDados("imagem_votos", $dadosIns)){
						$dados["status"] = true;

						$totalLikes++;
					}
				}

				$dados['likes'] = $totalLikes;
				$dados['dislikes'] = $totalDislikes;

			echo json_encode($dados);
		break;

		case 'dislikeImagem':
			
				$idImagem = $_POST['id'];
				$votado = 0; //Variável que informa se já havido sido votado nesta imagem
				$totalLikes = $totalDislikes = 0;
				$dados = array();

				//Verifica se esse usuário já votou nesta imagem
				$exeVotos = executaSQL("SELECT * FROM imagem_votos WHERE id_imagem = '".$idImagem."'");
				if(nLinhas($exeVotos) > 0){
					while ($regVotos = objetoPHP($exeVotos)) {
						
						//Se já foi votado, deleta o voto
						if($regVotos->id_pessoa == $_SESSION['idUser']){
							excluirDados("imagem_votos", "id = '".$regVotos->id."'");
							
							if($regVotos->tipo == 2){
								$votado = 1;
								$totalDislikes--; //Diminui um voto, afinal o voto foi retirado
							}elseif($regVotos->tipo == 1){
								$totalLikes--; //Tira o like que foi dado, pois foi trocado pelo dislike
							}
						}

						if($regVotos->tipo == 1){ //se for like
							$totalLikes++;
						}elseif($regVotos->tipo == 2){ //dislike
							$totalDislikes++;
						}
					}
				}

				//Se ainda não foi votado
				if($votado == 0){

					//Salva o voto do usuário
					$dadosIns['id_pessoa'] = $_SESSION['idUser'];
					$dadosIns['id_imagem'] = $idImagem;
					$dadosIns['tipo']		= 2; //like
					if(inserirDados("imagem_votos", $dadosIns)){
						$dados["status"] = true;

						$totalDislikes++;
					}
				}

				$dados['likes'] = $totalLikes;
				$dados['dislikes'] = $totalDislikes;

			echo json_encode($dados);
		break;
		
		default:
			echo "Ação não encontrada";
			break;
	}
?>