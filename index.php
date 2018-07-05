<!-- PLUGIN JQUERY -->
<script src="js/jquery-1.11.3.min.js" type="text/javascript"></script>

<!-- FONT-AWESOME -->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

<!-- BOOTSTRAP CSS -->
<link rel="stylesheet" type="text/css" href="css/bootstrap-grid.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap-grid.min.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap-reboot.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap-reboot.min.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">

<!-- BINI -->
<link rel="stylesheet" type="text/css" href="css/estilo-bini.css">

<!-- BOOTSTRAP JS -->
<script src="js/bootstrap.bundle.js" type="text/javascript"></script>
<script src="js/bootstrap.bundle.min.js" type="text/javascript"></script>
<script src="js/bootstrap.js" type="text/javascript"></script>
<script src="js/bootstrap.min.js" type="text/javascript"></script>

<!-- API GOOGLE LOGIN -->
<script src="https://apis.google.com/js/platform.js" async defer></script>
<meta name="google-signin-client_id" content="1075703487707-cgoqfaalqul1goq1154h0bvbkujj00ke.apps.googleusercontent.com">
<script src="https://apis.google.com/js/platform.js?onload=renderButton" async defer></script>

<script src="js/funcoes.js" type="text/javascript"></script>

<link rel="icon"  type="dragon-icon/png" href="images/dragon_icon.png" />

<meta charset="utf-8">

<?
	session_start();

	include_once('inc/conexao.php');
	include_once('inc/bancofuncoes.php');
	include_once('inc/funcoes.php');

	if($_SESSION['idUser'] > 0){

		if($_SESSION['mensagem'] != ""){
?>
			<div class="alert-<?=($_SESSION['mensagem_status'] ? 'success' : 'danger')?> alert" role="alert"><?=$_SESSION['mensagem']?></div>
<?			$_SESSION['mensagem'] = "";
		}

		$page = "inicio.php";
		if( isset($_GET['page']) ){
			$page = $_GET['page'].".php";
		}

		if( is_file($page) ){
			include($page);
		}else{
			include("error404.php");
		}

		include('inc/chat/chat.php');
		
	}else{
		include('login.php');
	}
?>