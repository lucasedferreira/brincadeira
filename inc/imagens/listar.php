<?
	$params = "1=1";
	if($tipo > 0){
		$params = "id_tipo = '".$tipo."'";
	}else{
		$params = "id_tipo = '1'";
	}
	$exe = executaSQL("SELECT * FROM imagens WHERE ".$params." ORDER BY RAND()");
?>

<!DOCTYPE html>
<html>
<head>
	<title>Imagens</title>
</head>
<body>

	<div class="container">
		<div class="card">
			<h5 class="card-header">Filtro</h5>
			<div class="card-body">
				<div class="row">
					<div class="col-md-6">
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="titulo">Título</label>
									<input type="text" class="form-control" name="titulo" id="titulo" required>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="clear"></div>

		<div class="card-columns">
		<?
		    if(nLinhas($exe) > 0){
		     	while($reg = objetoPHP($exe)){
		     		$totalLikes = $totalDislikes = 0;

		     		//Calcula todal de likes e dislikes
		     		$exeVotos = executaSQL("SELECT * FROM imagem_votos WHERE id_imagem = '".$reg->id."'");
		     		if(nLinhas($exeVotos) > 0){
		     			while ($regVotos = objetoPHP($exeVotos)) {

		     				if($regVotos->tipo == 1) //like
		     					$totalLikes++;
		     				elseif($regVotos->tipo == 2)
		     					$totalDislikes++;
		     			}
		     		}
		?>
			        <div class="card text-white bg-dark border-info">
				    	<img class="card-img-top" src="<?=$reg->arquivo_thumb != "" ? $reg->arquivo_thumb : $reg->arquivo?>" alt="<?=$reg->titulo?>">

				    	<div class="card-body">
						    <h5 class="card-title"><?=$reg->titulo?></h5>
						    
					        <small class="text-muted">
						    	<cite title="Source Title"><?=consultaAnimeById($reg->id_anime)?></cite>
						    </small>
						    
						    <p class="card-text"><?=$reg->descricao?></p>

						    
				    	</div>
				    	<div class="card-footer">
				    		<table width="100%">
				    			<tr>
				    				<td align="left">
							    		<a href="baixarArquivo.php?tabela=imagens&condicao=id=<?=$reg->id?>" target="_blank" class="btn btn-primary"><i class="fas fa-download"></i></a>
				    				</td>
				    				<td align="right">
				    					<span id="like-<?=$reg->id?>" class="text-success"><?=$totalLikes?></span>
										<a href="javascript:void(0);" data-id="<?=$reg->id?>" class="btn btn-success like"><i class="fas fa-thumbs-up"></i></a>
			                  			<a href="javascript:void(0);" data-id="<?=$reg->id?>" class="btn btn-outline-danger dislike"><i class="fas fa-thumbs-down"></i></a>
			                  			<span id="dislike-<?=$reg->id?>" class="text-danger"><?=$totalDislikes?></span>
				    				</td>
				    			</tr>
				    		</table>

					    </div>
					</div>
		<?		}
		    }
		?>
		</div>
	</div>

</body>
</html>

<script>
	$(function(){
						
		$('.like').click(function(){

			let id = $(this).attr('data-id');

			$.ajax({
                url: 'inc/genericJSON.php',
                type: 'post',
                data: {
                        acao:   'likeImagem',
                        id:     id
                },
                cache: false,
                success: function(data) {

                    $("#like-"+id).html(data.likes);
                    $("#dislike-"+id).html(data.dislikes);
                
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    alert(XMLHttpRequest.responseText);
                    //console.dir(XMLHttpRequest.responseText);
                },
                dataType: 'json'
            });
		});

		$('.dislike').click(function(){

			let id = $(this).attr('data-id');

			$.ajax({
                url: 'inc/genericJSON.php',
                type: 'post',
                data: {
                        acao:   'dislikeImagem',
                        id:     id
                },
                cache: false,
                success: function(data) {

                    $("#like-"+id).html(data.likes);
                    $("#dislike-"+id).html(data.dislikes);
                
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    alert(XMLHttpRequest.responseText);
                    //console.dir(XMLHttpRequest.responseText);
                },
                dataType: 'json'
            });
		});
		
	});
</script>