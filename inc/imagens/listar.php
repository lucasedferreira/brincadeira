<div class="card-columns imagens"></div>

<script>
	
	$(document).ready(function(){

		var flag = 0;

		$.ajax({

			url: 'inc/genericJSON.php',
            type: 'post',
            data: {
                    acao:   'populaImagens',
                    offset:  flag,
                    limit: 3
            },
            cache: false,
            success: function(data) {

            	for (var i = data.length - 1; i >= 0; i--) {
            		$(".imagens").append(data[i]);
            		flag += 3;
            	}
            
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                alert(XMLHttpRequest.responseText);
                //console.dir(XMLHttpRequest.responseText);
            },
            dataType: 'json'

		});

		$(window).scroll(function(){

			if($(window).scrollTop() >= $(document).height() - $(window).height()){

				$.ajax({

					url: 'inc/genericJSON.php',
		            type: 'post',
		            data: {
		                    acao:   'populaImagens',
		                    offset:  flag,
		                    limit: 3
		            },
		            cache: false,
		            success: function(data) {

		            	for (var i = data.length - 1; i >= 0; i--) {
		            		$(".imagens").append(data[i]);
		            		flag += 3;
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

	});

</script>