function signOut() {
    var auth2 = gapi.auth2.getAuthInstance();
    auth2.signOut().then(function () {
    	console.log('User signed out.');
	});
}

function onSignIn(googleUser) {

	var profile = googleUser.getBasicProfile();
	var id 		= profile.getId();
	var nome 	= profile.getName();
	var imagem 	= profile.getImageUrl();
	var email 	= profile.getEmail();
	var token	= googleUser.getAuthResponse().id_token;

	//document.getElementById('msg').innerHTML = email;

	if(email != ''){

		$.ajax({
                url: 'inc/genericJSON.php',
                type: 'post',
                data: {
                    acao: 'login',
                    id:  	id,
                    nome: 	nome,
                    imagem: imagem,
                    email:  email,
                },
                cache: false,
                async: false,

                success: function(data) {

                    if(data.status){
						$("#msg").addClass("alert-success alert");
						$("#msg").html(data.msg);
						window.location.href = "index.php?page=inicio";
					}else{
						$("#msg").addClass("alert-warning alert");
						$("#msg").html(data.msg);
						window.location.href = "index.php?page=login";
						signOut();
					}
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    alert(XMLHttpRequest.responseText);
                },
                dataType: 'json'
                
            });

	}else{
		var msg = "Usuário não encontrado!";
		document.getElementById('msg').innerHTML = msg;	
	}
}