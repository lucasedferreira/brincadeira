<!DOCTYPE html>
<html>
<head>
	<title>Imagens</title>
</head>
<body>

	<a href="index.php?page=inc/imagens/editar">Cadastro</a>
	<div class="container">
		<div class="row">
		<?
		    $exe = executaSQL("SELECT * FROM imagens ORDER BY RAND()");
		    if(nLinhas($exe) > 0){
		     	while($reg = objetoPHP($exe)){
		?>
			        <div class="card">
				    	<img class="card-img-top" src="<?=$reg->arquivo?>" alt="<?=$reg->titulo?>">
				    	<div class="card-body">
						    <h5 class="card-title"><?=$reg->titulo?></h5>
						    
						    <p class="card-text"><?=$reg->descricao?></p>
						    <p class="card-text"><small class="text-muted">Esta imagem está aqui apenas para teste</small></p>

							<p class="text-right">
								<a href="#" class="btn btn-success">Aprovar</a>
	                  			<a href="#" class="btn btn-outline-danger">Rejeitar</a>
	                  		</p>
				    	</div>
					</div>
		<?		}
		    }
		?>
		</div>
	</div>

</body>
</html>