<?php
$errors = "";
$db = mysqli_connect("localhost", "root", "", "todolist");
if (isset($_POST['submit'])) {
	if (empty($_POST['task']) or empty($_POST['discribe']) or empty($_POST['date1'])) {
		$errors = "پر کردن تمامی فیلدها اجباری است!";
	} else {
		$task = $_POST['task'];
		$id = time();
		$date1 = $_POST['date1'];
		$discribe = $_POST['discribe'];
		$sql = "INSERT INTO tasks2 (task, id, date, discribe) VALUES ('$task', '$id', '$date1', '$discribe')";
		mysqli_query($db, $sql);
		header('location: ');
	}
}

if (isset($_GET['complete'])) {
	$id = $_GET['complete'];
	mysqli_query($db, "DELETE FROM tasks2 WHERE id=" . $id);
	header('location: ');
}

?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>ToDoList</title>
	<link href="style.css" rel="stylesheet" type="text/css">
</head>

<body dir="auto">
	<div class="heading">
		<a href="">
			<h2 style="font-style: 'Hervetica'; color: #fff;">ToDo List PHP</h2>
		</a>
	</div>
	<br>
	<form method="post" action="" class="input_form">
		<?php if (isset($errors)) { ?>
			<p><?php echo $errors; ?></p>
		<?php } ?>
		<input type="text" name="task" class="task_input" placeholder="تسک خود را تایپ کنید...">
		<input type="date" name="date1" class="task_input" placeholder="تاریخ">
		<input type="text" name="discribe" class="task_input" min="20" placeholder="توضیحی برای تسک‌‌تان بنویسید...">
		<br>
		<button type="submit" name="submit" id="add_btn" class="add_btn">ذخیره کن</button>
	</form>

	<table>
		<thead></thead>
		<hr>
		<tbody>
			<?php
			$tasks = mysqli_query($db, "SELECT * FROM tasks2");
			$i = 1;
			while ($row = mysqli_fetch_array($tasks)) { ?>
				<tr class="tr-c">
					<td> <?php echo $i; ?> </td>
					<td class="task"> <?php echo $row['task']; ?> </td>
					<td class="task"> <?php echo $row['date']; ?> </td>
					<td class="task"> <?php echo $row['discribe']; ?> </td>
					<td class="delete">
						<a href="?complete=<?php echo $row['id'] ?>">x</a>
					</td>
				</tr>
			<?php $i++;
			} ?>
		</tbody>
	</table>
</body>

</html>
