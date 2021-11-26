<?php 
use application\models\Account;
?>
<!DOCTYPE html>
<html>
<head>
	<title><?= $title; ?></title>
	<script src="/public/scripts/jquery.js"></script>
	<script src="/public/scripts/form.js"></script>
	<script type="text/javascript" src="/public/scripts/bootstrap.min.js"></script>
	<link href="/public/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
		<div class="container">
			<a class="navbar-brand" href="#">ToDoList</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarNavAltMarkup">
				<div class="navbar-nav">
					<a class="nav-link active" href="/">Главная <span class="sr-only">(current)</span></a>
					<?=
					(Account::isAuth()
						? '<a class="nav-link" href="/account/logout">Выход('.$_SESSION['authorize']['login'].')</a>' 
						: '<a class="nav-link" href="/account/register">Регистрация</a><a class="nav-link" href="/account/login">Вход</a>') 
					?>
				</div>
			</div>
		</div>
	</nav>
	<div class="container">
		<?= $content; ?>
	</div>
</body>
</html>