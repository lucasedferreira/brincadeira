<?
	include('conexao.php');

	//Inclui dados
	function inserirDados($tabela, $dados, $mostrar=false){
		include('conexao.php');
		$campos = $valores = array();
		foreach($dados as $chave => $valor){
			$campos[]  = $chave;
			$valores[] = $valor;
		}
		$campos  = join(',', $campos);
		$valores = join("','", $valores);
		$sql = "INSERT INTO ".$tabela." (".$campos.") values ('".$valores."');";
		
		if($mostrar) echo $sql;
		
		$exe = mysqli_query($conn, $sql);
		
		return $exe;
	}

	//Altera Dados
	function alterarDados($tabela, $dados, $clausula, $mostrar=false){
	//	if($mostrar)
	//		var_dump($dados);
		
		foreach ($dados as $chave=>$valor){
			$alts[] = $chave." = '".$valor."' ";
		}
		$lista_alts = join(",", $alts);
		
		$sql = "UPDATE $tabela SET $lista_alts WHERE $clausula ";
		
		if($mostrar) echo $sql;
		
		if(function_exists('registrarLog')){
			$idLog = registrarLog('alterar', $sql, $tabela);
		}
		
		include('conexao.php');
		$exe =  mysqli_query($conn, $sql);
		
		if($exe){
			if( function_exists('confirmaLog') )
				confirmaLog($idLog);
		}else{
			if( function_exists('errorLog') )
				errorLog($idLog);
		}
		
		return $exe;
	
	}

	//Função que pega o próximo ID da tabela informada. 
	function proximoId ($tabela){
		$exe = executaSQL("SELECT MAX(id) as id FROM ".$tabela);
		if(nLinhas($exe)>0){
			$proxId = objetoPHP($exe);
			return ($proxId->id + 1);
		}else
			return 1;
	}
	
	//Exclui Dados
	function excluirDados($tabela, $clausula, $mostrar=false){

		$sql = "DELETE FROM $tabela WHERE $clausula";
		
		if($mostrar) echo $sql;
		
		include('conexao.php');
		$exe =  mysqli_query($conn, $sql);
		
		return $exe;
	}

	//Retorna todos os campos de uma Consulta Simples, informando Tabela e Cláusula 
	function executaSQLPadrao($tabela, $clausula="1", $mostrar=false){
		
		$sql = "SELECT * FROM ".$tabela." WHERE ".$clausula;
		//echo $sql;
		if($mostrar==true) echo $sql;

		include('conexao.php');
		return mysqli_query($conn, $sql);
		//echo "SELECT * FROM $tabela WHERE $clausula ";
	}

	//Retorna a execução do SQL completo no Banco de Dados 
	function executaSQL($sql, $mostrar=false){
		
		if($mostrar==true) echo $sql;

		include('conexao.php');
		return mysqli_query($conn, $sql);
	}
	
	//Retorna um Objeto do Registro retornado na consulta
	function objetoPHP($exe){
		return mysqli_fetch_object($exe);
	}
	
	function arrayPHP($exe){
		return mysqli_fetch_array($exe);
	}
	
	//Retorna o Número de Registros da consulta
	function nLinhas($exe){
		return mysqli_num_rows($exe);
	}

	function consultaPessoaById($id){
		$exe = executaSQL("SELECT nome FROM pessoa WHERE id = '".$id."'");

		if(nLinhas($exe)>0){
			$reg = objetoPHP($exe);
			
			return $reg->nome;
		}

	}
?>