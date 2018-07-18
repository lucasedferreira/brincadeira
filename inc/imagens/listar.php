<div class="card-columns">
		<?php
			$exe = executaSQL("SELECT * FROM imagens ORDER BY RAND()");

		    if(nLinhas($exe) > 0){
		     	while($reg = objetoPHP($exe)){
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
		?>
			        <div class="card text-white bg-dark mb-3 border-light">
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
										<a href="javascript:void(0);" id="btn-like-<?=$reg->id?>" data-id="<?=$reg->id?>" class="btn <?=$votou==1 ? 'btn-success' : 'btn-outline-success'?> like"><i class="fas fa-thumbs-up"></i></a>
			                  			<a href="javascript:void(0);" id="btn-dislike-<?=$reg->id?>" data-id="<?=$reg->id?>" class="btn <?=$votou==2 ? 'btn-danger' : 'btn-outline-danger'?> dislike"><i class="fas fa-thumbs-down"></i></a>
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