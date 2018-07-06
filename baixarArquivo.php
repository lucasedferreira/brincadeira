<?
	session_start();

	include_once('inc/conexao.php');
	include_once('inc/bancofuncoes.php');
	include_once('inc/funcoes.php');

	if(isset($_GET['campos']))
		$campos	= $_GET['campos'];
	else
		$campos = "arquivo";

	if(isset($_GET['tabela'])){
		$tabela		= $_GET['tabela'];
	}else{
		header("Location: index.php");
		mostraMensagem("Erro no download.", false);
	}
		
	if(isset($_GET['condicao'])){
		$condicao	= $_GET['condicao'];
	}else{
		header("Location: index.php");
		mostraMensagem("Erro no download.", false);
	}

	$exeFile = executaSQL("SELECT ".$campos." AS arquivo FROM ".$tabela." WHERE ".$condicao);
		
	if(nLinhas($exeFile)>0){
		
		$file = objetoPHP($exeFile);
		if(is_file($file->arquivo)){
		
			$ext = explode(".",$file->arquivo);
			$extensao = end($ext);
			$nomeArquivo = "imagem_iukinze.".$extensao;
			
			header('Content-type: octet/stream');
			header("Content-disposition: attachment; filename=".basename($nomeArquivo));
			header('Content-Length: '.filesize($file->arquivo));
			readfile($file->arquivo);
			exit;
		}else{
			header("Location: index.php");
			mostraMensagem("Arquivo não existe.", false);
		}
	}else{
		header("Location: index.php");
		mostraMensagem("Registro não encontrado.", false);
	}
?>