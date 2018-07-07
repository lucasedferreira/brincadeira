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

	//Função que remimensiona a imagem
	function redimensionaImagem($caminho_img,$imagem_original,$toWidth,$toHeight,$ext){
		
		$tamanho = getimagesize($imagem_original);
		$width = $tamanho[0];
		$height = $tamanho[1];
		
		if($width > $toWidth || $height > $toHeight){
		
			$scaleX = ($toWidth  / $width );
			$scaleY = ($toHeight / $height);
			
			$radio = min($scaleX,$scaleY);
			
			$newWidth = $radio * $width;
			$newHeight = $radio * $height;
			
		}else{
			
			$newWidth = $width;
			$newHeight = $height;
			
		}
		
		$caminho = $caminho_img;
		$imageResize = imagecreatetruecolor($newWidth,$newHeight);
		
		switch($ext){
			
			case "png":
				$image = imagecreatefrompng($imagem_original);
				break;
			case "gif":
				$image = imagecreatefromgif($imagem_original);
				break;
			default:
				$image = imagecreatefromjpeg($imagem_original);
				break;		
				
		}
		
		imagecopyresampled($imageResize,$image,0,0,0,0,$newWidth,$newHeight,$width,$height);
		imagejpeg($imageResize,$caminho,90);
	}
?>