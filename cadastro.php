<?
	if($_POST){
		$exe = executaSQL("SELECT * FROM pessoa WHERE email = '".$_POST['email']."'");

		if(nLinhas($exe) > 0){
			$msg = "Este email já está sendo usado!";
		}else{
			$dados = array();
			$dados['email'] = $_POST['email'];
			$dados['senha'] = md5($_POST['senha']);
			$dados['nome'] 	= $_POST['nome'];
			$dados['foto'] 	= $_POST['foto'];

			$exe = inserirDados("pessoa", $dados);

			if($exe){
				header("Location: index.php?page=inicio");
				die();
			}else{
				$msg = "Erro ao efetuar cadastro!";
			}
		}
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Cadastro</title>
	</head>
	<body class="login">
		<div class="container">
			<div class="row">
				<div class="col-sm-5 col-md-5">
					<div class="card">
						<div class="card-body">
							<a href="index.php?page=login" class="float-right btn btn-outline-primary">Login</a>
							<h4 class="card-title mb-4 mt-1">Cadastro</h4>
							<p>
								<div class="g-signin2" data-onsuccess="onSignIn" align="center"></div>
							</p>
							<hr>
							<?	if($msg != ""){ ?>
									<div id="msg" class="alert-warning alert" role="alert"><?=$msg?></div>
							<?	}else{ ?>
									<div id="msg" class="" role="alert"></div>
							<?	} ?>
							<form method="post" action="index.php?page=cadastro" enctype="multipart/form-data">
								<div class="form-group">
							        <input class="form-control" placeholder="Nome" type="text" id="nome" name="nome" required>
							    </div> <!-- form-group// -->
							    <div class="form-group">
							        <input class="form-control" placeholder="Email" type="email" id="email" name="email" required>
							    </div> <!-- form-group// -->
							    <div class="form-group">
							        <input class="form-control" placeholder="******" type="password" id="senha" name="senha" required>
							    </div> <!-- form-group// -->
							    <div class="form-group">
							        <input class="form-control" type="file" id="foto" name="foto" required>
							    </div> <!-- form-group// -->
							    <div class="row">
							        <div class="col-md-6">
							            <div class="form-group">
							                <button type="submit" class="btn btn-primary btn-block">Cadastrar</button>
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
	//$("#msg").fadeOut( 2000 );
</script>