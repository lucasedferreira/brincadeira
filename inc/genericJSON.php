<?php
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

			$dadosImg['media_likes'] = $totalLikes - $totalDislikes;
			alterarDados("imagens", $dadosImg, "id = '".$idImagem."'");

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

			//Atualiza a média de likes na tabela imagens
			$dadosImg['media_likes'] = $totalLikes - $totalDislikes;
			alterarDados("imagens", $dadosImg, "id = '".$idImagem."'");

			echo json_encode($dados);
		break;

		case 'populaSelectPersonagens':
			$idAnime = $_POST['idAnime'];
			$x = 0;
			$dados = array();

			if($idAnime > 0){

				$exe = executaSQL("SELECT * FROM personagens WHERE id_anime = '".$idAnime."'");
				if(nLinhas($exe) > 0){
					while ($reg = objetoPHP($exe)) {
						$dados['id'][$x]   = $reg->id;
						$dados['nome'][$x] = $reg->nome;

						$x++;
					}
					$dados['status'] = true;
					$dados['quant'] = $x;
				}else{
					$dados['status'] = false;
				}
			}else{
				$dados['status'] = false;
			}

			echo json_encode($dados);
		break;

		case 'populaImagens':
			
			$limit 	= $_POST['limit'];
			$offset = $_POST['offset'];

			$exe = executaSQL("SELECT * FROM imagens LIMIT ".$limit." OFFSET ".$offset);

			if(nLinhas($exe) > 0){
				while ( $reg = objetoPHP($exe) ) {

					$totalLikes = $totalDislikes = $votou = 0;

		     		//Calcula todal de likes e dislikes
		     		$exeVotos = executaSQL("SELECT * FROM imagem_votos WHERE id_imagem = '".$reg->id."'");
		     		if(nLinhas($exeVotos) > 0){

		     			while ($regVotos = objetoPHP($exeVotos)) {

		     				if($regVotos->tipo == 1){ //like
		     					$totalLikes++;

		     					if($regVotos->id_pessoa == $_SESSION['idUser'])
		     						$votou = 1;

		     				}elseif($regVotos->tipo == 2){
		     					$totalDislikes++;

		     					if($regVotos->id_pessoa == $_SESSION['idUser'])
		     						$votou = 2;

		     				}
		     			}
		     		}

					$dados[] =  '<div class="card text-white bg-dark mb-3 border-light">
							    	<img class="card-img-top" src="'.($reg->arquivo_thumb != "" ? $reg->arquivo_thumb : $reg->arquivo).'" alt="'.$reg->titulo.'">

							    	<div class="card-body">
									    <h5 class="card-title">'.$reg->titulo.'</h5>
									    
								        <small class="text-muted">
									    	<cite title="Source Title">'.consultaAnimeById($reg->id_anime).'</cite>
									    </small>
									    
									    <p class="card-text">'.$reg->descricao.'</p>

							    	</div>
							    	<div class="card-footer">
							    		<table width="100%">
							    			<tr>
							    				<td align="left">
										    		<a href="baixarArquivo.php?tabela=imagens&condicao=id='.$reg->id.'" target="_blank" class="btn btn-primary"><i class="fas fa-download"></i></a>
							    				</td>
							    				<td align="right">
							    					<span id="like-'.$reg->id.'" class="text-success">'.$totalLikes.'</span>
													<a href="javascript:void(0);" id="btn-like-'.$reg->id.'" data-id="'.$reg->id.'" class="btn '.($votou==1 ? 'btn-success' : 'btn-outline-success').' like"><i class="fas fa-thumbs-up"></i></a>
						                  			<a href="javascript:void(0);" id="btn-dislike-'.$reg->id.'" data-id="'.$reg->id.'" class="btn '.($votou==2 ? 'btn-danger' : 'btn-outline-danger').' dislike"><i class="fas fa-thumbs-down"></i></a>
						                  			<span id="dislike-'.$reg->id.'" class="text-danger">'.$totalDislikes.'</span>
							    				</td>
							    			</tr>
							    		</table>

								    </div>
								</div>';
				}

			}else{
				$dados[] = "";
			}
			
			echo json_encode($dados);

		break;
		
		default:
			echo "Ação não encontrada";
			break;
	}
?>