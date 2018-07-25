<?php
	if( isset($_FILES['imagens']) ){
		$msg = array();
		$imagens = $_FILES['imagens'];
		foreach ($imagens['name'] as $key => $nomeImg) {
			
			$id = proximoId('imagens');

			$nome = explode(".", $nomeImg);
			$ext = end($nome);
			$caminho = salvaDiretorio(array("uploads", "imagens")).$id.".".$ext;
			$caminho_thumb = salvaDiretorio(array("uploads", "imagens", "thumb")).$id.".".$ext;

			$dados = array();
			$dados['id'] 			= $id;
			$dados['titulo'] 		= "teste - ".$id;
			$dados['id_tipo'] 		= 1;
			$dados['id_anime'] 		= 1;
			$dados['descricao'] 	= "";
			$dados['arquivo']		= $caminho;
			$dados['arquivo_thumb']	= $caminho_thumb;

			if(move_uploaded_file($imagens['tmp_name'][$key], $caminho)){

				redimensionaImagem( $caminho_thumb, $caminho, 700, 400, $ext );

				inserirDados('imagens', $dados);
			}
		}

		mostraMensagem("Registro salvo com sucesso!", true);
        header("Location: index.php?page=inc/imagens/listagem");
        die();

	}

?>

<div class="container">
	<form action="index.php?page=inc/imagens/varias" method="post" enctype="multipart/form-data" name="cadastro">

		<div class="form-group">

            <div class="clear"></div>

			<div class="alert-warning alert" role="alert">
				<i class="fa fa-exclamation-triangle"></i> Atenção!<br>
				Por aqui você pode selecionar diversas imagens de uma vez só, mas elas serão salvas com os seguintes dados:<br>
				- Título: Será gerado uma frase aleatória;<br>
				- Anime: Outros;<br>
				- Tipo: Outros;<br>
				- Descrição: Vazia.<br>
			</div>

			<div class="row">
				<div class="col-md-12">
				  	<div class="form-group">
					    <label for="imagem">Imagem</label>
					    <input type="file" class="form-control-file" id="imagens" name="imagens[]" multiple="multiple" required>
				  	</div>
				</div>
			</div>

		</div>

		<div class="form-actions left">
			<button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Salvar</button>
			<button type="button" class="btn btn-outline-danger" onclick="window.location='index.php?page=inc/imagens/listagem'">Cancelar</button>
		</div>
	</form>
</div>
