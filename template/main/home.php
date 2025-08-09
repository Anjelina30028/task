<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Главная</title>
</head>

<body>
    <form action="/tasks" method="post">
        <input type="text" name="title" placeholder="Title" required>
        <input type="text" name="description" placeholder="description" required>
        <input type="text" name="status" placeholder="status" required>
        <button>SAVE</button>
    </form>

    <h2>All tasks</h2>

    <?php
    if (isset($tasks)) {
        foreach ($tasks as $task) {
    ?>
            <form action="/tasks" method="PUT">
                <input type="hidden" name="id" value="<?=$task->id ?>">

                <input type="text" name="title" placeholder="Title" value="<?=$task->title ?>" required>
                <input type="text" name="description" placeholder="description" value="<?=$task->description ?>" required>
                <input type="text" name="status" placeholder="status" value="<?=$task->status ?>" required>
                <button>Update</button>
            </form>
            <form action="tasks" method="DELETE">
                <input type="hidden" name="id" value="<?=$task->id ?>">
                <button>Delete</button>
            </form>
    <?php
        }
    }
    ?>
</body>

</html>