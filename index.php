<?php
$errors = "";
$db = mysqli_connect("localhost", "root", "", "todolist");

if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['submit'])) {
    if (empty($_POST['task']) || empty($_POST['discribe']) || empty($_POST['date1'])) {
        $errors = "پر کردن تمامی فیلدها اجباری است!";
    } else {
        $task = $_POST['task'];
        $date1 = $_POST['date1'];
        $discribe = $_POST['discribe'];

        $stmt = $db->prepare("INSERT INTO tasks2 (task, date, discribe) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $task, $date1, $discribe);

        if ($stmt->execute()) {
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit();
        } else {
            $errors = "خطا در ثبت اطلاعات: " . $stmt->error;
        }

        $stmt->close();
    }
}

if (isset($_GET['complete'])) {
    $id = $_GET['complete'];

    $stmt = $db->prepare("DELETE FROM tasks2 WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    } else {
        $errors = "خطا در حذف اطلاعات: " . $stmt->error;
    }

    $stmt->close();
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
        <?php if (!empty($errors)) { ?>
            <p><?php echo $errors; ?></p>
        <?php } ?>
        <input type="text" name="task" class="task_input" placeholder="تسک خود را تایپ کنید...">
        <input type="date" name="date1" class="task_input" placeholder="تاریخ">
        <input type="text" name="discribe" class="task_input" placeholder="توضیحی برای تسک‌تان بنویسید...">
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
            while ($row = mysqli_fetch_assoc($tasks)) { ?>
                <tr class="tr-c">
                    <td> <?php echo $i; ?> </td>
                    <td class="task"> <?php echo htmlspecialchars($row['task']); ?> </td>
                    <td class="task"> <?php echo htmlspecialchars($row['date']); ?> </td>
                    <td class="task"> <?php echo htmlspecialchars($row['discribe']); ?> </td>
                    <td class="delete">
                        <a href="?complete=<?php echo $row['id']; ?>">x</a>
                    </td>
                </tr>
            <?php $i++;
            } ?>
        </tbody>
    </table>
</body>
</html>
