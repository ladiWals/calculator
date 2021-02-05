<?php 
// Основной блок исполнения логики
$result = 0;
?>

<!DOCTYPE html>
<head>
	<title>Калькулятор</title>
	<link rel="SHORTCUT ICON" href="favicon.ico" type="image/x-icon">
	<link rel="stylesheet" href="styles.css">
</head>

<body>
	<h1>Простейший калькулятор</h1>
	<div class="buttons">
		<form>
			<input type="text" name="first" size="10">
			<input type="text" name="second" size="10">
			<input type="submit" value="=">
			<span class="pseudoInput">
				<label><?=$result?></label>
			</span>
		</form>
	</div>
</body>