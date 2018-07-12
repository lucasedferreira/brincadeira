<!DOCTYPE html>
<html>
	<head>

		<title>Inicio</title>

	</head>

	<body>

		<div class="alert alert-warning" role="alert">
			<h4 class="alert-heading">Bem vindo, </h4><?=$_SESSION['nomeUser']?>!</h4>
			<p>Este site está em sua fase beta :(</p>
			<p>Fique a vontade para navegar nas opções abaixo e relatar qualquer erro para nós</p>
			<hr>
			<p class="mb-0">Ass.: lukinhasgameplayetutoriais15</p>
		</div>

		<center>

			<div class="btn-group" role="group" aria-label="Button group with nested dropdown">
				<button type="button" class="btn btn-secondary" onclick="window.location='index.php?page=logout'">Logout</button>

				<div class="btn-group" role="group">
					<button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Imagens
					</button>
					<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
						<a class="dropdown-item" href="index.php?page=inc/imagens/listar">Listagem</a>
						<a class="dropdown-item" href="index.php?page=inc/imagens/cadastro">Cadastrar</a>
					</div>
				</div>
			</div>

			<div class="clear"></div>

			<img class="img" src="https://media1.tenor.com/images/850577b758b548fcaac70fb8abd55286/tenor.gif" height="330"/><br>

		</center>
	</body>
</html>
