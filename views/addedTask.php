<?php 
include('../template/header.php');
include('../controllers/authentication.php');
include('../template/topbar.php');
?>

<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header">
                        <h5 class="mb-0">Added Task</h5>
                    </div>
                    <div class="card-body">
                        <form action="../model/tasks.php" method="post">
                            <div class="form-group mb-3">
                                <label for="title">Title</label>
                                <input type="text" id="title" name="title" class="form-control" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="description">Description</label>
                                <textarea id="description" name="description" class="form-control" required></textarea>
                            </div>
                            <div class="form-group mb-3">
                                <label for="due_date">Date due</label>
                                <input type="date" id="due_date" name="due_date" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <button type="submit" name="added_task_btn" class="btn btn-primary">Add Task</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php 
include('../template/footer.php')
?>