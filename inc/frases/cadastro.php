<?php
	if($_POST){

		$id = proximoId('frases');

		$dados = array();
		$dados['id'] 			= $id;
		$dados['frase'] 		= $_POST['frase'];
		$dados['id_personagem'] = intval($_POST['autor']);

		if(inserirDados('frases', $dados, 1)){
			mostraMensagem("Registro salvo com sucesso!", true);
			header("Location: index.php?page=inc/frases/listar");
			die();
		}else{
			mostraMensagem("Erro no cadastro da frase.", false);
		}

		header("Location: index.php?page=inc/frases/cadastro");
		die();

	}

?>

	<form action="index.php?page=inc/frases/cadastro" method="post">
		<div class="container">
			<div class="card text-white bg-dark border-info">
		        <h5 class="card-header">Cadastro</h5>
		        <div class="card-body">
		            <div class="form-group">

		            <div class="clear"></div>

					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
							<label for="frase">Frase</label>
							<textarea class="form-control" id="frase" name="frase" rows="3" required></textarea>
					  	</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="anime">Anime</label>
								<div class="input-group">
									<select class="custom-select" id="anime" required>
										<option selected>Selecione o anime</option>
									    <?php
									    	/*$exe = executaSQL("SELECT * FROM animes ORDER BY nome");

									    	if(nLinhas($exe) > 0){
									    		while ($reg = objetoPHP($exe)) {
									    ?>
									    			<option value="<?=$reg->id?>"><?=$reg->nome?></option>
									    <?php
									    		}
									    	}*/
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
									<select class="custom-select" id="autor" name="autor" required>
										<option selected>Selecione o Anime</option>
									</select>
									<div class="input-group-append">
										<button class="btn btn-outline-primary" type="button" onclick="window.open('index.php?page=inc/personagens/cadastro','_blank');"><i class="fas fa-plus"></i></button>
									</div>
								</div>
							</div>
						</div>
					</div>

				</div>

				<div class="form-actions left">
					<button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Salvar</button>
					<button type="button" class="btn btn-outline-secondary" onclick="window.location='index.php?page=inc/frases/listar'">Cancelar</button>
				</div>
		        </div>
		    </div>
	    </div>
    </form>

<script>
	$(function(){

		$( "#anime" ).change(function() {

			$.ajax({
                url: 'inc/genericJSON.php',
                type: 'post',
                data: {
                        acao:   'populaSelectPersonagens',
                        idAnime: $(this).val()
                },
                cache: false,
                success: function(data) {

                    
                    var options = $('#autor');
	                options.find('option').remove();
                    if(data.status){
                    	
	                    $('<option>').val(0).text("Selecione o autor").appendTo(options);

	                    for(var i = 0; i < data.quant; i++){
	                        $('<option>').val(data.id[i]).text(data.nome[i]).appendTo(options);
	                        //options += '<option value="' + key + '">' + value + '</option>';
	                    }

                    }else{

                    	$('<option>').val(0).text("Selecione o Anime").appendTo(options);
                    }
                
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    alert(XMLHttpRequest.responseText);
                    //console.dir(XMLHttpRequest.responseText);
                },
                dataType: 'json'
        	});
		});
	})
</script>
