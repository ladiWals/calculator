<?php 
// Основной блок исполнения логики

$error = false;

// Когда нажал на "равно"
if($_POST['submit']) {
	// Проверяю, числа ли мне передали в форме
	$num = '|^[\d.]+$|';
	if(preg_match($num, $_POST['first']) && preg_match($num, $_POST['second'])) {
		eval('$result=' . $_POST['first'] . $_POST['action'] . $_POST['second'] . ';');
	} else {
		$error = "Поля должны содержать только цифры и разделитель в виде точки!!!";
	}
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
	<div class="buttons">
		<form action="/" method="POST">
			<div class="radioList">
				<ul>
					<li><input type="radio" name="action" value="+" <?=$_POST['action'] == '+' || empty($_POST['action']) ? 'checked' : ''?>> + (сложение)</li>
					<li><input type="radio" name="action" value="-" <?=$_POST['action'] == '-' ? 'checked' : ''?>> - (вычитание)</li>
					<li><input type="radio" name="action" value="*" <?=$_POST['action'] == '*' ? 'checked' : ''?>> * (умножение)</li>
					<li><input type="radio" name="action" value="/" <?=$_POST['action'] == '/' ? 'checked' : ''?>> / (деление)</li>
				</ul>
			</div>
			<input type="text" name="first" size="10" value="<?=$_POST['first'] ?? ''?>">
			<label><?=$_POST['action'] ?? '_'?></label>
			<input type="text" name="second" size="10" value="<?=$_POST['second'] ?? ''?>">
			<input type="submit" name="submit" value="=">
			<label class="pseudoInput"><?=$result?></label>
			<br>
			<label class="error"><?=$error ? $error : ''?></label>
		</form>
	</div>
</body>