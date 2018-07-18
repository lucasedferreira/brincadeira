<!DOCTYPE html>
<html>
<head>
	<title>Imagens</title>
	<style type="text/css">
	</style>
</head>
<body>

	<div class="container">

		<div id="carouselTopImagens" class="carousel slide" data-ride="carousel" style="height:650px;">
			<div class="carousel-inner">
				<?php
					$exeMais = executaSQL("SELECT * FROM imagens ORDER BY media_likes DESC LIMIT 5");

					if(nLinhas($exeMais) > 0){
						$x=0; //posição
						while ($regMais = objetoPHP($exeMais)) {
							$size = getimagesize($regMais->arquivo);
							
							$proporsao = 650 / $size[1];
							$largura = $size[0] * $proporsao;
							$x++;
				?>
							<div class="carousel-item <?=$x==1 ? 'active' : ''?>">

								<center><img class="image d-block w-100" src="<?=$regMais->arquivo?>" alt="<?=$regMais->titulo?>" style="max-height: 650px; max-width: <?=$largura?>px"></center>

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

            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link text-info active" id="listar-tab" data-toggle="tab" href="#listar" role="tab" aria-controls="listar" aria-selected="true">Imagens</a>
                    <a class="nav-item nav-link text-info" id="cadastro-tab" data-toggle="tab" href="#cadastro" role="tab" aria-controls="cadastro" aria-selected="false">Cadastro</a>
                </div>
            </nav>
            <div class="clear"></div>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="listar" role="tabpanel" aria-labelledby="listar-tab">
                    <?php include_once('inc/imagens/listar.php'); ?>
                </div>
                <div class="tab-pane fade" id="cadastro" role="tabpanel" aria-labelledby="cadastro-tab">
                    <?php include_once('inc/imagens/cadastro.php'); ?>
                </div>
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

                    //Se ainda não tiver like
                    if($("#btn-like-"+id).hasClass('btn-outline-success')){

                    	//Muda o botão para preenchido
	                    $("#btn-like-"+id).addClass('btn-success');
	                    $("#btn-like-"+id).removeClass('btn-outline-success');

	                    //Desmarca o dislike
	                    $("#btn-dislike-"+id).removeClass('btn-danger');
	                    $("#btn-dislike-"+id).addClass('btn-outline-danger');
                    }else{
                    	$("#btn-like-"+id).removeClass('btn-success');
	                    $("#btn-like-"+id).addClass('btn-outline-success');
                    }
                
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

                    if($("#btn-dislike-"+id).hasClass('btn-outline-danger')){

	                    $("#btn-dislike-"+id).addClass('btn-danger');
	                    $("#btn-dislike-"+id).removeClass('btn-outline-danger');

	                    //Desmarca o like
	                    $("#btn-like-"+id).removeClass('btn-success');
	                    $("#btn-like-"+id).addClass('btn-outline-success');
                    }else{
                    	$("#btn-dislike-"+id).removeClass('btn-danger');
	                    $("#btn-dislike-"+id).addClass('btn-outline-danger');
                    }
                
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