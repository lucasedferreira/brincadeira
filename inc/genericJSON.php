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
		
		default:
			echo "Ação não encontrada";
			break;
	}
?>