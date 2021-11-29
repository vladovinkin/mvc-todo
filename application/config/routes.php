<?php

return [
	'' => [
		'controller' => 'main',
		'action' => 'index',
	],
	'{page:\d+}' => [
		'controller' => 'main',
		'action' => 'index',
	],
	'account/register' => [
		'controller' => 'account',
		'action' => 'register',
	],
	'account/login' => [
		'controller' => 'account',
		'action' => 'login',
	],
	'account/logout' => [
		'controller' => 'account',
		'action' => 'logout',
	],
	'task/create' => [
		'controller' => 'task',
		'action' => 'create',
	],
	'task/update/{id:\d+}' => [
		'controller' => 'task',
		'action' => 'update',
	],
];