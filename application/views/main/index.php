<?php
$loader = new \Twig\Loader\FilesystemLoader("templates");
$twig = new \Twig\Environment($loader, [
    'cache' => 'compilation_cache',
]);

echo ($is_authorized
	? $twig->render('index.html', [
		'tasks' => $tasks,
		'pagination' => $pagination,
	])
	: $twig->render('index_noauth.html'));
?>