<?php
	//Имя пользователя и его пароль для аутентификации
	$username = 'rock';
	$password = 'roll';
	
	if (!isset($_SERVER['PHP_AUTH_USER']) ||
		!isset($_SERVER['PHP_AUTH_PW']) ||
		($_SERVER['PHP_AUTH_USER'] != $username) ||
		($_SERVER['PHP_AUTH_PW'] != $password)) {
		// Имя пользователя/пароль не действительны для отправки НТТР-заголовков,
		// подтверждающих аутентиФикацию
		header('НТТР/1.1 401 Unauthorized');
		header('WWW-Authenticate: Basic realm="Гитарные войны"');
		exit('<h2>Гитарные войны</h2>Извените вы должны ввести правильные' . 
				'имя пользователя и пароль, чтобы получить доступ к этой странице.');
	}
?>