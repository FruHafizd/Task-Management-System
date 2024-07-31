<?php 
include('../template/header.php');
include('../controllers/authentication.php');
include('../template/topbar.php');
include('../model/tasks.php');

// Cek apakah ID ada dan valid
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: ../views/listTask.php"); // Redirect ke halaman daftar tugas
    exit();
}

$id = $_GET['id'];
$tasks = new Tasks();
$task = $tasks->getTaskById($id);

if (!$task) {
    $_SESSION['status'] = "Task not found.";
    header("Location: ../views/listTask.php");
    exit();
}
?>

<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header">
                        <h5 class="mb-0">Update Task</h5>
                    </div>
                    <div class="card-body">
                        <form action="../model/tasks.php" method="post">
                            <input type="hidden" name="id" value="<?= $task['id'] ?>">
                            <div class="form-group mb-3">
                                <label for="title">Title</label>
                                <input type="text" id="title" name="title" class="form-control" value="<?= htmlspecialchars($task['title']) ?>" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="description">Description</label>
                                <textarea id="description" name="description" class="form-control" required><?= htmlspecialchars($task['description']) ?></textarea>
                            </div>
                            <div class="form-group mb-3">
                                <label for="due_date">Date due</label>
                                <input type="date" id="due_date" name="due_date" class="form-control" value="<?= $task['due_date'] ?>" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="status">Status</label><br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="status_pending" name="status" value="Pending" <?= ($task['status'] == 'pending') ? 'checked' : '' ?> required>
                                    <label class="form-check-label" for="status_pending">Pending</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="status_completed" name="status" value="Completed" <?= ($task['status'] == 'completed') ? 'checked' : '' ?> required>
                                    <label class="form-check-label" for="status_completed">Completed</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" name="update_task_btn" class="btn btn-primary">Update Task</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
include('../template/footer.php');
?>
