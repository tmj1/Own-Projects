<?php

$mysqli = new Mysqli('localhost', 'artlined_questionare', 'mobifon123', 'artlined_questionare');
/** Получаем наш ID статьи из запроса */
$name = trim($_POST['name']);
$email = trim($_POST['email']);
$age = intval($_POST['age']);
$question1 = intval($_POST['question1']);
$question2 = intval($_POST['question2']);
$question3 = intval($_POST['question3']);


echo $points;
if ($question1 == 1) $points=$points + 1;
if ($question2 == 2) $points=$points + 1;
if ($question3 == 1) $points=$points + 1;

/** Если нам передали ID то обновляем */
if($name && $email && $age){
	//вставляем запись в БД
	$query = $mysqli->query("INSERT INTO `users` VALUES(NULL, '$name', '$email', '$age', '$points')");
	$query3 = $mysqli->query("INSERT INTO `pools` VALUES(NULL, '$email', '$question1', '$question2', '$question3')");
	
	
	
	//извлекаем все записи из таблицы
	$query2 = $mysqli->query("SELECT * FROM `users` ORDER BY `id` DESC");

	while($row = $query2->fetch_assoc()){
		$users['id'][] = $row['id'];
		$users['name'][] = $row['name'];
		$users['email'][] = $row['email'];
		$users['age'][] = $row['age'];
		$users['points'][] = $row['points'];
	
	}

	$message = 'Все хорошо!';
}else{
	$message = 'Не удалось записать и извлечь данные';
}


/** Возвращаем ответ скрипту */

// Формируем масив данных для отправки
$out = array(
	'message' => $message,
	'users' => $users
);

// Устанавливаем заголовот ответа в формате json
header('Content-Type: text/json; charset=utf-8');

// Кодируем данные в формат json и отправляем
echo json_encode($out);

