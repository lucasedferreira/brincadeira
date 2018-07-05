<?
	//Função para mostrar mensagem na tela
	function mostraMensagem($mensagem="", $status=true){
		$_SESSION['mensagem'] = $mensagem;
		$_SESSION['mensagem_status'] = $status;
	}

	//Função para salvar um diretório
	function salvaDiretorio( $diretorios ){
		
		//Monta o diretório com as pastas passadas por array
		foreach( $diretorios as $diretorio ){
			
			$caminho .= $diretorio."/";
		}
		
		//Se a pasta não existir, é criada
		if( !is_dir( $caminho ) ){
			
			$caminho = '';
			
			foreach( $diretorios as $diretorio ){
			
			$caminho .= $diretorio."/";
				
				if( !is_dir( $caminho ) ){
					mkdir($caminho, 0777);
					chmod($caminho, 0777);
				}
				
			}
				
		}
		
		return $caminho;	
		
	}
?>