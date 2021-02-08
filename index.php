<?php 
// Основной блок исполнения логики

$error = false;
$result = '';
$logAction = [];
$logAction[] = [123, '+', 789, 912];

if($_POST['action']) {
	$num = '|^[\d.]+$|'; // Шаблон числа
	$first = $_POST['first'];
	$second = $_POST['second'];

	// Проверяю, числа ли мне передали в форме
	if(preg_match($num, $first) && preg_match($num, $second)) {
		if($_POST['action'] == '/' && $second == 0) {
			$error = "На ноль делить нельзя!!!";
		} else {
			eval('$result=' . $first . $_POST['action'] . $second . ';');

			// Пишу в лог
			$logRow = $first . ' ' . $_POST['action'] . ' ' . $second . ' ' .$result . '\r';
			$fileDesc = fopen("history.txt", 'a');
			fwrite($fileDesc, $logRow);
			fclose($fileDesc);
		}
	} else {
		$error = "Вводить только цифры!!!";
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
		<h1>Предыдущие вычисления</h1>
		<div class="log">
		<ul>
			<?php foreach($logAction as $sample) {?>
				<li>
					<?=$sample[0] . ' ' . $sample[1] . ' ' . $sample[2] . ' = ' . $sample[3]?>
				</li>
			<?php } ?>
		</ul>
	</div>
</body>