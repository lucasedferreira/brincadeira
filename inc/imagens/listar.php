<?php
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
	<style type="text/css">
		.image{
			max-height: 750px;
		}
	</style>
</head>
<body>

	<div class="container">

		<div id="carouselTopImagens" class="carousel slide" data-ride="carousel" style="height:750px;">
			<div class="carousel-inner">
				<?php
					$exeMais = executaSQL("SELECT * FROM imagens ORDER BY media_likes DESC LIMIT 5");

					if(nLinhas($exeMais) > 0){
						$x=0; //posição
						while ($regMais = objetoPHP($exeMais)) {
							$x++;
				?>
							<div class="carousel-item <?=$x==1 ? 'active' : ''?>">
								<img class="image d-block w-100" src="<?=$regMais->arquivo?>" alt="<?=$regMais->titulo?>">

								<div class="carousel-caption d-none d-md-block">
							    	<h5><?=$regMais->titulo?></h5>
							    	<p><?=$regMais->descricao?></p>
								</div>
							</div>
				<?php
						}
					}
				?>
				
			</div>
			<a class="carousel-control-prev" href="#carouselTopImagens" role="button" data-slide="prev">
				<span class="carousel-control-prev-icon" aria-hidden="true"></span>
				<span class="sr-only">Anterior</span>
			</a>
			<a class="carousel-control-next" href="#carouselTopImagens" role="button" data-slide="next">
				<span class="carousel-control-next-icon" aria-hidden="true"></span>
				<span class="sr-only">Próxima</span>
			</a>
		</div>

		<div class="clear"></div>

		<div class="card-columns">
		<?php
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
		<?php		}
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