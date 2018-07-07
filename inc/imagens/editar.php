<?php
	if($_POST){

		if(isset($_FILES['imagem'])){

			$id = proximoId('imagens');

			$nome = explode(".", $_FILES['imagem']['name']);
			$ext = end($nome);
			$caminho = salvaDiretorio(array("uploads", "imagens")).$id.".".$ext;
			$caminho_thumb = salvaDiretorio(array("uploads", "imagens", "thumb")).$id.".".$ext;

			$dados['id'] 			= $id;
			$dados['titulo'] 		= trim($_POST['titulo']);
			$dados['id_tipo'] 		= intval($_POST['tipo']);
			$dados['id_anime'] 		= intval($_POST['anime']);
			$dados['descricao'] 	= $_POST['descricao'];
			$dados['arquivo']		= $caminho;
			$dados['arquivo_thumb']	= $caminho_thumb;

			if( move_uploaded_file($_FILES['imagem']['tmp_name'], $caminho) ){
				
				redimensionaImagem( $caminho_thumb, $caminho, 700, 400, $ext );

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

<div class="container">
	<form action="index.php?page=inc/imagens/editar" method="post" enctype="multipart/form-data" name="cadastro">

		<div class="form-group">
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label for="exampleFormControlInput1">Título</label>
						<input type="text" class="form-control" name="titulo" id="titulo" required>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="anime">Anime</label>
						<select class="form-control" id="anime" name="anime" required>
						    <option value="">Selecione o anime</option>
						    <?php
						    	$exe = executaSQL("SELECT * FROM animes ORDER BY nome");

						    	if(nLinhas($exe) > 0){
						    		while ($reg = objetoPHP($exe)) {
						    ?>
						    			<option value="<?=$reg->id?>"><?=$reg->nome?></option>
						    <?php
						    		}
						    	}
						    ?>
						</select>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="tipo">Tipo</label>
						<select class="form-control" id="tipo" name="tipo" required>
						    <option value="">Selecione o tipo</option>
						    <option value="1">Desktop</option>
						    <option value="2">Mobile</option>
						    <option value="3">Outros</option>
						</select>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
					    <label for="descricao">Descrição</label>
					    <textarea class="form-control" id="descricao" name="descricao" rows="3"></textarea>
				  	</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
				  	<div class="form-group">
					    <label for="imagem">Imagem</label>
					    <input type="file" class="form-control-file" id="imagem" name="imagem">
				  	</div>
				</div>
			</div>
		</div>

		<div class="form-actions left">
			<button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Salvar</button>
			<button type="button" class="btn btn-outline-secondary" onclick="window.location='index.php?page=inc/imagens/listar'">Cancelar</button>
		</div>
	</form>
</div>