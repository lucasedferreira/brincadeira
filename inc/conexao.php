<?php
	//0- local
	//1- remoto
	$localRemoto = 1;

	if($localRemoto==0){
		$host = "localhost";
		$user = "root";
		$pass = "";
		$banco = "iukinze";
	}else{
		$host = "mysql785.umbler.com";
		$user = "iukinze";
		$pass = "m{x#5XZ*Q5";
		$banco = "iukinze";
	}

	$conn = mysqli_connect($host, $user, $pass, $banco) or die("Impossível conectar-se ao servidor ".$host);
?>
