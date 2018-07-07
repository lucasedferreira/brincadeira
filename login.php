<?php
	$msg = "";
	if(!empty($_SESSION['idUser'])){
		header('Location: index.php?page=inicio');
		die();
	}

	if($_POST){
		$exe = executaSQL("SELECT * FROM pessoa WHERE email = '".$_POST['email']."'");

		if(nLinhas($exe) > 0){
			$reg = objetoPHP($exe);

			if($reg->senha == md5($_POST['senha'])){
				$_SESSION['idUser']		= $reg->id;
				$_SESSION['nomeUser']	= $reg->nome;
				$_SESSION['emailUser'] 	= $reg->email;
				$_SESSION['imgUser'] 	= $reg->foto;

				header('Location: index.php?page=inicio');
				die();
			}else{
				$msg = "Senha não compatível com o email!";
			}
		}else{
			$msg = "Email não encontrado!";
		}
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Login</title>
		<link rel="stylesheet" type="text/css" href="css/estilo-login.css">
	</head>
	<body class="login">
		<div class="container">
			<div class="row">
				<div class="col-sm-5 col-md-5" id="box">
					<div class="card">
						<div class="card-body">
							<a href="index.php?page=cadastro" class="float-right btn btn-outline-primary">Cadastre-se</a>
							<h4 class="card-title mb-4 mt-1">Login</h4>
							<p>
								<div id="my-signin2" class="g-signin2" data-onsuccess="onSignIn" align="center"></div>
							</p>
							<!-- <div class="row">
								<div class="col-xs-6 col-sm-6 col-md-6">
						        	<a href="#" class="btn btn-lg btn-primary btn-block">Facebook</a>
						        </div>
						        <div class="col-xs-6 col-sm-6 col-md-6">
						        	<a href="#" class="btn btn-lg btn-info btn-block">Google</a>
						        </div>
					    	</div> -->
							<hr>
							<?php	if(!empty($msg)){ ?>
									<div id="msg" class="alert-warning alert" role="alert"><?=$msg?></div>
							<?php	}else{ ?>
									<div id="msg" class="" role="alert"></div>
							<?php	} ?>
							<form method="post" action="index.php?page=login">
							    <div class="form-group">
							        <input class="form-control" placeholder="Email" type="email" id="email" name="email" required>
							    </div> <!-- form-group// -->
							    <div class="form-group">
							        <input class="form-control" placeholder="******" type="password" id="senha" name="senha" required>
							    </div> <!-- form-group// -->                                      
							    <div class="row">
							        <div class="col-md-6">
							            <div class="form-group">
							                <button type="submit" class="btn btn-primary btn-block">Login</button>
							            </div> <!-- form-group// -->
							        </div>
							        <!-- <div class="col-md-6 text-right">
							            <a class="small" href="#">Forgot password?</a>
							        </div> -->
							    </div> <!-- .row// -->                                                                  
							</form>

						</div>
					</div> <!-- card.// -->
				</div>
			</div>
		</div>
	</body>
</html>

<script>
	function renderButton() {
	  gapi.signin2.render('my-signin2', {
	    'scope': 'profile email',
	    'longtitle': true,
	    'theme': 'dark',
	  });
	}
</script>