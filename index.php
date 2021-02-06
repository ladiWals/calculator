<?php 
// Основной блок исполнения логики
if($_POST['submit']) {
	switch($_POST['action']) {
		case '+':
			$result = $_POST['first'] + $_POST['second'];
			break;
		case '-':
			$result = $_POST['first'] - $_POST['second'];
			break;
		case '*':
			$result = $_POST['first'] * $_POST['second'];
			break;
		case '/':
			$result = $_POST['first'] / $_POST['second'];
			break;
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
	<!-- <pre><?//php var_dump($_POST);?></pre> -->
	<div class="buttons">
		<form action="/" method="POST">
			<div class="radioList">
				<ul>
					<li><input type="radio" name="action" value="+"> + (сложение)</li>
					<li><input type="radio" name="action" value="-"> - (вычитание)</li>
					<li><input type="radio" name="action" value="*"> * (умножение)</li>
					<li><input type="radio" name="action" value="/"> / (деление)</li>
				</ul>
			</div>
			<input type="text" name="first" size="10" value="<?=$_POST['first'] ?? ''?>">
			<label><?=$_POST['action'] ?? '_'?></label>
			<input type="text" name="second" size="10" value="<?=$_POST['second'] ?? ''?>">
			<input type="submit" name = "submit" value="=">
			<label class="pseudoInput"><?=$result?></label>
		</form>
	</div>
</body>