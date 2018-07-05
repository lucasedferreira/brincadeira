<?
	session_destroy();
	session_start();
	header("Location: index.php?page=login");
?>
<script>signOut();</script>