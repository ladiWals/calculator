<?php 
// Основной блок исполнения логики

$error = false;
$result = '';

require_once('connection.php');
$link = mysqli_connect($host, $user, $password, $database) or die("Ошибка " . mysqli_error($link));

// Обработка полученной формы
if($_POST['action']) {
	$num = '|^[\d.]+$|'; // Шаблон числа
	$first = $_POST['first'];
	$second = $_POST['second'];
	$action = $_POST['action'];

	// Проверяю, числа ли мне передали в форме
	if(preg_match($num, $first) && preg_match($num, $second)) {
		if($_POST['action'] == '/' && $second == 0) { // Ошибка если делю на ноль
			$error = "На ноль делить нельзя!!!";
		} else { // Если всё в порядке

			// Вычисление результата
			eval('$result=' . $first . $_POST['action'] . $second . ';');

			$newAction = $first . $action . $second . $result;

			if($_COOKIE['lastRow'] != $newAction) {

				// Внесение нового лога в БД
				$res = mysqli_query($link, 
					"INSERT INTO calculator_logs (first, second, action, result) VALUES ('$first', '$second', '$action', '$result')") 
				or die("Ошибка " . mysqli_error($link));

				// Кукаю последнее действие
				setcookie('lastRow', $newAction);
			}
		}
	} else {
		$error = "Вводить только цифры!!!";
	}
}

if($_POST['clearLog']) {
	unset($_COOKIE['lastRow']);
	$res = mysqli_query($link, "DELETE FROM calculator_logs") or die("Ошибка " . mysqli_error($link));
}

?>

<!DOCTYPE html>
<head>
	<meta charset="utf-8">
	<title>Калькулятор</title>
	<link rel="SHORTCUT ICON" href="favicon.ico" type="image/x-icon">
	<link rel="stylesheet" href="styles.css">
</head>

<body>
	<h1>Простейший калькулятор</h1>
	<div class="mainField">
		<form action="/" method="POST">
			<table>
				<tr>
					<td>
					</td>
					<td>
						<input type="submit" name="action" value="+" <?=isset($_POST['action']) && $_POST['action'] == '+' 
							|| empty($_POST['action']) ? 'checked' : ''?>>
					</td>
				</tr>
				<tr>
					<td>
					</td>
					<td>
						<input type="submit" name="action" value="-" <?=isset($_POST['action']) && $_POST['action'] == '-' 
							|| empty($_POST['action']) ? 'checked' : ''?>>
					</td>
				</tr>
				<tr>
					<td>
						<input type="text" name="first" size="10" value="<?=$_POST['first'] ?? ''?>">
					</td>
					<td>
						<input type="submit" name="action" value="*" <?=isset($_POST['action']) && $_POST['action'] == '*' 
							|| empty($_POST['action']) ? 'checked' : ''?>>
					</td>
					<td>
						<input type="text" name="second" size="10" value="<?=$_POST['second'] ?? ''?>">
					</td>
					<td>
						<label class="pseudoInput"><?='=' . $result?></label>
					</td>
				</tr>
				<tr>
					<td>
					</td>
					<td>
						<input type="submit" name="action" value="/" <?=isset($_POST['action']) && $_POST['action'] == '/' 
							|| empty($_POST['action']) ? 'checked' : ''?>>
					</td>
				</tr>
				<tr>
					<td>
					</td>
					<td>
						<input type="submit" name="action" value="**" <?=isset($_POST['action']) && $_POST['action'] == '**' 
							|| empty($_POST['action']) ? 'checked' : ''?>>
					</td>
				</tr>
			</table>
			<label class="error"><?=$error ? $error : ''?></label>
		</form>
	</div>
	<div class="log">
		<h2>Предыдущие вычисления</h2>
		<ul>
			<?php

			// Получаю все логи из таблицы БД
			$res = mysqli_query($link, $readLogQuery = "SELECT first, second, action, result FROM calculator_logs") or die("Ошибка " . mysqli_error($link));

			// Извлечение данных запроса
			for ($data = []; $row = mysqli_fetch_assoc($res); $data[] = $row);

			foreach($data as $logRow) { ?>
				<li>
					<?=$logRow['first'] . ' ' . $logRow['action'] . ' ' . $logRow['second'] . ' = ' . $logRow['result']?>
				</li>
			<?php
			}

			// закрываем подключение
			mysqli_close($link);
			?>
		</ul>
		<form action="/" method="POST">
			<input type="submit" name="clearLog" value="Очистить историю">
		</form>
	</div>
</body>