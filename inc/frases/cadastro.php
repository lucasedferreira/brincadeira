<?php
	if($_POST){

		if(count($_FILES['imagem']) > 0){
			foreach ($_POST['titulo'] as $key => $titulo) {
				$id = proximoId('imagens');

				$nome = explode(".", $_FILES['imagem']['name'][$key]);
				$ext = end($nome);
				$caminho = salvaDiretorio(array("uploads", "imagens")).$id.".".$ext;
				$caminho_thumb = salvaDiretorio(array("uploads", "imagens", "thumb")).$id.".".$ext;

				$dados = array();
				$dados['id'] 			= $id;
				$dados['titulo'] 		= trim($titulo);
				$dados['id_tipo'] 		= intval($_POST['tipo'][$key]);
				$dados['id_anime'] 		= intval($_POST['anime'][$key]);
				$dados['descricao'] 	= $_POST['descricao'][$key];
				$dados['arquivo']		= $caminho;
				$dados['arquivo_thumb']	= $caminho_thumb;

				move_uploaded_file($_FILES['imagem']['tmp_name'][$key], $caminho);

				redimensionaImagem( $caminho_thumb, $caminho, 700, 400, $ext );

				inserirDados('imagens', $dados);

			}

			mostraMensagem("Registro salvo com sucesso!", true);
			header("Location: index.php?page=inc/imagens/listar");
			die();
		}else{
			mostraMensagem("Erro no upload da(s) imagem(ns).", false);
		}

		header("Location: index.php?page=inc/imagens/cadastro");
		die();
	}
?>

	<div class="container">
		<div class="card text-white bg-dark border-info">
	        <h5 class="card-header">Cadastro</h5>
	        <div class="card-body">
	            <div class="form-group">

	            <div class="clear"></div>

	            <div class="row text-center">
	                <div class="col-md-12">
	                    <div class="btn-group" role="group" aria-label="Basic example">
	                        <button type="button" class="btn btn-secondary"><span id="quant">1</span></button>
	                        <a href="javascript:void(0);" id="add_foto_rapida" class="btn btn-primary" title="Adicionar mais uma foto" alt="Adicionar mais uma foto">
	                            <i class="fa fa-plus"></i> Adicionar mais uma imagem
	                        </a>
	                    </div>
	                </div>
	            </div>
	            <input class="hidden" id="quant_frases" value="1">

	            <div class="clear"></div>

				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="frase">Frase</label>
							<input type="text" class="form-control" name="frase[0]" id="frase" required>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="anime">Anime</label>
							<div class="input-group">
								<select class="custom-select" id="anime">
									<option selected>Selecione o anime</option>
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
								<div class="input-group-append">
									<button class="btn btn-outline-primary" type="button" onclick="window.open('index.php?page=inc/animes/cadastro','_blank');"><i class="fas fa-plus"></i></button>
								</div>
							</div>
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<label for="autor">Autor</label>
							<div class="input-group">
								<select class="custom-select" id="autor" name="autor[0]"></select>
								<div class="input-group-append">
									<button class="btn btn-outline-primary" type="button" onclick="window.open('index.php?page=inc/personagens/cadastro','_blank');"><i class="fas fa-plus"></i></button>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div id="adiconar_foto_rapida"></div>

			</div>

			<div class="form-actions left">
				<button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Salvar</button>
				<button type="button" class="btn btn-outline-secondary" onclick="window.location='index.php?page=inc/imagens/listar'">Cancelar</button>
			</div>
	        </div>
	    </div>
    </div>

