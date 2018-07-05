<!DOCTYPE html>
<html>
	<head>
		
		<title>Inicio</title>

		<link rel="stylesheet" type="text/css" href="css/estilo-inicio.css">

	</head>

	<body>

		<div class="header">	
		
				Início <br>
				Página em progresso<br>
				

		</div>

		<div class="php">

		<?
		echo $_SESSION['nomeUser']."<br>";
		echo $_SESSION['emailUser'];
		?>

		</div>
		<br>
		Testando deploy automático
		<br>
		<a href="index.php?page=logout">Sair</a><br>
		<a href="index.php?page=testeouqualquercoisa">Ir para uma página super legal</a><br>
		<a href="index.php?page=putzgrila">putz grila</a><br>
		<a href="index.php?page=inc/imagens/listar">imagens</a>
		<br>
		<center>

			<img class="img" src="https://media1.tenor.com/images/850577b758b548fcaac70fb8abd55286/tenor.gif" height="330"/><br>

		</center>
	</body>
</html>
