<?	
	if($_POST){

		if(isset($_FILES['imagem'])){

			$id = proximoId('imagens');

			$nome = explode(".", $_FILES['imagem']['name']);
			$ext = end($nome);
			$caminho = "uploads/imagens/".$id.".".$ext;

			$dados['id'] 		= $id;
			$dados['titulo'] 	= $_POST['titulo'];
			$dados['descricao'] = $_POST['descricao'];
			$dados['arquivo']	= $caminho;

			if( move_uploaded_file($_FILES['imagem']['tmp_name'], $caminho) ){
				if(inserirDados('imagens', $dados)){

					mostraMensagem("Registro salvo com sucesso!", true);
					header("Location: index.php?page=inc/imagens/listar");
					die();
				}else{
					mostraMensagem("Erro ao inserir os dados.", false);
				}
			}else{
				mostraMensagem("Erro ao salvar a imagem.", false);
			}
		}else{
			mostraMensagem("Erro no upload da imagem.", false);
		}
		
		header("Location: index.php?page=inc/imagens/editar");
		die();
	}
?>

<form action="index.php?page=inc/imagens/editar" method="post" enctype="multipart/form-data" name="cadastro">
	Digite o titulo aqui
	<br>
	<input type="text" name="titulo" id="titulo" required>
	<br><br>
	Descricao
	<br>
	<textarea name="descricao" id="descricao" required></textarea>
	<br><br>
	Imagem
	<br>
	<input type="file" name="imagem" id="imagem" required>
	<br><br>
	<input type="submit" value="Enviar">
</form>