<script>
	$(function(){
		let x = total = 0;

		$('#add_foto_rapida').click(function(){
			x++;

			let conteudo = "";

			conteudo += '	<div id="row-'+ x +'">'
			conteudo += '		<hr>';

			conteudo += '		<div class="row">';
			conteudo += '			<div class="col-md-6">';
			conteudo += '				<div class="form-group">';
			conteudo += '					<label for="exampleFormControlInput1">Título</label>';
			conteudo += '					<input type="text" class="form-control" name="titulo['+ x +']" id="titulo" required>';
			conteudo += '				</div>';
			conteudo += '			</div>';
            conteudo += '			<div class="col-md-6">';
			conteudo += '				<div class="form-group">';
			conteudo += '					<label for="anime">Anime</label>';
			conteudo += '					<select class="form-control" id="anime" name="anime['+ x +']" required>';
			conteudo += '				    <option value="">Selecione o anime</option>';
										    <?php
										    	$exe = executaSQL("SELECT * FROM animes ORDER BY nome");
										    	if(nLinhas($exe) > 0){
										    		while ($reg = objetoPHP($exe)) {
										    ?>
			conteudo += '					    			<option value="<?=$reg->id?>"><?=$reg->nome?></option>';
										    <?php
										    		}
										    	}
										    ?>
			conteudo += '					</select>';
			conteudo += '				</div>';
			conteudo += '			</div>';
			conteudo += '		</div>';

			conteudo += '		<div class="row">';
			conteudo += '			<div class="col-md-6">';
			conteudo += '				<div class="form-group">';
			conteudo += '					<label for="tipo">Tipo</label>';
			conteudo += '					<select class="form-control" id="tipo" name="tipo['+ x +']" required>';
			conteudo += '					    <option value="">Selecione o tipo</option>';
			conteudo += '					    <option value="1">Desktop</option>';
			conteudo += '					    <option value="2">Mobile</option>';
			conteudo += '					    <option value="3">Outros</option>';
			conteudo += '					</select>';
			conteudo += '				</div>';
			conteudo += '			</div>';
			conteudo += '			<div class="col-md-5">';
			conteudo += '			  	<div class="form-group">';
			conteudo += '				    <label for="imagem">Imagem</label>';
			conteudo += '				    <input type="file" class="form-control-file" id="imagem" name="imagem['+ x +']">';
			conteudo += '			  	</div>';
			conteudo += '			</div>';
            conteudo +=	'		    <div class="col-md-1">';
			conteudo +=	'		     	<div class="form-group">';
			conteudo +=	'		     		 <a href="javascript:void(0);" id="excluir-'+ x +'" data-number="' + x + '" class="btn btn-danger" title="Excluir" alt="Excluir">';
            conteudo +=	'		    			<i class="fa fa-times"></i>';
            conteudo +=	'		    		</a>';
			conteudo +=	'		     	</div>';
			conteudo +=	'		    </div>';
			conteudo += '		</div>';

			conteudo +=	'	</div>';


			$('#adiconar_foto_rapida').append(conteudo);

            //Atualiza quantidade total
            total = parseInt($('#quant_frases').val()) + 1;
            $('#quant').html( total );
            $('#quant_frases').val( total );

			$('#excluir-'+ x).click(function(){
				number = $(this).attr('data-number');
				$('#row-' + number).remove();

                total = parseInt($('#quant_frases').val()) - 1;
                $('#quant').html( total );
                $('#quant_frases').val( total );
			});

		});

		$( "#anime" ).change(function() {
			if($(this).val() > 0){

				$.ajax({
                url: 'inc/genericJSON.php',
                type: 'post',
                data: {
                        acao:   'populaSelectPersonagens',
                        idAnime: $(this).val()
                },
                cache: false,
                success: function(data) {

                    if(data.status){
console.dir('teste');
                    	var options = $('#autor');
	                    options.find('option').remove();
	                    $('<option>').val(0).text("Selecione o autor").appendTo(options);
	                    for(var i = 0; i < data.quant; i++){
	                        $('<option>').val(data.id).text(data.nome).appendTo(options);
	                        //options += '<option value="' + key + '">' + value + '</option>';
	                    }

                    }else{
                    	options.find('option').remove();
                    	$('<option').val(0).text("Erro ao carregar personagens").appendTo(options);
                    }
                
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    alert(XMLHttpRequest.responseText);
                    //console.dir(XMLHttpRequest.responseText);
                },
                dataType: 'json'
            });
			}
		});
	})
</script>
