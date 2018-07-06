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
		?>
			        <div class="card text-white bg-dark border-info">
				    	<img class="card-img-top" src="<?=$reg->arquivo?>" alt="<?=$reg->titulo?>">

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
				    					
											<a href="google.com" class="btn btn-success"><i class="fas fa-thumbs-up"></i></a>
				                  			<a href="#" class="btn btn-outline-danger"><i class="fas fa-thumbs-down"></i></a>
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